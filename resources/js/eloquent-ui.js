import './config'
import './components/currency'
import './components/once'
import { mountEditor } from "./components/editor";

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(`[data-${EloquentUIConfig.ns}-blocknote-editor]`).forEach((el) => {
        mountEditor(el);
    });
});

// Export the EloquentUI namespace
export default window.EloquentUI;
