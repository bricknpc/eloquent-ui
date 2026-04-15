import './config';
import './components/currency';
import './components/once';
import { mountEditor } from "./components/editor";
import './../css/eloquent-ui.css';

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(`[data-${EloquentUIConfig.nsDash}-blocknote-editor]`).forEach((el) => {
        mountEditor(el);
    });
});

// Export the EloquentUI namespace
export default window.EloquentUI;
