<template>
  <div class="pagination">
    <button 
      :disabled="currentPage === 1"
      @click="$emit('page-change', currentPage - 1)"
    >
      Previous
    </button>

    <span>Page {{ currentPage }} of {{ lastPage }}</span>

    <button 
      :disabled="currentPage === lastPage"
      @click="$emit('page-change', currentPage + 1)"
    >
      Next
    </button>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  currentPage: number;
  lastPage: number;
}>();

defineEmits<{
  (e: 'page-change', page: number): void;
}>();
</script>

<style lang="scss" scoped>
@use "sass:color";

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 1rem;
  margin-top: 2rem;

  button {
    padding: 0.5rem 1rem;
    background: #2c3e50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;

    &:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    &:not(:disabled):hover {
      background: color.adjust(#2c3e50, $lightness: -5%);
    }
  }
}
</style> 