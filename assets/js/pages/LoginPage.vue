<template>
    <div>
        <h1>Connexion à l'application</h1>

        <form @submit="handleSubmit">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text"
                       placeholder="Nom d'utilisateur"
                       name="username"
                       id="username"
                       :class="{'form-control':true, 'is-invalid': (error != '')}"
                       v-model="credentials.username"
                >
                <p v-show="(error != '')" class="invalid-feedback">{{error}}</p>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password"
                       placeholder="Mot de passe"
                       name="password"
                       id="password"
                       class="form-control"
                       v-model="credentials.password"
                >
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Je me connecte</button>
            </div>
        </form>
    </div>
</template>

<script>
  import AuthAPI from '../services/authAPI'

  export default {
    name: 'LoginPage',
    data () {
      return {
        credentials: {
          username: '',
          password: ''
        },
        error: ''
      }
    },
    methods: {
      async handleSubmit (event) {
        event.preventDefault()

        try {
          await AuthAPI.authenticate(this.credentials)
          this.error = ''
        } catch (e) {
          this.error = 'Aucun compte ne possède ce nom d\'utilisateur ou alors les informations sont incorrectes'
        }
      }
    }
  }
</script>

<style scoped>

</style>