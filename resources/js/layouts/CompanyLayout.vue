<template>
  <div class="flex flex-col h-screen">
    <div class="flex flex-1 pt-16">
      <!-- Sidebar -->
      <CompanySidebar/>
      <main>
        <div class="p-4 sm:ml-64">
          <router-view />
        </div>
      </main>
    </div>
    <!-- Footer -->
    <CompanyFooter class="fixed bottom-0 left-0 w-full z-20" />
  </div>
</template>

<script setup>
import CompanySidebar from '../components/CompanySidebar.vue';
import CompanyFooter from '../components/CompanyFooter.vue';
</script>

<style scoped>
</style>