<template>
    <div class="row">
      <!-- Recent Transactions Timeline -->
      <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100">
          <div class="card-body p-4">
            <div class="mb-4">
              <h5 class="card-title fw-semibold">Recent Transactions</h5>
            </div>
            <ul class="timeline-widget mb-0 position-relative mb-n5">
              <li v-for="(transaction, index) in transactions" :key="index" class="timeline-item d-flex position-relative overflow-hidden">
                <div class="timeline-time text-dark flex-shrink-0 text-end">{{ transaction.time }}</div>
                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                  <span :class="['timeline-badge', 'border-2', `border-${transaction.type}`, 'flex-shrink-0', 'my-8']"></span>
                  <span class="timeline-badge-border d-block flex-shrink-0"></span>
                </div>
                <div class="timeline-desc fs-3 text-dark mt-n1">
                  <span v-html="transaction.description"></span>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
  
      <!-- Recent Transactions Table -->
      <div class="col-lg-8 d-flex align-items-stretch">
        <div class="card w-100">
          <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Recent Transactions</h5>
            <div class="table-responsive">
              <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                  <tr>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Id</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Assigned</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Name</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Priority</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Budget</h6>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="transaction in tableData" :key="transaction.id">
                    <td class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">{{ transaction.id }}</h6>
                    </td>
                    <td class="border-bottom-0">
                      <h6 class="fw-semibold mb-1">{{ transaction.assigned }}</h6>
                      <span class="fw-normal">{{ transaction.role }}</span>
                    </td>
                    <td class="border-bottom-0">
                      <p class="mb-0 fw-normal">{{ transaction.name }}</p>
                    </td>
                    <td class="border-bottom-0">
                      <div class="d-flex align-items-center gap-2">
                        <span :class="['badge', `bg-${transaction.priority}`, 'rounded-3', 'fw-semibold']">{{ transaction.priorityText }}</span>
                      </div>
                    </td>
                    <td class="border-bottom-0">
                      <h6 class="fw-semibold mb-0 fs-4">{{ transaction.budget }}</h6>
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
  export default {
    data() {
      return {
        transactions: [
          { time: '09:30', type: 'primary', description: 'Payment received from John Doe of $385.90' },
          { time: '10:00 am', type: 'info', description: 'New sale recorded <a href="javascript:void(0)" class="text-primary d-block fw-normal">#ML-3467</a>' },
          { time: '12:00 am', type: 'success', description: 'Payment was made of $64.95 to Michael' },
          { time: '09:30 am', type: 'warning', description: 'New sale recorded <a href="javascript:void(0)" class="text-primary d-block fw-normal">#ML-3467</a>' },
          { time: '09:30 am', type: 'danger', description: 'New arrival recorded' },
          { time: '12:00 am', type: 'success', description: 'Payment Done' }
        ],
        tableData: [
          { id: 1, assigned: 'Sunil Joshi', role: 'Web Designer', name: 'Elite Admin', priority: 'primary', priorityText: 'Low', budget: '$3.9' },
          { id: 2, assigned: 'Andrew McDownland', role: 'Project Manager', name: 'Real Homes WP Theme', priority: 'secondary', priorityText: 'Medium', budget: '$24.5k' },
          { id: 3, assigned: 'Christopher Jamil', role: 'Project Manager', name: 'MedicalPro WP Theme', priority: 'danger', priorityText: 'High', budget: '$12.8k' },
          { id: 4, assigned: 'Nirav Joshi', role: 'Frontend Engineer', name: 'Hosting Press HTML', priority: 'success', priorityText: 'Critical', budget: '$2.4k' }
        ]
      };
    }
  };
  </script>
  
  <style scoped>
  /* Scoped styles for the component */
  </style>
  