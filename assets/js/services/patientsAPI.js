import axios from 'axios'

function findAll () {

  let config = {
    method: 'get',
    url: process.env.VUE_APP_API_URL + '/api/patients',
    headers: {}
  }

  return axios(config)
    .then(response => response.data['hydra:member'])

}

function deletePatient (id) {

  let config = {
    method: 'delete',
    url: process.env.VUE_APP_API_URL + '/api/patients/' + id,
    headers: {}
  }

  return axios(config)

}

export default {
  findAll,
  delete: deletePatient
}