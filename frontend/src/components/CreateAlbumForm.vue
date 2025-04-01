<template>
  <form @submit.prevent="handleSubmit" class="create-album-form">
    <div class="form-group">
      <label for="song_name">Song Name</label>
      <input
        id="song_name"
        v-model="form.song_name"
        type="text"
        required
      >
    </div>

    <div class="form-group">
      <label for="artist_name">Artist Name</label>
      <input
        id="artist_name"
        v-model="form.artist_name"
        type="text"
        required
      >
    </div>

    <div class="form-group">
      <label for="cover_image">Cover Image</label>
      <input
        id="cover_image"
        type="file"
        accept="image/*"
        @change="handleImageChange"
      >
      <img
        v-if="form.cover_image"
        :src="form.cover_image"
        alt="Album cover preview"
        class="cover-preview"
      >
    </div>

    <div class="form-actions">
      <button type="submit" :disabled="isLoading">
        {{ isLoading ? 'Creating...' : 'Create Album' }}
      </button>
      <button type="button" @click="$emit('cancel')">
        Cancel
      </button>
    </div>
  </form>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import type { Album } from '@/types';

const emit = defineEmits<{
  (e: 'submit', data: Omit<Album, 'id' | 'votes_count'>): void;
  (e: 'cancel'): void;
}>();

const isLoading = ref(false);
const form = ref({
  song_name: '',
  artist_name: '',
  cover_image: ''
});

const handleImageChange = (event: Event) => {
  const input = event.target as HTMLInputElement;
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = (e) => {
      form.value.cover_image = e.target?.result as string;
    };
    reader.readAsDataURL(input.files[0]);
  }
};

const handleSubmit = async () => {
  emit('submit', form.value);
};
</script>

<style lang="scss" scoped>
@use "sass:color";

.create-album-form {
  max-width: 500px;
  margin: 0 auto;
  padding: 2rem;
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);

  .form-group {
    margin-bottom: 1.5rem;

    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: bold;
    }

    input[type="text"] {
      width: 100%;
      padding: 0.5rem;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .cover-preview {
      max-width: 200px;
      margin-top: 1rem;
      border-radius: 4px;
    }
  }

  .form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;

    button {
      flex: 1;
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 4px;
      cursor: pointer;

      &:first-child {
        background: #2c3e50;
        color: white;

        &:hover {
          background: color.adjust(#2c3e50, $lightness: -5%);
        }

        &:disabled {
          opacity: 0.5;
          cursor: not-allowed;
        }
      }

      &:last-child {
        background: #f8f9fa;
        color: #2c3e50;

        &:hover {
          background: color.adjust(#f8f9fa, $lightness: -5%);
        }
      }
    }
  }
}
</style> 