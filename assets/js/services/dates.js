// Convert timestamp to string date 2020-10-10
function convertDateForUpdate (timestamp) {

  let dateFormated = new Date(timestamp)

  let year = dateFormated.getFullYear()

  // mounth start at 0 = Jan & end at 11 = Dec
  let mounth = dateFormated.getMonth() + 1
  if (mounth < 10) mounth = '0' + mounth

  // getDate to get the day in the mounth
  let day = dateFormated.getDate()
  if (day < 10) day = '0' + day

  return year + '-' + mounth + '-' + day
}

// Conversion d'un timestamp au format de date locale
function localeDateString (timestamp) {
  let dateFormated = new Date(timestamp)

  let year = dateFormated.getFullYear()

  // mounth start at 0 = Jan & end at 11 = Dec
  let mounth = dateFormated.getMonth() + 1
  if (mounth < 10) mounth = '0' + mounth

  // getDate to get the day in the mounth
  let day = dateFormated.getDate()
  if (day < 10) day = '0' + day

  return day + '/' + mounth + '/' + year
}

export default {
  convertDateForUpdate,
  localeDateString
}