import { createRouter, createWebHistory } from 'vue-router'
import Register from '../components/Register.vue'
import Login from '../components/Login.vue'
import Profile from '../components/Profile.vue'
import ProductList from '../components/ProductList.vue'
import ProductCreateEdit from '../components/ProductCreateEdit.vue'
import Cart from '../components/Cart.vue'
import OrderHistory from '../components/OrderHistory.vue'
import CMSManagement from '../components/CMSManagement.vue'

const routes = [
  {
    path: '/register',
    name: 'Register',
    component: Register,
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/profile',
    name: 'Profile',
    component: Profile,
    meta: { requiresAuth: true },
  },
  {
    path: '/products',
    name: 'ProductList',
    component: ProductList,
    meta: { requiresAuth: true },
  },
  {
    path: '/products/create',
    name: 'ProductCreate',
    component: ProductCreateEdit,
    meta: { requiresAuth: true },
  },
  {
    path: '/products/edit/:id',
    name: 'ProductEdit',
    component: ProductCreateEdit,
    meta: { requiresAuth: true },
  },
  {
    path: '/cart',
    name: 'Cart',
    component: Cart,
    meta: { requiresAuth: true },
  },
  {
    path: '/orders',
    name: 'OrderHistory',
    component: OrderHistory,
    meta: { requiresAuth: true },
  },
  {
    path: '/cms',
    name: 'CMSManagement',
    component: CMSManagement,
    meta: { requiresAuth: true },
  },
  {
    path: '/',
    redirect: '/login',
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Navigation guard for auth
router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('auth_token')
  if (to.meta.requiresAuth && !isAuthenticated) {
    next({ name: 'Login' })
  } else {
    next()
  }
})

export default router
