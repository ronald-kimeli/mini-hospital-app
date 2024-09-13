<!-- <script setup>
import Sidebar from './Layout/Sidebar.vue';
import Header from './Layout/Header.vue';
</script>

<template>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <Sidebar />
    <div class="body-wrapper">
      <Header />
      <div class="container-fluid">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template> -->


<template>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <Sidebar />
    <div class="body-wrapper">
      <Header />
      <div class="container-fluid">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script setup>
import { watch } from 'vue';
import { useNotificationStore } from '../stores/notificationStore'; 
import Sidebar from './Layout/Sidebar.vue';
import Header from './Layout/Header.vue';

const notificationStore = useNotificationStore();

watch(
  () => notificationStore.message,
  (newMessage) => {
    if (newMessage) {
      notificationStore.showNotification(notificationStore.message, notificationStore.type);
      notificationStore.message = '';
    }
  }
);
</script>

