<template>
    <div class="container-fluid">
      <!-- Header and Add Treatment Button -->
      <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
              <h4 class="fw-semibold mb-8">Treatment List</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item" aria-current="page">Treatments</li>
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
  
      <!-- Treatment List -->
      <div class="card shadow rounded">
        <div class="card-header">
          <h4 class="d-inline">
            <RouterLink to="/dashboard/treatments/create" class="btn btn-sm btn-dark float-end">Add Treatment</RouterLink>
          </h4>
        </div>
        <div class="card-body p-3">
          <div class="table-responsive border rounded">
            <table class="table align-middle text-nowrap mb-0">
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Patient Name</th>
                  <th scope="col">Doctor Name</th>
                  <th scope="col">Date of Treatment</th>
                  <th scope="col">Price</th>
                  <th scope="col">Status</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(treatment, index) in treatments" :key="index">
                  <td>{{ treatment.id }}</td>
                  <td>{{ treatment.patient.name }}</td>
                  <td>{{ treatment.doctor.name }}</td>
                  <td>{{ treatment.date_of_treatment }}</td>
                  <td>{{ treatment.price }}</td>
                  <td>{{ treatment.status }}</td>
                  <td>
                    <div class="btn-group" role="group" aria-label="Actions">
                      <button @click="selectTreatment(treatment)" class="btn btn-sm btn-primary mx-2">View</button>
                      <button @click="selectTreatmentForEdit(treatment)" class="btn btn-sm btn-secondary mx-2">Edit</button>
                      <button @click="deleteTreatment(treatment.id)" class="btn btn-sm btn-danger mx-2">Delete</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
  
      <!-- View Treatment Modal -->
      <div v-if="selectedTreatment" class="modal show d-block" tabindex="-1" role="dialog" style="display: block;">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Treatment Details</h5>
              <button type="button" class="btn-close" @click="selectedTreatment = null"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <!-- Treatment Basic Details -->
                <div class="col-lg-4">
                  <div class="card mb-3">
                    <div class="card-header">Basic Information</div>
                    <div class="card-body">
                      <p><strong>ID:</strong> {{ selectedTreatment.id }}</p>
                      <p><strong>Patient Name:</strong> {{ selectedTreatment.patient.name }}</p>
                      <p><strong>Date of Treatment:</strong> {{ selectedTreatment.date_of_treatment }}</p>
                      <p><strong>Price:</strong> {{ selectedTreatment.price }}</p>
                      <p><strong>Status:</strong> {{ selectedTreatment.status }}</p>
                      <p><strong>Treatment Provided:</strong> {{ selectedTreatment.treatment_provided }}</p>
                    </div>
                  </div>
                </div>
  
                <!-- Notes Cards -->
                <div class="col-lg-8">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="card mb-3">
                        <div class="card-header">Doctor Notes</div>
                        <div class="card-body">
                          <p>{{ selectedTreatment.doctor_notes }}</p>
                          <small>Time: {{ selectedTreatment.doctor_notes_time }}</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card mb-3">
                        <div class="card-header">Laboratory Notes</div>
                        <div class="card-body">
                          <p>{{ selectedTreatment.laboratory_notes }}</p>
                          <small>Time: {{ selectedTreatment.laboratory_notes_time }}</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card mb-3">
                        <div class="card-header">Radiology Notes</div>
                        <div class="card-body">
                          <p>{{ selectedTreatment.radiology_notes }}</p>
                          <small>Time: {{ selectedTreatment.radiology_notes_time }}</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card mb-3">
                        <div class="card-header">Optician Notes</div>
                        <div class="card-body">
                          <p>{{ selectedTreatment.optician_notes }}</p>
                          <small>Time: {{ selectedTreatment.optician_notes_time }}</small>
                        </div>
                      </div>
                    </div>
                  </div>
  
                  <!-- Doctor and Department Details -->
                  <div class="row mt-3">
                    <div class="col-md-6">
                      <div class="card mb-3">
                        <div class="card-header">Doctor Details</div>
                        <div class="card-body">
                          <p><strong>Name:</strong> {{ selectedTreatment.doctor.name }}</p>
                          <p><strong>Email:</strong> {{ selectedTreatment.doctor.email }}</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card mb-3">
                        <div class="card-header">Department Details</div>
                        <div class="card-body">
                          <p><strong>Name:</strong> {{ selectedTreatment.department.name }}</p>
                          <p><strong>Description:</strong> {{ selectedTreatment.department.description }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Edit Treatment Modal -->
      <div v-if="editTreatment" class="modal show d-block" tabindex="-1" role="dialog" style="display: block;">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Treatment</h5>
              <button type="button" class="btn-close" @click="editTreatment = null"></button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="updateTreatment">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="date_of_treatment" class="form-label">Date of Treatment</label>
                      <input type="datetime-local" id="date_of_treatment" v-model="editTreatment.date_of_treatment" class="form-control" required />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="price" class="form-label">Price</label>
                      <input type="number" id="price" v-model="editTreatment.price" class="form-control" required />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="status" class="form-label">Status</label>
                      <select id="status" v-model="editTreatment.status" class="form-select">
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <!-- Add other status options as needed -->
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="treatment_provided" class="form-label">Treatment Provided</label>
                      <textarea id="treatment_provided" v-model="editTreatment.treatment_provided" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="doctor_notes" class="form-label">Doctor Notes</label>
                      <textarea id="doctor_notes" v-model="editTreatment.doctor_notes" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="laboratory_notes" class="form-label">Laboratory Notes</label>
                      <textarea id="laboratory_notes" v-model="editTreatment.laboratory_notes" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="radiology_notes" class="form-label">Radiology Notes</label>
                      <textarea id="radiology_notes" v-model="editTreatment.radiology_notes" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="optician_notes" class="form-label">Optician Notes</label>
                      <textarea id="optician_notes" v-model="editTreatment.optician_notes" class="form-control"></textarea>
                    </div>
                  </div>
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
    name: 'TreatmentManagement',
    setup() {
      const treatments = ref([]);
      const selectedTreatment = ref(null);
      const editTreatment = ref(null);
      const userStore = useUserStore();
      const token = ref(userStore.getToken);
      const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
      const router = useRouter();
  
      const fetchTreatments = async () => {
        try {
          const response = await fetch(`${BASE_URL}/api/treatments`, {
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${token.value}`,
            },
          });
          const data = await response.json();
          if (response.ok) {
            treatments.value = data.data;
          } else {
            console.error('Error fetching treatments:', data.errors || 'Unknown error');
          }
        } catch (error) {
          console.error('Error fetching treatments:', error);
        }
      };
  
      const selectTreatment = (treatment) => {
        selectedTreatment.value = treatment;
      };
  
      const selectTreatmentForEdit = (treatment) => {
        editTreatment.value = { ...treatment };
      };
  
      const deleteTreatment = async (treatmentId) => {
        try {
          const response = await fetch(`${BASE_URL}/api/treatments/${treatmentId}`, {
            method: 'DELETE',
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${token.value}`,
            }
          });
          if (response.ok) {
            await fetchTreatments(); // Refresh the list after deletion
          } else {
            const data = await response.json();
            console.error('Error deleting treatment:', data.errors || 'Unknown error');
          }
        } catch (error) {
          console.error('Error deleting treatment:', error);
        }
      };
  
      const updateTreatment = async () => {
        try {
          const response = await fetch(`${BASE_URL}/api/treatments/${editTreatment.value.id}`, {
            method: 'PUT',
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${token.value}`,
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(editTreatment.value),
          });
          const result = await response.json();
          if (response.ok) {
            editTreatment.value = null; // Close the modal
            await fetchTreatments(); // Refresh the list after updating
          } else {
            console.error('Error updating treatment:', result.errors || 'Unknown error');
          }
        } catch (error) {
          console.error('Error updating treatment:', error);
        }
      };
  
      onMounted(fetchTreatments);
  
      return {
        treatments,
        selectedTreatment,
        editTreatment,
        fetchTreatments,
        selectTreatment,
        selectTreatmentForEdit,
        deleteTreatment,
        updateTreatment,
      };
    },
  });
  </script>
  
  <style scoped>
  .modal.show {
    display: block;
  }
  </style>
  