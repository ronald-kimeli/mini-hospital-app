<template>
  <div class="container-fluid">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">Users list</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">Users</li>
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
    <div class="product-list">
      <div class="card shadow rounded">
        <div class="card-header">
          <h4 class="d-inline">
            <RouterLink to="/dashboard/users/create" class="btn btn-sm btn-dark float-end">Create User</RouterLink>
          </h4>
        </div>
        <div class="card-body">
          <div class="table-responsive-md table-responsive-xl table-responsive-xxl">
            <table class="table table-striped table-bordered rounded">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Email</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, index) in users" :key="index">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.role.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>
                    <div class="btn-group" role="group" aria-label="Third group">
                      <RouterLink :to="`/dashboard/users/${user.id}`" class="btn btn-sm btn-primary mx-2">Edit</RouterLink>
                      <button @click="deleteUser(user.id)" class="btn btn-sm btn-danger mx-2">Delete</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useUserStore } from '../../stores/userState'; // Adjust path as needed

const userStore = useUserStore(); // Create store instance
const users = ref([]);
const token = ref(userStore.getToken); // Access token from store

const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;

const fetchUsers = async () => {
  try {
    const response = await fetch(`${BASE_URL}/users`, {
      headers: {
        'Authorization': `Bearer ${token.value}`,
      },
    });

    if (response.ok) {
      const responseData = await response.json();
      users.value = responseData.data; // Assuming data is in response.data
    } else {
      console.error('HTTP error:', response.status);
    }
  } catch (error) {
    console.error('Error fetching users:', error);
  }
};

const deleteUser = async (userId) => {
  try {
    const response = await fetch(`${BASE_URL}/users/${userId}`, {
      method: 'DELETE',
      headers: {
        'Authorization': `Bearer ${token.value}`,
      },
    });

    if (response.ok) {
      await fetchUsers(); 
    } else {
      console.error('HTTP error:', response.status);
    }
  } catch (error) {
    console.error('Error deleting user:', error);
  }
};

onMounted(() => {
  fetchUsers();
});
</script>

<style scoped>
/* Add any necessary styles here */
</style>
