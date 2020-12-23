<template>
    <div>
        <div class="patient-profile jumbotron">
            <div class="container">

                <div class="profil-header">
                    <span>{{patient.firstName}} {{patient.lastName}} <span class="profil-date-naissance"> - {{localeDateString(Date.parse(patient.birthdate))}}</span></span>
                    <date-picker v-model="patient.birthdate">
                        <template v-slot="{ inputValue, inputEvents }">
                            <div class="calendar-input-wrapper my-auto" @click="tooglePopOver">
                                <input class="btn btn-info button-calendar scale-reduce" id="calendar-input"
                                       v-on="inputEvents"/>
                                <!--On triche en cachant le input derrière un bouton ayant la même apparence-->
                                <button class="btn btn-info button-calendar"></button>
                                <i class="far fa-calendar-alt"></i>
                            </div>
                        </template>
                    </date-picker>
                </div> <!--end of profil-header-->

                <div class="tables-flex-container">
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
                                    <input type="text" class="form-control" id="inputIMC"
                                           v-bind:value="calcIMC(patient)"
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

                        <br>

                        <!-- Fce -->
                        <tr>
                            <td>Fce</td>  <!-- this.$router.push({ name: 'patients'}) -->
                            <td>
                                <div class="form-group my-auto">
                                    <input type="text" class="form-control" id="inputFce" v-model="patient.fce">
                                </div>
                            </td>
                        </tr>

                        <!-- Fevg -->
                        <tr>
                            <td>Fevg</td>  <!-- this.$router.push({ name: 'patients'}) -->
                            <td>
                                <div class="form-group my-auto">
                                    <input type="text" class="form-control" id="inputFevg"
                                           v-model="patient.fevg">
                                </div>
                            </td>
                        </tr>

                    </table>

                    <table>
                        <h4>Exercices</h4>
                        <!-- Exercices -->
                        <tr v-for="exercice in patient.exercice" :key="exercice.id">
                            <td>{{exercice.exercice.name}} (1RM)</td>

                            <td>
                                <div class="form-group my-auto">
                                    <input type="text" class="form-control" v-bind:id="'inputExercice'+exercice.id"
                                           v-model="exercice.OneRm">
                                </div>
                            </td>

                            <td>
                                <toggle-button class="my-auto" v-model="exercice.enabled"
                                               :sync="true"
                                               :labels="{checked: 'Oui', unchecked: 'Non'}"/>
                            </td>
                        </tr>

                        <tr class="tr-button-generer-exercices">
                            <div>
                                <button class="btn btn-primary" @click="handleGenerationExercices(patient.id)">Générer
                                    la config d'exercices
                                </button>
                            </div>
                        </tr>

                    </table>
                </div> <!--end of tables-flex-container-->

                <div class="actions-buttons">
                    <button @click="handleSaveDataPatient(patientId)" class="btn btn-success">Sauvegarder les
                        modifications
                    </button>
                </div>

            </div>
        </div>
    </div>

</template>

