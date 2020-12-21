<template>
    <div>
        <h1>Création d'un nouveau patient</h1>
        <form>
            <div class="form-group">
                <label for="inputName">Nom</label>
                <input type="text" class="form-control" id="inputName" aria-describedby="emailHelp" placeholder="Saisie du nom.">
                <small id="inputNameHelp" class="form-text text-muted">Saisir le nom du patient.</small>
            </div>
            <div class="form-group">
                <label for="inputPrenom">Prenom</label>
                <input type="text" class="form-control" id="inputPrenom" placeholder="Saisie du prenom.">
                <small id="inputPrenomHelp" class="form-text text-muted">Saisir le prenom du patient.</small>
            </div>
            <div class="form-group">
                <label for="inputDate">Date de naissance</label>
                <input type="date" class="form-control" id="inputDate" placeholder="Date de naissance.">
                <small id="inputDateHelp" class="form-text text-muted">Entrer la date de naissance du patient.</small>
            </div>
            <button type="submit" class="btn btn-primary">Creation du patient et de son compte.</button>
        </form>


    </div>
</template>

<script>
  export default {
    name: 'PatientCreatePage'
  }
</script>

<style scoped>

</style>