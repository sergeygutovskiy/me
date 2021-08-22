<template>
    <section class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h1>Портфолио - {{ edited_project.name }}</h1>
                </div>
            </div>
        </div>
        <div class="col-10">
            <form class="card" v-if="project" @submit="form_submitted">
                <div class="card-body">
                    <div>
                        <label class="form-label">Название</label>
                        <input class="form-control" type="text" v-model="edited_project.name">
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Описание</label>
                        <textarea class="form-control" rows="6" v-model="edited_project.description"></textarea>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Ссылка</label>
                        <input class="form-control" type="text" v-model="edited_project.link">
                    </div>
                    <div class="mt-3">
                        <label class="form-label">GitHub</label>
                        <input class="form-control" type="text" v-model="edited_project.source_link">
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Картинка PC</label>
                        <select class="form-control" v-model="edited_project.pc_image_path">
                            <option :value="null">
                                Нет
                            </option>
                            <option 
                                v-for="image in images" 
                                :key="image" 
                                :value="image"
                                >
                                {{ image }}
                            </option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Картинка Mobile</label>
                        <select class="form-control" v-model="edited_project.mobile_image_path">
                            <option :value="null">
                                Нет
                            </option>
                            <option 
                                v-for="image in images" 
                                :key="image" 
                                :value="image"
                                >
                                {{ image }}
                            </option>
                        </select>
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
            edited_project: {
                name: null,
                description: null,
                pc_image_path: null,
                mobile_image_path: null,
            },

            project: null,
            project_endpoint_url: `/api/portfolio/${this.id}`,
        
            images: [],
            images_endpoint_url: '/api/files/portfolio',

            messages: {
                updated: null,
            },
        }
    },

    async created() {
        await this.get_project();
        await this.get_images();
    },

    methods: {
        async get_project() {
            const raw_response = await fetch(this.project_endpoint_url);
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.project = api_response.data().project; 

            this.edited_project.name = this.project.name;
            this.edited_project.description = this.project.description;
            this.edited_project.link = this.project.link;
            this.edited_project.source_link = this.project.source_link;

            const pc_image = this.project.pc_image_path;
            const mobile_image = this.project.mobile_image_path; 

            if ( pc_image !== null )
                this.edited_project.pc_image_path = pc_image.split('/')[pc_image.split('/').length - 1]
            
            if ( mobile_image !== null )
                this.edited_project.mobile_image_path = mobile_image.split('/')[mobile_image.split('/').length - 1]
        },

        async form_submitted(event) {
            event.preventDefault();

            this.messages.updated = null;

            const raw_response = await fetch( this.project_endpoint_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name: this.edited_project.name,
                    description: this.edited_project.description,
                    link: this.edited_project.link,
                    source_link: this.edited_project.source_link !== '' ? this.edited_project.source_link : null,
                    pc_image_path: this.edited_project.pc_image_path,
                    mobile_image_path: this.edited_project.mobile_image_path,
                })
            });

            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_good()) this.messages.updated = true;
            else this.messages.updated = false;
        },

        async get_images() {
            const raw_response = await fetch(this.images_endpoint_url);
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.images = api_response.data().files; 
        }
    },
}
</script>