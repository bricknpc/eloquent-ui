export default class Dropdown {
    /**
     * @param {HTMLElement} dropdownElement
     */
    constructor(dropdownElement) {
        const ns       = window.EloquentUIConfig?.ns       ?? 'eloquentUi';
        const nsDashed = window.EloquentUIConfig?.nsDashed ?? 'eloquent-ui';

        this.ns        = ns;
        this.nsDashed  = nsDashed;
        this.el        = dropdownElement;
        this.multiple  = dropdownElement.getAttribute(`data-${nsDashed}-multiple`)     === 'true';
        this.allowCreate = dropdownElement.getAttribute(`data-${nsDashed}-allow-create`) === 'true';

        this.inputSelect  = dropdownElement.querySelector(`[data-${nsDashed}-input-select]`);
        this.inputElement = dropdownElement.querySelector(`[data-${nsDashed}-input-element]`);
        this.optionsPanel = dropdownElement.querySelector(`[data-${nsDashed}-dropdown-options]`);
        this.allOptions   = dropdownElement.querySelectorAll(`[data-${nsDashed}-dropdown-option]`);
        this.valuesWrapper= dropdownElement.querySelector(`[data-${nsDashed}-dropdown-values]`);
        this.hiddenInput  = dropdownElement.querySelector(`[data-${nsDashed}-hidden-input]`);
        this.toggleBtn    = dropdownElement.querySelector(`[data-${nsDashed}-dropdown-toggle]`);
        this.createRow    = dropdownElement.querySelector(`[data-${nsDashed}-dropdown-create]`);
        this.createLabel  = dropdownElement.querySelector(`[data-${nsDashed}-create-label]`);
        this.noResults    = dropdownElement.querySelector(`[data-${nsDashed}-no-results]`);
        this.valuesSpan   = dropdownElement.querySelector('.dropdown-values');

        this.isOpen      = false;
        this.activeIndex = -1;
        this.selected    = [];

        this._init();
    }

    _init() {
        this._initSelected();
        this.renderBadges();
        this.syncHiddenInputs();
        this.markSelectedOptions();
        this._bindEvents();

        if (!this.inputElement) {
            this.inputSelect.setAttribute('tabindex', '0');
        }
    }

    _initSelected() {
        const rawValue = this.el.getAttribute(`data-${this.nsDashed}-value`);
        if (!rawValue) return;

        try {
            const parsed = JSON.parse(rawValue);

            if (this.multiple) {
                let entries = [];

                if (Array.isArray(parsed)) {
                    // Flat array of values: [1, 2, 3]
                    entries = parsed.map(v => ({ value: v, label: null }));
                } else if (parsed !== null && typeof parsed === 'object') {
                    // Key/value object: {"1": "Tag A", "2": "Tag B"}
                    entries = Object.entries(parsed).map(([k, v]) => ({ value: k, label: v }));
                }

                entries.forEach(({ value, label }) => {
                    const opt = [...this.allOptions].find(o => o.dataset.value == value);
                    this.selected.push({
                        value,
                        label: label ?? (opt ? opt.dataset.label : value),
                    });
                });
            } else {
                if (parsed !== null && parsed !== '') {
                    const opt = [...this.allOptions].find(o => o.dataset.value == parsed);
                    this.selected = [{ value: parsed, label: opt ? opt.dataset.label : parsed }];
                }
            }
        } catch(e) {}
    }

    _dispatchInputEvent() {
        if (this.multiple) {
            // Dispatch on the last hidden input, or the values wrapper if none yet
            const inputs = this.valuesWrapper.querySelectorAll('input[type="hidden"]');
            const target = inputs.length ? inputs[inputs.length - 1] : this.valuesWrapper;
            target.dispatchEvent(new Event('input', { bubbles: true }));
        } else {
            if (this.hiddenInput) {
                this.hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
            }
        }
    }

    openPanel() {
        if (this.isOpen) {
            return;
        }
        this.isOpen = true;
        this.optionsPanel.classList.remove('d-none');
        this.toggleBtn.textContent = this.toggleBtn.getAttribute(`data-${this.nsDashed}-dropdown-up`);
        this.filterOptions('');
        this.activeIndex = -1;
    }

    closePanel() {
        if (!this.isOpen) {
            return;
        }
        this.isOpen = false;
        this.optionsPanel.classList.add('d-none');
        this.toggleBtn.textContent = this.toggleBtn.getAttribute(`data-${this.nsDashed}-dropdown-down`);
        this.activeIndex = -1;
        this._setActive(-1);
        if (this.inputElement) {
            this.inputElement.textContent = '';
        }
    }

    togglePanel() {
        this.isOpen ? this.closePanel() : this.openPanel();
    }

    filterOptions(query) {
        const q = query.trim().toLowerCase();
        let visibleCount = 0;

        this.allOptions.forEach(opt => {
            const match = opt.dataset.label.toLowerCase().includes(q);
            opt.classList.toggle('d-none', !match);
            if (match) {
                visibleCount++;
            }
        });

        if (this.createRow && this.createLabel) {
            const exactMatch = [...this.allOptions].some(o => o.dataset.label.toLowerCase() === q);
            const showCreate = this.allowCreate && q.length > 0 && !exactMatch;
            this.createRow.classList.toggle('d-none', !showCreate);
            if (showCreate) {
                this.createLabel.textContent = query.trim();
            }
        }

        const showNoResults = visibleCount === 0 && !(this.createRow && !this.createRow.classList.contains('d-none'));
        if (this.noResults) {
            this.noResults.classList.toggle('d-none', !showNoResults);
        }

        this.activeIndex = -1;
        this._setActive(-1);
    }

    _visibleOptionRows() {
        const rows = [];
        if (this.createRow && !this.createRow.classList.contains('d-none')) {
            rows.push(this.createRow);
        }

        this.allOptions.forEach(o => {
            if (!o.classList.contains('d-none')) {
                rows.push(o);
            }
        });

        return rows;
    }

    _setActive(index) {
        this._visibleOptionRows().forEach((row, i) => {
            row.classList.toggle('active', i === index);
        });
    }

    _navigateOptions(direction) {
        const rows = this._visibleOptionRows();
        this.activeIndex = direction === 'down'
            ? Math.min(this.activeIndex + 1, rows.length - 1)
            : Math.max(this.activeIndex - 1, 0);
        this._setActive(this.activeIndex);
    }

    selectOption(value, label) {
        if (this.multiple) {
            const exists = this.selected.findIndex(s => s.value === value);
            if (exists > -1) {
                this.selected.splice(exists, 1);
            } else {
                this.selected.push({ value, label });
            }
        } else {
            this.selected = [{ value, label }];
            this.closePanel();
        }

        this.renderBadges();
        this.syncHiddenInputs();
        this.markSelectedOptions();

        if (this.inputElement) {
            this.inputElement.textContent = '';
        }

        if (this.multiple) {
            this.filterOptions(this.inputElement ? this.inputElement.textContent : '');
        }
    }

    removeSelected(value) {
        this.selected = this.selected.filter(s => s.value !== value);
        this.renderBadges();
        this.syncHiddenInputs();
        this.markSelectedOptions();
    }

    renderBadges() {
        this.valuesSpan?.querySelectorAll('.dropdown-value-badge').forEach(badge => badge.remove());

        this.selected.forEach(({ value, label }) => {
            const badge = document.createElement('span');
            badge.className = 'dropdown-value-badge';
            badge.setAttribute('data-badge-value', value);

            const text = document.createElement('span');
            text.textContent = label;
            badge.appendChild(text);

            if (this.multiple) {
                const remove = document.createElement('span');
                remove.className = 'badge-remove';
                remove.textContent = '×';
                remove.addEventListener('click', e => {
                    e.stopPropagation();
                    this.removeSelected(value);
                });
                badge.appendChild(remove);
            }

            if (this.inputElement) {
                this.valuesSpan.insertBefore(badge, this.inputElement);
            } else {
                this.valuesSpan.appendChild(badge);
            }
        });
    }

    syncHiddenInputs() {
        if (this.multiple) {
            this.valuesWrapper.innerHTML = '';
            const name = this.el.getAttribute(`data-${this.nsDashed}-name`);
            this.selected.forEach(({ value }) => {
                const inp = document.createElement('input');
                inp.type  = 'hidden';
                inp.name  = `${name}[]`;
                inp.value = value;
                this.valuesWrapper.appendChild(inp);
            });
        } else {
            if (this.hiddenInput) {
                this.hiddenInput.value = this.selected.length ? this.selected[0].value : '';
            }
        }

        this._dispatchInputEvent();
    }

    markSelectedOptions() {
        this.allOptions.forEach(opt => {
            opt.classList.toggle('selected', this.selected.some(s => s.value === opt.dataset.value));
        });
    }

    _bindEvents() {
        // Control click
        this.inputSelect.addEventListener('click', e => this._onControlClick(e));

        // Input element events
        if (this.inputElement) {
            this.inputElement.addEventListener('input',   () => this._onInput());
            this.inputElement.addEventListener('keydown', e  => this._onInputKeydown(e));
        } else {
            this.inputSelect.addEventListener('keydown', e => this._onControlKeydown(e));
        }

        // Option clicks
        this.allOptions.forEach(opt => {
            opt.addEventListener('click', e => {
                e.stopPropagation();
                this.selectOption(opt.dataset.value, opt.dataset.label);
                if (this.inputElement) {
                    this.inputElement.focus();
                }
            });
        });

        // Create row click
        if (this.createRow) {
            this.createRow.addEventListener('click', e => {
                e.stopPropagation();
                const label = this.inputElement.textContent.trim();
                if (label) this.selectOption(label, label);
                if (this.inputElement) {
                    this.inputElement.focus();
                }
            });
        }

        // Close on outside click
        document.addEventListener('click', e => {
            if (!this.el.contains(e.target)) {
                this.closePanel();
            }
        });
    }

    _onControlClick(e) {
        if (e.target.classList.contains('badge-remove')) {
            return;
        }

        if (e.target === this.inputElement) {
            if (!this.isOpen) {
                this.openPanel();
            }

            return;
        }

        if (e.target === this.toggleBtn) {
            this.togglePanel();
            return;
        }

        this.openPanel();

        if (this.inputElement) {
            this.inputElement.focus();
            const range = document.createRange();
            const sel   = window.getSelection();
            range.selectNodeContents(this.inputElement);
            range.collapse(false);
            sel.removeAllRanges();
            sel.addRange(range);
        }
    }

    _onInput() {
        if (!this.isOpen) {
            this.openPanel();
        }

        this.filterOptions(this.inputElement.textContent);
    }

    _onInputKeydown(e) {
        const rows = this._visibleOptionRows();

        switch (e.key) {
            case 'ArrowDown':
                e.preventDefault();
                this._navigateOptions('down');
                break;
            case 'ArrowUp':
                e.preventDefault();
                this._navigateOptions('up');
                break;
            case 'Enter':
                e.preventDefault();
                if (this.activeIndex >= 0 && rows[this.activeIndex]) {
                    rows[this.activeIndex].click();
                } else if (this.allowCreate && this.inputElement.textContent.trim()) {
                    const label = this.inputElement.textContent.trim();
                    this.selectOption(label, label);
                }
                break;
            case 'Escape':
                this.closePanel();
                break;
            case 'Backspace':
                if (this.inputElement.textContent === '' && this.multiple && this.selected.length) {
                    this.removeSelected(this.selected[this.selected.length - 1].value);
                }
                break;
        }
    }

    _onControlKeydown(e) {
        switch (e.key) {
            case 'Enter':
            case ' ':
                e.preventDefault();
                if (this.isOpen && this.activeIndex >= 0) {
                    this._visibleOptionRows()[this.activeIndex]?.click();
                } else {
                    this.togglePanel();
                }
                break;
            case 'Escape':
                this.closePanel();
                break;
            case 'ArrowDown':
                e.preventDefault();
                if (!this.isOpen) {
                    this.openPanel();
                }
                this._navigateOptions('down');
                break;
            case 'ArrowUp':
                e.preventDefault();
                if (!this.isOpen) {
                    this.openPanel();
                }
                this._navigateOptions('up');
                break;
        }
    }
}