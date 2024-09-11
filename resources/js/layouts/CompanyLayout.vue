<template>
    <div class="pt-16">
      <!-- Sidebar -->
      <CompanySidebar/>
      <main>
        <div class="p-4 sm:ml-64">
          <router-view />
        </div>
      </main>
    </div>
    <!-- Footer -->
    <!--  -->
  <!-- </div> -->
</template>

<script setup>
import CompanySidebar from '../components/CompanySidebar.vue';
</script>

<style scoped>
</style>