export const routes = [
  {path: '/patients', component: require('./pages/PatientsPage').default, name: 'patients'},
  {path: '/', component: require('./pages/HomePage').default, name: 'home'},
  {path: '*', redirect: '/'}
]