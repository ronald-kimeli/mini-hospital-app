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
            <RouterLink to="/dashboard/visits/create" class="btn btn-sm btn-dark float-end">
              <i class="bi bi-plus"></i> Add Visit
            </RouterLink>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="mb-4">
      <input v-model="filterQuery" @input="filterVisits" type="text" class="form-control" placeholder="Search Visits..." />
    </div>

     <!-- Export Buttons Group -->
     <div class="mb-4">
      <div class="btn-group" role="group" aria-label="Export Buttons">
        <button @click="exportToPDF" class="btn btn-danger">
          <i class="bi bi-file-earmark-pdf"></i> Export to PDF
        </button>
        <button @click="exportToExcel" class="btn btn-success">
          <i class="bi bi-file-earmark-excel"></i> Export to Excel
        </button>
      </div>
    </div>

    <!-- Visit List Table -->
    <div class="card shadow rounded">
      <div class="card-header">
        <h4 class="d-inline">Visits</h4>
      </div>
      <div class="card-body p-3">
        <div class="table-responsive border rounded">
          <table class="table align-middle text-nowrap mb-0">
            <thead>
              <tr>
                <th scope="col">#</th> <!-- Auto-increment ID column -->
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
                <td>{{ index + 1 }}</td> <!-- Auto-increment ID -->
                <td>{{ visit.id }}</td>
                <td>{{ visit.patient.name }}</td>
                <td>{{ formatDate(visit.check_in_time) }}</td>
                <td>{{ formatDate(visit.check_out_time) }}</td>
                <td>{{ visit.current_stage }}</td>
                <td>
                  <div class="btn-group" role="group" aria-label="Actions">
                    <button @click="selectVisit(visit)" class="btn btn-sm btn-primary mx-2">
                      <i class="bi bi-eye"></i>
                    </button>
                    <button @click="selectVisitForEdit(visit)" class="btn btn-sm btn-secondary mx-2">
                      <i class="bi bi-pencil"></i>
                    </button>
                    <button @click="deleteVisit(visit.id)" class="btn btn-sm btn-danger mx-2">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import { ref, onMounted } from 'vue';
import { useUserStore } from '../stores/userState';
import { jsPDF } from 'jspdf';
import 'jspdf-autotable';
import * as XLSX from 'xlsx';

export default {
  setup() {
    const visits = ref([]);
    const filterQuery = ref('');
    const userStore = useUserStore();
    const token = ref(userStore.getToken);
    const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;

    // Fetch all visits
    const fetchVisits = async () => {
      try {
        const response = await fetch(`${BASE_URL}/api/visits`, {
          headers: {
            'Authorization': `Bearer ${token.value}`,
            'Accept': 'application/json',
          },
        });
        const data = await response.json();
        visits.value = data.data;
      } catch (error) {
        console.error('Error fetching visits:', error);
      }
    };

    // Filter visits by patient name or ID
    const filterVisits = async () => {
      try {
        const response = await fetch(`${BASE_URL}/api/patients/filter?name=${filterQuery.value}`, {
          headers: {
            'Authorization': `Bearer ${token.value}`,
            'Accept': 'application/json',
          },
        });
        const data = await response.json();
        visits.value = data.data;
      } catch (error) {
        console.error('Error filtering visits:', error);
      }
    };

    // Export visits to PDF
    const exportToPDF = () => {
      const doc = new jsPDF();
      doc.setFontSize(18);
      doc.text('Patient Summary Report', 14, 22);

      doc.setFontSize(12);
      doc.autoTable({
        head: [['#', 'Id', 'Patient', 'Check-In', 'Check-Out', 'Current Stage']],
        body: visits.value.map((visit, index) => [
          index + 1,
          visit.id,
          visit.patient.name,
          formatDate(visit.check_in_time),
          formatDate(visit.check_out_time),
          visit.current_stage
        ]),
        startY: 30,
      });

      doc.save('patients.pdf');
    };

    // Export visits to Excel
    const exportToExcel = () => {
      const ws_data = [
        ['#', 'Id', 'Patient', 'Check-In', 'Check-Out', 'Current Stage'],
        ...visits.value.map((visit, index) => [
          index + 1,
          visit.id,
          visit.patient.name,
          formatDate(visit.check_in_time),
          formatDate(visit.check_out_time),
          visit.current_stage
        ])
      ];

      const ws = XLSX.utils.aoa_to_sheet(ws_data);
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, 'Visit Summary');
      XLSX.writeFile(wb, 'patients.xlsx');
    };

    // Format date for display
    const formatDate = (dateString) => {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString();
    };

    // Fetch visits on component mount
    onMounted(fetchVisits);

    return {
      visits,
      filterQuery,
      fetchVisits,
      filterVisits,
      exportToPDF,
      exportToExcel,
      formatDate,
    };
  },
};
</script>
