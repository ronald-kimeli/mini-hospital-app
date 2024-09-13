<template>
    <div class="container-fluid">
      <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
              <h4 class="fw-semibold mb-8">Create Referral</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <RouterLink to="/dashboard/referrals">Referrals</RouterLink>
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
            <RouterLink to="/dashboard/referrals" class="btn btn-sm btn-dark float-end">Referrals</RouterLink>
          </h4>
        </div>
        <div class="card-body">
          <form @submit.prevent="createReferral" novalidate>
            <div class="mb-3">
              <label for="patient_name" class="form-label">Patient Name:</label>
              <input
                v-model="referral.patient_name"
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
              <label for="referred_to" class="form-label">Referred To:</label>
              <input
                v-model="referral.referred_to"
                type="text"
                id="referred_to"
                class="form-control"
                :class="{ 'is-invalid': errors.referred_to }"
                required
              />
              <div v-if="errors.referred_to" class="invalid-feedback d-block">
                {{ errors.referred_to[0] || 'Referred To is required.' }}
              </div>
            </div>
            <div class="mb-3">
              <label for="referral_date" class="form-label">Date:</label>
              <input
                v-model="referral.referral_date"
                type="date"
                id="referral_date"
                class="form-control"
                :class="{ 'is-invalid': errors.referral_date }"
                required
              />
              <div v-if="errors.referral_date" class="invalid-feedback d-block">
                {{ errors.referral_date[0] || 'Referral Date is required.' }}
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
    name: 'CreateReferral',
    setup() {
      const referral = ref({
        patient_name: '',
        referred_to: '',
        referral_date: ''
      });
      const errors = ref({});
      const router = useRouter();
      const userStore = useUserStore();
      const token = ref(userStore.getToken);
  
      const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
  
      const createReferral = async () => {
        // Clear previous errors
        errors.value = {};
  
        // Simple client-side validation
        const form = document.querySelector('form');
        if (!form.checkValidity()) {
          form.classList.add('was-validated');
          return;
        }
  
        try {
          const response = await fetch(`${BASE_URL}/api/referrals`, {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${token.value}`,
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(referral.value),
          });
  
          const responseData = await response.json();
  
          if (response.ok) {
            if (responseData.status === 'success') {
              router.push('/dashboard/referrals');
            } else {
              errors.value = responseData.errors || {};
              console.log('Validation errors:', errors.value);
            }
          } else {
            errors.value = responseData.errors || { general: ['An error occurred.'] };
            console.error('Server error:', errors.value);
          }
        } catch (error) {
          console.error('Error creating referral:', error);
        }
      };
  
      return {
        referral,
        errors,
        createReferral,
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
  