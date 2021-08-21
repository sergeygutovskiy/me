<template>
    <section class="row">
        <div class="col-6">
            <form class="card" @submit="form_submitted">
                <div class="card-body">
                    <div>
                        <label class="form-label">Название</label>
                        <input class="form-control" type="text" v-model="name">
                    </div>
                    <div class="mt-3">
                        <label class="form-label">
                            Картинка
                        </label>
                        <div class="input-group">
                            <select class="form-select" v-model="is_image">
                                <option 
                                    :value="false" 
                                    :selected="!is_image"
                                    >
                                    Нет
                                </option>
                                <option 
                                    :value="true" 
                                    :selected="is_image"
                                    >
                                    Есть
                                </option>
                            </select>
                            <input 
                                type="file" 
                                class="form-control" 
                                :disabled="!is_image"
                                @change="image_changed"
                                >
                            </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Описание</label>
                        <textarea class="form-control" rows="6" v-model="description"></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <div v-if="messages.added" class="alert alert-success" role="alert">
                        Данные добавлены 
                    </div>

                    <div v-else-if="messages.added === false" class="alert alert-danger" role="alert">
                        Ошибка
                    </div>
                    
                    <button class="btn btn-success" type="submit">
                        Добавить
                    </button>
                </div>
            </form>
        </div>
    </section>
</template>

<script>
import ApiResponse from '../../../components/core/ApiResponse';

export default {    
    data() {
        return {
            name: null,
            description: null,
            is_image: false,
            image: null,

            endpoint_url: `/api/notes/`,
        
            messages: {
                added: null,
            },
        }
    },

    watch: {
        'is_image': function(val) {
            if (!val) 
                this.image = null;
        }
    },

    methods: {
        async form_submitted(event) {
            event.preventDefault();

            let form_data = new FormData();
            form_data.append('name', this.name);
            form_data.append('description', this.description);
            form_data.append('is_image', this.is_image);
            form_data.append('image', this.is_image ? this.image : '');

            this.messages.added = null;

            const raw_response = await fetch( this.endpoint_url, {
                method: 'POST',
                body: form_data,
            });

            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_good()) this.messages.added = true;
            else this.messages.added = false;
        },

        image_changed(event) {
            this.image = event.target.files[0];
        }
    },
}
</script>