<template>
    <div>
      <h2 class="text-2xl font-bold text-center mb-8">Şifre Sıfırlama</h2>
      <form @submit.prevent="submitResetPassword">
        <div class="mb-4">
          <label class="block text-gray-700">E-Posta</label>
          <input
            type="email"
            v-model="email"
            class="w-full px-3 py-2 border border-gray-300 rounded-md"
            placeholder="E-Posta adresinizi girin"
            required
          />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">OTP</label>
          <input
            type="text"
            v-model="otp"
            class="w-full px-3 py-2 border border-gray-300 rounded-md"
            placeholder="OTP kodunuzu girin"
            required
          />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Yeni Şifre</label>
          <input
            type="password"
            v-model="newPassword"
            class="w-full px-3 py-2 border border-gray-300 rounded-md"
            placeholder="Yeni şifrenizi girin"
            required
          />
        </div>
        <button
          type="submit"
          class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600"
        >
          Şifreyi Sıfırla
        </button>
        <p class="mt-4 text-center">
        Zaten bir hesabınız var mı?
        <router-link to="/login" class="text-green-500 hover:underline">Giriş</router-link>
      </p>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { resetPassword } from '../../services/authService';
  import { showError, showSuccess } from '../../services/alertService';
  
  const email = ref('');
  const otp = ref('');
  const newPassword = ref('');
  
  const submitResetPassword = async () => {
    try {
      const response = await resetPassword(email.value, otp.value, newPassword.value);
      if (response.success) {
        showSuccess('Şifreniz başarıyla sıfırlandı!');
        router.push({ name: 'login' });
      } else {
        showError('Şifre sıfırlanamadı. Lütfen bilgilerinizi kontrol edin.');
      }
    } catch (error) {
      showError('Şifre sıfırlanırken bir hata oluştu.');
    }
  };
  </script>
  
  <style scoped>
  /* Stil ekleyebilirsiniz */
  </style>
  