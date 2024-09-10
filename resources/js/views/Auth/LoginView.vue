<template>
  <div>
    <h2 class="text-2xl font-bold text-center mb-8">Giriş</h2>
    <form @submit.prevent="submitLogin">
      <div class="mb-4">
        <label class="block text-gray-700">Email</label>
        <input
          type="email"
          v-model="email"
          class="w-full px-3 py-2 border border-gray-300 rounded-md"
          placeholder="E-Mail adresinizi girin"
          required
          autocomplete="email"
        />
      </div>
      <div class="mb-6">
        <label class="block text-gray-700">Parola</label>
        <input
          type="password"
          v-model="password"
          class="w-full px-3 py-2 border border-gray-300 rounded-md"
          placeholder="Şifrenizi giriniz"
          required
          autocomplete="current-password"
        />
      </div>
      <button
        type="submit"
        class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600"
      >
        Giriş Yap
      </button>
    </form>
    <p class="mt-4 text-center">
      Hesabınız yok mu?
      <router-link to="/register" class="text-blue-500 hover:underline">Kayıt Ol</router-link>
    </p>
    <p class="mt-2 text-center">
      Şifrenizi mi unuttunuz?
      <router-link to="/password-forgot" class="text-blue-500 hover:underline">Şifremi Unuttum</router-link>
    </p>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router'; 
import { login } from '../../services/authService';
import { showError, showSuccess } from '../../services/alertService';

const email = ref('company@gmail.com');
const password = ref('password');

const router = useRouter();

const submitLogin = async () => {
  try {
    const response = await login(email.value, password.value);
    console.log(response);
    if (response.success) {
      showSuccess('Giriş Başarılı!');
      const userRole = localStorage.getItem('role');
      // Kullanıcı rolüne göre yönlendirme
      if (userRole === 'user') {
        router.push({ name: 'user-home' });
      } else if (userRole === 'company') {
        router.push({ name: 'company-home' });
      } else if (userRole === 'admin') {
        router.push({ name: 'admin-home' });
      } else {
        // Rol yoksa login sayfasına yönlendir
        router.push({ name: 'login' });
      }
    } else {
      showError('Giriş başarısız. Giriş bilgilerini kontrol ediniz!');
    }
  } catch (error) {
    showError('Giriş başarısız. Giriş bilgilerini kontrol ediniz!');
  }
};
</script>

<style scoped>
/* Özel stiller buraya eklenebilir */
</style>
