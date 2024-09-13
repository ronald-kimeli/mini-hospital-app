<template>
    <div class="row">
      <div v-for="product in products" :key="product.id" class="col-sm-6 col-xl-3">
        <div class="card overflow-hidden rounded-2">
          <div class="position-relative">
            <a href="javascript:void(0)">
              <img :src="product.image" class="card-img-top rounded-0" :alt="product.name">
            </a>
            <a href="javascript:void(0)"
               class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3"
               data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart">
              <i class="ti ti-basket fs-4"></i>
            </a>
          </div>
          <div class="card-body pt-3 p-4">
            <h6 class="fw-semibold fs-4">{{ product.name }}</h6>
            <div class="d-flex align-items-center justify-content-between">
              <h6 class="fw-semibold fs-4 mb-0">
                ${{ product.currentPrice }} 
                <span class="ms-2 fw-normal text-muted fs-3">
                  <del>${{ product.originalPrice }}</del>
                </span>
              </h6>
              <ul class="list-unstyled d-flex align-items-center mb-0">
                <li v-for="n in 5" :key="n" class="me-1">
                  <a href="javascript:void(0)">
                    <i :class="['ti ti-star', { 'text-warning': n <= product.rating }]" ></i>
                  </a>
                </li>
              </ul>
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
        products: [
          {
            id: 1,
            name: 'Boat Headphone',
            image: '../assets/images/products/s4.jpg',
            currentPrice: 50,
            originalPrice: 65,
            rating: 5
          },
          {
            id: 2,
            name: 'MacBook Air Pro',
            image: '../assets/images/products/s5.jpg',
            currentPrice: 650,
            originalPrice: 900,
            rating: 5
          },
          {
            id: 3,
            name: 'Red Valvet Dress',
            image: '../assets/images/products/s7.jpg',
            currentPrice: 150,
            originalPrice: 200,
            rating: 5
          },
          {
            id: 4,
            name: 'Cute Soft Teddybear',
            image: '../assets/images/products/s11.jpg',
            currentPrice: 285,
            originalPrice: 345,
            rating: 5
          }
        ]
      };
    }
  };
  </script>
  
  <style scoped>
  /* Scoped styles for the component */
  </style>
  