<template>
    <section class="row">
        <header class="col-12 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h1>Посты</h1>
                    <router-link class="btn btn-success" :to="{ name: 'posts.add' }">
                        Добавить
                    </router-link>
                </div>
            </div>
        </header>
        <div class="col-6">
            <div v-for="post in posts" :key="post.id" class="card mb-4">
                <div class="card-body">
                    <h4>{{ post.title }}</h4>
                </div>
                <div class="card-footer">
                    <router-link 
                        :to="{ name: 'posts.edit', params: { id: post.id } }"
                        class="btn btn-primary me-1"
                        >
                        Редактировать
                    </router-link>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import ApiResponse from '../../../components/core/ApiResponse';

export default {
    data() {
        return {
            posts: [],
            posts_endpoint_url: '/api/posts/',
        }
    },

    async created() {
        await this.get_posts();
    },

    methods: {
        async get_posts() {
            const raw_response = await fetch(this.posts_endpoint_url);
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.posts = api_response.data().posts; 
        },
    },
}
</script>