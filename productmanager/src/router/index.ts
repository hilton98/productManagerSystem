import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import Register from '@/views/Register.vue';
import Login from '@/views/Login.vue';
import PanelView from '@/views/PanelView.vue';
import NotFound from '@/views/NotFound.vue';
import Cookies from 'js-cookie';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/dashboard',
    name: 'dashboard',
    component: PanelView,
    meta: { requiresAuth: true },
  },
  {
    path: '/',
    name: 'login',
    component: Login,
    beforeEnter: (to, from, next) => {
      const token = Cookies.get(process.env.VUE_APP_TOKEN_API); 
      if (token) {
        next('/dashboard');
      } else {
        next();
      }
    },
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    beforeEnter: (to, from, next) => {
      const token = Cookies.get(process.env.VUE_APP_TOKEN_API); 
      if (token) {
        next('/dashboard');
      } else {
        next();
      }
    }
  },
  {
    path: '/:catchAll(.*)', // Pega todas as rotas não encontradas
    name: 'NotFound',
    component: NotFound,
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
