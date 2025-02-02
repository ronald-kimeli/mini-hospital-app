<template>
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body">
          <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">BookLoans Overview</h5>
            </div>
          </div>
          <!-- Use ApexCharts component -->
          <apex-charts
            type="bar"
            height="350"
            :options="chartOptions"
            :series="chartSeries"
          ></apex-charts>
        </div>
      </div>
    </div>
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <h5 class="card-title fw-semibold mb-4">Recent BookLoans</h5>
          <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
              <thead class="text-dark fs-4">
                <tr>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Id</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">AssignedTo</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Name</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Status</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">OfferedDay</h6>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(bookloan, index) in bookloans" :key="index">
                  <td>
                    <h6 class="fw-semibold mb-0">{{ bookloan.id }}</h6>
                  </td>
                  <td>
                    <h6 class="fw-semibold mb-1">{{ bookloan.user.name }}</h6>
                  </td>
                  <td>
                    <p class="mb-0 fw-normal">{{ bookloan.book?.name }}</p>
                  </td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <span class="badge bg-success rounded-3 fw-semibold" v-if="bookloan.status == 'Returned'">{{ bookloan.status }}</span>
                      <span class="badge bg-primary rounded-3 fw-semibold" v-else>{{ bookloan.status }}</span>
                    </div>
                  </td>
                  <td>
                    <h6 class="fw-semibold mb-0 fs-4">{{ bookloan.loan_date }}</h6>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
import ApexCharts from 'vue3-apexcharts'; // Import the Vue wrapper for ApexCharts
import { useFetch } from '@vueuse/core';

export default defineComponent({
  name: 'BookLoansList',
  components: {
    ApexCharts,
  },
  setup() {
    const bookloans = ref([]);
    const chartOptions = ref({});
    const chartSeries = ref([]);
    const BASE_URL = "http://localhost:8001/api";

    const fetchBookLoans = async () => {
      try {
        const { data } = await useFetch(`${BASE_URL}/bookloans`);
        const response = data.value;
        const responseData = await response;
        bookloans.value = JSON.parse(responseData).data;
        console.log(typeof(bookloans));
        generateChart(); 
      } catch (error) {
        console.error('Error fetching bookloans:', error);
      }
    };

    const deleteBook = async (bookloanId) => {
      try {
        // await useFetch(`${BASE_URL}/bookloans/${bookloanId}`, { method: 'DELETE' });
        console.log(await useFetch(`${BASE_URL}/bookloans/${bookloanId}`, { method: 'DELETE' }));
        await fetchBookLoans();
      } catch (error) {
        console.error('Error deleting bookloan:', error);
      }
    };

    onMounted(() => {
      fetchBookLoans();
    });

    const generateChart = () => {
      // Prepare data for the chart (user_id, book_id, status)
      const userIDs = bookloans.value.map(loan => loan.user_id);
      const bookIDs = bookloans.value.map(loan => loan.book_id);
      const statuses = bookloans.value.map(loan => loan.status);

      // Chart configuration
      chartOptions.value = {
        chart: {
          type: 'bar',
          height: 350,
          stacked: true,
        },
        plotOptions: {
          bar: {
            horizontal: false,
          },
        },
        xaxis: {
          categories: bookloans.value.map(loan => loan.id), // Assuming 'id' is available in bookloans
        },
        legend: {
          position: 'top',
        },
      };

      chartSeries.value = [
        {
          name: 'User ID',
          data: userIDs,
        },
        {
          name: 'Book ID',
          data: bookIDs,
        },
        {
          name: 'Status',
          data: statuses,
        },
      ];
    };

    return {
      bookloans,
      deleteBook,
      chartOptions,
      chartSeries,
    };
  },
});
</script>

<style scoped>
/* Add any component-specific styles here */
</style>
