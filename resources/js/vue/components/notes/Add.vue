<template>
    <section class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h1>Заметки - Добавить</h1>
                </div>
            </div>
        </div>
        <div class="col-6">
            <form class="card" @submit="form_submitted">
                <div class="card-body">
                    <div>
                        <label class="form-label">Название</label>
                        <input class="form-control" type="text" v-model="name">
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

            endpoint_url: `/api/notes/`,
        
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
                    name: this.name,
                    description: this.description
                })
            });

            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_good()) this.messages.added = true;
            else this.messages.added = false;
        },
    },
}
</script>