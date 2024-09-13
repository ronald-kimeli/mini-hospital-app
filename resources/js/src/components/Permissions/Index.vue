<template>
  <div class="container-fluid">
    <!-- Header and Add Permission Button -->
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">Permission List</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">Permissions</li>
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

    <!-- Permissions List -->
    <div class="card shadow rounded">
      <div class="card-header">
        <RouterLink to="/dashboard/permissions/create" class="btn btn-sm btn-dark float-end">Add Permission</RouterLink>
      </div>
      <div class="card-body p-3">
        <div class="table-responsive border rounded">
          <table class="table align-middle text-nowrap mb-0">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Permission Name</th>
                <th scope="col">Created At</th>
                <th scope="col">Updated At</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(permission, index) in permissions" :key="permission.id">
                <td>{{ permission.id }}</td>
                <td>{{ permission.name }}</td>
                <td>{{ formatDate(permission.created_at) }}</td>
                <td>{{ formatDate(permission.updated_at) }}</td>
                <td>
                  <div class="btn-group" role="group" aria-label="Actions">
                    <button @click="selectPermission(permission)" class="btn btn-sm btn-primary mx-2">View</button>
                    <button @click="selectPermissionForEdit(permission)" class="btn btn-sm btn-secondary mx-2">Edit</button>
                    <button @click="deletePermission(permission.id)" class="btn btn-sm btn-danger mx-2">Delete</button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- View Permission Modal -->
    <div v-if="selectedPermission" class="modal show d-block" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Permission Details</h5>
            <button type="button" class="btn-close" @click="selectedPermission = null"></button>
          </div>
          <div class="modal-body">
            <div class="card mb-3">
              <div class="card-header">Permission Information</div>
              <div class="card-body">
                <p><strong>ID:</strong> {{ selectedPermission.id }}</p>
                <p><strong>Permission Name:</strong> {{ selectedPermission.name }}</p>
                <p><strong>Created At:</strong> {{ formatDate(selectedPermission.created_at) }}</p>
                <p><strong>Updated At:</strong> {{ formatDate(selectedPermission.updated_at) }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Permission Modal -->
    <div v-if="editPermission" class="modal show d-block" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Permission</h5>
            <button type="button" class="btn-close" @click="editPermission = null"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updatePermission">
              <div class="mb-3">
                <label for="permission_name" class="form-label">Permission Name</label>
                <input type="text" id="permission_name" v-model="editPermission.name" class="form-control" required />
              </div>
              <div class="mb-3">
                <label for="created_at" class="form-label">Created At</label>
                <input type="datetime-local" id="created_at" v-model="editPermission.created_at" class="form-control" />
              </div>
              <div class="mb-3">
                <label for="updated_at" class="form-label">Updated At</label>
                <input type="datetime-local" id="updated_at" v-model="editPermission.updated_at" class="form-control" />
              </div>
              <button type="submit" class="btn btn-primary">Update Permission</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '../../stores/userState';

export default defineComponent({
  name: 'PermissionsManagement',
  setup() {
    const permissions = ref([]);
    const selectedPermission = ref(null);
    const editPermission = ref(null);
    const userStore = useUserStore();
    const token = ref(userStore.getToken);
    const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
    const router = useRouter();

    const fetchPermissions = async () => {
      try {
        const response = await fetch(`${BASE_URL}/api/permissions`, {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token.value}`,
          },
        });
        const result = await response.json();
        permissions.value = result.data;
      } catch (error) {
        console.error('Error fetching permissions:', error);
      }
    };

    const selectPermission = (permission) => {
      selectedPermission.value = { ...permission };
    };

    const formatDateForInput = (dateString) => {
      const date = new Date(dateString);
      return date.toISOString().slice(0, 16);
    };

    const selectPermissionForEdit = (permission) => {
      editPermission.value = {
        ...permission,
        created_at: formatDateForInput(permission.created_at),
        updated_at: formatDateForInput(permission.updated_at)
      };
    };

    const deletePermission = async (permissionId) => {
      try {
        await fetch(`${BASE_URL}/api/permissions/${permissionId}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token.value}`,
          },
        });
        await fetchPermissions();
      } catch (error) {
        console.error('Error deleting permission:', error);
      }
    };

    const updatePermission = async () => {
      try {
        await fetch(`${BASE_URL}/api/permissions/${editPermission.value.id}`, {
          method: 'PUT',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token.value}`,
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(editPermission.value),
        });
        await fetchPermissions();
        editPermission.value = null;
      } catch (error) {
        console.error('Error updating permission:', error);
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
      fetchPermissions();
    });

    return {
      permissions,
      selectedPermission,
      editPermission,
      selectPermission,
      selectPermissionForEdit,
      deletePermission,
      updatePermission,
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
