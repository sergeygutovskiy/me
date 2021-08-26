<template>
    <div class="card">
        <div class="card-body">
            <form @submit="form_submitted">
                <h2 class="mb-3">
                    Добавить ссылку
                </h2>
                <div class="mb-3">
                    <label class="form-label">Ссылка</label>
                    <input class="form-control" type="text" v-model="added_link.link">
                </div>
                <div class="mb-3">
                    <label class="form-label">Текст</label>
                    <input class="form-control" type="text" v-model="added_link.text">
                </div>
                <div>
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
        
            <div class="mt-4">
                <h2 class="mb-3">
                    Ссылки:
                </h2>
                <div>
                    <div class="card mb-4" v-for="link in links" :key="link.id">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Ссылка</label>
                                <input class="form-control" type="text" v-model="link.link">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Текст</label>
                                <input class="form-control" type="text" v-model="link.text">
                            </div>
                            <div>
                                <button 
                                    class="btn btn-success mr-1" 
                                    type="button" 
                                    @click="update_link(link)"
                                    >
                                    Обновить
                                </button>
                                <button 
                                    class="btn btn-danger" 
                                    type="button" 
                                    @click="delete_link(link)"
                                    >
                                    Удалить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ApiResponse from '../../../../components/core/ApiResponse';

export default {
    props: [
        'note'
    ],

    data() {
        return {
            added_link: {
                link: null,
                text: null,
            },

            links: [],

            messages: {
                added: null,
            },

            added_link_endpoint_url: `/api/notes/${this.note}/links`,
            links_endpoint_url: `/api/notes/${this.note}/links`,
        }
    },

    watch: {
        'added_link.link': function(val) {
            let splitted = val.split('/');
            splitted = splitted.slice(2, 3 - splitted.length);
            
            this.added_link.text = splitted.join('');
        },
    },

    async created() {
        await this.get_links();
    },

    methods: {
        async form_submitted(event) {
            event.preventDefault();

            this.messages.added = null;

            const raw_response = await fetch( this.added_link_endpoint_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    link: this.added_link.link,
                    text: this.added_link.text
                })
            });

            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                this.messages.added = false;
                return;
            }

            this.messages.added = true;
        },

        async get_links() {
            const raw_response = await fetch(this.links_endpoint_url);
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.links = api_response.data().links; 
        },

        async update_link(link) {
            const raw_response = await fetch( this.added_link_endpoint_url + `/${link.id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    link: link.link,
                    text: link.text
                })
            });

            const api_response = await (new ApiResponse()).process(raw_response);
        },

        async delete_link(link) {
            const raw_response = await fetch( this.added_link_endpoint_url + `/${link.id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            const api_response = await (new ApiResponse()).process(raw_response);
            
            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.links = this.links.filter(l => l.id !== link.id);
        },
    }
}
</script>