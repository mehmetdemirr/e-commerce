import axiosService from './axiosService';

// Ürünleri getirme
export const getProducts = async (page = 1, perPage = 10) => {
  try {
    const response = await axiosService.get(`/products/company`, {
      params: {
        page,
        per_page: perPage,
      },
    });
    return response.data;
  } catch (error) {
    console.error('Product fetch failed:', error);
    throw error;
  }
};

// Ürün ekleme
export const addProduct = async (productData) => {
  try {
    const response = await axiosService.post(`/products`, productData);
    return response.data;
  } catch (error) {
    console.error('Product add failed:', error);
    throw error;
  }
};
