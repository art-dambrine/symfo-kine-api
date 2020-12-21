<template>
    <div>
        <h1>Création d'un nouveau patient</h1>
        <form>
            <div class="form-group">
                <label for="inputName">Nom</label>
                <input type="text" class="form-control" id="inputName" aria-describedby="emailHelp"
                       placeholder="Saisie du nom." v-model="nom">
                <small id="inputNameHelp" class="form-text text-muted">Saisir le nom du patient.</small>
            </div>
            <div class="form-group">
                <label for="inputPrenom">Prenom</label>
                <input type="text" class="form-control" id="inputPrenom" placeholder="Saisie du prenom."
                       v-model="prenom">
                <small id="inputPrenomHelp" class="form-text text-muted">Saisir le prenom du patient.</small>
            </div>
            <div class="form-group">
                <label for="inputDate">Date de naissance</label>
                <input type="date" class="form-control" id="inputDate" placeholder="Date de naissance."
                       v-model="birthdate">
                <small id="inputDateHelp" class="form-text text-muted">Entrer la date de naissance du patient.</small>
            </div>
        </form>

        <button @click="postNewPatientAndCreateAccount()" class="btn btn-primary">Creation du patient et de son
            compte.
        </button>


    </div>
</template>

<script>
  import patientsAPI from '../services/patientsAPI'
  import toast from '../services/toast'

  export default {
    name: 'PatientCreatePage',
    data () {
      return {
        nom: '',
        prenom: '',
        birthdate: ''
      }
    },
    methods: {
      async postNewPatientAndCreateAccount () {
        let data = JSON.stringify(
          {
            'firstName': this.nom,
            'lastName': this.prenom,
            'birthdate': this.birthdate
          }
        )

        try {
          let response = await patientsAPI.createPatient(data)
          let newPatientId = response.data.id
          toast.showToast('success', 'Patient ' + newPatientId + ' créé.')

          try {
            console.log(newPatientId)
            let response = await patientsAPI.createPatientAccount(newPatientId)
            toast.showToast('success', 'Compte du patient créé.')
            console.log(response)
          } catch (e) {
            toast.showToast('error', 'Erreur dans la création du compte. ' + e.response.data['hydra:description'])
          }

        } catch (e) {
          toast.showToast('error', 'Erreur dans la création du patient.')
        }

      }
    }
  }
</script>

<style scoped>

</style>