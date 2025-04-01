import api from './config';

interface LoginData {
    email: string;
    password: string;
}

interface RegisterData extends LoginData {
    name: string;
}

export const authService = {
    async login(data: LoginData) {
        const response = await api.post('/login', data);
        if (response.data.token) {
            localStorage.setItem('token', response.data.token);
        }
        return response.data;
    },

    async register(data: RegisterData) {
        const response = await api.post('/register', data);
        if (response.data.token) {
            localStorage.setItem('token', response.data.token);
        }
        return response.data;
    },

    async logout() {
        await api.post('/logout');
        localStorage.removeItem('token');
    },

    getToken() {
        return localStorage.getItem('token');
    },

    isAuthenticated() {
        return !!this.getToken();
    }
}; 