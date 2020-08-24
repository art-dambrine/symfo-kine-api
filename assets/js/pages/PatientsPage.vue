<template>
    <div>
        <h1>Liste des patients</h1>

        <table class="table table-hover">
            <thead>
            <tr>
                <th>Id.</th>
                <th class="text-center">Patient</th>
                <th class="text-center">Date de naissance</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="patient in paginatedPatients" :key="patient.id">
                <td>{{patient.id}}</td>
                <td class="text-center"><a href="#">{{patient.firstName}} {{patient.lastName}}</a></td>
                <td class="text-center">{{localeDateString(Date.parse(patient.birthdate))}}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-info">Editer</button>
                    <button class="btn btn-sm btn-danger" :disabled="patient.totalRepetition > 0"
                            @click="handleDelete(patient.id)">Supprimer
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <pagination
                :current-page="currentPage"
                :items-per-page="itemsPerPage"
                :table-length="tableLength"
                :on-page-change="handlePageChange"
        ></pagination>

    </div>
</template>

<script>

  import Pagination from '../components/Pagination'
  import { getDataPagination } from '../components/Pagination'

  export default {
    name: 'PatientsPage',
    components: { Pagination },
    data () {
      return {
        patients: null,
        currentPage: 1,
        itemsPerPage: 6
      }
    },
    computed: {
      paginatedPatients () {
        return getDataPagination.paginatedItems(this.patients, this.currentPage, this.itemsPerPage)
      },
      tableLength () {
        if (this.patients != null)
          return this.patients.length
        else
          return null
      }
    },
    methods: {
      localeDateString (timestamp) {
        return new Date(timestamp).toLocaleDateString()
      },
      handleDelete (patientId) {

        let originalPatients = [...this.patients]

        this.patients = this.patients.filter(patient => patient.id != patientId)

        var requestOptions = {
          method: 'DELETE',
          redirect: 'follow'
        }

        fetch('http://localhost/api/patients/' + patientId, requestOptions)
          .then(response => {
            if (!response.ok) {
              this.patients = originalPatients
            }
            return response.text()
          })
          .catch(error => {
            this.patients = originalPatients
            console.log('error', error)
          })
      },
      handlePageChange (page) {
          this.currentPage = page
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