import { createRouter, createWebHashHistory } from 'vue-router'

import { getCurrentUser } from './db'
import Home from './views/Home.vue'

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
    component: () => import(/* webpackChunkName: "categories" */ './views/Products.vue')
  },
  {
    path: '/categories',
    name: 'Categories',
    meta: { requiresAuth: true },
    component: () => import(/* webpackChunkName: "categories" */ './views/Categories.vue')
  },
  {
    path: '/preselection',
    name: 'Preselection',
    meta: { requiresAuth: true },
    component: () => import(/* webpackChunkName: "preselection" */ './views/Preselection.vue')
  },
  {
    path: '/about',
    name: 'About',
    component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

router.beforeEach(async (to, from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  if (requiresAuth && !await getCurrentUser()) {
    next('/');
  }
  else {
    next();
  }
})

export default router
