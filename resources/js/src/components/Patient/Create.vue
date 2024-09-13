<template>
  <div class="container-fluid">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">Add Patient</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <RouterLink to="/dashboard/patients">Patients</RouterLink>
                </li>
              </ol>
            </nav>
          </div>
          <div class="col-3">
            <div class="text-center mb-n5">
              <img src="../../assets/images/backgrounds/rocket.png" alt="Rocket Icon" class="img-fluid mb-n4" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card shadow rounded">
      <div class="card-header">
        <h4 class="d-inline">
          <RouterLink to="/dashboard/patients" class="btn btn-sm btn-dark float-end">Patients</RouterLink>
        </h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="createPatient" novalidate>
          <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input
              v-model="newPatient.name"
              type="text"
              id="name"
              class="form-control"
              :class="{ 'is-invalid': errors.name }"
              required
            />
            <div v-if="errors.name" class="invalid-feedback d-block">
              {{ errors.name[0] || 'Name is required.' }}
            </div>
          </div>
          
          <div class="mb-3">
            <label for="id_number" class="form-label">ID Number:</label>
            <input
              v-model="newPatient.id_number"
              type="text"
              id="id_number"
              class="form-control"
              :class="{ 'is-invalid': errors.id_number }"
              required
            />
            <div v-if="errors.id_number" class="invalid-feedback d-block">
              {{ errors.id_number[0] || 'ID Number is required.' }}
            </div>
          </div>

          <div class="mb-3">
            <label for="date_of_birth" class="form-label">Date of Birth:</label>
            <input
              v-model="newPatient.date_of_birth"
              type="date"
              id="date_of_birth"
              class="form-control"
              :class="{ 'is-invalid': errors.date_of_birth }"
            />
            <div v-if="errors.date_of_birth" class="invalid-feedback d-block">
              {{ errors.date_of_birth[0] || 'Date of Birth is required.' }}
            </div>
          </div>

          <div class="mb-3">
            <label for="gender" class="form-label">Gender:</label>
            <select
              v-model="newPatient.gender"
              id="gender"
              class="form-select"
              :class="{ 'is-invalid': errors.gender }"
              required
            >
              <option value="" disabled>Select Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
            <div v-if="errors.gender" class="invalid-feedback d-block">
              {{ errors.gender[0] || 'Gender selection is required.' }}
            </div>
          </div>

          <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number:</label>
            <input
              v-model="newPatient.phone_number"
              type="tel"
              id="phone_number"
              class="form-control"
              :class="{ 'is-invalid': errors.phone_number }"
              required
            />
            <div v-if="errors.phone_number" class="invalid-feedback d-block">
              {{ errors.phone_number[0] || 'Phone Number is required.' }}
            </div>
          </div>

          <button type="submit" class="btn btn-primary mt-2">Submit</button>
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
  name: 'CreatePatient',
  setup() {
    const newPatient = ref({
      name: '',
      id_number: '',
      date_of_birth: '',
      gender: '',
      phone_number: ''
    });
    const errors = ref({});
    const router = useRouter();
    const userStore = useUserStore();
    const token = ref(userStore.getToken);

    const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;

    const createPatient = async () => {
      // Clear previous errors
      errors.value = {};

      // Simple client-side validation
      const form = document.querySelector('form');
      if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
      }

      try {
        const response = await fetch(`${BASE_URL}/api/patients`, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token.value}`,
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(newPatient.value),
        });

        const responseData = await response.json();

        if (response.ok) {
          if (responseData.status === 'success') {
            router.push('/dashboard/patients');
          } else {
            errors.value = responseData.errors || {};
            console.log('Validation errors:', errors.value);
          }
        } else {
          errors.value = responseData.errors || { general: ['An error occurred.'] };
          console.error('Server error:', errors.value);
        }
      } catch (error) {
        console.error('Error creating patient:', error);
      }
    };

    return {
      newPatient,
      errors,
      createPatient,
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
