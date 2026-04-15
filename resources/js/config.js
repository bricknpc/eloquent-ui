/**
 * @typedef {Object} EloquentUIConfig
 * @property {string} ns - Namespace for EloquentUI components in camel case
 * @property {string} nsDash - Namespace for the EloquentUI components in kebab case
 */

const config = JSON.parse(document.querySelector('meta[name="eloquent-ui"]').content);
window.EloquentUIConfig = Object.assign(window.EloquentUIConfig || {}, config);
