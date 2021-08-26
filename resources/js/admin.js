import Vue from 'vue';
import VueRouter from 'vue-router';

// // import bootstrap from 'bootstrap';
import '../scss/admin.scss';

import App from './vue/components/App.vue';
import SettingsIndex from './vue/components/settings/Index.vue';

import NotesIndex from './vue/components/notes/Index.vue';
import NotesAdd from './vue/components/notes/Add.vue';
import NotesEdit from './vue/components/notes/Edit.vue';

import PortfolioIndex from './vue/components/portfolio/Index.vue';
import PortfolioEdit from './vue/components/portfolio/Edit.vue';

import FilesIndex from './vue/components/files/Index.vue';

import PostsIndex from './vue/components/posts/Index.vue'; 
import PostsAdd from './vue/components/posts/Add.vue'; 
import PostsEdit from './vue/components/posts/Edit.vue'; 

window.Vue = Vue; 

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    base: '/admin/',
    routes: [
        {
            path: '/settings',
            name: 'settings',
            component: SettingsIndex,
        },
        {
            path: '/notes',
            name: 'notes',
            component: NotesIndex,
        },
        {
            path: '/notes/add',
            name: 'notes.add',
            component: NotesAdd,
        },
        {
            path: '/files',
            name: 'files',
            component: FilesIndex,
        },
        {
            path: '/notes/:id/edit',
            name: 'notes.edit',
            component: NotesEdit,
            props: true,
        },
        {
            path: '/portfolio',
            name: 'portfolio',
            component: PortfolioIndex,
        },
        {
            path: '/portfolio/:id/edit',
            name: 'portfolio.edit',
            component: PortfolioEdit,
            props: true,
        },
        {
            path: '/posts',
            name: 'posts',
            component: PostsIndex,
        },
        {
            path: '/posts/add',
            name: 'posts.add',
            component: PostsAdd,
        },
        {
            path: '/posts/:id/edit',
            name: 'posts.edit',
            component: PostsEdit,
            props: true,
        },
    ],
});

new Vue({
    el: '#app',
    render: h => h(App),
    router
});
