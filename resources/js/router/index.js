import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/views/Home.vue';
import BookForm from '@/components/BookForm.vue'; // Adjust the path as needed

const routes = [
  { path: '/', component: Home },
  { path: '/books', component: BookForm },
  // Add other routes as needed
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
