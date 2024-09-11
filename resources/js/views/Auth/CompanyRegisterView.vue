<!-- CompanyRegister.vue -->
<template>
    <div>
      <h2 class="text-2xl font-bold text-center mb-8">Şirket Kayıt Ol</h2>
      <form @submit.prevent="submitRegister">
        <div class="mb-4">
          <label class="block text-gray-700">Ad</label>
          <input
            type="text"
            v-model="name"
            class="w-full px-3 py-2 border border-gray-300 rounded-md"
            placeholder="Ad soyadınızı giriniz"
            required
          />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Email</label>
          <input
            type="email"
            v-model="email"
            class="w-full px-3 py-2 border border-gray-300 rounded-md"
            placeholder="E-Mail adresinizi giriniz "
            required
          />
        </div>
        <div class="mb-6">
          <label class="block text-gray-700">Parola</label>
          <input
            type="password"
            v-model="password"
            class="w-full px-3 py-2 border border-gray-300 rounded-md"
            placeholder="Parolanız giriniz"
            required
          />
        </div>
        <div class="mb-6">
          <label class="block text-gray-700">Parola Tekrarı</label>
          <input
            type="password"
            v-model="passwordAgain"
            class="w-full px-3 py-2 border border-gray-300 rounded-md"
            placeholder="Parolanızı tekrar giriniz"
            required
          />
        </div>
        <button
          type="submit"
          class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600"
        >
          Register
        </button>
      </form>
      <p class="mt-4 text-center">
        Zaten bir hesabınız var mı?
        <router-link to="/login" class="text-green-500 hover:underline">Giriş</router-link>
      </p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { register } from '../../services/authService';
  import { showError, showSuccess } from '../../services/alertService';
  
  const name = ref('');
  const email = ref('');
  const password = ref('');
  const passwordAgain = ref('');
  
  const submitRegister = async () => {
    // Kayıt işlemleri burada yapılabilir
    console.log('Name:', name.value);
    console.log('Email:', email.value);
    console.log('Password:', password.value);
    console.log('Password Again:', passwordAgain.value);
  try {
    const response = await register(name.value,email.value, password.value,passwordAgain.value,"company");
    console.log(response);
    if (response.success) {
      showSuccess('Kayıt Başarılı!');
      router.push({name:"login"});
    } else {
      showError('Giriş başarısız. Giriş bilgilerini kontrol ediniz!');
    }
  } catch (error) {
    showError(`Giriş başarısız. Giriş bilgilerini kontrol ediniz!`);
  }
};
  </script>