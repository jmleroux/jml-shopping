import { createRouter, createWebHashHistory } from 'vue-router'

import Home from './views/HomeView.vue'
import useAuthentication from "./useAuthentication";

const { isAuthenticated } = useAuthentication();

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/products',
    name: 'Products',
    meta: { requiresAuth: true },
    component: () => import('./views/ProductsView.vue')
  },
  {
    path: '/categories',
    name: 'Categories',
    meta: { requiresAuth: true },
    component: () => import('./views/CategoriesView.vue')
  },
  {
    path: '/preselection',
    name: 'Preselection',
    meta: { requiresAuth: true },
    component: () => import('./views/PreselectionView.vue')
  },
  {
    path: '/contact',
    name: 'Contact',
    component: () => import('./views/ContactView.vue')
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

router.beforeEach(async (to, from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  if (requiresAuth && !isAuthenticated.value) {
    next('/');
  }
  else {
    next();
  }
})

export default router
