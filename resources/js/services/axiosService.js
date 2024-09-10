import axios from 'axios';

// Token'ı localStorage veya başka bir yerden alabilirsin
const token = localStorage.getItem('token');

// Axios instance oluşturuyoruz
const customAxios = axios.create({
  baseURL: 'http://localhost/api', 
  headers: {
    'Content-Type': 'application/json',
    Authorization: `Bearer ${token}`
  }
});

// Request interceptor (istek yapılmadan önce token güncellenebilir)
customAxios.interceptors.request.use(
  (config) => {
    const newToken = localStorage.getItem('token');
    if (newToken) {
      config.headers.Authorization = `Bearer ${newToken}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

export default customAxios;
