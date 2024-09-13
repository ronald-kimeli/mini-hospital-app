<template>
  <div class="container-fluid">
    <!-- Header and Add Role Button -->
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">Role List</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">Roles</li>
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

    <!-- Roles List -->
    <div class="card shadow rounded">
      <div class="card-header">
        <h4 class="d-inline">
          <RouterLink to="/dashboard/roles/create" class="btn btn-sm btn-dark float-end">Add Role</RouterLink>
        </h4>
      </div>
      <div class="card-body p-3">
        <div class="table-responsive border rounded">
          <table class="table align-middle text-nowrap mb-0">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Role Name</th>
                <th scope="col">Created At</th>
                <th scope="col">Updated At</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(role, index) in roles" :key="role.id">
                <td>{{ role.id }}</td>
                <td>{{ role.name }}</td>
                <td>{{ formatDate(role.created_at) }}</td>
                <td>{{ formatDate(role.updated_at) }}</td>
                <td>
                  <div class="btn-group" role="group" aria-label="Actions">
                    <button @click="selectRole(role)" class="btn btn-sm btn-primary mx-2">View</button>
                    <button @click="selectRoleEdit(role)" class="btn btn-sm btn-secondary mx-2">Edit</button>
                    <button @click="deleteRole(role.id)" class="btn btn-sm btn-danger mx-2">Delete</button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- View Role Modal -->
    <div v-if="selectedRole" class="modal show d-block" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Role Details</h5>
            <button type="button" class="btn-close" @click="selectedRole = null"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <!-- Role Basic Details -->
              <div class="col-lg-12">
                <div class="card mb-3">
                  <div class="card-header">Basic Information</div>
                  <div class="card-body">
                    <p><strong>ID:</strong> {{ selectedRole.id }}</p>
                    <p><strong>Role Name:</strong> {{ selectedRole.name }}</p>
                    <p><strong>Created At:</strong> {{ formatDate(selectedRole.created_at) }}</p>
                    <p><strong>Updated At:</strong> {{ formatDate(selectedRole.updated_at) }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Role Modal -->
    <div v-if="editRole" class="modal show d-block" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Role</h5>
            <button type="button" class="btn-close" @click="editRole = null"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateRole">
              <div class="mb-3">
                <label for="role_name" class="form-label">Role Name</label>
                <input type="text" id="role_name" v-model="editRole.name" class="form-control" />
              </div>
              <div class="mb-3">
                <label for="created_at" class="form-label">Created At</label>
                <input type="datetime-local" id="created_at" v-model="editRole.created_at" class="form-control" />
              </div>
              <div class="mb-3">
                <label for="updated_at" class="form-label">Updated At</label>
                <input type="datetime-local" id="updated_at" v-model="editRole.updated_at" class="form-control" />
              </div>
              <button type="submit" class="btn btn-primary">Update Role</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
import { useUserStore } from '../../stores/userState';
import { useRoute, useRouter } from 'vue-router';

export default defineComponent({
  name: 'RolesManagement',
  setup() {
    const roles = ref([]);
    const selectedRole = ref(null);
    const editRole = ref(null);
    const userStore = useUserStore();
    const token = ref(userStore.getToken);
    const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
    const route = useRoute();
    const router = useRouter();

    const fetchRoles = async () => {
      try {
        const response = await fetch(`${BASE_URL}/api/roles`, {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token.value}`,
          },
        });
        const result = await response.json();
        roles.value = result.data;
      } catch (error) {
        console.error('Error fetching roles:', error);
      }
    };

    const selectRole = async (role) => {
      selectedRole.value = { ...role };
    };

    const formatDateForInput = (dateString) => {
      const date = new Date(dateString);
      return date.toISOString().slice(0, 16);
    };

    const selectRoleEdit = async (role) => {
      editRole.value = {
        ...role,
        created_at: formatDateForInput(role.created_at),
        updated_at: formatDateForInput(role.updated_at)
      };
    };

    const deleteRole = async (roleId) => {
      try {
        await fetch(`${BASE_URL}/api/roles/${roleId}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token.value}`,
          },
        });
        await fetchRoles();
      } catch (error) {
        console.error('Error deleting role:', error);
      }
    };

    const updateRole = async () => {
      try {
        await fetch(`${BASE_URL}/api/roles/${editRole.value.id}`, {
          method: 'PUT',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token.value}`,
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(editRole.value),
        });
        await fetchRoles();
        editRole.value = null;
      } catch (error) {
        console.error('Error updating role:', error);
      }
    };

    const formatDate = (dateString) => {
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
      });
    };

    onMounted(() => {
      fetchRoles();
    });

    return {
      roles,
      selectedRole,
      editRole,
      selectRole,
      selectRoleEdit,
      deleteRole,
      updateRole,
      formatDate,
    };
  },
});
</script>

<style scoped>
.modal.show {
  display: block;
}
</style>