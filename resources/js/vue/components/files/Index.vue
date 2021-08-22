<template>
    <section class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h1>Файловый менеджер</h1>
                </div>
            </div>
        </div>
        <div class="col-12 mb-3">
            <h2 class="mb-3">Заметки</h2>
            
            <div class="card">
                <div class="card-body">

                <h3 class="mb-3">Удаление</h3>
                <div class="mb-3">
                    <div class="input-group">
                        <select class="form-control" v-model="current_note">
                            <option :value="null">
                                Выберете картинку
                            </option>
                            <option 
                                v-for="note in notes" 
                                :key="note" 
                                :value="note"
                                >
                                {{ note }}
                            </option>
                        </select>
                        <button 
                            class="btn btn-danger" 
                            @click="delete_note_file"
                            :disabled="!current_note"
                            >
                            Удалить
                        </button>
                    </div>
                </div>
                
                <h3 class="mb-3">Добавление</h3>
                <vue-dropzone 
                    ref="notes" 
                    id="notes_dropzone" 
                    :options="files_notes"
                    >
                </vue-dropzone>
                </div>
            </div>
        </div>

        <div class="col-12">
            <h2 class="mb-3">Портфолио</h2>
            
            <div class="card">
                <div class="card-body">

                <h3 class="mb-3">Удаление</h3>
                <div class="mb-3">
                    <div class="input-group">
                        <select class="form-control" v-model="current_project">
                            <option :value="null">
                                Выберете картинку
                            </option>
                            <option 
                                v-for="project in projects" 
                                :key="project" 
                                :value="project"
                                >
                                {{ project }}
                            </option>
                        </select>
                        <button 
                            class="btn btn-danger" 
                            @click="delete_project_file"
                            :disabled="!current_project"
                            >
                            Удалить
                        </button>
                    </div>
                </div>
                
                <h3 class="mb-3">Добавление</h3>
                <vue-dropzone 
                    ref="notes" 
                    id="notes_dropzone" 
                    :options="files_projects"
                    >
                </vue-dropzone>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import ApiResponse from '../../../components/core/ApiResponse';

import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    components: {
        vueDropzone: vue2Dropzone
    },

    data() {
        return {
            files_notes: {
                url: '/api/files/notes',
                thumbnailWidth: 150,
                maxFilesize: 2.0,
                headers: { 
                }
            },
            
            files_projects: {
                url: '/api/files/portfolio',
                thumbnailWidth: 150,
                maxFilesize: 2.0,
                headers: { 
                }
            },

            notes_endpoint_url: '/api/files/notes',
            notes: [],
            current_note: null,

            projects_endpoint_url: '/api/files/portfolio',
            projects: [],
            current_project: null,
        }
    },

    async created() {
        await this.get_notes_files();
        await this.get_projects_files();
    },

    methods: {
        async get_notes_files() {
            const raw_response = await fetch(this.notes_endpoint_url);
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.notes = api_response.data().files; 
        },

        async get_projects_files() {
            const raw_response = await fetch(this.projects_endpoint_url);
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.projects = api_response.data().files; 
        },

        async delete_note_file() {
            const raw_response = await fetch( this.notes_endpoint_url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name: this.current_note,
                })
            });
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.notes = this.notes.filter(n => n !== this.current_note);
            this.current_note = null;
        },

        async delete_project_file() {
            const raw_response = await fetch( this.projects_endpoint_url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name: this.current_project,
                })
            });
            const api_response = await (new ApiResponse()).process(raw_response);

            if (api_response.is_bad()) {
                api_response.alert_problem();
                return;
            }

            this.projects = this.projects.filter(p => p !== this.current_project);
            this.current_project = null;
        },
    },
}
</script>