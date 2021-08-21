<template>
    <main class="container mt-5 mb-5">
        <div class="row">
            <div class="col-4 mb-4">
                <ul class="list-group list-group-horizontal">
                    <router-link class="list-group-item list-group-item-action" :to="{ name: 'notes' }">
                        Заметки
                    </router-link>
                </ul>
            </div>
            <div class="col-12">
                <router-view />
            </div>
        </div>
    </main>
</template>

<script>
export default {
    data() {
        return {
        }   
    },
}
</script>