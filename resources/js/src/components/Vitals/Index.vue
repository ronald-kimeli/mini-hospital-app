<template>
  <div class="container-fluid">
    <!-- Header and Add Vital Button -->
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">Vital Signs List</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">Vitals</li>
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

    <!-- Vital Signs List -->
    <div class="card shadow rounded">
      <div class="card-header">
        <h4 class="d-inline">
          <RouterLink to="/dashboard/vitals/create" class="btn btn-sm btn-dark float-end">Add Vital</RouterLink>
        </h4>
      </div>
      <div class="card-body p-3">
        <div class="table-responsive border rounded">
          <table class="table align-middle text-nowrap mb-0">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Patient Name</th>
                <th scope="col">Temperature</th>
                <th scope="col">Blood Pressure</th>
                <th scope="col">Pulse</th>
                <th scope="col">Date</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(vital, index) in vitals" :key="vital.id">
                <td>{{ vital.id }}</td>
                <td>{{ vital.patient.name }}</td>
                <td>{{ vital.temperature }}</td>
                <td>{{ vital.blood_pressure }}</td>
                <td>{{ vital.pulse }}</td>
                <td>{{ formatDate(vital.created_at) }}</td>
                <td>
                  <div class="btn-group" role="group" aria-label="Actions">
                    <button @click="selectVital(vital)" class="btn btn-sm btn-primary mx-2">View</button>
                    <button @click="selectVitalForEdit(vital)" class="btn btn-sm btn-secondary mx-2">Edit</button>
                    <button @click="deleteVital(vital.id)" class="btn btn-sm btn-danger mx-2">Delete</button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- View Vital Modal -->
    <div v-if="selectedVital" class="modal show d-block" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Vital Sign Details</h5>
            <button type="button" class="btn-close" @click="selectedVital = null"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <!-- Vital Basic Details -->
              <div class="col-lg-4">
                <div class="card mb-3">
                  <div class="card-header">Basic Information</div>
                  <div class="card-body">
                    <p><strong>ID:</strong> {{ selectedVital.id }}</p>
                    <p><strong>Patient Name:</strong> {{ selectedVital.patient.name }}</p>
                    <p><strong>Date:</strong> {{ formatDate(selectedVital.created_at) }}</p>
                    <p><strong>Temperature:</strong> {{ selectedVital.temperature }} °C</p>
                    <p><strong>Blood Pressure:</strong> {{ selectedVital.blood_pressure }}</p>
                    <p><strong>Pulse:</strong> {{ selectedVital.pulse }}</p>
                  </div>
                </div>
              </div>

              <!-- Visit Details -->
              <div class="col-lg-8">
                <div class="card mb-3">
                  <div class="card-header">Visit Details</div>
                  <div class="card-body">
                    <p><strong>Check-in Time:</strong> {{ selectedVital.visit.check_in_time }}</p>
                    <p><strong>Check-out Time:</strong> {{ selectedVital.visit.check_out_time }}</p>
                    <p><strong>Current Stage:</strong> {{ selectedVital.visit.current_stage }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Vital Modal -->
    <div v-if="editVital" class="modal show d-block" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Vital Sign</h5>
            <button type="button" class="btn-close" @click="editVital = null"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateVital">
              <div class="mb-3">
                <label for="height" class="form-label">Height (m)</label>
                <input type="text" id="height" v-model="editVital.height" class="form-control" />
              </div>
              <div class="mb-3">
                <label for="weight" class="form-label">Weight (kg)</label>
                <input type="text" id="weight" v-model="editVital.weight" class="form-control" />
              </div>
              <div class="mb-3">
                <label for="temperature" class="form-label">Temperature (°C)</label>
                <input type="number" step="0.01" id="temperature" v-model="editVital.temperature"
                  class="form-control" />
              </div>
              <div class="mb-3">
                <label for="blood_pressure" class="form-label">Blood Pressure</label>
                <input type="text" id="blood_pressure" v-model="editVital.blood_pressure" class="form-control" />
              </div>
              <div class="mb-3">
                <label for="pulse" class="form-label">Pulse</label>
                <input type="number" id="pulse" v-model="editVital.pulse" class="form-control" />
              </div>
              <div class="mb-3">
                <label for="created_at" class="form-label">Date and Time</label>
                <input type="datetime-local" id="created_at" v-model="editVital.created_at" class="form-control" />
              </div>

              <button type="submit" class="btn btn-primary">Update Vital Sign</button>
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
  name: 'VitalManagement',
  setup() {
    const vitals = ref([]);
    const selectedVital = ref(null);
    const editVital = ref(null);
    const userStore = useUserStore();
    const token = ref(userStore.getToken);
    const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
    const router = useRouter();

    const fetchVitals = async () => {
      try {
        const response = await fetch(`${BASE_URL}/api/vitals`, {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token.value}`,
          },
        });
        const data = await response.json();
        if (response.ok) {
          vitals.value = data.data;
        } else {
          console.error('Error fetching vitals:', data.errors || 'Unknown error');
        }
      } catch (error) {
        console.error('Error fetching vitals:', error);
      }
    };

    const selectVital = (vital) => {
      selectedVital.value = vital;
    };

    const selectVitalForEdit = (vital) => {
      editVital.value = { ...vital };
    };

    const deleteVital = async (vitalId) => {
      if (confirm('Are you sure you want to delete this vital sign?')) {
        try {
          const response = await fetch(`${BASE_URL}/api/vitals/${vitalId}`, {
            method: 'DELETE',
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${token.value}`,
            },
          });
          if (response.ok) {
            await fetchVitals(); // Refresh the list after deletion
          } else {
            const data = await response.json();
            console.error('Error deleting vital:', data.errors || 'Unknown error');
          }
        } catch (error) {
          console.error('Error deleting vital:', error);
        }
      }
    };

    const updateVital = async () => {
      try {
        const response = await fetch(`${BASE_URL}/api/vitals/${editVital.value.id}`, {
          method: 'PUT',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token.value}`,
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(editVital.value),
        });
        const result = await response.json();
        if (response.ok) {
          editVital.value = null; 
          await fetchVitals(); 
        } else {
          console.error('Error updating vital:', result.errors || 'Unknown error');
        }
      } catch (error) {
        console.error('Error updating vital:', error);
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

    onMounted(fetchVitals);

    return {
      vitals,
      selectedVital,
      editVital,
      fetchVitals,
      selectVital,
      selectVitalForEdit,
      deleteVital,
      updateVital,
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
