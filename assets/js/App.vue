<template>
    <div>
        <h2>Composant Vue APP</h2>
        <p>Mon URL d'API (.env) : {{urlApi}}</p>
        <button class="btn btn-primary" @click="consolelog">Get ramdom number from lodash</button>
        <example></example>
    </div>
</template>

<script>
    import Example from './components/Example'


    export default {
        name: "App",
        components : {
          Example
        },
        data () {
            return {
                urlApi: process.env.VUE_APP_API_URL
            }
        },
        methods : {
             consolelog() {
                console.log(this.lodash.random(0,5))
             }
        }
    }
</script>

<style scoped>

</style>