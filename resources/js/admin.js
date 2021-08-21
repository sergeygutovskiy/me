import Vue from 'vue';
import VueRouter from 'vue-router';

import bootstrap from 'bootstrap';
import '../scss/admin.scss';

import App from './vue/components/App.vue';
import NotesIndex from './vue/components/notes/Index.vue';
import NotesAdd from './vue/components/notes/Add.vue';
import NotesEdit from './vue/components/notes/Edit.vue';

window.Vue = Vue; 

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    base: '/admin/',
    routes: [
        // {
        //     path: '/notes',
        //     name: 'notes',
        //     component: NotesIndex,
        // },
        // {
        //     path: '/notes/add',
        //     name: 'notes.add',
        //     component: NotesAdd,
        // },
        // {
        //     path: '/notes/:id/edit',
        //     name: 'notes.edit',
        //     component: NotesEdit,
        //     props: true,
        // },
    ],
});

new Vue({
    el: '#app',
    render: h => h(App),
    router
});
