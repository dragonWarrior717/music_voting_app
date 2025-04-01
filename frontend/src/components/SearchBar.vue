<template>
  <div class="search-bar">
    <input
      type="text"
      :value="modelValue"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      placeholder="Search albums..."
    >
    <button @click="$emit('search')">Search</button>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  modelValue: string;
}>();

defineEmits<{
  (e: 'update:modelValue', value: string): void;
  (e: 'search'): void;
}>();
</script>

<style lang="scss" scoped>
@use "sass:color";

.search-bar {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;

  input {
    flex: 1;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    min-width: 0;
  }

  button {
    padding: 0.5rem 1rem;
    background: #2c3e50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;

    &:hover {
      background: color.adjust(#2c3e50, $lightness: -5%);
    }
  }
}
</style> 