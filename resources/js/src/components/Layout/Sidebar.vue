<template>
  <aside id="main-wrapper" class="left-sidebar">
    <div>
      <div class="brand-logo d-flex align-items-center justify-content-between p-2">
        <RouterLink to="/dashboard" class="text-nowrap logo-img">
          <img src="../../assets/images/road-44237_640.png" width="180" alt="Hospital Management" class="img-fluid" />
        </RouterLink>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
          <i class="bi bi-x fs-8"></i>
        </div>
      </div>
      <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
          <li class="nav-small-cap">
            <span class="hide-menu">Home</span>
          </li>
          <li class="sidebar-item">
            <RouterLink class="sidebar-link" :to="{ path: '/dashboard' }" :class="{ active: isExactLink('/dashboard') }"
              aria-expanded="false">
              <span>
                <i class="bi bi-house-door"></i>
              </span>
              <span class="hide-menu">Dashboard</span>
            </RouterLink>
          </li>
          <li class="nav-small-cap">
            <span class="hide-menu">Core</span>
          </li>
          <li class="sidebar-item">
            <RouterLink class="sidebar-link" :to="{ path: '/dashboard/patients' }"
              :class="{ active: isExactLink('/dashboard/patients') }" aria-expanded="false">
              <span>
                <i class="bi bi-person"></i>
              </span>
              <span class="hide-menu">Patients</span>
            </RouterLink>
          </li>
          <li class="sidebar-item">
            <RouterLink class="sidebar-link" :to="{ path: '/dashboard/visits' }"
              :class="{ active: isExactLink('/dashboard/visits') }" aria-expanded="false">
              <span>
                <i class="bi bi-calendar-event"></i>
              </span>
              <span class="hide-menu">Visits</span>
            </RouterLink>
          </li>
          <li class="sidebar-item">
            <RouterLink class="sidebar-link" :to="{ path: '/dashboard/vitals' }"
              :class="{ active: isExactLink('/dashboard/vitals') }" aria-expanded="false">
              <span>
                <i class="bi bi-heart-pulse"></i>
              </span>
              <span class="hide-menu">Vitals</span>
            </RouterLink>
          </li>
          <li class="sidebar-item">
            <RouterLink class="sidebar-link" :to="{ path: '/dashboard/treatments' }"
              :class="{ active: isExactLink('/dashboard/treatments') }" aria-expanded="false">
              <span>
                <i class="bi bi-capsule"></i>
              </span>
              <span class="hide-menu">Treatments</span>
            </RouterLink>
          </li>
          <li class="sidebar-item">
            <RouterLink class="sidebar-link" :to="{ path: '/dashboard/referrals' }"
              :class="{ active: isExactLink('/dashboard/referrals') }" aria-expanded="false">
              <span>
                <i class="bi bi-arrow-right-circle"></i>
              </span>
              <span class="hide-menu">Referrals</span>
            </RouterLink>
          </li>
          <!-- <li class="sidebar-item">
            <RouterLink class="sidebar-link" :to="{ path: '/dashboard/users' }"
              :class="{ active: isExactLink('/dashboard/users') }" aria-expanded="false">
              <span>
                <i class="bi bi-people"></i>
              </span>
              <span class="hide-menu">Users</span>
            </RouterLink>
          </li> -->
          <li class="sidebar-item">
            <RouterLink class="sidebar-link" :to="{ path: '/dashboard/departments' }"
              :class="{ active: isExactLink('/dashboard/departments') }" aria-expanded="false">
              <span>
                <i class="bi bi-briefcase"></i>
              </span>
              <span class="hide-menu">Departments</span>
            </RouterLink>
          </li>
          <li class="sidebar-item">
            <RouterLink class="sidebar-link" :to="{ path: '/dashboard/roles' }"
              :class="{ active: isExactLink('/dashboard/roles') }" aria-expanded="false">
              <span>
                <i class="bi bi-person-badge"></i>
              </span>
              <span class="hide-menu">Roles</span>
            </RouterLink>
          </li>
          <li class="sidebar-item">
            <RouterLink class="sidebar-link" :to="{ path: '/dashboard/permissions' }"
              :class="{ active: isExactLink('/dashboard/permissions') }" aria-expanded="false">
              <span>
                <i class="bi bi-shield-check"></i>
              </span>
              <span class="hide-menu">Permissions</span>
            </RouterLink>
          </li>
          <li class="sidebar-item">
            <RouterLink class="sidebar-link" :to="{ path: '/dashboard/filter-patients' }"
              :class="{ active: isExactLink('/dashboard/filter-patients') }" aria-expanded="false">
              <span>
                <i class="bi bi-graph-up-arrow"></i>
              </span>
              <span class="hide-menu">Patient Reports</span>
            </RouterLink>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
</template>

<script>
import { useRoute } from 'vue-router';

export default {
  setup() {
    const route = useRoute();

    const isExactLink = (path) => {
      return route.path === path;
    };

    return { isExactLink };
  }
};
</script>

<style scoped>
.sidebar-link.active {
  background-color: #ddd;
}

.sidebar-link {
  display: block;
}
</style>
