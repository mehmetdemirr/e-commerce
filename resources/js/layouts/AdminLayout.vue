<!-- AdminLayout.vue -->
<template>
  Admin Layout
    <div>
      <header>
        <nav>
          <router-link to="/">Dashboard</router-link>
          <router-link to="/users">Users</router-link>
          <router-link to="/orders">Orders</router-link>
          <router-link to="/settings">Settings</router-link>
          <router-link to="/logout">Logout</router-link>
        </nav>
      </header>
      <main>
        <router-view></router-view>
      </main>
      <footer>
        <!-- Footer content -->
      </footer>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  // setup kısmında gerekli olan ref ve diğer reaktif değişkenler burada tanımlanabilir
  </script>
  
  <style scoped>
  /* Admin layout styles */
  </style>
  