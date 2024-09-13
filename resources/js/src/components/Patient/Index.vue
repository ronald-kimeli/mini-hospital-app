<template>
  <div class="container-fluid">
    <!-- Page Header -->
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">Patient List</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">Patients</li>
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

    <!-- Patient List -->
    <div class="product-list">
      <div class="card">
        <div class="card-header">
          <h4 class="d-inline">
            <RouterLink to="/dashboard/patients/create" class="btn btn-sm btn-dark float-end">Add Patient</RouterLink>
          </h4>
        </div>
        <div class="card-body p-3">
          <div class="table-responsive border rounded">
            <table class="table align-middle text-nowrap mb-0">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Name</th>
                  <th scope="col">ID Number</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(patient, index) in patients" :key="patient.id">
                  <td>{{ patient.id }}</td>
                  <td>{{ patient.name }}</td>
                  <td>{{ patient.id_number }}</td>
                  <td>
                    <div class="btn-group" role="group" aria-label="Actions">
                      <button @click="viewPatient(patient)" class="btn btn-sm btn-primary mx-2" data-bs-toggle="modal"
                        data-bs-target="#viewPatientModal">View</button>
                      <button @click="editPatient(patient)" class="btn btn-sm btn-secondary mx-2" data-bs-toggle="modal"
                        data-bs-target="#editPatientModal">Edit</button>
                      <button @click="checkInPatient(patient)" class="btn btn-sm btn-success mx-2"
                        data-bs-toggle="modal" data-bs-target="#checkInPatientModal">Check In</button>
                      <button @click="deletePatient(patient.id)" class="btn btn-sm btn-danger mx-2">Delete</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- View Patient Modal -->
    <div class="modal fade modal-xl" id="viewPatientModal" tabindex="-1" aria-labelledby="viewPatientModalLabel"
      aria-hidden="true" ref="viewPatientModal">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="viewPatientModalLabel">Patient Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <dl class="row mb-0">
              <dt class="col-sm-3">ID:</dt>
              <dd class="col-sm-9">{{ selectedPatient.id }}</dd>
              <dt class="col-sm-3">Name:</dt>
              <dd class="col-sm-9">{{ selectedPatient.name }}</dd>
              <dt class="col-sm-3">ID Number:</dt>
              <dd class="col-sm-9">{{ selectedPatient.id_number }}</dd>
              <dt class="col-sm-3">Date of Birth:</dt>
              <dd class="col-sm-9">{{ selectedPatient.date_of_birth }}</dd>
              <dt class="col-sm-3">Gender:</dt>
              <dd class="col-sm-9">{{ selectedPatient.gender }}</dd>
              <dt class="col-sm-3">Phone Number:</dt>
              <dd class="col-sm-9">{{ selectedPatient.phone_number }}</dd>
              <dt class="col-sm-3">Email:</dt>
              <dd class="col-sm-9">{{ selectedPatient.email }}</dd>
              <dt class="col-sm-3">Created At:</dt>
              <dd class="col-sm-9">{{ selectedPatient.created_at }}</dd>
              <dt class="col-sm-3">Updated At:</dt>
              <dd class="col-sm-9">{{ selectedPatient.updated_at }}</dd>
            </dl>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Patient Modal -->
    <div class="modal fade modal-xl" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel"
      aria-hidden="true" ref="editPatientModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editPatientModalLabel">Edit Patient</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updatePatient" class="needs-validation" novalidate>
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" v-model="editPatientData.name" class="form-control"
                  :class="{ 'is-invalid': errors.name }" required />
                <div v-if="errors.name" class="invalid-feedback">
                  {{ errors.name[0] }}
                </div>
              </div>
              <div class="mb-3">
                <label for="id_number" class="form-label">ID Number</label>
                <input type="text" id="id_number" v-model="editPatientData.id_number" class="form-control"
                  :class="{ 'is-invalid': errors.id_number }" required />
                <div v-if="errors.id_number" class="invalid-feedback">
                  {{ errors.id_number[0] }}
                </div>
              </div>
              <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <input type="date" id="date_of_birth" v-model="editPatientData.date_of_birth" class="form-control"
                  :class="{ 'is-invalid': errors.date_of_birth }" />
                <div v-if="errors.date_of_birth" class="invalid-feedback">
                  {{ errors.date_of_birth[0] }}
                </div>
              </div>
              <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select id="gender" v-model="editPatientData.gender" class="form-select"
                  :class="{ 'is-invalid': errors.gender }" required>
                  <option value="" disabled>Select Gender</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                  <option value="other">Other</option>
                </select>
                <div v-if="errors.gender" class="invalid-feedback">
                  {{ errors.gender[0] }}
                </div>
              </div>
              <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="tel" id="phone_number" v-model="editPatientData.phone_number" class="form-control"
                  :class="{ 'is-invalid': errors.phone_number }" required />
                <div v-if="errors.phone_number" class="invalid-feedback">
                  {{ errors.phone_number[0] }}
                </div>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" v-model="editPatientData.email" class="form-control"
                  :class="{ 'is-invalid': errors.email }" />
                <div v-if="errors.email" class="invalid-feedback">
                  {{ errors.email[0] }}
                </div>
              </div>
              <button type="submit" class="btn btn-primary mt-2">Update</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Check-In Patient Modal -->
    <div class="modal fade modal-xl" id="checkInPatientModal" tabindex="-1" aria-labelledby="checkInPatientModalLabel"
      aria-hidden="true" ref="checkInPatientModal">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="checkInPatientModalLabel">Check-In Patient</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="checkInVisit">
              <div class="mb-3">
                <label for="patient_name" class="form-label">Patient Name</label>
                <input type="text" id="patient_name" v-model="selectedCheckInPatient.name" class="form-control"
                  readonly />
              </div>

              <div class="mb-3">
                <label for="check_in_time" class="form-label">Check In Time</label>
                <input type="datetime-local" id="check_in_time" v-model="selectedCheckInPatient.check_in_time"
                  class="form-control" :class="{ 'is-invalid': errors.check_in_time }" />
                <div v-if="errors.check_in_time" class="invalid-feedback">
                  {{ errors.check_in_time[0] }}
                </div>
              </div>
              <div class="mb-3">
                <label for="current_stage" class="form-label">Stage</label>
                <select id="current_stage" v-model="selectedCheckInPatient.current_stage" class="form-select"
                  :class="{ 'is-invalid': errors.current_stage }">
                  <option value="" disabled>Select Stage</option>
                  <option value="triage">Triage</option>
                  <option value="doctor">Doctor</option>
                  <option value="laboratory">Laboratory</option>
                  <option value="radiology">Radiology</option>
                  <option value="optical">Optical</option>
                  <option value="checked_out">Checked Out</option>
                </select>
                <div v-if="errors.current_stage" class="invalid-feedback">
                  {{ errors.current_stage[0] }}
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Check-In</button>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
import { useNotificationStore } from '../../stores/notificationStore';
import { useUserStore } from '../../stores/userState';
import { Modal } from 'bootstrap';

