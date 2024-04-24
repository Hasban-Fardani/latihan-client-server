import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('@/views/LoginView.vue') 
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('@/views/RegisterView.vue') 
    },
    {
      path: '/spareparts/details/:id',
      name: 'spareparts-detail',
      component: () => import('@/views/SparepartDetail.vue') 
    },
    {
      path: '/spareparts',
      name: 'spareparts',
      component: () => import('@/views/SparepartsListView.vue') 
    },
    {
      path: '/admin/dashboard',
      name: 'admin-dashboard',
      component: () => import('@/views/admin/DashboardView.vue') 
    },
    {
      path: '/admin/sparepart',
      name: 'admin-sparepart',
      component: () => import('@/views/admin/SparepartView.vue') 
    },
    {
      path: '/admin/category',
      name: 'admin-category',
      component: () => import('@/views/admin/CategoryView.vue') 
    },
    {
      path: '/admin/transaction',
      name: 'admin-transaction',
      component: () => import('@/views/admin/TransactionView.vue') 
    },
    {
      path: '/admin/user',
      name: 'admin-user',
      component: () => import('@/views/admin/UserView.vue') 
    },
  ]
})

export default router
