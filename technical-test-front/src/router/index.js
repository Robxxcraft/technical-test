import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('../views/home.vue')
    },
    {
      path: '/posts',
      component: () => import('../views/posts/manage.vue')
    },
    {
      path: '/posts/details/:slug',
      component: () => import('../views/posts/detail.vue')
    },
    {
      path: '/posts/create',
      component: () => import('../views/posts/create.vue')
    },
    {
      path: '/posts/edit/:slug',
      component: () => import('../views/posts/edit.vue')
    }
  ]
})

export default router
