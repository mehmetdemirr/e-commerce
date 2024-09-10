<template>
    <div class="p-4 max-w-md mx-auto">
      <h2 class="text-2xl font-bold text-center mb-8">Şifremi Unuttum</h2>
      <form @submit.prevent="submitForgotPassword">
        <div class="mb-4">
          <label class="block text-gray-700">E-posta Adresi</label>
          <input
            type="email"
            v-model="email"
            class="w-full px-3 py-2 border border-gray-300 rounded-md"
            placeholder="E-posta adresinizi girin"
            required
          />
        </div>
        <button
          type="submit"
          class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600"
        >
          Gönder
        </button>
      </form>
      <p class="mt-4 text-center">
        Hesabınız var mı? 
        <router-link to="/login" class="text-blue-500 hover:underline">Giriş Yap</router-link>
      </p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { forgotPassword } from '../../services/authService'; // Şifre sıfırlama servisi
  import { showError, showSuccess } from '../../services/alertService'; 
  import { useRouter } from 'vue-router';
  
  const email = ref('company@gmail.com');
  const router = useRouter();
  
  const submitForgotPassword = async () => {
    try {
      const response = await forgotPassword(email.value);
      console.log(response);
      if (response.success) {
        showSuccess('E-posta gönderildi. Lütfen e-posta adresinizi kontrol edin.');
        router.push({ name: 'passwordReset' });
      } else {
        showError('E-posta gönderilemedi. Lütfen tekrar deneyin.');
      }
    } catch (error) {
      showError('E-posta gönderilirken bir hata oluştu.');
    }
  };
  </script>
  
  <style scoped>
  /* Burada gerekli stilleri ekleyebilirsiniz */
  </style>
  