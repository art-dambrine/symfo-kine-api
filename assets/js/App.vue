<template>
    <div>
        <h2>Composant Vue APP</h2>
        <p>Mon URL d'API (.env) : {{urlApi}}</p>
        <button class="btn btn-primary" @click="consolelog">Hello</button>
    </div>
</template>

<script>
    export default {
        name: "App",
        data () {
            return {
                urlApi: process.env.VUE_APP_API_URL
            }
        },
        methods : {
             consolelog() {
                console.log("Hello vue")
             }
        }
    }
</script>

<style scoped>

</style>