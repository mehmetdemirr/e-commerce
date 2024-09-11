<template>
   <header>
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      <div class="flex items-center justify-start rtl:justify-end">
        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
               <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
         </button>
        <a href="/" class="flex ms-2 md:me-24">
          <img src='/assets/images/logo.png' class="h-8 me-3" alt="FlowBite Logo" />
          <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">E-Ticaret</span>
        </a>
      </div>
      <div class="flex items-center">
          <div class="flex items-center ms-3">
            <button
            @click="logout"
              class="mt-4 bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600"
            >
              Çıkış Yap
          </button>
          </div>
        </div>
    </div>
  </div>
</nav>
</header>
</template>

<script setup>
  import { useRouter } from 'vue-router';
  import { ref } from 'vue';
  import { logout as apiLogout } from '../services/authService'; // Çıkış işlemini yapan servis fonksiyonu
  
  const router = useRouter();
  
  const logout = async () => {
    console.log("çıkış yap");
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

  