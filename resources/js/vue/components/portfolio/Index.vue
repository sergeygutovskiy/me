<template>
    <section class="row">
        <header class="col-12 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h1>Портфолио</h1>
                    <!-- <router-link class="btn btn-success" :to="{ name: 'notes.add' }">
                        Добавить
                    </router-link> -->
                </div>
            </div>
        </header>
        <div class="col-6">
            <div v-for="project in projects" :key="project.id" class="card mb-4">
                <div class="card-body">
                    <h4>{{ project.name }}</h4>
                </div>
                <div class="card-footer">
                    <router-link 
                        :to="{ name: 'portfolio.edit', params: { id: project.id } }"
                        class="btn btn-primary me-1"
                        >
                        Редактировать
                    </router-link>
                    <button 
                        class="btn btn-danger btn-sm"
                        @click="delete_project(project.id)"
                        >
                        Удалить
                    </button>
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
            projects: [],
            projects_endpoint_url: '/api/portfolio/',
        }
    },

    async created() {
        await this.get_projects();
    },

    methods: {
        async get_projects() {
            const raw_response = await fetch(this.projects_endpoint_url);
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.projects = api_response.data().projects; 
        },

        async delete_project(id) {
            const raw_response = await fetch(this.projects_endpoint_url + id, {
                method: 'DELETE',
            });
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.projects = this.projects.filter(project => project.id !== id);
        },
    },
}
</script>