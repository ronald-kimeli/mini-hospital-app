<template>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <RouterLink to="/" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="../../assets/images/road-44237_640.png" width="180" alt="Hospital Management" />
                </RouterLink>

                <form @submit.prevent="loginUser">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="email" v-model="user.email" class="form-control" aria-describedby="emailHelp">
                    <span v-if="errors.email" class="text-danger">{{ errors.email[0] }}</span>
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" v-model="user.password" class="form-control">
                    <span v-if="errors.password" class="text-danger">{{ errors.password[0] }}</span>
                  </div>
                  <span v-if="errors.error" class="text-danger">{{ errors.error[0] }}</span>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                      <label class="form-check-label text-dark" for="flexCheckChecked">
                        Remember this Device
                      </label>
                    </div>
                    <RouterLink class="text-primary fw-bold" to="#">Forgot Password ?</RouterLink>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In
                  </button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">New to Hospital?</p>
                    <RouterLink class="text-primary fw-bold ms-2" to="/register">Create an account</RouterLink>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '../../stores/userState';

const userStore = useUserStore();
const router = useRouter();

const user = ref({ email: '', password: '' });
const errors = ref({});

const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;

const loginUser = async () => {
  try {
    // Clear previous errors
    errors.value = {};

    const response = await fetch(`${BASE_URL}/api/login`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(user.value),
    });

    if (response.ok) {
      const responseData = await response.json();

      if (responseData.status === 'success') {
        userStore.setUser({ user: responseData.user, token: responseData.token });
        router.push('/dashboard');
      } else {
        console.error('Unexpected response:', responseData);
        errors.value = { error: ['Unexpected response from server'] };
      }
    } else {
      // Handle non-200 HTTP status codes (e.g., 404, 500)
      console.error('HTTP error:', response.status);
      const responseError = await response.json();
      errors.value = responseError.errors || { error: ['An error occurred'] };
    }
  } catch (error) {
    console.error('Error logging in:', error);
    errors.value = { error: ['An error occurred while logging in'] };
  }
};
</script>

<style scoped>
/* Add any necessary styles here */
</style>