export default defineComponent({
  name: 'PatientList',
  setup() {
    const notificationStore = useNotificationStore();
    const userStore = useUserStore();
    const patients = ref([]);
    const selectedPatient = ref({});
    const selectedCheckInPatient = ref({
      id: '',
      name: '',
      check_in_time: '',
      current_stage: ''
    });

    const viewPatientModal = ref(null);
    const editPatientModal = ref(null);
    const checkInPatientModal = ref(null);

    const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
    const editPatientData = ref({});
    const errors = ref({});
    const token = ref(userStore.getToken);

    const fetchPatients = async () => {
      try {
        const response = await fetch(`${BASE_URL}/api/patients`, {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token.value}`,
            'Content-Type': 'application/json',
          }
        });
        const data = await response.json();
        patients.value = data.data;
      } catch (error) {
        notificationStore.showNotification('Error fetching patients', 'error');
      }
    };

    const closeModal = (modalRef) => {
      if (modalRef.value) {
        const modalInstance = Modal.getInstance(modalRef.value) || new Modal(modalRef.value);
        modalInstance.hide();
      }
    };

    const checkInPatient = (patient) => {
      selectedCheckInPatient.value = { ...patient, check_in_time: '', current_stage: '' };
    };

    const viewPatient = (patient) => {
      selectedPatient.value = patient;
    };

    const editPatient = (patient) => {
      editPatientData.value = { ...patient };
    };

    const checkInVisit = async () => {

      const { check_in_time, current_stage } = selectedCheckInPatient.value;

      if (!check_in_time || !current_stage) {
        errors.value = {
          check_in_time: !check_in_time ? ['Check In Time is required'] : [],
          current_stage: !current_stage ? ['Stage is required'] : [],
        };
        return;
      }

      const selectedCheckInPatientPayload = {
        check_in_time: selectedCheckInPatient.value.check_in_time,
        current_stage: selectedCheckInPatient.value.current_stage,
        patient_id: selectedCheckInPatient.value.id
      };

      try {
        const response = await fetch(`${BASE_URL}/api/visits`, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token.value}`,
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(selectedCheckInPatientPayload),
        });

        if (response.ok) {
          const createdVisit = await response.json();
          if (createdVisit.success) {
            notificationStore.showNotification('Patient checked in successfully', 'success');
            closeModal(checkInPatientModal);
            // await fetchPatients();
          } else {
            const errorData = await response.json();
            errors.value = errorData.errors || {};
            notificationStore.showNotification('Validation errors occurred.', 'error');
          }
        }
      } catch (error) {
        console.error(error);
        notificationStore.showNotification('Error checking in patient', 'error');
      }
    };

    const updatePatient = async () => {
      try {
        const response = await fetch(`${BASE_URL}/api/patients/${editPatientData.value.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token.value}`,
          },
          body: JSON.stringify(editPatientData.value),
        });

        if (response.ok) {
          const updatedPatient = await response.json();
          patients.value = patients.value.map(p =>
            p.id === updatedPatient.id ? updatedPatient : p
          );
          notificationStore.showNotification('Patient updated successfully', 'success');
          closeModal(editPatientModal);
          await fetchPatients();
        } else {
          const errorData = await response.json();
          errors.value = errorData.errors || {};
        }
      } catch (error) {
        notificationStore.showNotification('Error updating patient', 'error');
      }
    };

    const deletePatient = async (id) => {
      if (!confirm('Are you sure you want to delete this patient?')) return;

      try {
        const response = await fetch(`${BASE_URL}/api/patients/${id}`, {
          method: 'DELETE',
          headers: {
            'Authorization': `Bearer ${token.value}`,
          },
        });

        if (response.ok) {
          patients.value = patients.value.filter(p => p.id !== id);
          notificationStore.showNotification('Patient deleted successfully', 'success');
        } else {
          notificationStore.showNotification('Error deleting patient', 'error');
        }
      } catch (error) {
        notificationStore.showNotification('Error deleting patient', 'error');
      }
    };

    onMounted(fetchPatients);

    return {
      patients,
      selectedPatient,
      editPatientData,
      errors,
      viewPatient,
      editPatient,
      updatePatient,
      deletePatient,
      checkInPatient,
      selectedCheckInPatient,
      checkInVisit
    };
  },
});

</script>

<style scoped>
.modal.show {
  display: block;
}
</style>
