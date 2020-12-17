<template>
    <div>
        <b-navbar toggleable="lg" type="light" variant="light">
            <b-navbar-brand :to="{ name: 'home' }">Kine</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-item :to="{ name: 'patients' }">Patients</b-nav-item>
                    <b-nav-item href="#" disabled>Exercices</b-nav-item>
                </b-navbar-nav>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <b-nav-item :to="{ name: 'login' }">
                        <button class="btn btn-success">Connexion</button>
                    </b-nav-item>
                    <b-nav-item v-show="showDeconnexion">
                        <button @click="handleLogout" class="btn btn-danger">Déconnexion
                        </button>
                    </b-nav-item>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
  import AuthAPI from '../services/authAPI'
  import axios from "axios"

  export default {
    name: 'Navbar',
    methods: {
      handleLogout () {
        AuthAPI.logout()
        this.$router.push({ name: 'login' })
      }
    },
    computed: {
      showDeconnexion () {
        if (AuthAPI.storeToken.token === null)
          return false
        else
          return true
      }

    },
    mounted() {
      // On prévient axios qu'on aura maintenant un header par défaut sur toutes nos futures requêtes HTTP
      axios.defaults.headers.common["Authorization"] = "Bearer " + window.localStorage.getItem("authToken")
      AuthAPI.storeToken.token = window.localStorage.getItem("authToken")
    }
  }
</script>

<style scoped>

</style>