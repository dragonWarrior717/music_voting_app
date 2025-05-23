<template>
  <div class="login-page">
    <form @submit.prevent="handleSubmit">
      <h2>Login</h2>
      
      <div class="form-group">
        <label for="email">Email</label>
        <input 
          type="email" 
          id="email" 
          v-model="email" 
          required
        >
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input 
          type="password" 
          id="password" 
          v-model="password" 
          required
        >
      </div>

      <button type="submit" :disabled="isLoading">
        {{ isLoading ? 'Loading...' : 'Login' }}
      </button>

      <p class="error" v-if="error">{{ error }}</p>

      <p class="register-link">
        Don't have an account? 
        <router-link to="/register">Register</router-link>
      </p>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
const email = ref('');
const password = ref('');
const error = ref('');
const isLoading = ref(false);

const handleSubmit = async () => {
  try {
    isLoading.value = true;
    error.value = '';
    await authStore.login(email.value, password.value);
  } catch (e: any) {
    error.value = e.response?.data?.message || 'An error occurred';
  } finally {
    isLoading.value = false;
  }
};
</script>

<style lang="scss" scoped>
.login-page {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: calc(100vh - 200px);

  form {
    width: 100%;
    max-width: 400px;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

    h2 {
      text-align: center;
      margin-bottom: 2rem;
    }

    .form-group {
      margin-bottom: 1rem;

      label {
        display: block;
        margin-bottom: 0.5rem;
      }

      input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 4px;
      }
    }

    button {
      width: 100%;
      padding: 0.75rem;
      background: #2c3e50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;

      &:disabled {
        opacity: 0.7;
        cursor: not-allowed;
      }
    }

    .error {
      color: red;
      margin-top: 1rem;
      text-align: center;
    }

    .register-link {
      margin-top: 1rem;
      text-align: center;

      a {
        color: #2c3e50;
      }
    }
  }
}
</style> 