<script>
  import patientsAPI from '../services/patientsAPI'
  import PatientsAPI from '../services/patientsAPI'
  import DatePicker from 'v-calendar/lib/components/date-picker.umd'
  import toast from '../services/toast'
  import dates from '../services/dates'

  export default {
    name: 'PatientProfilePage',
    components: { DatePicker },
    data () {
      return {
        patient: null,
        patientId: this.$route.params.id,
        dateNaissanceInitiale: ''
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
        return dates.localeDateString(timestamp)
      },
      // Convert timestamp to string date 2020-10-10
      convertDateForUpdate (timestamp) {
        return dates.convertDateForUpdate(timestamp)
      },

      calcIMC (patient) {
        let IMC = (parseInt(patient.poids) / (Math.pow(parseInt(patient.taille) / 100, 2)))
        return Math.round(IMC * 100) / 100
      },

      isEmptyOrSpaces (str) {
        str = '' + str
        return str === null || str.match(/^\s*$/) !== null
      },

      async handleSaveDataPatient (patientId) {
        try {

          // Gestion du changement de date de naissance
          if (!this.dateIsUnchanged) {
            let confirmation = window.confirm('Voulez vous vraiment modifier la date de naissance ? Cela entrainera également la mise à jour du compte du patient...')
            if (confirmation) {
              try {
                let reponseUpdateBirthdate = await PatientsAPI.updateBirthdatePatient(patientId, this.convertDateForUpdate(Date.parse(this.patient.birthdate)))
                console.log(reponseUpdateBirthdate.data)
                toast.showToast('success', 'Modification de la date de naissance.')
                this.dateNaissanceInitiale = this.patient.birthdate
              } catch (e) {
                toast.showToast('error', 'Erreur dans la mise à jour de la date de naissance.')
                console.log('error', e)
              }
            }
          }

          // Gestion du changement des infos de base

          if (this.isEmptyOrSpaces(this.patient.taille)) this.patient.taille = null
          if (this.isEmptyOrSpaces(this.patient.poids)) this.patient.poids = null
          if (this.isEmptyOrSpaces(this.patient.fce)) this.patient.fce = null
          if (this.isEmptyOrSpaces(this.patient.fevg)) this.patient.fevg = null

          let data = '{ ' +
            '"borg": ' + (this.patient.borg === undefined ? false : this.patient.borg) + ',' +
            ' "taille": ' + (this.patient.taille === undefined ? null : this.patient.taille) + ',' +
            ' "poids": ' + (this.patient.poids === undefined ? null : this.patient.poids) + ',' +
            ' "bbloquant": ' + (this.patient.bbloquant === undefined ? false : this.patient.bbloquant) + ',' +
            '  "dnd": ' + (this.patient.dnd === undefined ? false : this.patient.dnd) + ',' +
            '  "did": ' + (this.patient.did === undefined ? false : this.patient.did) + ',' +
            '  "fce": ' + (this.patient.fce === undefined ? null : this.patient.fce) + ',' +
            '  "fevg": ' + (this.patient.fevg === undefined ? null : this.patient.fevg) + '' +
            '}'

          let response = await PatientsAPI.updateSimpleAttributesPatient(patientId, data)
          console.log(response.data)
          toast.showToast('success', 'Modifications enregistrées avec succès.')

        } catch (e) {
          toast.showToast('error', 'Erreur dans l\'enregistrement des attributs.')
          console.log('error', e)
        }

        // Gestion du changement des données d'exercices

        for (let i = 0; i < this.patient.exercice.length; i++) {

          let exercice = {
            'OneRm': parseInt(this.patient.exercice[i].OneRm),
            'enabled': this.patient.exercice[i].enabled
          }

          try {
            await PatientsAPI.updatePatientUpdateOneExerciceConfig(this.patient.exercice[i].id, JSON.stringify(exercice))
          } catch (e) {
            let num = i + 1
            toast.showToast('error', 'Erreur dans l\'enregistrement de l\'exercice n°' + num)
            console.log('error', e)
          }
        }

      },

      async handleGenerationExercices (patientId) {

        try {
          let response = await PatientsAPI.generatePatientExerciceDefaultConfig(patientId)
          this.patient.exercice = response.data.exercice
          console.log(response.data.exercice)
        } catch (e) {
          console.log('error', e)
        }
      },
      tooglePopOver () {
        document.getElementById('calendar-input').focus()
      },

      async fetchAndSaveInitialDate () {
        try {
          await this.fetchPatient()
          this.dateNaissanceInitiale = this.patient.birthdate
        } catch (e) {
          console.log('error', e)
        }
      }
    },
    computed: {
      diabete () {
        return (!this.patient.did && !this.patient.dnd)
      },
      date () {
        return this.patient.birthdate
      },
      dateIsUnchanged () {
        return this.localeDateString(this.patient.birthdate) === this.localeDateString(this.dateNaissanceInitiale)
      }

    },
    mounted () {
      // Au chargement du composant on charge le profile du patient
      this.fetchAndSaveInitialDate()
    }
  }
</script>

<style scoped>

    .jumbotron {
        padding: 1rem;
        margin: 0 auto;
    }

    .profil-header {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        font-size: 2em;
        font-weight: bold;
    }

    .profil-date-naissance {
        color: gray;
        font-weight: lighter;
        margin-right: 10px;
    }

    /* Calendar input css */

    .calendar-input-wrapper {
        position: relative;
        cursor: pointer;
        width: 36px;
        height: 36px;
        transform: translateY(2px);
    }

    .button-calendar {
        position: absolute;
        font-size: 0.5em;
        color: transparent;
        width: inherit;
        height: inherit;
        opacity: 0.8;
    }

    .scale-reduce {
        transform: scale(0.9);
    }

    .calendar-input-wrapper i {
        color: white;
        text-align: center;
        width: inherit;
        height: inherit;
        font-size: 0.5em;
        transform: translateY(-15px);
    }

    /* fin de calendar input css */

    .tables-flex-container {
        display: flex;
    }

    table tr {
        display: flex;
        text-align: center;
        margin-bottom: 10px;
    }

    table tr td:first-child {
        width: 150px;
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

    /* CSS spécifique du tableau n°1 */

    table:first-child {
        margin-right: 80px;
    }

    /* CSS spécifique du tableau n°2 */
    table:nth-child(2) tr td {
        justify-content: left;
    }

    table:nth-child(2) tr td {
        width: auto;
        padding-right: 20px;
    }

    table:nth-child(2) tr td:nth-child(2) {
        width: 90px;
    }


    .tr-button-generer-exercices div {
        margin-top: 5px;
        width: 100%;
    }


    .actions-buttons {
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        margin: 20px 20px 10px 20px;
        max-width: 820px;
    }

    .actions-buttons button {
        font-size: 0.9em;
        padding: 12px;
    }


</style>