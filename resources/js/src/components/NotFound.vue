<template>
  <div>
    <h1>404 - Not Found</h1>
    <p>The page you are looking for does not exist.</p>
    <RouterLink to="/">Go back to Home</RouterLink>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '../stores/userState';

const router = useRouter();
const userStore = useUserStore();

onMounted(() => {
  if (userStore.getToken) { 
    router.push('/dashboard'); 
  }
});
</script>
