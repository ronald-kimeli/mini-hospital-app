<template>
    <div class="container-fluid">
      <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
              <h4 class="fw-semibold mb-8">Add Vital Sign</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <RouterLink to="/dashboard/vitals">Vitals</RouterLink>
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
            <RouterLink to="/dashboard/vitals" class="btn btn-sm btn-dark float-end">Vitals</RouterLink>
          </h4>
        </div>
        <div class="card-body">
          <form @submit.prevent="createVital" novalidate>
            <div class="mb-3">
              <label for="patient_name" class="form-label">Patient Name:</label>
              <input
                v-model="vital.patient_name"
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
              <label for="temperature" class="form-label">Temperature (°C):</label>
              <input
                v-model="vital.temperature"
                type="number"
                id="temperature"
                class="form-control"
                :class="{ 'is-invalid': errors.temperature }"
                required
                step="0.1"
              />
              <div v-if="errors.temperature" class="invalid-feedback d-block">
                {{ errors.temperature[0] || 'Temperature is required.' }}
              </div>
            </div>
            <div class="mb-3">
              <label for="blood_pressure" class="form-label">Blood Pressure:</label>
              <input
                v-model="vital.blood_pressure"
                type="text"
                id="blood_pressure"
                class="form-control"
                :class="{ 'is-invalid': errors.blood_pressure }"
                required
              />
              <div v-if="errors.blood_pressure" class="invalid-feedback d-block">
                {{ errors.blood_pressure[0] || 'Blood Pressure is required.' }}
              </div>
            </div>
            <div class="mb-3">
              <label for="pulse" class="form-label">Pulse:</label>
              <input
                v-model="vital.pulse"
                type="number"
                id="pulse"
                class="form-control"
                :class="{ 'is-invalid': errors.pulse }"
                required
              />
              <div v-if="errors.pulse" class="invalid-feedback d-block">
                {{ errors.pulse[0] || 'Pulse is required.' }}
              </div>
            </div>
            <div class="mb-3">
              <label for="date" class="form-label">Date:</label>
              <input
                v-model="vital.date"
                type="date"
                id="date"
                class="form-control"
                :class="{ 'is-invalid': errors.date }"
                required
              />
              <div v-if="errors.date" class="invalid-feedback d-block">
                {{ errors.date[0] || 'Date is required.' }}
              </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Add Vital Sign</button>
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
    name: 'CreateVital',
    setup() {
      const vital = ref({
        patient_name: '',
        temperature: '',
        blood_pressure: '',
        pulse: '',
        date: ''
      });
      const errors = ref({});
      const router = useRouter();
      const userStore = useUserStore();
      const token = ref(userStore.getToken);
  
      const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
  
      const createVital = async () => {
        // Clear previous errors
        errors.value = {};
  
        // Simple client-side validation
        const form = document.querySelector('form');
        if (!form.checkValidity()) {
          form.classList.add('was-validated');
          return;
        }
  
        try {
          const response = await fetch(`${BASE_URL}/api/vitals`, {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${token.value}`,
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(vital.value),
          });
  
          const responseData = await response.json();
  
          if (response.ok) {
            if (responseData.status === 'success') {
              router.push('/dashboard/vitals');
            } else {
              errors.value = responseData.errors || {};
              console.log('Validation errors:', errors.value);
            }
          } else {
            errors.value = responseData.errors || { general: ['An error occurred.'] };
            console.error('Server error:', errors.value);
          }
        } catch (error) {
          console.error('Error creating vital sign:', error);
        }
      };
  
      return {
        vital,
        errors,
        createVital,
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
  