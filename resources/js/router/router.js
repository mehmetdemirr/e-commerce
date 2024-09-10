import { createRouter, createWebHistory } from "vue-router";
import UserLayout from '../layouts/UserLayout.vue';
import CompanyLayout from '../layouts/CompanyLayout.vue';
import AdminLayout from '../layouts/AdminLayout.vue';
import AuthLayout from '../layouts/AuthLayout.vue';

const routes = [
     {
        path: '/',
        component: AuthLayout,
        children: [
          { path: 'login', name: 'login', component: () => import('../views/Auth/LoginView.vue') },
          { path: 'register', name: 'register', component: () => import('../views/Auth/UserRegisterView.vue') },
          { path: 'company/register', name: 'company-register', component: () => import('../views/Auth/companyRegisterView.vue') },
          { path: 'password-forgot', name: 'password-forgot', component: () => import('../views/Auth/passwordForgotView.vue') },
          { path: 'password-reset', name: 'password-reset', component: () => import('../views/Auth/passwordResetView.vue') } 
        ]
     },
     {
        path: '/user',
        component: UserLayout,
        children: [
          { path: '', name: 'user-home', component: () => import('../views/User/HomeView.vue') },
        ]
      },
      {
        path: '/company',
        component: CompanyLayout,
        children: [
          { path: '', name: 'company-home', component: () => import('../views/Company/HomeView.vue') },
          { path: 'products', name: 'company-products', component: () => import('../views/Company/Product/ProductView.vue') },
          { path: 'customers', name: 'company-customers', component: () => import('../views/Company/CustomerView.vue') },
          { path: 'orders', name: 'company-orders', component: () => import('../views/Company/OrderView.vue') },
        ]
      },
      {
        path: '/admin',
        component: AdminLayout,
        children: [
          { path: '', name: 'admin-home', component: () => import('../views/Admin/HomeView.vue') },
        ]
      },
      {
        path: '/:catchAll(.*)',name: 'not-found',component: () => import('../views/NotFoundView.vue')
      },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation Guard ile token ve role kontrolü
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  const userRole = localStorage.getItem('role');
  // Eğer token yoksa login veya register sayfasına yönlendirme
  if (!token) {
    if (to.name === 'login' || to.name === 'register' || to.name === 'company-register' || to.name === 'password-forgot' || to.name === 'password-reset') {
      return next();
    }
    return next({ name: 'login' });
  }

  // Eğer token varsa ve login, register veya company-register sayfasındaysak ana sayfaya yönlendir
  if (token && (to.name === 'login' || to.name === 'register' || to.name === 'company-register' || to.name === 'password-forgot' || to.name === 'password-reset')) {
    if (userRole === 'user') {
      return next({ name: 'user-home' });
    } else if (userRole === 'company') {
      return next({ name: 'company-home' });
    } else if (userRole === 'admin') {
      return next({ name: 'admin-home' });
    }
  }

  // Kullanıcı rolüne göre sayfalara erişim kontrolü
  if (to.name === 'user-home' && userRole !== 'user') {
    return next({ name: 'login' });
  } else if (to.name === 'company-home' && userRole !== 'company') {
    return next({ name: 'login' });
  } else if (to.name === 'admin-home' && userRole !== 'admin') {
    return next({ name: 'login' });
  }

  // Ana sayfa yönlendirmesi için token ve rol kontrolü
  if (to.path === '/') {
    if (token) {
      if (userRole === 'user') {
        return next({ name: 'user-home' });
      } else if (userRole === 'company') {
        return next({ name: 'company-home' });
      } else if (userRole === 'admin') {
        return next({ name: 'admin-home' });
      }
    } else {
      return next({ name: 'login' });
    }
  }

  // Eğer role ve token uyumluysa, yönlendirmeye devam et
  next();
});

export default router;
