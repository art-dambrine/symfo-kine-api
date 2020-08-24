<template>
    <div>
        <h1>Liste des patients</h1>

        <table class="table table-hover">
            <thead>
            <tr>
                <th>Id.</th>
                <th>Patient</th>
                <th>Username</th>
                <th class="text-center">Date de naissance</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>123</td>
                <td><a href="#">Arthur Dambrine</a></td>
                <td>a.dambrine.21</td>
                <td class="text-center">21-11-1996</td>
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
    name: 'PatientsPage'
  }
</script>

<style scoped>

</style>