<template>
    <div class="container-fluid">
        <!-- Header and Add Visit Button -->
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Visit List</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">Visits</li>
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

        <!-- Visit List Table -->
        <div class="card shadow rounded">
            <div class="card-header">
                <h4 class="d-inline">
                    <RouterLink to="/dashboard/visits/create" class="btn btn-sm btn-dark float-end">Add Visit
                    </RouterLink>
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive border rounded">
                    <table class="table align-middle text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Patient</th>
                                <th scope="col">Check-In</th>
                                <th scope="col">Check-Out</th>
                                <th scope="col">Current Stage</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(visit, index) in visits" :key="visit.id">
                                <td>{{ visit.id }}</td>
                                <td>{{ visit.patient.name }}</td>
                                <td>{{ formatDate(visit.check_in_time) }}</td>
                                <td>{{ formatDate(visit.check_out_time) }}</td>
                                <td>{{ visit.current_stage }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        <button @click="selectVisit(visit)"
                                            class="btn btn-sm btn-primary mx-2">View</button>
                                        <!-- <button @click="selectVisitForEdit(visit)"
                                            class="btn btn-sm btn-secondary mx-2">Edit</button> -->
                                        <button @click="selectVisitForEdit(visit)" class="btn btn-sm btn-secondary mx-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#selectVisitForEditModal">Edit</button>
                                        <button @click="deleteVisit(visit.id)"
                                            class="btn btn-sm btn-danger mx-2">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- View Visit Modal -->
        <div v-if="selectedVisit" class="modal show d-block" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Visit Details</h5>
                        <button type="button" class="btn-close" @click="selectedVisit = null"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card mb-3">
                                    <div class="card-header">Basic Information</div>
                                    <div class="card-body">
                                        <p><strong>ID:</strong> {{ selectedVisit.id }}</p>
                                        <p><strong>Patient Name:</strong> {{ selectedVisit.patient.name }}</p>
                                        <p><strong>Doctor Name:</strong> {{ selectedVisit.doctor_name }}</p>
                                        <p><strong>Date:</strong> {{ formatDate(selectedVisit.visit_date) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Visit Modal -->
        <div class="modal fade modal-lg" id="selectVisitForEditModal" tabindex="-1"
            aria-labelledby="selectVisitForEditModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="selectVisitForEditModalLabel">Edit Visit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" v-if="editVisit">
                        <form @submit.prevent="updateVisit">
                            <div class="mb-3">
                                <label for="patient_name" class="form-label">Patient Name</label>
                                <input type="text" id="patient_name" v-model="editVisit.patient.name"
                                    class="form-control" readonly />
                            </div>

                            <div class="mb-3">
                                <label for="check_in_time" class="form-label">Check In Time</label>
                                <input type="datetime-local" id="check_in_time" v-model="editVisit.check_in_time"
                                    class="form-control" required />
                            </div>

                            <div class="mb-3">
                                <label for="check_out_time" class="form-label">Check Out Time</label>
                                <input type="datetime-local" id="check_out_time" v-model="editVisit.check_out_time"
                                    class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label for="current_stage" class="form-label">Current Stage</label>
                                <select id="current_stage" v-model="editVisit.current_stage" class="form-select"
                                    required>
                                    <option value="triage">Triage</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="laboratory">Laboratory</option>
                                    <option value="reception">Reception</option>
                                    <option value="radiology">Radiology</option>
                                    <option value="optical">Optical</option>
                                    <option value="checked_out">Checked Out</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="stages" class="form-label">Stages</label>
                                <input type="text" id="stages" v-model="editVisit.stages" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label for="checked_out" class="form-label">Checked Out</label>
                                <select id="checked_out" v-model="editVisit.checked_out" class="form-select" required>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
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
    name: 'VisitManagement',
    setup() {
        const visits = ref([]);
        const selectedVisit = ref(null);
        const editVisit = ref(null);
        const userStore = useUserStore();
        const token = ref(userStore.getToken);
        const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
        const router = useRouter();

        const fetchVisits = async () => {
            try {
                const response = await fetch(`${BASE_URL}/api/visits`, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token.value}`,
                    },
                });
                const data = await response.json();
                if (response.ok) {
                    visits.value = data.data;
                } else {
                    console.error('Error fetching visits:', data.errors || 'Unknown error');
                }
            } catch (error) {
                console.error('Error fetching visits:', error);
            }
        };

        const fetchVisit = async (visitId) => {
            try {
                const response = await fetch(`${BASE_URL}/api/visits/${visitId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token.value}`,
                    },
                });
                const data = await response.json();
                if (response.ok) {
                    selectedVisit.value = data.data;
                } else {
                    console.error('Error fetching visit details:', data.errors || 'Unknown error');
                }
            } catch (error) {
                console.error('Error fetching visit details:', error);
            }
        };

        const selectVisit = (visit) => {
            fetchVisit(visit.id);
        };

        const selectVisitForEdit = (visit) => {
            editVisit.value = { ...visit }; // Make sure to create a copy of the visit object
        };

        const updateVisit = async () => {
            try {
                const response = await fetch(`${BASE_URL}/api/visits/${editVisit.value.id}`, {
                    method: 'PUT',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token.value}`,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(editVisit.value),
                });
                const result = await response.json();
                if (response.ok) {
                    editVisit.value = null;
                    await fetchVisits();
                    router.push('/dashboard/visits');
                } else {
                    console.error('Error updating visit:', result.errors || 'Unknown error');
                }
            } catch (error) {
                console.error('Error updating visit:', error);
            }
        };

        const deleteVisit = async (visitId) => {
            if (confirm('Are you sure you want to delete this visit?')) {
                try {
                    const response = await fetch(`${BASE_URL}/api/visits/${visitId}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token.value}`,
                        },
                    });
                    if (response.ok) {
                        await fetchVisits();
                    } else {
                        const data = await response.json();
                        console.error('Error deleting visit:', data.errors || 'Unknown error');
                    }
                } catch (error) {
                    console.error('Error deleting visit:', error);
                }
            }
        };

        const formatDate = (dateString) => {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString();
        };

        onMounted(fetchVisits);

        return {
            visits,
            selectedVisit,
            editVisit,
            selectVisit,
            selectVisitForEdit,
            updateVisit,
            deleteVisit,
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