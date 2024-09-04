// src/router/index.js

import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../views/Dashboard.vue';
import Quiz from '../views/Quiz.vue';

const routes = [
  {
    path: '/',
    name: 'Dashboard',
    component: Dashboard,
  },
  {
    path: '/quiz/:quizId',
    name: 'Quiz',
    component: Quiz,
    props: true,  // This enables passing quizId as a prop to the Quiz component
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
