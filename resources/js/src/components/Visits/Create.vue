<template>
    <div class="container-fluid">
      <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
              <h4 class="fw-semibold mb-8">Create Visit</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <RouterLink to="/dashboard/visits">Visits</RouterLink>
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
            <RouterLink to="/dashboard/visits" class="btn btn-sm btn-dark float-end">Visits</RouterLink>
          </h4>
        </div>
        <div class="card-body">
          <form @submit.prevent="createVisit" novalidate>
            <div class="mb-3">
              <label for="patient_name" class="form-label">Patient Name:</label>
              <input
                v-model="visit.patient_name"
                type="text"
                id="patient_name"
                class="form-control"
                :class="{ 'is-invalid': errors.patient_name }"
                required
              />
              <div v-if="errors.patient_name" class="invalid-feedback d-block">
                {{ errors.patient_name[0] || 'Patient Name is required.' }}
              </div>
            </div>
            <div class="mb-3">
              <label for="doctor_name" class="form-label">Doctor Name:</label>
              <input
                v-model="visit.doctor_name"
                type="text"
                id="doctor_name"
                class="form-control"
                :class="{ 'is-invalid': errors.doctor_name }"
                required
              />
              <div v-if="errors.doctor_name" class="invalid-feedback d-block">
                {{ errors.doctor_name[0] || 'Doctor Name is required.' }}
              </div>
            </div>
            <div class="mb-3">
              <label for="visit_date" class="form-label">Date:</label>
              <input
                v-model="visit.visit_date"
                type="date"
                id="visit_date"
                class="form-control"
                :class="{ 'is-invalid': errors.visit_date }"
                required
              />
              <div v-if="errors.visit_date" class="invalid-feedback d-block">
                {{ errors.visit_date[0] || 'Visit Date is required.' }}
              </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Create</button>
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
    name: 'CreateVisit',
    setup() {
      const visit = ref({
        patient_name: '',
        doctor_name: '',
        visit_date: ''
      });
      const errors = ref({});
      const router = useRouter();
      const userStore = useUserStore();
      const token = ref(userStore.getToken);
  
      const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
  
      const createVisit = async () => {
        // Clear previous errors
        errors.value = {};
  
        // Simple client-side validation
        const form = document.querySelector('form');
        if (!form.checkValidity()) {
          form.classList.add('was-validated');
          return;
        }
  
        try {
          const response = await fetch(`${BASE_URL}/api/visits`, {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${token.value}`,
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(visit.value),
          });
  
          const responseData = await response.json();
  
          if (response.ok) {
            if (responseData.status === 'success') {
              router.push('/dashboard/visits');
            } else {
              errors.value = responseData.errors || {};
              console.log('Validation errors:', errors.value);
            }
          } else {
            errors.value = responseData.errors || { general: ['An error occurred.'] };
            console.error('Server error:', errors.value);
          }
        } catch (error) {
          console.error('Error creating visit:', error);
        }
      };
  
      return {
        visit,
        errors,
        createVisit,
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
  