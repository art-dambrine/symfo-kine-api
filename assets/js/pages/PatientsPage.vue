<template>
    <div>
        <h1>Liste des patients</h1>

        <table class="table table-hover">
            <thead>
            <tr>
                <th>Id.</th>
                <th class="text-center">Patient</th>
                <th class="text-center">Date de naissance</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="patient in patients" :key="patient.id">
                <td>{{patient.id}}</td>
                <td class="text-center"><a href="#">{{patient.firstName}} {{patient.lastName}}</a></td>
                <td class="text-center">{{localeDateString(Date.parse(patient.birthdate))}}</td>
                <td>
                    <button class="btn btn-sm btn-info">Edit</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>


  export default {
    name: 'PatientsPage',
    data () {
      return {
        patients: null
      }
    },
    methods: {
      localeDateString (timestamp) {
        return new Date(timestamp).toLocaleDateString()
      }
    },
    mounted () {
      let requestOptions = {
        method: 'GET',
        redirect: 'follow'
      }

      fetch('http://localhost/api/patients', requestOptions)
        .then(response => response.json())
        .then(result => this.patients = result['hydra:member'])
        .catch(error => console.log('error', error))
    }
  }
</script>

<style scoped>

</style>