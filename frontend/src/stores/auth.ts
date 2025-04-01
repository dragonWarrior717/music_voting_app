import { defineStore } from 'pinia';
import { ref } from 'vue';
import type { User } from '@/types';
import api from '@/utils/api';
import router from '@/router';

export const useAuthStore = defineStore('auth', () => {
    const user = ref<User | null>(null);
    const token = ref<string | null>(null);

    const login = async (email: string, password: string) => {
        try {
            const response = await api.post('/login', { email, password });
            user.value = response.data.user;
            token.value = response.data.token;
            localStorage.setItem('token', response.data.token);
            router.push('/albums');
        } catch (error) {
            throw error;
        }
    };

    const register = async (name: string, email: string, password: string, password_confirmation: string) => {
        try {
            const response = await api.post('/register', {
                name,
                email,
                password,
                password_confirmation
            });
            user.value = response.data.user;
            token.value = response.data.token;
            localStorage.setItem('token', response.data.token);
            router.push('/albums');
        } catch (error) {
            throw error;
        }
    };

    const logout = async () => {
        try {
            await api.post('/logout');
            user.value = null;
            token.value = null;
            localStorage.removeItem('token');
            router.push('/login');
        } catch (error) {
            console.error('Logout error:', error);
        }
    };

    return {
        user,
        token,
        login,
        register,
        logout
    };
}); 