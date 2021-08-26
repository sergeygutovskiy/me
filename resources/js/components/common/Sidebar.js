export default class Sidebar {
    constructor(sidebar_wrapper_el, sidebar_el, sidebar_info_text_el, sidebar_close_button_el) {
        if (
            sidebar_wrapper_el === null || sidebar_wrapper_el === undefined ||
            sidebar_el === null || sidebar_el === undefined ||
            sidebar_close_button_el === null || sidebar_close_button_el === undefined ||
            sidebar_info_text_el === null || sidebar_info_text_el === undefined
        ) {
            throw new Error('No sidebar');
        }

        this._sidebar_wrapper_el = sidebar_wrapper_el;  
        this._sidebar_el = sidebar_el;
        this._sidebar_close_button_el = sidebar_close_button_el;
        this._sidebar_info_text_el = sidebar_info_text_el;
        this._opened = false;
    }

    open() {
        if (this._opened) return;

        this._opened = true;
        this._sidebar_wrapper_el.classList.add('active');
    }

    close() {
        if (!this._opened) return;
        
        this._opened = false;
        this._sidebar_wrapper_el.classList.remove('active');
    }

    wrapper() {
        return this._sidebar_wrapper_el;
    }

    close_button() {
        return this._sidebar_close_button_el;
    }

    add_content(element) {
        this._sidebar_el.append(element);
    }

    set_info_text(text) {
        this._sidebar_info_text_el.textContent = text;
    }

    remove_content() {
        this._sidebar_el.textContent = '';
        this._sidebar_info_text_el.textContent = '';
    }
}