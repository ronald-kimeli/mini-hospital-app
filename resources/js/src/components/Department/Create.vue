<template>
    <div class="container-fluid">
      <!-- Header and Create Department Button -->
      <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
              <h4 class="fw-semibold mb-8">Create Department</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item" aria-current="page">Departments</li>
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
  
      <!-- Create Department Form -->
      <div class="card shadow rounded">
        <div class="card-body p-3">
          <form @submit.prevent="createDepartment">
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" id="name" v-model="department.name" class="form-control" :class="{'is-invalid': errors.name}" />
              <div v-if="errors.name" class="invalid-feedback">
                {{ errors.name[0] }}
              </div>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <input type="text" id="description" v-model="department.description" class="form-control" :class="{'is-invalid': errors.description}" />
              <div v-if="errors.description" class="invalid-feedback">
                {{ errors.description[0] }}
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { defineComponent, ref } from 'vue';
  import { useUserStore } from '../../stores/userState';
  import { useRouter } from 'vue-router';
  
  export default defineComponent({
    name: 'CreateDepartment',
    setup() {
      const department = ref({ name: '', description: '' });
      const errors = ref({});
      const userStore = useUserStore();
      const token = ref(userStore.getToken);
      const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
      const router = useRouter();
  
      const validateForm = () => {
        errors.value = {}; // Reset errors
        let valid = true;
  
        if (!department.value.name.trim()) {
          errors.value.name = ['Name is required.'];
          valid = false;
        }
  
        if (!department.value.description.trim()) {
          errors.value.description = ['Description is required.'];
          valid = false;
        }
  
        return valid;
      };
  
      const createDepartment = async () => {
        if (!validateForm()) {
          return;
        }
  
        try {
          const response = await fetch(`${BASE_URL}/api/departments`, {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${token.value}`,
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(department.value),
          });
  
          const result = await response.json();
          if (response.ok) {
            if (result.status === 'success') {
              console.log('Redirecting to /admin/patients');
              router.push('/admin/patients'); // Updated redirection URL
            } else {
              errors.value = result.errors || {};
              console.log('Validation errors:', errors.value);
            }
          } else {
            errors.value = { general: ['An error occurred while creating the department.'] };
            console.error('Server error:', errors.value);
          }
        } catch (error) {
          console.error('Error creating department:', error);
        }
      };
  
      return {
        department,
        errors,
        createDepartment
      };
    },
  });
  </script>
  
  <style scoped>
  .card.bg-info-subtle {
    background-color: #e3f2fd; /* Adjust this to match your theme */
  }
  
  .is-invalid {
    border-color: #dc3545;
  }
  
  .invalid-feedback {
    display: block;
  }
  
  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
  }
  
  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
  }
  </style>
  