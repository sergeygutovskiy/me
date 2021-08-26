<template>
    <section class="row" v-if="post">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h1>Посты - {{ post.title }}</h1>
                </div>
            </div>
        </div>
        <div class="col-10">
            <form class="card" @submit="form_submitted">
                <div class="card-body">
                    <div>
                        <label class="form-label">Заголовок</label>
                        <input class="form-control" type="text" v-model="edited_post.title">
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Slug</label>
                        <div class="input-group">
                            <input class="form-control" type="text" v-model="edited_post.slug">
                            <button 
                                class="btn btn-primary" 
                                type="button" 
                                @click="generate_slug"
                                :disabled="!edited_post.title"
                                >
                                Сгенерировать
                            </button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Описание</label>
                        <textarea class="form-control" rows="6" v-model="edited_post.description"></textarea>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Содержание</label>
                        <quill-editor
                            v-model="edited_post.body"
                        />
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

import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

import slugify from 'slugify';

import { quillEditor } from 'vue-quill-editor'

export default {
    props: [
        'id',
    ],
    
    components: {
        quillEditor
    },

    data() {
        return {
            edited_post: {
                title: null,
                slug: null,
                description: null,

                body: null,
                editor: null,
            },

            post: null,
            post_endpoint_url: `/api/posts/${this.id}`,
        
            // images: [],
            // images_endpoint_url: '/api/files/notes',

            messages: {
                updated: null,
            },
        }
    },

    async created() {
        await this.get_post();
        // await this.get_images();
    },

    methods: {
        async get_post() {
            const raw_response = await fetch(this.post_endpoint_url);
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.post = api_response.data().post; 

            this.edited_post.title = this.post.title;
            this.edited_post.slug = this.post.slug;
            this.edited_post.description = this.post.description;
            this.edited_post.body = this.post.body;
        },

        generate_slug() {
            this.edited_post.slug = slugify(this.edited_post.title, {
                lower: true,
            });
        },

        async form_submitted(event) {
            event.preventDefault();

            this.messages.updated = null;

            const raw_response = await fetch( this.post_endpoint_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    title: this.edited_post.title,
                    slug: this.edited_post.slug,
                    description: this.edited_post.description,
                    body: this.edited_post.body
                })
            });

            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_good()) this.messages.updated = true;
            else this.messages.updated = false;
        },

        // async get_images() {
        //     const raw_response = await fetch(this.images_endpoint_url);
        //     const api_response = await (new ApiResponse()).process(raw_response);

        //     if (api_response.is_bad()) {
        //         api_response.alert_problem();
        //         return;
        //     }

        //     this.images = api_response.data().files; 
        // }
    },
}
</script>