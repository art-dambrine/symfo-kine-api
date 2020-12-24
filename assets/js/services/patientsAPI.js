import axios from 'axios'

function findAll (archived) {
  let suffix = ''
  if (archived != undefined) {
    if (archived == true) suffix = '?archived=true'
    if (archived == false) suffix = '?archived=false'
  }

  let config = {
    method: 'get',
    url: process.env.VUE_APP_API_URL + '/api/patients' + suffix,
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

function createPatient (data) {
  let axios = require('axios')

  let config = {
    method: 'post',
    url: process.env.VUE_APP_API_URL + '/api/patients',
    headers: {
      'Content-Type': 'application/json'
    },
    data: data
  }

  return axios(config)
}

function createPatientAccount (id) {
  let axios = require('axios')
  let data = JSON.stringify({ 'patient': 'api/patients/' + id })

  let config = {
    method: 'post',
    url: process.env.VUE_APP_API_URL + '/api/users',
    headers: {
      'Content-Type': 'application/json'
    },
    data: data
  }

  return axios(config)

}

function deletePatient (id) {

  let config = {
    method: 'delete',
    url: process.env.VUE_APP_API_URL + '/api/patients/' + id,
    headers: {}
  }

  return axios(config)

}

function archivePatient (id, archived) {

  let axios = require('axios')
  let data = JSON.stringify({ 'archived': archived })

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

function updateSimpleAttributesPatient (id, data) {

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

function updatePatientUpdateOneExerciceConfig (idConfigExercice, exerciceJson) {

  let data = exerciceJson

  let config = {
    method: 'patch',
    url: process.env.VUE_APP_API_URL + '/api/patient_config_exercices/' + idConfigExercice,
    headers: {
      'Content-Type': 'application/merge-patch+json'
    },
    data: data
  }

  return axios(config)
}

export default {
  findAll,
  findOne,
  createPatient,
  createPatientAccount,
  generatePatientExerciceDefaultConfig,
  updateSimpleAttributesPatient,
  updateBirthdatePatient,
  updatePatientUpdateOneExerciceConfig,
  delete: deletePatient,
  archive: archivePatient
}