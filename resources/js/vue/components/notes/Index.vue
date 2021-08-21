<template>
    <section class="row">
        <header class="col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h1>Заметки</h1>
                    <router-link class="btn btn-success" :to="{ name: 'notes.add' }">
                        Добавить
                    </router-link>
                </div>
            </div>
        </header>
        <div class="col-6 mt-4">
            <div v-for="note in notes" :key="note.id" class="card mb-4">
                <div class="card-body">
                    <h4>{{ note.name }}</h4>
                </div>
                <div class="card-footer">
                    <router-link 
                        :to="{ name: 'notes.edit', params: { id: note.id } }"
                        class="btn btn-primary btn-sm me-1"
                        >
                        Редактировать
                    </router-link>
                    <button 
                        class="btn btn-danger btn-sm"
                        @click="delete_note(note.id)"
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
            notes: [],
            notes_endpoint_url: '/api/notes/',
        }
    },

    async created() {
        await this.get_notes();
    },

    methods: {
        async get_notes() {
            const raw_response = await fetch(this.notes_endpoint_url);
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.notes = api_response.data().notes; 
        },

        async delete_note(id) {
            const raw_response = await fetch(this.notes_endpoint_url + id, {
                method: 'DELETE',
            });
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }
        },
    },
}
</script>