<template>
  <div class="layout">
    <header v-if="authStore.token">
      <nav>
        <h1>Music Taste App</h1>
        <div class="user-menu">
          <span>{{ authStore.user?.name }}</span>
          <button @click="authStore.logout">Logout</button>
        </div>
      </nav>
    </header>

    <main>
      <slot></slot>
    </main>
  </div>
</template>

<script setup lang="ts">
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
</script>

<style lang="scss" scoped>
.layout {
  min-height: 100vh;
  
  header {
    background: #2c3e50;
    color: white;
    padding: 1rem;

    nav {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;

      .user-menu {
        display: flex;
        gap: 1rem;
        align-items: center;

        button {
          padding: 0.5rem 1rem;
          border: 1px solid white;
          background: transparent;
          color: white;
          cursor: pointer;
          border-radius: 4px;

          &:hover {
            background: rgba(255, 255, 255, 0.1);
          }
        }
      }
    }
  }

  main {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
  }
}
</style> 