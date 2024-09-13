<template>
  <div class="container-fluid">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">Patient Details</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">Patients</li>
                <li class="breadcrumb-item active" aria-current="page">Details</li>
              </ol>
            </nav>
          </div>
          <div class="col-3">
            <div class="text-center mb-n5">
              <img src="../../assets/images/backgrounds/rocket.png" alt="Rocket Icon" class="img-fluid mb-n4" />
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="card shadow-sm">
      <div class="card-body">
        <dl class="row mb-0">
          <dt class="col-sm-3">ID:</dt>
          <dd class="col-sm-9">{{ patient.id }}</dd>
          
          <dt class="col-sm-3">Name:</dt>
          <dd class="col-sm-9">{{ patient.name }}</dd>
          
          <dt class="col-sm-3">ID Number:</dt>
          <dd class="col-sm-9">{{ patient.id_number }}</dd>
          
          <dt class="col-sm-3">Check-In Time:</dt>
          <dd class="col-sm-9">{{ patient.check_in_time }}</dd>
          
          <dt class="col-sm-3">Check-Out Time:</dt>
          <dd class="col-sm-9">{{ patient.check_out_time }}</dd>
          
          <dt class="col-sm-3">Current Stage:</dt>
          <dd class="col-sm-9">{{ patient.current_stage }}</dd>
          
          <dt class="col-sm-3">Stages:</dt>
          <dd class="col-sm-9">{{ patient.stages }}</dd>
        </dl>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
import { useUserStore } from '../../stores/userState';
import { useRoute } from 'vue-router';

export default defineComponent({
  name: 'PatientDetail',
  setup() {
    const patient = ref({});
    const userStore = useUserStore();
    const token = ref(userStore.getToken);
    const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
    const route = useRoute();
    const patientId = route.params.id;

    const fetchPatient = async () => {
      try {
        const response = await fetch(`${BASE_URL}/api/patients/${patientId}`, {
          headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token.value}`,
          },
        });

        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        patient.value = data.data; // Adjust based on your API's response structure
      } catch (error) {
        console.error('Error fetching patient:', error);
      }
    };

    onMounted(() => {
      fetchPatient();
    });

    return {
      patient
    };
  },
});
</script>
