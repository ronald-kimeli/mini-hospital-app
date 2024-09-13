<template>
    <div class="container-fluid">
      <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
              <h4 class="fw-semibold mb-8">Create Permission</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <RouterLink to="/dashboard/permissions">Permissions</RouterLink>
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
            <RouterLink to="/dashboard/permissions" class="btn btn-sm btn-dark float-end">Permissions</RouterLink>
          </h4>
        </div>
        <div class="card-body">
          <form @submit.prevent="createPermission" novalidate>
            <div class="mb-3">
              <label for="permission_name" class="form-label">Permission Name:</label>
              <input
                v-model="permission.name"
                type="text"
                id="permission_name"
                class="form-control"
                :class="{ 'is-invalid': errors.name }"
                required
              />
              <div v-if="errors.name" class="invalid-feedback d-block">
                {{ errors.name[0] || 'Permission Name is required.' }}
              </div>
            </div>
  
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Create Permission</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { defineComponent, ref } from 'vue';
  import { useRouter } from 'vue-router';
  import { useUserStore } from '../../stores/userState';
  
  export default defineComponent({
    name: 'CreatePermission',
    setup() {
      const permission = ref({ name: '' });
      const errors = ref({});
      const router = useRouter();
      const userStore = useUserStore();
      const token = ref(userStore.getToken);
      const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
  
      const createPermission = async () => {
        // Clear previous errors
        errors.value = {};
  
        // Simple client-side validation
        const form = document.querySelector('form');
        if (!form.checkValidity()) {
          form.classList.add('was-validated');
          return;
        }
  
        try {
          const response = await fetch(`${BASE_URL}/api/permissions`, {
            method: 'POST',
            headers: {
              'Authorization': `Bearer ${token.value}`,
              'Accept': 'application/json',
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(permission.value),
          });
  
          const responseData = await response.json();
  
          if (response.ok) {
            if (responseData.status === 'success') {
              router.push('/dashboard/permissions');
            } else {
              errors.value = responseData.errors || {};
              console.log('Validation errors:', errors.value);
            }
          } else {
            errors.value = responseData.errors || { general: ['An error occurred.'] };
            console.error('Server error:', errors.value);
          }
        } catch (error) {
          console.error('Error creating permission:', error);
        }
      };
  
      return {
        permission,
        errors,
        createPermission,
      };
    },
  });
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
  </style>
  