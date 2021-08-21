export default class BlurSidebarManager {
    constructor(blur, sidebar) {
        if (
            blur === null || blur === undefined ||
            sidebar === null || sidebar === undefined
        ) {
            throw new Error('No blur or sidebar');
        }

        this._blur = blur;
        this._sidebar = sidebar;

        this._sidebar.wrapper().addEventListener('click', event => {
            if (event.target === this._sidebar.wrapper()) this.close();
        });

        this._sidebar.close_button().addEventListener('click', event => {
            if (event.target === this._sidebar.close_button()) this.close();
        });
    }

    open() {
        this._blur.open();
        this._sidebar.open();
    }

    close() {
        this._sidebar.close();
        this._blur.close();
    }

    add_content_to_sidebar = el => this._sidebar.add_content(el);
    remove_content_from_sidebar = () => this._sidebar.remove_content();
}