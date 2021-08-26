<template>
    <section class="row" v-if="note">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h1>Заметки - {{ note.name }}</h1>
                </div>
            </div>
        </div>
        <div class="col-10 mb-4">
            <form class="card" @submit="form_submitted">
                <div class="card-body">
                    <div>
                        <label class="form-label">Название</label>
                        <input class="form-control" type="text" v-model="edited_note.name">
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Описание</label>
                        <textarea class="form-control" rows="6" v-model="edited_note.description"></textarea>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Картинка</label>
                        <select class="form-control" v-model="edited_note.image_path">
                            <option :value="null">
                                Нет
                            </option>
                            <option 
                                v-for="image in images" 
                                :key="image" 
                                :value="image"
                                >
                                {{ image }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <div v-if="messages.updated" class="alert alert-success" role="alert">
                        Данные обновлены
                    </div>

                    <div v-else-if="messages.updated === false" class="alert alert-danger" role="alert">
                        Ошибка
                    </div>
                    
                    <button class="btn btn-success" type="submit">
                        Обновить
                    </button>
                </div>
            </form>
        </div>

        <div class="col-10">
            <notes-index v-bind:note="id" />
        </div>
    </section>
</template>

<script>
import ApiResponse from '../../../components/core/ApiResponse';

import NotesIndex from './links/Index.vue';

export default {
    props: [
        'id',
    ],
    
    components: {
        NotesIndex
    },

    data() {
        return {
            edited_note: {
                name: null,
                description: null,
                image_path: null
            },

            note: null,
            note_endpoint_url: `/api/notes/${this.id}`,
        
            images: [],
            images_endpoint_url: '/api/files/notes',

            messages: {
                updated: null,
            },
        }
    },

    async created() {
        await this.get_note();
        await this.get_images();
    },

    methods: {
        async get_note() {
            const raw_response = await fetch(this.note_endpoint_url);
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.note = api_response.data().note; 

            this.edited_note.name = this.note.name;
            this.edited_note.description = this.note.description;
        
            const image = this.note.image_path; 
            if ( image !== null )
                this.edited_note.image_path = image.split('/')[image.split('/').length - 1]
        },

        async form_submitted(event) {
            event.preventDefault();

            this.messages.updated = null;

            const raw_response = await fetch( this.note_endpoint_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name: this.edited_note.name,
                    description: this.edited_note.description,
                    image_path: this.edited_note.image_path
                })
            });

            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_good()) this.messages.updated = true;
            else this.messages.updated = false;
        },

        async get_images() {
            const raw_response = await fetch(this.images_endpoint_url);
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.images = api_response.data().files; 
        }
    },
}
</script>