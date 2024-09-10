<!-- CompanyRegister.vue -->
<template>
    <div>
      <h2 class="text-2xl font-bold text-center mb-8">Kayıt Ol</h2>
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
      <p class="mt-4 text-center">
        Şirket olarak mı devam edeceksin?
        <router-link to="/company/register" class="text-green-500 hover:underline">Şirket Kayıt</router-link>
      </p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useRouter } from 'vue-router'; 
  import { register } from '../../services/authService';
  import { showError, showSuccess } from '../../services/alertService';
  
  const name = ref('mehmet demir');
  const email = ref('mehmet@gmail.com');
  const password = ref('12345678');
  const passwordAgain = ref('12345678');

  const router = useRouter();

  const submitRegister = async () => {
    // Kayıt işlemleri burada yapılabilir
    console.log('Name:', name.value);
    console.log('Email:', email.value);
    console.log('Password:', password.value);
    console.log('Password Again:', passwordAgain.value);
  try {
    const response = await register(name.value,email.value, password.value,passwordAgain.value,"user");
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
  
  <style scoped>

  </style>
  