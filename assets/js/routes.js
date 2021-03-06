export const routes = [
  {path: '/patients', component: require('./pages/PatientsPage').default, name: 'patients'},
  {path: '/patients/:id', component: require('./pages/PatientProfilePage').default, name: 'patient'},
  {path: '/create/patient', component: require('./pages/PatientCreatePage').default, name: 'patientCreate'},
  {path: '/login', component: require('./pages/LoginPage').default, name: 'login'},
  {path: '/', component: require('./pages/HomePage').default, name: 'home'},
  {path: '*', redirect: '/'}
]