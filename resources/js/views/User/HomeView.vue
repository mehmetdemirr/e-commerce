<template>
    <div class="p-4">
      <h1 class="text-2xl font-bold">User Home Screen</h1>
      <button
        @click="logout"
        class="mt-4 bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600"
      >
        Çıkış Yap
      </button>
    </div>
  </template>
  
  <script setup>
  import { useRouter } from 'vue-router';
  import { ref } from 'vue';
  import { logout as apiLogout } from '../../services/authService'; // Çıkış işlemini yapan servis fonksiyonu
  
  const router = useRouter();
  
  const logout = async () => {
    try {
      await apiLogout(); // Çıkış yapma işlemi
      // Token'ı ve diğer kullanıcı bilgilerini temizle
      localStorage.removeItem('token');
      localStorage.removeItem('role');
      // Ana sayfaya yönlendir
      router.push({ name: 'login' });
    } catch (error) {
      console.error('Çıkış işlemi sırasında bir hata oluştu:', error);
    }
  };
  </script>
  
  <style scoped>
  /* Burada gerekli stilleri ekleyebilirsiniz */
  </style>
  