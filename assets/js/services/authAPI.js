import axios from 'axios'

function logout () {
  window.localStorage.removeItem("authToken")
  delete axios.defaults.headers["Authorization"]
}

function authenticate (credentials) {
  let data = JSON.stringify({ 'username': credentials.username, 'password': credentials.password })

  let config = {
    method: 'post',
    url: process.env.VUE_APP_API_URL + '/api/login_check',
    headers: {
      'Content-Type': 'application/json'
    },
    data: data
  }


  return axios(config)
    .then(response => response.data.token)
    .then(token => {
      // Je stocke le token dans le local storage
      window.localStorage.setItem('authToken', token)

      // On prévient axios qu'on aura maintenant un header par défaut sur toutes nos futures requêtes HTTP
      axios.defaults.headers["Authorization"] = "Bearer " + token

      return true
    })
}

export default {
  authenticate,
  logout
}