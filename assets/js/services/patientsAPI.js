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

function findOne (id) {

  let config = {
    method: 'get',
    url: process.env.VUE_APP_API_URL + '/api/patients/' + id,
    headers: {}
  }

  return axios(config)
    .then(response => response.data)

}

function deletePatient (id) {

  let config = {
    method: 'delete',
    url: process.env.VUE_APP_API_URL + '/api/patients/' + id,
    headers: {}
  }

  return axios(config)

}

function updateSimpleAttributesPatient (id, data) {

  let axios = require('axios')
  let config = {
    method: 'patch',
    url: process.env.VUE_APP_API_URL + '/api/patients/' + id,
    headers: {
      'Content-Type': 'application/merge-patch+json'
    },
    data: data
  }

  return axios(config)
}

function updateBirthdatePatient (id, newBirthdate) {

  let axios = require('axios')
  let data = '{"birthdate": "' + newBirthdate + '"}'

  let config = {
    method: 'patch',
    url: process.env.VUE_APP_API_URL + '/api/patients/' + id,
    headers: {
      'Content-Type': 'application/merge-patch+json'
    },
    data: data
  }

  return axios(config)

}

function generatePatientExerciceDefaultConfig (id) {

  let data = JSON.stringify({})

  let config = {
    method: 'post',
    url: process.env.VUE_APP_API_URL + '/api/exercices/' + id + '/generateexercicesconfig',
    headers: {
      'Content-Type': 'application/json'
    },
    data: data
  }

  return axios(config)

}

export default {
  findAll, findOne, generatePatientExerciceDefaultConfig, updateSimpleAttributesPatient, updateBirthdatePatient,
  delete: deletePatient
}