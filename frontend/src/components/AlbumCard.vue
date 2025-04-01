<template>
  <div class="album-card">
    <img 
      :src="album.cover_image" 
      :alt="`${album.song_name} cover`"
      @error="handleImageError"
    >
    
    <div class="album-info">
      <h3>{{ album.song_name }}</h3>
      <p>{{ album.artist_name }}</p>
      
      <div class="votes">
        <vote-buttons
          :value="album.user_vote"
          :votes-count="album.votes_count"
          :upvotes="album.upvotes"
          :downvotes="album.downvotes"
          @upvote="$emit('vote', album.id, 1)"
          @downvote="$emit('vote', album.id, -1)"
        />
      </div>

      <button 
        v-if="isAdmin"
        class="delete-btn"
        @click="$emit('delete', album.id)"
      >
        Delete
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useAuthStore } from '@/stores/auth';
import type { Album } from '@/types';
import VoteButtons from './VoteButtons.vue';

const props = defineProps<{
  album: Album
}>();

const emit = defineEmits<{
  (e: 'vote', albumId: number, value: 1 | -1): void
  (e: 'delete', albumId: number): void
}>();

const authStore = useAuthStore();
const isAdmin = computed(() => authStore.user?.role === 'admin');

const handleImageError = (e: Event) => {
  const img = e.target as HTMLImageElement;
  img.src = '/images/placeholder.png';
};
</script>

<style lang="scss" scoped>
@use "sass:color";

.album-card {
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s;

  &:hover {
    transform: translateY(-2px);
  }

  img {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }

  .album-info {
    padding: 1rem;

    h3 {
      margin: 0;
      font-size: 1.2rem;
    }

    p {
      color: #666;
      margin: 0.5rem 0;
    }

    .votes {
      margin: 1rem 0;
    }

    .delete-btn {
      width: 100%;
      padding: 0.5rem;
      background: #dc3545;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;

      &:hover {
        background: color.adjust(#dc3545, $lightness: -5%);
      }
    }
  }
}
</style> 