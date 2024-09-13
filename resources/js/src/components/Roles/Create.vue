<!-- <template>
  <div class="container-fluid">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">Create Role</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <RouterLink to="/dashboard/roles">Roles</RouterLink>
                </li>
              </ol>
            </nav>
          </div>
          <div class="col-3">
            <div class="text-center mb-n5">
              <img src="../../assets/images/backgrounds/rocket.png" alt="" class="img-fluid mb-n4" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card shadow rounded">
      <div class="card-header">
        <h4 class="d-inline">
          <RouterLink to="/dashboard/roles" class="btn btn-sm btn-dark float-end">Roles</RouterLink>
        </h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="createRole" novalidate>
          <div class="mb-3">
            <label for="role_name" class="form-label">Role Name:</label>
            <input
              v-model="role.name"
              type="text"
              id="role_name"
              class="form-control"
              :class="{ 'is-invalid': errors.name }"
              required
            />
            <div v-if="errors.name" class="invalid-feedback">
              {{ errors.name[0] || 'Role Name is required and must be unique.' }}
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Create Role</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

const role = ref({ name: '' });
const errors = ref({});
const router = useRouter();
const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;

const createRole = async () => {
  errors.value = {};

  const form = document.querySelector('form');
  if (!form.checkValidity()) {
    form.classList.add('was-validated');
    return;
  }

  try {
    const response = await fetch(`${BASE_URL}/api/roles`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(role.value)
    });

    const responseData = await response.json();

    if (response.ok) {
      if (responseData.success) {
        showToast('Role created successfully!', 'success');
        setTimeout(() => {
          router.push('/dashboard/roles');
        }, 1000);
      } else {
        errors.value = responseData.errors || {};
        showToast('Validation errors occurred.', 'error');
      }
    } else {
      showToast(responseData.errors?.general || 'An error occurred.', 'error');
    }
  } catch (error) {
    showToast('An error occurred while creating the role.', 'error');
  }
};

const showToast = (message, type) => {
  Toastify({
    text: message,
    duration: 3000,
    close: true,
    gravity: 'bottom', 
    position: 'right', 
    backgroundColor: type === 'success' ? '#4caf50' : '#f44336',
  }).showToast();
};
</script>

<style scoped>
.invalid-feedback {
  display: block;
}
.was-validated .form-control:invalid,
.was-validated .form-select:invalid {
  border-color: #dc3545;
}
.was-validated .form-control:valid,
.was-validated .form-select:valid {
  border-color: #198754;
}
.text-danger {
  color: #dc3545;
}
</style> -->

<template>
  <div class="container-fluid">
    <!-- Form header -->
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">Create Role</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <RouterLink to="/dashboard/roles">Roles</RouterLink>
                </li>
              </ol>
            </nav>
          </div>
          <div class="col-3">
            <div class="text-center mb-n5">
              <img src="../../assets/images/backgrounds/rocket.png" alt="" class="img-fluid mb-n4" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Display validation errors -->
    <div v-if="validationErrors.length" class="text-danger mb-3">
      <ul>
        <li v-for="error in validationErrors" :key="error">{{ error }}</li>
      </ul>
    </div>

    <!-- Form to create a role -->
    <div class="card shadow rounded">
      <div class="card-header">
        <h4 class="d-inline">
          <RouterLink to="/dashboard/roles" class="btn btn-sm btn-dark float-end">Roles</RouterLink>
        </h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="createRole" novalidate>
          <div class="mb-3">
            <label for="role_name" class="form-label">Role Name:</label>
            <input
              v-model="role.name"
              type="text"
              id="role_name"
              class="form-control"
              :class="{ 'is-invalid': errors.name }"
              required
            />
            <div v-if="errors.name" class="invalid-feedback">
              {{ errors.name[0] || 'Role Name is required and must be unique.' }}
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Create Role</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useNotificationStore } from '../../stores/notificationStore';

const role = ref({ name: '' });
const errors = ref({});
const validationErrors = ref([]);
const router = useRouter();
const notificationStore = useNotificationStore();
const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;

const createRole = async () => {
  errors.value = {};
  validationErrors.value = []; // Clear validation errors
  const form = document.querySelector('form');

  if (!form.checkValidity()) {
    form.classList.add('was-validated');
    // Collect validation errors
    validationErrors.value = Array.from(form.querySelectorAll('.invalid-feedback'))
      .map(el => el.textContent.trim());
    return;
  }

  try {
    const response = await fetch(`${BASE_URL}/api/roles`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(role.value)
    });

    const responseData = await response.json();

    if (response.ok) {
      if (responseData.success) {
        notificationStore.showNotification('Role created successfully!', 'success');
        setTimeout(() => {
          router.push('/dashboard/roles');
        }, 1000);
      } else {
        // Collect validation errors from response
        validationErrors.value = responseData.errors ? Object.values(responseData.errors).flat() : [];
        notificationStore.showNotification('Validation errors occurred.', 'error');
      }
    } else {
      notificationStore.showNotification(responseData.errors?.general || 'An error occurred.', 'error');
    }
  } catch (error) {
    notificationStore.showNotification('An error occurred while creating the role.', 'error');
  }
};
</script>

<style scoped>
.invalid-feedback {
  display: block;
}
.was-validated .form-control:invalid,
.was-validated .form-select:invalid {
  border-color: #dc3545;
}
.was-validated .form-control:valid,
.was-validated .form-select:valid {
  border-color: #198754;
}
.text-danger {
  color: #dc3545;
}
</style>
