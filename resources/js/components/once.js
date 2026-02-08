/**
 * EloquentUI Once Component
 */
(function(window) {
    'use strict';

    const namespace = window.EloquentUIConfig?.namespace || 'eloquent-ui';
    const onceAttr = `data-${namespace}-once`;
    const onceOthersAttr = `data-${namespace}-once-others`;

    class Once {
        constructor(element) {
            if (!(element instanceof HTMLElement)) {
                throw new TypeError('Once requires a valid HTMLElement');
            }

            if (!element.hasAttribute(onceAttr)) {
                console.warn('Element does not have once attribute:', element);
                return;
            }

            this.element = element;
            this.others = this._getOtherElements();
            this.disabled = false;

            this._init();
        }

        _init() {
            if (this.element.dataset.onceInitialized === 'true') {
                return;
            }

            this.element.addEventListener('click', this._handleClick.bind(this));
            this.element.dataset.onceInitialized = 'true';
        }

        _getOtherElements() {
            const othersSelector = this.element.getAttribute(onceOthersAttr);

            if (!othersSelector) {
                return [];
            }

            try {
                const elements = document.querySelectorAll(othersSelector);
                return Array.from(elements);
            } catch (error) {
                console.error('Invalid selector in once-others attribute:', othersSelector, error);
                return [];
            }
        }

        _handleClick(event) {
            if (this.disabled) {
                return;
            }

            const form = this.element.closest('form');

            if (form && !form.checkValidity()) {
                return;
            }

            this._disableButton(this.element);
            this.others.forEach(otherElement => {
                this._disableButton(otherElement);
            });

            this.disabled = true;
        }

        _disableButton(button) {
            button.disabled = true;
            button.setAttribute('aria-disabled', 'true');
            button.classList.add('disabled');

            if (!button.dataset.originalText) {
                button.dataset.originalText = button.innerHTML;
            }
        }

        enable() {
            this._enableButton(this.element);

            this.others.forEach(otherElement => {
                this._enableButton(otherElement);
            });

            this.disabled = false;
        }

        _enableButton(button) {
            button.disabled = false;
            button.setAttribute('aria-disabled', 'false');
            button.classList.remove('disabled');

            if (button.dataset.originalText) {
                button.innerHTML = button.dataset.originalText;
            }
        }

        destroy() {
            this.element.removeEventListener('click', this._handleClick);
            delete this.element.dataset.onceInitialized;
            this.enable();
        }

        static init(context = document) {
            const selector = `[${onceAttr}]`;
            const elements = context.querySelectorAll(selector);
            const instances = [];

            elements.forEach(element => {
                try {
                    const instance = new Once(element);
                    instances.push(instance);
                } catch (error) {
                    console.error('Failed to initialize Once for element:', element, error);
                }
            });

            return instances;
        }

        static autoInit() {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => {
                    Once.init();
                });
            } else {
                Once.init();
            }
        }
    }

    // Initialize EloquentUI namespace
    if (typeof window.EloquentUI === 'undefined') {
        window.EloquentUI = {};
    }

    window.EloquentUI.Once = Once;

    // Auto-initialize if configured
    if (window.EloquentUIConfig?.autoInit !== false) {
        Once.autoInit();
    }

})(window);