<template>
  <div class="container-fluid">
    <!-- Header and Add Referral Button -->
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">Referral List</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">Referrals</li>
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

    <!-- Referrals List -->
    <div class="card shadow rounded">
      <div class="card-header">
        <h4 class="d-inline">
          <RouterLink to="/dashboard/referrals/create" class="btn btn-sm btn-dark float-end">Add Referral</RouterLink>
        </h4>
      </div>
      <div class="card-body p-3">
        <div class="table-responsive border rounded">
          <table class="table align-middle text-nowrap mb-0">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Patient Name</th>
                <th scope="col">Referral Department</th>
                <th scope="col">Date of Referral</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(referral, index) in referrals" :key="referral.id">
                <td>{{ referral.id }}</td>
                <td>{{ referral.patient.name }}</td>
                <td>{{ referral.referral_department.name }}</td>
                <td>{{ formatDate(referral.date_of_referral) }}</td>
                <td>{{ referral.status }}</td>
                <td>
                  <div class="btn-group" role="group" aria-label="Actions">
                    <button @click="selectReferral(referral)" class="btn btn-sm btn-primary mx-2">View</button>
                    <button @click="selectReferralForEdit(referral)" class="btn btn-sm btn-secondary mx-2">Edit</button>
                    <button @click="deleteReferral(referral.id)" class="btn btn-sm btn-danger mx-2">Delete</button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- View Referral Modal -->
    <div v-if="selectedReferral" class="modal show d-block" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Referral Details</h5>
            <button type="button" class="btn-close" @click="selectedReferral = null"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <!-- Referral Basic Details -->
              <div class="col-lg-6">
                <div class="card mb-3">
                  <div class="card-header">Basic Information</div>
                  <div class="card-body">
                    <p><strong>ID:</strong> {{ selectedReferral.id }}</p>
                    <p><strong>Patient Name:</strong> {{ selectedReferral.patient.name }}</p>
                    <p><strong>Date of Referral:</strong> {{ formatDate(selectedReferral.date_of_referral) }}</p>
                    <p><strong>Referral Department:</strong> {{ selectedReferral.referral_department.name }}</p>
                    <p><strong>Status:</strong> {{ selectedReferral.status }}</p>
                    <p><strong>Completed By:</strong> {{ selectedReferral.completed_by.name }}</p>
                    <p><strong>Completed At:</strong> {{ formatDate(selectedReferral.completed_at) }}</p>
                  </div>
                </div>
              </div>

              <!-- Treatment Details -->
              <div class="col-lg-6">
                <div class="card mb-3">
                  <div class="card-header">Treatment Details</div>
                  <div class="card-body">
                    <p><strong>Treatment ID:</strong> {{ selectedReferral.treatment.id }}</p>
                    <p><strong>Doctor Notes:</strong> {{ selectedReferral.treatment.doctor_notes }}</p>
                    <p><strong>Laboratory Notes:</strong> {{ selectedReferral.treatment.laboratory_notes }}</p>
                    <p><strong>Radiology Notes:</strong> {{ selectedReferral.treatment.radiology_notes }}</p>
                    <p><strong>Optician Notes:</strong> {{ selectedReferral.treatment.optician_notes }}</p>
                    <p><strong>Date of Treatment:</strong> {{ formatDate(selectedReferral.treatment.date_of_treatment) }}</p>
                    <p><strong>Price:</strong> {{ selectedReferral.treatment.price }}</p>
                    <p><strong>Status:</strong> {{ selectedReferral.treatment.status }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Referral Modal -->
    <div v-if="editReferral" class="modal show d-block" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Referral</h5>
            <button type="button" class="btn-close" @click="editReferral = null"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateReferral">
              <div class="mb-3">
                <label for="patient_name" class="form-label">Patient Name</label>
                <input type="text" id="patient_name" v-model="editReferral.patient.name" class="form-control" />
              </div>
              <div class="mb-3">
                <label for="referral_department_name" class="form-label">Referral Department</label>
                <input type="text" id="referral_department_name" v-model="editReferral.referral_department.name" class="form-control" />
              </div>
              <div class="mb-3">
                <label for="date_of_referral" class="form-label">Date of Referral</label>
                <input type="datetime-local" id="date_of_referral" v-model="editReferral.date_of_referral" class="form-control" />
              </div>
              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" id="status" v-model="editReferral.status" class="form-control" />
              </div>
              <div class="mb-3">
                <label for="completed_by_name" class="form-label">Completed By</label>
                <input type="text" id="completed_by_name" v-model="editReferral.completed_by.name" class="form-control" />
              </div>

              <button type="submit" class="btn btn-primary">Update Referral</button>
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
  name: 'ReferralManagement',
  setup() {
    const referrals = ref([]);
    const selectedReferral = ref(null);
    const editReferral = ref(null);
    const userStore = useUserStore();
    const token = ref(userStore.getToken);
    const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
    const router = useRouter();

    const fetchReferrals = async () => {
      try {
        const response = await fetch(`${BASE_URL}/api/referrals`, {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token.value}`,
          },
        });
        const data = await response.json();
        if (response.ok) {
          referrals.value = data.data;
        } else {
          console.error('Error fetching referrals:', data.errors || 'Unknown error');
        }
      } catch (error) {
        console.error('Error fetching referrals:', error);
      }
    };

    const selectReferral = (referral) => {
      selectedReferral.value = referral;
    };

    const selectReferralForEdit = (referral) => {
      editReferral.value = { ...referral };
    };

    const deleteReferral = async (referralId) => {
      if (confirm('Are you sure you want to delete this referral?')) {
        try {
          const response = await fetch(`${BASE_URL}/api/referrals/${referralId}`, {
            method: 'DELETE',
            headers: {
              'Accept': 'application/json',
              'Authorization': `Bearer ${token.value}`,
            },
          });
          if (response.ok) {
            await fetchReferrals(); // Refresh the list after deletion
          } else {
            const data = await response.json();
            console.error('Error deleting referral:', data.errors || 'Unknown error');
          }
        } catch (error) {
          console.error('Error deleting referral:', error);
        }
      }
    };

    const updateReferral = async () => {
      try {
        const response = await fetch(`${BASE_URL}/api/referrals/${editReferral.value.id}`, {
          method: 'PUT',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token.value}`,
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(editReferral.value),
        });
        const result = await response.json();
        if (response.ok) {
          editReferral.value = null; 
          await fetchReferrals(); 
        } else {
          console.error('Error updating referral:', result.errors || 'Unknown error');
        }
      } catch (error) {
        console.error('Error updating referral:', error);
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

    onMounted(fetchReferrals);

    return {
      referrals,
      selectedReferral,
      editReferral,
      fetchReferrals,
      selectReferral,
      selectReferralForEdit,
      deleteReferral,
      updateReferral,
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