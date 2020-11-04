<template>
    <div>
        <h2>Consultation / edition du profil patient :</h2> <br>

        <div class="patient-profile jumbotron">
            <div class="container">
                <h1 class="display-4">{{patient.firstName}} {{patient.lastName}}</h1>
                <p class="lead">
                    Date de naissance : {{localeDateString(Date.parse(patient.birthdate))}} <br>
                </p>

                <table>
                    <!-- taille -->
                    <tr>
                        <td>Taille (cm)</td>
                        <td>
                            <div class="form-group my-auto">
                                <input type="text" class="form-control" id="inputTaille" v-model="patient.taille">
                            </div>
                        </td>
                    </tr>

                    <!-- poids -->
                    <tr>
                        <td>Poids (kg)</td>
                        <td>
                            <div class="form-group my-auto">
                                <input type="text" class="form-control" id="inputPoids" v-model="patient.poids">
                            </div>
                        </td>
                    </tr>

                    <!-- IMC -->
                    <tr>
                        <td>IMC</td>
                        <td>
                            <div class="form-group my-auto">
                                <input type="text" class="form-control" id="inputIMC" v-bind:value="calcIMC(patient)"
                                       disabled>
                            </div>
                        </td>
                    </tr>

                    <br>

                    <!-- Borg-->
                    <tr>
                        <td>Borg</td>
                        <td>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptionsBorg"
                                       id="radioBorgTrue" value="true" v-model="patient.borg">
                                <label class="form-check-label" for="radioBorgTrue">Oui</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptionsBorg"
                                       id="radioBorgFalse" value="false" v-model="patient.borg">
                                <label class="form-check-label" for="radioBorgFalse">Non</label>
                            </div>
                        </td>
                    </tr>

                    <br>

                    <!-- Bbloquant-->
                    <tr>
                        <td>BBloquant</td>
                        <td>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptionsBbloquant"
                                       id="radioBbloquantTrue" value="true" v-model="patient.bbloquant">
                                <label class="form-check-label" for="radioBbloquantTrue">Oui</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptionsBbloquant"
                                       id="radioBbloquantFalse" value="false" v-model="patient.bbloquant">
                                <label class="form-check-label" for="radioBbloquantFalse">Non</label>
                            </div>
                        </td>
                    </tr>

                    <!-- Diabete DND DID Aucun -->
                    <tr>
                        <td>Diabete</td>
                        <td>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckboxDnd"
                                       v-model="patient.dnd">
                                <label class="form-check-label" for="inlineCheckboxDnd">DND</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckboxDid"
                                       v-model="patient.did">
                                <label class="form-check-label" for="inlineCheckboxDid">DID</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckboxAucunDiabete"
                                       v-model="diabete" disabled>
                                <label class="form-check-label" for="inlineCheckboxAucunDiabete">Aucun</label>
                            </div>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

</template>

<script>
  import patientsAPI from '../services/patientsAPI'

  export default {
    name: 'PatientProfilePage',
    data () {
      return {
        patient: null,
        patientId: this.$route.params.id
      }
    },
    methods: {
      async fetchPatient () {
        try {
          this.patient = await patientsAPI.findOne(this.patientId)
        } catch (e) {
          console.log(e)
        }
      },
      // Conversion d'un timestamp au format de date locale
      localeDateString (timestamp) {
        return new Date(timestamp).toLocaleDateString()
      },
      calcIMC (patient) {
        let IMC = (parseInt(patient.poids) / (Math.pow(parseInt(patient.taille) / 100, 2)))
        return Math.round(IMC * 100) / 100
      }
    },
    computed: {
      diabete () {
        let did = (this.patient.did == 1)
        let dnd = (this.patient.dnd == 1)
        return (!did && !dnd)
      }
    },
    mounted () {
      // Au chargement du composant on charge le profile du patient
      this.fetchPatient()
    }
  }
</script>

<style scoped>

    table tr {
        display: flex;
        text-align: center;
        margin-bottom: 10px;
    }

    table tr td:first-child {
        width: 100px;
    }

    table tr td:nth-child(2) {
        width: 200px;
    }

    table tr td {
        padding-right: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    table tr td:last-child {
        padding-right: 0;
    }


</style>