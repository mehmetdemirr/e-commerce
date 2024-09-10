<!-- AuthLayout.vue -->
<template>
   <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
      <router-view></router-view>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

</script>

<style scoped>

</style>
