<!-- <script setup>

import ProductList from './Revised/ProductList.vue';
import RecentTransactions from './Revised/RecentTransactions.vue';
import Row1 from './Revised/Row1.vue';

</script>

<template>
    <div>
        <Row1 />
        <RecentTransactions />
        <ProductList />
    </div>
</template> -->



<template>
    <div>
        <!-- Header -->
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <h4 class="fw-semibold mb-8">Dashboard Summary</h4>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-info rounded-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Patients</h5>
                        <p class="card-text">{{ summaryData.total_patients }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-success rounded-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Visits</h5>
                        <p class="card-text">{{ summaryData.total_visits }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-warning rounded-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Pending Treatments</h5>
                        <p class="card-text">{{ summaryData.pending_treatments }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart for Treatment Status by Department -->
        <div class="card shadow rounded mb-4">
            <div class="card-header">
                <h4>Treatment Status by Department</h4>
            </div>
            <div class="card-body">
                <apexchart type="donut" :options="departmentChartOptions" :series="departmentChartSeries" />
            </div>
        </div>

        <!-- Chart for Visits by Date -->
        <div class="card shadow rounded mb-4">
            <div class="card-header">
                <h4>Visits by Date</h4>
            </div>
            <div class="card-body">
                <apexchart type="line" :options="visitsChartOptions" :series="visitsChartSeries" />
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
import ApexCharts from 'vue3-apexcharts';
import { useUserStore } from '../stores/userState';

export default defineComponent({
    components: {
        apexchart: ApexCharts,
    },
    setup() {
        const summaryData = ref({});
        const departmentChartOptions = ref({
            chart: {
                type: 'donut',
                height: 300,
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '60%',
                    },
                },
            },
            labels: [],
            colors: ['#FF4560', '#00E396', '#008FFB', '#FEB019'],
            legend: {
                position: 'bottom',
            },
        });
        const departmentChartSeries = ref([]);

        const visitsChartOptions = ref({
            chart: {
                type: 'line',
                zoom: {
                    enabled: false,
                },
                height: 350,
            },
            stroke: {
                curve: 'smooth',
            },
            xaxis: {
                categories: [],
            },
            colors: ['#00E396'],
            dataLabels: {
                enabled: false,
            },
        });
        const visitsChartSeries = ref([{
            name: 'Visits',
            data: [],
        }]);

        const userStore = useUserStore();
        const token = ref(userStore.getToken);

        const fetchSummaryData = async () => {
            try {
                const BASE_URL = import.meta.env.VITE_PUBLIC_BACKEND_URL;
                const response = await fetch(`${BASE_URL}/api/dashboard/summary`, {
                    headers: {
                        'Authorization': `Bearer ${token.value}`,
                        'Accept': 'application/json',
                    },
                });
                const data = await response.json();
                console.log(data);

                summaryData.value = data.data;

                // Update charts for departments
                departmentChartOptions.value.labels = summaryData.value.treatments_by_department.map(dept => dept.department);
                departmentChartSeries.value = summaryData.value.treatments_by_department.map(dept => dept.count);

                // Update charts for visits
                const today = new Date();
                const past30Days = Array.from({ length: 30 }, (_, i) => {
                    const date = new Date();
                    date.setDate(today.getDate() - i);
                    return date.toISOString().split('T')[0];
                }).reverse();

                const visitsByDate = summaryData.value.visits_by_date.reduce((acc, visit) => {
                    acc[visit.date] = visit.count;
                    return acc;
                }, {});

                visitsChartOptions.value.xaxis.categories = past30Days;
                visitsChartSeries.value[0].data = past30Days.map(date => visitsByDate[date] || 0);

            } catch (error) {
                console.error('Error fetching summary data:', error);
            }
        };

        onMounted(fetchSummaryData);

        return {
            summaryData,
            departmentChartOptions,
            departmentChartSeries,
            visitsChartOptions,
            visitsChartSeries,
        };
    },
});
</script>

<style scoped>
.card {
    border: 1px solid #ddd;
}

.card-body {
    padding: 1rem;
}

.card-title {
    font-size: 1.25rem;
}

.card-text {
    font-size: 1.5rem;
}
</style>