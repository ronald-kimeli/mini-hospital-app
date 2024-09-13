<template>
  <!-- Header Start -->
  <header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none">
          <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="#">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-icon-hover" href="#">
            <i class="ti ti-bell-ringing"></i>
            <div class="notification bg-primary rounded-circle"></div>
          </a>
        </li>
      </ul>
      <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
          <li class="nav-item">
            <a :href="sourceCodeUrl" target="_blank" class="btn btn-primary">Source Code</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link nav-icon-hover" href="#" id="drop2" @click="toggleDropdown" aria-expanded="false">
              <img src="../../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
            </a>
            <div v-show="isDropdownOpen" class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
              <div class="message-body">
                <a href="#" class="d-flex align-items-center gap-2 dropdown-item">
                  <i class="ti ti-user fs-6"></i>
                  <p class="mb-0 fs-3">{{ user.name || 'My Profile' }}</p>
                </a>
                <button @click="logout" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</button>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Header End -->
</template>

<script setup>
import { ref, computed } from 'vue';
import { useUserStore } from '../../stores/userState';
import { useRouter } from 'vue-router';

const userStore = useUserStore();
const router = useRouter();

const user = computed(() => userStore.getUser);
const token = computed(() => userStore.getToken);
const isDropdownOpen = ref(false);

const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
const sourceCodeUrl = import.meta.env.VITE_SOURCE_CODE_URL || 'https://github.com/ronald-kimeli';

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};

const logout = async () => {
  try {
    const response = await fetch(`${BASE_URL}/api/logout`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token.value}`,
      },
    });

    if (response.ok) {
      userStore.clearUser();
      router.push('/');
    } else {
      throw new Error('Logout failed!');
    }
  } catch (error) {
    console.error('Logout error:', error);
  }
};

// Close dropdown when clicking outside
document.addEventListener('click', (event) => {
  const dropdown = document.querySelector('.dropdown-menu');
  if (dropdown && !dropdown.contains(event.target) && !event.target.closest('.dropdown')) {
    isDropdownOpen.value = false;
  }
});
</script>

<style scoped>
/* Improved dropdown styles */
.dropdown-menu {
  display: none;
  position: absolute;
  right: 0;
  top: 100%;
  z-index: 1000;
  background-color: #fff;
  border: 1px solid rgba(0,0,0,.125);
  border-radius: .25rem;
  box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
}

.dropdown-menu.show {
  display: block;
}

.nav-item .dropdown-menu {
  display: none;
}

.nav-item:hover .dropdown-menu,
.nav-item .dropdown-menu.show {
  display: block;
}

/* Add some padding and styling to the dropdown items */
.dropdown-item {
  padding: 0.5rem 1rem;
  border-bottom: 1px solid rgba(0,0,0,.125);
}

.dropdown-item:last-child {
  border-bottom: none;
}
</style>
