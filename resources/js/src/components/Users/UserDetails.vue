<template>
  <div class="container mt-4">
    <div class="card shadow rounded">
      <div class="card-header">
        <h4 class="d-inline">Edit User
          <RouterLink to="/users" class="btn btn-sm btn-outline-success float-end">Users</RouterLink>
        </h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="updateUser">
          <div class="form-group">
            <label for="name">Name:</label>
            <input v-model="userData.name" type="text" id="name" class="form-control" />
            <span v-if="errors.name" class="text-danger">{{ errors.name[0] }}</span>
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input v-model="userData.email" type="email" id="email" class="form-control" />
            <span v-if="errors.email" class="text-danger">{{ errors.email[0] }}</span>
          </div>
          <div class="form-group">
            <label for="role_id">Role:</label>
            <input v-model="userData.role_id" type="number" id="role_id" class="form-control" />
            <span v-if="errors.role_id" class="text-danger">{{ errors.role_id[0] }}</span>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input v-model="userData.password" type="password" id="password" class="form-control" />
            <span v-if="errors.password" class="text-danger">{{ errors.password[0] }}</span>
          </div>
          <div class="form-group">
            <label for="password_confirmation">Password Confirmation:</label>
            <input v-model="userData.password_confirmation" type="password" id="password_confirmation" class="form-control" />
          </div>
          <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';

export default defineComponent({
  name: 'UpdateUser',
  setup() {
    const router = useRouter();
    const route = useRoute();
    const id = route.params.id;
    
    const userData = ref({
      name: '',
      email: '',
      role_id: '',
      password: '',
      password_confirmation: ''
    });

    const errors = ref({});
    const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;


    const fetchUserData = async () => {
      try {
        const response = await fetch(`${BASE_URL}/api/users/${id}`);
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const { user } = await response.json(); 
        console.log(user);
             
        userData.value = user;
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    };

    const updateUser = async () => {
      try {
        const response = await fetch(`${BASE_URL}/api/users/${id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(userData.value)
        });

        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        
        // Optionally handle the response or errors here
        const data = await response.json(); // You might want to process this based on your API's response
        router.push(`/users/${id}`);  // Redirect to the user details page
      } catch (error) {
        console.error('Error updating user:', error);
        // Handle and display errors if needed
        errors.value = error.response?.data?.errors || {};
      }
    };

    onMounted(() => {
      fetchUserData();
    });

    return {
      userData,
      errors,
      updateUser
    };
  }
});
</script>
