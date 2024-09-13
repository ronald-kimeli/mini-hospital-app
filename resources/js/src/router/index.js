import { createRouter, createWebHistory } from 'vue-router';
import { useUserStore } from '../stores/userState'; // Adjust path as needed

import Dashboard from '../components/Dashboard.vue';
import Main from '../components/Main.vue';
import UsersIndex from '../components/Users/Index.vue';
import UsersCreate from '../components/Users/Create.vue';
import UserDetails from '../components/Users/UserDetails.vue';
import NotFound from '../components/NotFound.vue';
import Login from '../components/Auth/Login.vue';
import Helper from '../components/Helper.vue';
import Index from '../components/Patient/Index.vue';
import Show from '../components/Patient/Show.vue';
import CreatePatient from '../components/Patient/Create.vue';
import DepartmentIndex from '../components/Department/Index.vue';
import DepartmentCreate from '../components/Department/Create.vue';
import TreatmentIndex from '../components/Treatment/Index.vue';
import TreatmentCreate from '../components/Treatment/Create.vue';
import RoleIndex from '../components/Roles/Index.vue';
import RoleCreate from '../components/Roles/Create.vue';
import VitalIndex from '../components/Vitals/Index.vue';
import VitalCreate from '../components/Vitals/Create.vue';
import ReferralIndex from '../components/Referrals/Index.vue';
import ReferralCreate from '../components/Referrals/Create.vue';
import VisitIndex from '../components/Visits/Index.vue';
import VisitCreate from '../components/Visits/Create.vue';
import PermissionIndex from '../components/Permissions/Index.vue';
import PermissionCreate from '../components/Permissions/Create.vue';
import FilterPatients from '../components/FilterPatients.vue';

const routes = [
  {
    path: '/dashboard',
    component: Dashboard,
    meta: { requiresAuth: true },
    children: [
      { path: '', component: Helper },
      { path: 'filter-patients', component: FilterPatients },
      { path: 'patients', component: Index },
      { path: 'patients/create', component: CreatePatient},
      { path: 'departments', component: DepartmentIndex },
      { path: 'departments/create', component: DepartmentCreate},
      { path: 'treatments', component: TreatmentIndex },
      { path: 'treatments/create', component: TreatmentCreate},
      { path: 'roles', component: RoleIndex },
      { path: 'roles/create', component: RoleCreate},
      { path: 'vitals', component: VitalIndex },
      { path: 'vitals/create', component: VitalCreate},
      { path: 'visits', component: VisitIndex },
      { path: 'visits/create', component: VisitCreate},
      { path: 'referrals', component: ReferralIndex },
      { path: 'referrals/create', component: ReferralCreate},
      { path: 'permissions', component: PermissionIndex },
      { path: 'permissions/create', component: PermissionCreate},
      { path: 'users', component: UsersIndex },
      { path: 'users/create', component: UsersCreate },
      { path: 'users/:id', name: 'UserDetails', component: UserDetails },
    ],
  },
  {
    path: '/',
    name: 'Login',
    component: Login,
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: NotFound,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const userStore = useUserStore();
  const isAuthenticated = !!userStore.getToken;

  if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated) {
    next('/');
  } else {
    next();
  }
});

export default router;
