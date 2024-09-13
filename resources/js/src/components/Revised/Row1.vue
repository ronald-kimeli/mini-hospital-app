<template>
    <div class="row">
      <div class="col-lg-8 d-flex align-items-stretch">
        <div class="card w-100">
          <div class="card-body">
            <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
              <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Sales Overview</h5>
              </div>
              <div>
                <select v-model="selectedMonth" class="form-select">
                  <option v-for="(month, index) in months" :key="index" :value="index + 1">
                    {{ month.label }}
                  </option>
                </select>
              </div>
            </div>
            <apexchart type="bar" height="345" :options="chartOptions" :series="chartSeries" />
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="row">
          <div class="col-lg-12">
            <!-- Yearly Breakup -->
            <div class="card overflow-hidden">
              <div class="card-body p-4">
                <h5 class="card-title mb-9 fw-semibold">Yearly Breakup</h5>
                <div class="row align-items-center">
                  <div class="col-8">
                    <h4 class="fw-semibold mb-3">$36,358</h4>
                    <div class="d-flex align-items-center mb-3">
                      <span class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                        <i class="ti ti-arrow-up-left text-success"></i>
                      </span>
                      <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                      <p class="fs-3 mb-0">last year</p>
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="me-4">
                        <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                        <span class="fs-2">2023</span>
                      </div>
                      <div>
                        <span class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"></span>
                        <span class="fs-2">2022</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="d-flex justify-content-center">
                      <apexchart type="donut" width="180" :options="breakupOptions" :series="breakupSeries" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <!-- Monthly Earnings -->
            <div class="card">
              <div class="card-body">
                <div class="row align-items-start">
                  <div class="col-8">
                    <h5 class="card-title mb-9 fw-semibold">Monthly Earnings</h5>
                    <h4 class="fw-semibold mb-3">$6,820</h4>
                    <div class="d-flex align-items-center pb-1">
                      <span class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                        <i class="ti ti-arrow-down-right text-danger"></i>
                      </span>
                      <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                      <p class="fs-3 mb-0">last year</p>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="d-flex justify-content-end">
                      <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                        <i class="ti ti-currency-dollar fs-6"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <apexchart id="earning" type="area" height="60" :options="earningOptions" :series="earningSeries" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import ApexCharts from 'vue3-apexcharts';
  
  export default {
    components: {
      apexchart: ApexCharts,
    },
    data() {
      return {
        selectedMonth: '1',
        months: [
          { label: 'March 2023' },
          { label: 'April 2023' },
          { label: 'May 2023' },
          { label: 'June 2023' }
        ],
        monthlyData: {
          1: { earnings: [355, 390, 300, 350, 390, 180, 355, 390], expenses: [280, 250, 325, 215, 250, 310, 280, 250] },
          2: { earnings: [400, 420, 350, 380, 400, 200, 400, 420], expenses: [300, 270, 340, 230, 270, 320, 300, 270] },
          3: { earnings: [330, 380, 320, 360, 370, 210, 340, 380], expenses: [290, 260, 330, 220, 260, 300, 290, 260] },
          4: { earnings: [360, 410, 330, 370, 380, 230, 350, 410], expenses: [310, 280, 340, 240, 280, 320, 310, 280] }
        },
        chartOptions: {
          chart: {
            type: 'bar',
            height: 345,
            offsetX: -15,
            toolbar: { show: true },
            foreColor: '#adb0bb',
            fontFamily: 'inherit',
            sparkline: { enabled: false },
          },
          colors: ['#5D87FF', '#49BEFF'],
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: '35%',
              borderRadius: [6],
              borderRadiusApplication: 'end',
              borderRadiusWhenStacked: 'all',
            },
          },
          markers: { size: 0 },
          dataLabels: { enabled: false },
          legend: { show: false },
          grid: {
            borderColor: 'rgba(0,0,0,0.1)',
            strokeDashArray: 3,
            xaxis: { lines: { show: false } },
          },
          xaxis: {
            type: 'category',
            categories: ['16/08', '17/08', '18/08', '19/08', '20/08', '21/08', '22/08', '23/08'],
            labels: { style: { cssClass: 'grey--text lighten-2--text fill-color' } },
          },
          yaxis: {
            show: true,
            min: 0,
            max: 400,
            tickAmount: 4,
            labels: { style: { cssClass: 'grey--text lighten-2--text fill-color' } },
          },
          stroke: {
            show: true,
            width: 3,
            lineCap: 'butt',
            colors: ['transparent'],
          },
          tooltip: { theme: 'light' },
          responsive: [
            {
              breakpoint: 600,
              options: {
                plotOptions: {
                  bar: {
                    borderRadius: 3,
                  },
                },
              },
            },
          ],
        },
        chartSeries: [
          { name: 'Earnings this month:', data: [355, 390, 300, 350, 390, 180, 355, 390] },
          { name: 'Expense this month:', data: [280, 250, 325, 215, 250, 310, 280, 250] },
        ],
        breakupOptions: {
          color: '#adb5bd',
          chart: {
            width: 180,
            type: 'donut',
            fontFamily: 'Plus Jakarta Sans, sans-serif',
            foreColor: '#adb0bb',
          },
          plotOptions: {
            pie: {
              startAngle: 0,
              endAngle: 360,
              donut: {
                size: '75%',
              },
            },
          },
          stroke: { show: false },
          dataLabels: { enabled: false },
          legend: { show: false },
          colors: ['#5D87FF', '#ecf2ff', '#F9F9FD'],
          responsive: [
            {
              breakpoint: 991,
              options: {
                chart: { width: 150 },
              },
            },
          ],
          tooltip: {
            theme: 'dark',
            fillSeriesColor: false,
          },
        },
        breakupSeries: [38, 40, 25],
        earningOptions: {
          chart: {
            id: 'sparkline3',
            type: 'area',
            height: 60,
            sparkline: { enabled: true },
            group: 'sparklines',
            fontFamily: 'Plus Jakarta Sans, sans-serif',
            foreColor: '#adb0bb',
          },
          series: [
            {
              name: 'Earnings',
              color: '#49BEFF',
              data: [25, 66, 20, 40, 12, 58, 20],
            },
          ],
          stroke: { curve: 'smooth', width: 2 },
          fill: { colors: ['#f3feff'], type: 'solid', opacity: 0.05 },
          markers: { size: 0 },
          tooltip: {
            theme: 'dark',
            fixed: { enabled: true, position: 'right' },
            x: { show: false },
          },
        },
        earningSeries: [
          {
            name: 'Earnings',
            color: '#49BEFF',
            data: [25, 66, 20, 40, 12, 58, 20],
          },
        ],
      };
    },
    watch: {
      selectedMonth(newMonth) {
        const data = this.monthlyData[newMonth];
        this.chartSeries = [
          { name: 'Earnings this month:', data: data.earnings },
          { name: 'Expense this month:', data: data.expenses }
        ];
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add any scoped styles here */
  </style>
  