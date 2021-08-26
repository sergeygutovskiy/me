import ApiResponse from '../core/ApiResponse';

export default class NotesManager {
    constructor(notes_els, manager) {
        if (notes_els === null || notes_els === undefined) {
            throw new Error('No notes');
        }

        this._notes_els = notes_els;
        this._manager = manager;
        this._previous_shown_note = null; 

        for (let note of this._notes_els) {
            note.addEventListener('click', event => {
                this.show_info(event.target.dataset.noteId);
            });
        }
    }

    async show_info(note_id) {
        note_id = Number.parseInt(note_id);

        if (this._previous_shown_note === null || note_id !== this._previous_shown_note.id) {
            const note = await this.get_note_info(note_id);
            this.build_note_content(note);
            this._previous_shown_note = note;
        }

        this._manager.open();
    }

    async get_note_info(note_id) {
        const url = `/api/notes/${note_id}`;
        const raw_response = await fetch(url);
        const api_response = await (new ApiResponse()).process(raw_response);

        if (api_response.is_bad()) {
            api_response.alert_problem();
            return;
        }

        return api_response.data().note;
    } 

    build_note_content(note) {
        this._manager.remove_content_from_sidebar();

        const date = new Date(note.created_at);
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const formatted_text = new Intl.DateTimeFormat('ru-RU', options).format(date);
        
        this._manager.set_info_text(formatted_text);

        if (note.image_path !== null) {
            const img_wrapper = document.createElement('div');
            img_wrapper.classList.add('note-sidebar__image-wrapper');

            const img = document.createElement('img');
            img.classList.add('note-sidebar__image');
            img.src = note.image_path;

            img_wrapper.append(img);
            this._manager.add_content_to_sidebar(img_wrapper);
        }

        const heading = document.createElement('span');
        heading.classList.add('note-sidebar__title');
        heading.textContent = note.name;

        // const paragraph = document.createElement('p');
        // paragraph.classList.add('note-sidebar__paragraph');
        // paragraph.textContent = note.description;

        const paragraph = new DOMParser()
            .parseFromString('<p>' + note.description + '</p>', 'text/html').body.firstElementChild;
        paragraph.classList.add('note-sidebar__paragraph');
        

        this._manager.add_content_to_sidebar(heading);
        this._manager.add_content_to_sidebar(paragraph);

        if (note.links.length > 0) {
            const links_heading = document.createElement('span');
            links_heading.classList.add('note-sidebar__links-title');
            links_heading.textContent = 'Читать:';
        
            this._manager.add_content_to_sidebar(links_heading);

            const anchors_wrapper = document.createElement('div');
            anchors_wrapper.classList.add('note-sidebar__links');

            for (const link of note.links) {
                const anchor = document.createElement('a');
                anchor.classList.add('note-sidebar__link');
                anchor.classList.add('link');
                anchor.href = link.link;
                anchor.textContent = link.text;
            
                anchors_wrapper.append(anchor);
            }

            this._manager.add_content_to_sidebar(anchors_wrapper);
        }
    }
}