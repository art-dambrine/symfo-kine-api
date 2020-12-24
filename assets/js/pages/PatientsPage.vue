<template>
    <div>
        <div class="head-patient-page">
            <h1 class="d-inline">Liste des patients</h1>
            <button @click="redirectToPatientCreate()" class="btn btn-sm btn-outline-primary"><span
                    class="plus-bold">+</span> nouveau patient
            </button>
        </div>

        <div class="form-group display-archive-form">
            <label for="toggleArchived">Afficher les patients archivés. </label>
            <toggle-button id="toggleArchived"
                           class="my-auto" v-model="displayArchived"
                           :sync="true"
                           :labels="{checked: 'Oui', unchecked: 'Non'}"/>
        </div>

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
                <td class="text-center"><a @click="redirectToPatientProfile(patient)"
                                           v-bind:class="{ 'href-style' : !displayArchived,'href-style disabled': displayArchived  }">{{patient.firstName}}
                    {{patient.lastName}}</a></td>
                <td class="text-center">{{localeDateString(Date.parse(patient.birthdate))}}</td>
                <td class="text-center buttons-actions">
                    <button @click="redirectToPatientProfile(patient)" class="btn btn-sm btn-primary"
                            :disabled="displayArchived==true">Afficher
                    </button>
                    <button class="btn btn-sm btn-info"
                            @click="handleArchive(patient.id)"><i class="fas fa-archive"></i>
                    </button>
                    <button class="btn btn-sm btn-danger"
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
        search: '',
        displayArchived: false
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
      },
      // whenever displayArchived changes, this function will run
      displayArchived: function () {
        this.fetchPatients(this.displayArchived)
      }
    },
    methods: {

      // Permet de récupérer les patients (archived = true or false)
      async fetchPatients (archived) {
        try {
          this.patients = await PatientsAPI.findAll(archived)
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
        let confirm = window.confirm('Voulez vous vraiment supprimer le profil de ' + patient[0].firstName + ' ' + patient[0].lastName + ' ?')
        if (!confirm) return

        let originalPatients = [...this.patients]

        // ASTUCE: retire dynamiquement le patient au clic sur "supprimer" (approche optimiste)
        this.patients = this.patients.filter(patient => patient.id != patientId)

        try {
          await PatientsAPI.delete(patientId)
        } catch (e) {
          this.patients = originalPatients
          toast.showToast('error', e.toString())
          console.log('error', e)
        }

      },

      // Gestion de l'archivage d'un patient
      async handleArchive (patientId) {

        let originalPatients = [...this.patients]

        // ASTUCE: retire dynamiquement le patient au clic sur "supprimer" (approche optimiste)
        this.patients = this.patients.filter(patient => patient.id != patientId)

        try {
          await PatientsAPI.archive(patientId, !this.displayArchived)
          if (this.displayArchived) toast.showToast('info', 'Patient retiré des archives.')
          else toast.showToast('info', 'Patient archivé.')
        } catch (e) {
          this.patients = originalPatients
          toast.showToast('error', e.toString())
          console.log('error', e)
        }

      },

      //Gestion du changement de page
      handlePageChange (page) { this.currentPage = page},

      redirectToPatientProfile (patient) {
        this.$router.push({ name: 'patient', params: { id: patient.id } })
      },

      redirectToPatientCreate () {
        this.$router.push({ name: 'patientCreate' })
      }

    },
    mounted () {
      // Au chargement du composant, on va chercher les patients
      this.fetchPatients(false)
    }
  }
</script>

<style scoped>

    .head-patient-page {
        display: flex;
        align-items: center;
    }

    .head-patient-page button {
        margin-left: 20px;
        font-size: 1.1em;
        padding: 0 20px;
    }

    .plus-bold {
        font-weight: bold;
        font-size: 1.2em;
    }

    .display-archive-form {
        display: flex;
        align-items: center;
    }

    .display-archive-form label {
        margin: 0 10px 0 0;
    }

    .buttons-actions {
        display: flex;
        justify-content: space-evenly;
    }

    .buttons-actions button {
        padding: 0.35rem 0.6rem;
    }

    .buttons-actions button:first-child {
        flex: 0.4;
    }

    .href-style {
        color: #4582ec;
    }

    .href-style.disabled {
        color: #414444;
    }

    .href-style:hover {
        text-decoration: underline;
        color: #1559cf;
        cursor: pointer;
    }

    .href-style.disabled:hover {
        color: #414444;
    }

</style>