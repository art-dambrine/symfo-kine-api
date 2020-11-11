<template>
    <div>
        <navbar></navbar>
        <div class="container pt-3">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>

  import Navbar from './components/Navbar'

  export default {
    name: 'App',
    components: { Navbar }
  }
</script>

<style scoped>

</style>