<template>
    <div class="container-fluid">
        <!-- Header and Add Department Button -->
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Book list</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">Books</li>
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

        <!-- Department List -->
        <div class="card shadow rounded">
            <div class="card-header ">
                <h4 class="d-inline">
                    <RouterLink to="/dashboard/departments/create" class="btn btn-sm btn-dark float-end">Create
                        Department</RouterLink>
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive border rounded">
                    <table class="table align-middle text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(department, index) in departments" :key="index">
                                <td>{{ department.id }}</td>
                                <td>{{ department.name }}</td>
                                <td>{{ truncateDescription(department.description) }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        <button @click="selectDepartment(department)"
                                            class="btn btn-sm btn-primary mx-2">View</button>
                                        <button @click="selectDepartmentForEdit(department)"
                                            class="btn btn-sm btn-secondary mx-2">Edit</button>
                                        <button @click="deleteDepartment(department.id)"
                                            class="btn btn-sm btn-danger mx-2">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- View Department Modal -->
        <div v-if="selectedDepartment" class="modal show d-block" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Department Details</h5>
                        <button type="button" class="btn-close" @click="selectedDepartment = null"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>ID:</strong> {{ selectedDepartment.id }}</p>
                        <p><strong>Name:</strong> {{ selectedDepartment.name }}</p>
                        <p><strong>Description:</strong> {{ selectedDepartment.description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Department Modal -->
        <div v-if="editDepartment" class="modal show d-block" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Department</h5>
                        <button type="button" class="btn-close" @click="editDepartment = null"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateDepartment">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" v-model="editDepartment.name" class="form-control"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" id="description" v-model="editDepartment.description"
                                    class="form-control" required />
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
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
import { useRouter } from 'vue-router';

export default defineComponent({
    name: 'DepartmentManagement',
    setup() {
        const departments = ref([]);
        const selectedDepartment = ref(null);
        const editDepartment = ref(null);
        const userStore = useUserStore();
        const token = ref(userStore.getToken);
        const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
        const router = useRouter();

        const fetchDepartments = async () => {
            try {
                const response = await fetch(`${BASE_URL}/api/departments`, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token.value}`,
                    },
                });
                const data = await response.json();
                if (response.ok) {
                    departments.value = data.data;
                } else {
                    console.error('Error fetching departments:', data.errors || 'Unknown error');
                }
            } catch (error) {
                console.error('Error fetching departments:', error);
            }
        };

        const selectDepartment = (department) => {
            selectedDepartment.value = department;
        };

        const selectDepartmentForEdit = (department) => {
            editDepartment.value = { ...department }; // Make a copy for editing
        };

        const deleteDepartment = async (departmentId) => {
            try {
                const response = await fetch(`${BASE_URL}/api/departments/${departmentId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token.value}`,
                    }
                });
                if (response.ok) {
                    await fetchDepartments(); // Refresh the list after deletion
                } else {
                    const data = await response.json();
                    console.error('Error deleting department:', data.errors || 'Unknown error');
                }
            } catch (error) {
                console.error('Error deleting department:', error);
            }
        };

        const updateDepartment = async () => {
            try {
                const response = await fetch(`${BASE_URL}/api/departments/${editDepartment.value.id}`, {
                    method: 'PUT',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token.value}`,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(editDepartment.value)
                });
                const result = await response.json();
                if (response.ok) {
                    editDepartment.value = null; // Close the modal
                    await fetchDepartments(); // Refresh the list after updating
                } else {
                    console.error('Error updating department:', result.errors || 'Unknown error');
                }
            } catch (error) {
                console.error('Error updating department:', error);
            }
        };

    const truncateDescription = (description) => {
      if (!description) return '';
      return description.length > 50 ? `${description.substring(0, 50)}...` : description;
    };

        onMounted(() => {
            fetchDepartments();
        });

        return {
            departments,
            selectedDepartment,
            editDepartment,
            selectDepartment,
            selectDepartmentForEdit,
            deleteDepartment,
            updateDepartment,
            truncateDescription
        };
    },
});
</script>

<style scoped>
.modal.show {
    display: block;
}
</style>