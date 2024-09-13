<template>
    <div class="container-fluid">
      <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
              <h4 class="fw-semibold mb-8">Edit Patient</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><RouterLink to="/dashboard/patients">Patients</RouterLink></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
        <div class="card-body">
          <form @submit.prevent="updatePatient">
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" id="name" v-model="patient.name" class="form-control" :class="{'is-invalid': errors.name}" />
              <div v-if="errors.name" class="invalid-feedback">
                {{ errors.name[0] }}
              </div>
            </div>
  
            <div class="mb-3">
              <label for="id_number" class="form-label">ID Number</label>
              <input type="text" id="id_number" v-model="patient.id_number" class="form-control" :class="{'is-invalid': errors.id_number}" />
              <div v-if="errors.id_number" class="invalid-feedback">
                {{ errors.id_number[0] }}
              </div>
            </div>
  
            <!-- Add more fields as necessary -->
            <div class="mb-3">
              <label for="date_of_birth" class="form-label">Date of Birth</label>
              <input type="date" id="date_of_birth" v-model="patient.date_of_birth" class="form-control" :class="{'is-invalid': errors.date_of_birth}" />
              <div v-if="errors.date_of_birth" class="invalid-feedback">
                {{ errors.date_of_birth[0] }}
              </div>
            </div>
  
            <div class="mb-3">
              <label for="gender" class="form-label">Gender</label>
              <select id="gender" v-model="patient.gender" class="form-select" :class="{'is-invalid': errors.gender}">
                <option value="" disabled>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
              <div v-if="errors.gender" class="invalid-feedback">
                {{ errors.gender[0] }}
              </div>
            </div>
  
            <div class="mb-3">
              <label for="phone_number" class="form-label">Phone Number</label>
              <input type="tel" id="phone_number" v-model="patient.phone_number" class="form-control" :class="{'is-invalid': errors.phone_number}" />
              <div v-if="errors.phone_number" class="invalid-feedback">
                {{ errors.phone_number[0] }}
              </div>
            </div>
  
            <button type="submit" class="btn btn-primary mt-2">Update</button>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { defineComponent, ref, onMounted } from 'vue';
  import { useFetch } from '@vueuse/core';
  import { useUserStore } from '../../stores/userState';
  import { useRoute, useRouter } from 'vue-router';
  
  export default defineComponent({
    name: 'EditPatient',
    setup() {
      const patient = ref({
        name: '',
        id_number: '',
        date_of_birth: '',
        gender: '',
        phone_number: ''
      });
      const errors = ref({});
      const userStore = useUserStore();
      const token = ref(userStore.getToken);
      const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
      const route = useRoute();
      const router = useRouter();
      const patientId = route.params.id;
  
      const fetchPatient = async () => {
        try {
          const response = await fetch(`${BASE_URL}/api/patients/${patientId}`, {
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${token.value}`,
            },
          });
  
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
  
          const data = await response.json();
          patient.value = data.data;
        } catch (error) {
          console.error('Error fetching patient:', error);
        }
      };
  
      const updatePatient = async () => {
        try {
          const response = await fetch(`${BASE_URL}/api/patients/${patientId}`, {
            method: 'PUT',
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${token.value}`,
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(patient.value)
          });
  
          const result = await response.json();
  
          if (response.ok) {
            if (result.success) {
              router.push('/dashboard/patients');
            } else {
              errors.value = result.errors || {};
              console.error('Update failed:', errors.value);
            }
          } else {
            errors.value = result.errors || { general: ['An error occurred.'] };
            console.error('HTTP error:', errors.value);
          }
        } catch (error) {
          console.error('Error updating patient:', error);
        }
      };
  
      onMounted(() => {
        fetchPatient();
      });
  
      return {
        patient,
        errors,
        updatePatient
      };
    },
  });
  </script>
  
  <style scoped>
  .invalid-feedback {
    display: block;
  }
  </style>
  