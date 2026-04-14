/**
 * @typedef {Object} EloquentUIConfig
 * @property {string} ns - Namespace for EloquentUI components
 */

const config = JSON.parse(document.querySelector('meta[name="eloquent-ui"]').content);
window.EloquentUIConfig = Object.assign(window.EloquentUIConfig || {}, config);
