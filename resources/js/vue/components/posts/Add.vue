<template>
    <section class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h1>Посты - Добавить</h1>
                </div>
            </div>
        </div>
        <div class="col-10">
            <form class="card" @submit="form_submitted">
                <div class="card-body">
                    <div>
                        <label class="form-label">Заголовок</label>
                        <input class="form-control" type="text" v-model="title">
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Slug</label>
                        <div class="input-group">
                            <input class="form-control" type="text" v-model="slug">
                            <button 
                                class="btn btn-primary" 
                                type="button" 
                                @click="generate_slug"
                                :disabled="!title"
                                >
                                Сгенерировать
                            </button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Описание</label>
                        <textarea class="form-control" rows="6" v-model="description"></textarea>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Содержание</label>
                        <quill-editor
                            v-model="body"
                        />
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

import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

import slugify from 'slugify';

import { quillEditor } from 'vue-quill-editor'

export default {
    components: {
        quillEditor
    },

    data() {
        return {
            title: null,
            slug: null,
            description: null,

            body: null,
            editor: null,

            endpoint_url: `/api/posts/`,
        
            messages: {
                added: null,
            },
        }
    },

    methods: {
        async form_submitted(event) {
            event.preventDefault();

            this.messages.added = null;

            const raw_response = await fetch( this.endpoint_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    title: this.title,
                    slug: this.slug,
                    description: this.description,
                    body: this.body
                })
            });

            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_good()) this.messages.added = true;
            else this.messages.added = false;
        },

        generate_slug() {
            this.slug = slugify(this.title, {
                lower: true,
            });
        }
    },
}
</script>