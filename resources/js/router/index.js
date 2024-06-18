import { createRouter, createWebHistory } from "vue-router";

import home from '../Components/HomePage.vue';
import about from '../Components/AboutPage.vue';
import notFound from '../Components/NotFoundPage.vue';

const routes = [
  {
    path: '/',
    component: home,
  },
  {
    path: '/about',
    component: about,
  },
  {
    path: '/:pathMatch(.*)*',
    component: notFound,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;