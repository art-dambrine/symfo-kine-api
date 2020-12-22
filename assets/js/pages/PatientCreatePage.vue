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

            <date-picker v-model="birthdate">
                <template v-slot="{ inputValue, inputEvents }">
                    <div class="form-group">
                        <label for="inputDate">Date de naissance</label>
                        <input class="form-control" id="inputDate"
                               placeholder="Cliquer dans le champ pour selectionner."
                               v-on="inputEvents"
                               v-bind:value="(birthdate == '' ? '' : localeDateString(Date.parse(birthdate)))"/>
                        <small id="inputDateHelp" class="form-text text-muted">
                            Entrer la date de naissance du patient.</small>
                    </div>
                </template>
            </date-picker>

        </form>

        <button @click="postNewPatientAndCreateAccount()" class="btn btn-primary">Creation du patient et de son
            compte.
        </button>


    </div>
</template>

<script>
  import patientsAPI from '../services/patientsAPI'
  import toast from '../services/toast'
  import DatePicker from 'v-calendar/lib/components/date-picker.umd'
  import dates from '../services/dates'

  export default {
    name: 'PatientCreatePage',
    components: { DatePicker },
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
            'birthdate': this.convertDateForUpdate(Date.parse(this.birthdate))
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

      },

      // Convert timestamp to string date 2020-10-10
      convertDateForUpdate (timestamp) {
        return dates.convertDateForUpdate(timestamp)
      },
      // Conversion d'un timestamp au format de date locale
      localeDateString (timestamp) {
        return dates.localeDateString(timestamp)
      }

    }
  }
</script>

<style scoped>

</style>