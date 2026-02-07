/**
 * EloquentUI Currency Input Component
 * Handles currency input with whole and cents fields, currency selection, and paste support
 */
(function() {
    'use strict';

    const NS = 'eloquent-ui'; // Your namespace from ns() function

    class Currency {
        constructor(element) {
            if (!element) {
                throw new Error('Currency component element is required');
            }

            this.element = element;
            this.name = element.dataset[`${this.camelCase(NS)}Name`];

            if (!this.name) {
                throw new Error('Currency component must have a data-eloquent-ui-name attribute');
            }

            // Get input elements within the input-group
            this.wholeInput = element.querySelector(`#${this.name}-whole`);
            this.centsInput = element.querySelector(`#${this.name}-cents`);

            // Currency input is OUTSIDE the input-group, search the whole document
            this.currencyInput = document.getElementById(`${this.name}-currency`);

            if (!this.wholeInput || !this.centsInput) {
                throw new Error(`Currency inputs not found for ${this.name}`);
            }

            // Get configuration
            this.config = {
                focusSwitch: element.dataset[`${this.camelCase(NS)}FocusSwitch`] !== 'false',
                required: element.dataset[`${this.camelCase(NS)}Required`] === 'true',
                min: this.parseNumber(element.dataset[`${this.camelCase(NS)}Min`]),
                max: this.parseNumber(element.dataset[`${this.camelCase(NS)}Max`])
            };

            // Get currency dropdown elements
            this.currencyButton = element.querySelector(`[data-${NS}-currency-select]`);
            this.currencyDropdown = element.querySelector('.dropdown-menu');

            // Currency announcement is unique per component, find it near the component
            // First try to find it as a sibling, then search document as fallback
            this.currencyAnnouncement = element.parentElement?.querySelector(`[data-${NS}-currency-announcement]`) ||
                document.querySelector(`[data-${NS}-currency-announcement][data-${NS}-name="${this.name}"]`);

            // Initialize
            this.init();
        }

        /**
         * Convert kebab-case to camelCase for dataset access
         */
        camelCase(str) {
            return str.replace(/-([a-z])/g, (g) => g[1].toUpperCase());
        }

        /**
         * Parse number from string, return null if invalid
         */
        parseNumber(value) {
            if (value === null || value === undefined || value === '') {
                return null;
            }
            const parsed = parseInt(value, 10);
            return isNaN(parsed) ? null : parsed;
        }

        /**
         * Initialize all event listeners
         */
        init() {
            // Pad cents on load
            this.padCents();

            // Cents input handlers
            this.centsInput.addEventListener('input', this.handleCentsInput.bind(this));
            this.centsInput.addEventListener('blur', this.padCents.bind(this));

            // Whole input handlers
            if (this.config.focusSwitch) {
                this.wholeInput.addEventListener('keypress', this.handleDecimalKey.bind(this));
            }

            // Paste handlers
            this.wholeInput.addEventListener('paste', this.handlePaste.bind(this));
            this.centsInput.addEventListener('paste', this.handlePaste.bind(this));

            // Currency dropdown handlers
            if (this.currencyButton && this.currencyDropdown) {
                this.initCurrencyDropdown();
            }

            // Validation on change
            this.wholeInput.addEventListener('change', this.validate.bind(this));
            this.centsInput.addEventListener('change', this.validate.bind(this));
        }

        /**
         * Pad cents input to always show 2 digits
         */
        padCents() {
            const value = this.centsInput.value;
            if (value !== '') {
                const parsed = parseInt(value, 10);
                if (!isNaN(parsed)) {
                    this.centsInput.value = Math.abs(parsed).toString().padStart(2, '0');
                }
            }
        }

        /**
         * Handle input in cents field with overflow/underflow to whole field
         */
        handleCentsInput(event) {
            let newValue = parseInt(event.target.value) || 0;
            const currentWhole = parseInt(this.wholeInput.value) || 0;

            if (newValue > 99) {
                // Overflow: move to whole field
                const wholeUnits = Math.floor(newValue / 100);
                const remainingCents = newValue % 100;

                let newWhole = currentWhole + wholeUnits;

                // Respect max constraint
                if (this.config.max !== null && newWhole > this.config.max) {
                    this.wholeInput.value = this.config.max;
                    this.centsInput.value = '99';
                } else {
                    this.wholeInput.value = newWhole;
                    this.centsInput.value = remainingCents.toString().padStart(2, '0');
                }
            } else if (newValue < 0) {
                // Underflow: subtract from whole field
                const wholeUnits = Math.ceil(Math.abs(newValue) / 100);
                const remainingCents = 100 - (Math.abs(newValue) % 100);

                let newWhole = currentWhole - wholeUnits;

                // Respect min constraint
                if (this.config.min !== null && newWhole < this.config.min) {
                    this.wholeInput.value = this.config.min;
                    this.centsInput.value = '00';
                } else {
                    this.wholeInput.value = newWhole;
                    this.centsInput.value = (remainingCents === 100 ? 0 : remainingCents).toString().padStart(2, '0');
                }
            } else {
                // Normal input: pad to 2 digits
                this.centsInput.value = newValue.toString().padStart(2, '0');
            }
        }

        /**
         * Handle decimal key (comma or period) in whole field
         */
        handleDecimalKey(event) {
            if (event.key === ',' || event.key === '.') {
                event.preventDefault();
                this.centsInput.focus();
                this.centsInput.select();
            }
        }

        /**
         * Parse pasted amount text
         */
        parseAmount(text) {
            // Remove whitespace
            text = text.trim();

            // Determine decimal separator (last occurrence of . or ,)
            const lastDot = text.lastIndexOf('.');
            const lastComma = text.lastIndexOf(',');
            const decimalSeparator = lastDot > lastComma ? '.' : ',';

            // Remove thousand separators but keep decimal separator
            if (decimalSeparator === '.') {
                text = text.replace(/[,_\s]/g, '');
            } else {
                text = text.replace(/[._\s]/g, '').replace(',', '.');
            }

            // Parse as float
            const value = parseFloat(text);
            if (isNaN(value)) return null;

            // Split into whole and cents
            const whole = Math.floor(value);
            const cents = Math.round((value - whole) * 100);

            return { whole, cents };
        }

        /**
         * Handle paste in either input field
         */
        handlePaste(event) {
            event.preventDefault();

            const pastedText = (event.clipboardData || window.clipboardData).getData('text');
            const parsed = this.parseAmount(pastedText);

            if (parsed !== null) {
                let newWhole = parsed.whole;
                let newCents = parsed.cents;

                // Respect constraints
                if (this.config.min !== null && newWhole < this.config.min) {
                    newWhole = this.config.min;
                    newCents = 0;
                }
                if (this.config.max !== null && newWhole > this.config.max) {
                    newWhole = this.config.max;
                    newCents = 99;
                }

                this.wholeInput.value = newWhole;
                this.centsInput.value = newCents.toString().padStart(2, '0');

                // Trigger validation
                this.validate();
            }
        }

        /**
         * Initialize currency dropdown functionality
         */
        initCurrencyDropdown() {
            const items = this.currencyDropdown.querySelectorAll('.dropdown-item');
            const genericSymbol = this.currencyButton.dataset[`${this.camelCase(NS)}CurrencySymbol`] || '¤';

            items.forEach(item => {
                item.addEventListener('click', (event) => {
                    event.preventDefault();

                    const value = item.dataset[`${this.camelCase(NS)}Value`];
                    const symbol = item.textContent.trim();

                    // Update button text
                    this.currencyButton.textContent = symbol;

                    // Update hidden currency input - CRITICAL for form submission
                    if (this.currencyInput) {
                        this.currencyInput.value = value;

                        // Trigger change event for any listeners
                        this.currencyInput.dispatchEvent(new Event('change', { bubbles: true }));
                    } else {
                        console.warn(`Hidden currency input #${this.name}-currency not found`);
                    }

                    // Update aria-current for accessibility
                    items.forEach(i => i.removeAttribute('aria-current'));
                    item.setAttribute('aria-current', 'true');

                    // Announce change for screen readers
                    this.announceCurrencyChange(value, symbol);

                    // Close the dropdown (Bootstrap 5)
                    if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
                        const dropdown = bootstrap.Dropdown.getInstance(this.currencyButton);
                        if (dropdown) {
                            dropdown.hide();
                        }
                    }
                });
            });
        }

        /**
         * Announce currency change for accessibility
         */
        announceCurrencyChange(key, value) {
            if (!this.currencyAnnouncement) return;

            const template = this.currencyAnnouncement.dataset[`${this.camelCase(NS)}CurrencyAnnouncementMessage`] ||
                'Currency of :attribute has been changed to :key (:value)';

            const message = template
                .replace(':attribute', this.name)
                .replace(':key', key)
                .replace(':value', value);

            this.currencyAnnouncement.textContent = message;

            // Clear after a delay so it can be re-announced if needed
            setTimeout(() => {
                this.currencyAnnouncement.textContent = '';
            }, 1000);
        }

        /**
         * Validate the current values against min/max constraints
         */
        validate() {
            const whole = parseInt(this.wholeInput.value) || 0;
            const cents = parseInt(this.centsInput.value) || 0;
            const totalCents = (whole * 100) + cents;

            let isValid = true;

            if (this.config.min !== null) {
                const minCents = this.config.min * 100;
                if (totalCents < minCents) {
                    isValid = false;
                    this.wholeInput.value = this.config.min;
                    this.centsInput.value = '00';
                }
            }

            if (this.config.max !== null) {
                const maxCents = this.config.max * 100;
                if (totalCents > maxCents) {
                    isValid = false;
                    this.wholeInput.value = this.config.max;
                    this.centsInput.value = '99';
                }
            }

            return isValid;
        }

        /**
         * Get the current value as an object
         */
        getValue() {
            return {
                whole: parseInt(this.wholeInput.value) || 0,
                cents: parseInt(this.centsInput.value) || 0,
                currency: this.currencyInput ? this.currencyInput.value : null,
                amount: parseFloat(`${this.wholeInput.value || 0}.${this.centsInput.value || 0}`),
                amountInCents: ((parseInt(this.wholeInput.value) || 0) * 100) + (parseInt(this.centsInput.value) || 0)
            };
        }

        /**
         * Set the value programmatically
         */
        setValue(whole, cents, currency = null) {
            this.wholeInput.value = whole;
            this.centsInput.value = cents.toString().padStart(2, '0');

            if (currency !== null && this.currencyInput) {
                this.currencyInput.value = currency;

                // Update button if dropdown exists
                if (this.currencyButton) {
                    const item = this.currencyDropdown.querySelector(`[data-${NS}-value="${currency}"]`);
                    if (item) {
                        this.currencyButton.textContent = item.textContent.trim();
                    }
                }
            }

            this.validate();
        }

        /**
         * Destroy the component and remove event listeners
         */
        destroy() {
            // Remove event listeners (need to use the bound versions)
            const handlers = {
                centsInput: this.handleCentsInput.bind(this),
                centsBlur: this.padCents.bind(this),
                wholeKeypress: this.handleDecimalKey.bind(this),
                wholePaste: this.handlePaste.bind(this),
                centsPaste: this.handlePaste.bind(this),
                wholeChange: this.validate.bind(this),
                centsChange: this.validate.bind(this)
            };

            this.centsInput.removeEventListener('input', handlers.centsInput);
            this.centsInput.removeEventListener('blur', handlers.centsBlur);
            this.wholeInput.removeEventListener('keypress', handlers.wholeKeypress);
            this.wholeInput.removeEventListener('paste', handlers.wholePaste);
            this.centsInput.removeEventListener('paste', handlers.centsPaste);
            this.wholeInput.removeEventListener('change', handlers.wholeChange);
            this.centsInput.removeEventListener('change', handlers.centsChange);
        }

        /**
         * Static method to initialize all currency components on the page
         */
        static init() {
            const selector = `[data-${NS}-input="currency"]`;
            const elements = document.querySelectorAll(selector);
            const instances = [];

            elements.forEach(element => {
                try {
                    instances.push(new Currency(element));
                } catch (error) {
                    console.error('Failed to initialize currency component:', error, element);
                }
            });

            return instances;
        }
    }

    // Expose to window
    if (!window.EloquentUI) {
        window.EloquentUI = {};
    }
    window.EloquentUI.Currency = Currency;

})();
