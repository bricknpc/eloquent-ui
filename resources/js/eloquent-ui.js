import './config';
import './components/currency';
import Dropdown from './components/dropdown';
import './components/once';
import { mountEditor } from "./components/editor";
import './../css/eloquent-ui.css';

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(`[data-${EloquentUIConfig.nsDash}-blocknote-editor]`).forEach(editorElement => {
        mountEditor(editorElement);
    });

    document.querySelectorAll(`[data-${EloquentUIConfig.nsDash}-dropdown="true"]`).forEach(dropdownElement => {
        new Dropdown(dropdownElement);
    });
});

// Export the EloquentUI namespace
export default window.EloquentUI;
