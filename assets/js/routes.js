export const routes = [
  {path: '/patients', component: require('./pages/PatientsPage').default, name: 'patients'},
  {path: '/patients/:id', component: require('./pages/PatientProfilePage').default, name: 'patient'},
  {path: '/login', component: require('./pages/LoginPage').default, name: 'login'},
  {path: '/', component: require('./pages/HomePage').default, name: 'home'},
  {path: '*', redirect: '/'}
]