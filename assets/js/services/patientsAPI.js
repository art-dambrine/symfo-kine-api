function findAll () {
  let requestOptions = {
    method: 'GET',
    redirect: 'follow'
  }

  return fetch(process.env.VUE_APP_API_URL + '/api/patients', requestOptions)
    .then(response => response.json())
    .then(result => result['hydra:member'])
}

function deletePatient (id) {
  let requestOptions = {
    method: 'DELETE',
    redirect: 'follow'
  }

  return fetch(process.env.VUE_APP_API_URL + '/api/patients/' + id, requestOptions)
}

export default {
  findAll,
  delete: deletePatient
}