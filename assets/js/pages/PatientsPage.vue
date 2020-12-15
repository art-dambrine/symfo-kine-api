<template>
    <div>
        <h1>Liste des patients</h1>

        <div class="form-group">
            <input type="text" v-model="search" class="form-control" placeholder="Rechercher...">
        </div>

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
                <td class="text-center" ><a @click="redirectToPatientProfile(patient)" class="href-style">{{patient.firstName}} {{patient.lastName}}</a></td>
                <td class="text-center">{{localeDateString(Date.parse(patient.birthdate))}}</td>
                <td class="text-center buttons-actions">
                    <button @click="redirectToPatientProfile(patient)" class="btn btn-sm btn-primary">Afficher</button>
                    <button class="btn btn-sm btn-danger" :disabled="patient.totalRepetition > 0"
                            @click="handleDelete(patient.id)"><i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <pagination
                v-show="(filteredPatients!=null && itemsPerPage < filteredPatients.length)"
                :current-page="currentPage"
                :items-per-page="itemsPerPage"
                :table-length="tableLength"
                :on-page-change="handlePageChange"
        ></pagination>

    </div>
</template>

<script>

  import Pagination, { getDataPagination } from '../components/Pagination'
  import PatientsAPI from '../services/patientsAPI'
  import toast from '../services/toast'

  export default {
    name: 'PatientsPage',
    components: { Pagination },
    data () {
      return {
        patients: null,
        currentPage: 1,
        itemsPerPage: 8,
        search: ''
      }
    },
    computed: {

      // Retourne le tableau filtré des patients en fonction de la recherche
      filteredPatients () {
        if (this.patients != null)
          return this.patients.filter(
            patient =>
              patient.firstName.toLowerCase().includes(this.search.toLowerCase()) ||
              patient.lastName.toLowerCase().includes(this.search.toLowerCase())
          )
        else
          return null
      },

      // Retourne les données paginées
      paginatedPatients () {
        if (this.search != '')
          return getDataPagination.paginatedItems(this.filteredPatients, this.currentPage, this.itemsPerPage)
        else
          return getDataPagination.paginatedItems(this.patients, this.currentPage, this.itemsPerPage)
      },

      // Retourne la taille du tableau de patients filtré
      tableLength () {
        if (this.filteredPatients != null)
          return this.filteredPatients.length
        else
          return null
      }
    },
    watch: {
      // On ramène l'utilisateur à la page 1 à chaque modification de 'search'
      search: function () {
        this.currentPage = 1
      }
    },
    methods: {

      // Permet de récupérer les patients
      async fetchPatients () {
        try {
          this.patients = await PatientsAPI.findAll()
        } catch (e) {
          console.log('error', e)
        }
      },

      // Conversion d'un timestamp au format de date locale
      localeDateString (timestamp) {
        return new Date(timestamp).toLocaleDateString()
      },

      // Gestion de la suppression d'un patient
      async handleDelete (patientId) {

        // Validation avant suppression
        let patient = this.patients.filter(patient => patient.id == patientId)
        let confirm = window.confirm('Voulez vous vraiment supprimer le profil de ' + patient[0].firstName + " " + patient[0].lastName + ' ?')
        if (!confirm) return


        let originalPatients = [...this.patients]

        // ASTUCE: retire dynamiquement le patient au clic sur "supprimer" (approche optimiste)
        this.patients = this.patients.filter(patient => patient.id != patientId)

        try {
          await PatientsAPI.delete(patientId)
        } catch (e) {
          this.patients = originalPatients
          toast.showToast('error',e.toString())
          console.log('error', e)
        }

      },

      //Gestion du changement de page
      handlePageChange (page) { this.currentPage = page},

      redirectToPatientProfile (patient) {
        this.$router.push({ name: 'patient', params: { id: patient.id } })
      }

    },
    mounted () {
      // Au chargement du composant, on va chercher les patients
      this.fetchPatients()
    }
  }
</script>

<style scoped>

    .buttons-actions{
        display: flex;
        justify-content: space-evenly;
    }

    .buttons-actions button{
        padding: 0.35rem 0.6rem;
    }

    .buttons-actions button:first-child{
        flex: 0.4;
    }

    .href-style{
        color: #4582ec;
    }

    .href-style:hover{
        text-decoration: underline;
        color: #1559cf;
        cursor: pointer;
    }

</style>