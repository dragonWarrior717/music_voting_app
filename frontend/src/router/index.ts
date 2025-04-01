import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/login',
            name: 'login',
            component: () => import('@/pages/LoginPage.vue'),
            meta: { guest: true }
        },
        {
            path: '/register',
            name: 'register',
            component: () => import('@/pages/RegisterPage.vue'),
            meta: { guest: true }
        },
        {
            path: '/albums',
            name: 'albums',
            component: () => import('@/pages/AlbumPage.vue'),
            meta: { requiresAuth: true }
        },
        {
            path: '/albums/:id',
            name: 'album-detail',
            component: () => import('@/pages/AlbumDetailPage.vue'),
            meta: { requiresAuth: true }
        },
        {
            path: '/',
            redirect: '/albums'
        }
    ]
});

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();
    
    if (to.meta.requiresAuth && !authStore.token) {
        next('/login');
    } else if (to.meta.guest && authStore.token) {
        next('/albums');
    } else {
        next();
    }
});

export default router; 