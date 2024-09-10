import axiosService from './axiosService';

// Login işlemi
export const login = async (email, password) => {
  try {
    const response = await axiosService.post('/auth/login', {
      email,
      password,
    });
    if (response.data.data.token && response.data.data.roles) {
      localStorage.setItem('token', response.data.token);
      localStorage.setItem('role', response.data.data.roles[0]);
    }
    return response.data;
  } catch (error) {
    console.error('Login failed:', error);
    throw error;
  }
};

// Şifremi unuttum işlemi
export const forgotPassword = async (email) => {
  try {
    const response = await axiosService.post('/auth/password-forgot', {
      email,
    });
    console.log("password forgot response :",response);
    return response.data;
  } catch (error) {
    console.error('Password forgot failed:', error);
    throw error;
  }
};

// Şifre sıfırlama işlemi
export const resetPassword = async (email, otp, password) => {
  try {
    const response = await axiosService.post('/auth/password-reset', {
      email,
      otp,
      password,
    });
    return response.data;
  } catch (error) {
    console.error('Password reset failed:', error);
    throw error;
  }
};

// Kayıt olma işlemi
export const register = async (name, email, password, passwordConfirmation, role) => {
  try {
    const response = await axiosService.post('/auth/register', {
      name,
      email,
      password,
      password_confirmation: passwordConfirmation,
      role,
    });
    return response.data;
  } catch (error) {
    console.error('Registration failed:', error);
    throw error;
  }
};

// Logout işlemi
export const logout = async () => {
  try {
    const response = await axiosService.post('/auth/logout');
    localStorage.removeItem('token'); // Token'ı temizle
    return response.data;
  } catch (error) {
    console.error('Logout failed:', error);
    throw error;
  }
};
