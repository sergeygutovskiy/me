<template>
    <section class="row">
        <div class="col-6">
            <form class="card" v-if="note" @submit="form_submitted">
                <div class="card-body">
                    <div>
                        <label class="form-label">Название</label>
                        <input class="form-control" type="text" v-model="edited_note.name">
                    </div>
                    <div class="mt-3">
                        <label class="form-label">
                            Картинка
                            <span v-if="note.image_path">
                                <a :href="note.image_path">
                                    посмотреть
                                </a>
                            </span>
                        </label>
                        <div class="input-group">
                            <select class="form-select" v-model="edited_note.is_image">
                                <option 
                                    :value="false" 
                                    :selected="!edited_note.is_image"
                                    >
                                    Нет
                                </option>
                                <option 
                                    :value="true" 
                                    :selected="edited_note.is_image"
                                    >
                                    Есть
                                </option>
                            </select>
                            <input 
                                type="file" 
                                class="form-control" 
                                :disabled="!edited_note.is_image"
                                @change="image_changed"
                                >
                            </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Описание</label>
                        <textarea class="form-control" rows="6" v-model="edited_note.description"></textarea>
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
    </section>
</template>

<script>
import ApiResponse from '../../../components/core/ApiResponse';

export default {
    props: [
        'id',
    ],
    
    data() {
        return {
            edited_note: {
                name: null,
                description: null,
                is_image: false,
                image: null,
            },

            note: null,
            note_endpoint_url: `/api/notes/${this.id}`,
        
            messages: {
                updated: null,
            },
        }
    },

    watch: {
        'edited_note.is_image': function(val) {
            if (!val) 
                this.edited_note.image = null;
        }
    },

    async created() {
        await this.get_note();
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
            this.edited_note.is_image = !!this.note.image_path;
        },

        async form_submitted(event) {
            event.preventDefault();

            let form_data = new FormData();
            form_data.append('name', this.edited_note.name);
            form_data.append('description', this.edited_note.description);
            form_data.append('is_image', this.edited_note.is_image);
            form_data.append('new_image', this.edited_note.is_image ? this.edited_note.image : '');

            this.messages.updated = null;

            const raw_response = await fetch( this.note_endpoint_url, {
                method: 'POST',
                body: form_data,
            });

            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_good()) this.messages.updated = true;
            else this.messages.updated = false;
        },

        image_changed(event) {
            this.edited_note.image = event.target.files[0];
        }
    },
}
</script>