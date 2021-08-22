<template>
    <section class="row">
        <header class="col-12 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h1>Настройки</h1>
                </div>
            </div>
        </header>
        <div class="col-12">
            <form class="card mb-5" v-for="item in settings" :key="item.id" @submit="send_form($event, item)">
                <div class="card-body">
                    <h2 class="mb-3">{{ item.name }}</h2>
                    <div class="mb-3">
                        <label class="form-label">Название</label>
                        <input class="form-control" type="text" :value="item.param" disabled>
                    </div>
                    <div>
                        <label class="form-label">Значение</label>
                        <textarea 
                            rows="5"
                            class="form-control" 
                            v-model="item.value"
                        ></textarea>
                    </div>
                </div>
                <div class="card-footer">
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
    data() {
        return {
            settings: [],
            settings_endpoint_url: '/api/settings'
        }
    },

    async created() {
        await this.get_settings();
    },

    methods: {
        async get_settings() {
            const raw_response = await fetch(this.settings_endpoint_url);
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.settings = api_response.data().settings; 
        },

        async send_form(event, setting) {
            event.preventDefault();
            console.log(setting);
            
            const endpoint_url = this.settings_endpoint_url + `/${setting.id}`;
            
            const raw_response = await fetch(endpoint_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    value: setting.value, 
                })
            });
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }
        }
    },
}
</script>