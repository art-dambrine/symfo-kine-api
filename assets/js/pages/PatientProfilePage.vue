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
                    <tr>
                        <td>Taille (cm)</td>
                        <td>
                            <div class="form-group my-auto">
                                <input type="text" class="form-control" id="inputTaille" v-model="patient.taille">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Poids (kg)</td>
                        <td>
                            <div class="form-group my-auto">
                                <input type="text" class="form-control" id="inputPoids" v-model="patient.poids">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>IMC</td>
                        <td>
                            <div class="form-group my-auto">
                                <input type="text" class="form-control" id="inputIMC" v-bind:value="calcIMC(patient)" disabled>
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
      calcIMC(patient){
        let IMC = (parseInt(patient.poids) / (Math.pow(parseInt(patient.taille) / 100 ,2)))
        return Math.round(IMC * 100) / 100
      }
    },
    mounted () {
      // Au chargement du composant on charge le profile du patient
      this.fetchPatient()
    }
  }
</script>

<style scoped>

    table tr{
        display: flex;
        text-align: center;
        margin-bottom: 10px;
    }

    table tr td:first-child{
        width: 50px;
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