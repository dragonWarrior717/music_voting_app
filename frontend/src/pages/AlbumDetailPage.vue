<template>
  <div class="album-detail-page">
    <loading-spinner v-if="isLoading" />
    
    <template v-else-if="album">
      <div class="album-header">
        <img 
          :src="album.cover_image" 
          :alt="`${album.song_name} cover`"
          class="album-cover"
        >
        
        <div class="album-info">
          <h1>{{ album.song_name }}</h1>
          <p class="artist">{{ album.artist_name }}</p>
          
          <div class="votes">
            <vote-buttons
              :value="album.user_vote"
              :votes-count="album.votes_count"
              @upvote="handleVote(1)"
              @downvote="handleVote(-1)"
            />
          </div>

          <div class="actions" v-if="isAdmin">
            <button @click="showEditForm = true" class="edit-btn">
              Edit Album
            </button>
            <button @click="handleDelete" class="delete-btn">
              Delete Album
            </button>
          </div>
        </div>
      </div>

      <edit-album-form
        v-if="showEditForm"
        :album="album"
        @submit="handleUpdate"
        @cancel="showEditForm = false"
      />
    </template>

    <div v-else class="error">
      Album not found
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAlbumStore } from '@/stores/album';
import { useAuthStore } from '@/stores/auth';
import type { Album } from '@/types';
import LoadingSpinner from '@/components/LoadingSpinner.vue';
import VoteButtons from '@/components/VoteButtons.vue';
import EditAlbumForm from '@/components/EditAlbumForm.vue';

const route = useRoute();
const router = useRouter();
const albumStore = useAlbumStore();
const authStore = useAuthStore();

const album = ref<Album | null>(null);
const isLoading = ref(true);
const showEditForm = ref(false);

const isAdmin = computed(() => authStore.user?.role === 'admin');

const fetchAlbum = async () => {
  try {
    const id = parseInt(route.params.id as string);
    album.value = await albumStore.fetchAlbum(id);
  } catch (error) {
    console.error('Error fetching album:', error);
  } finally {
    isLoading.value = false;
  }
};

const handleVote = async (value: 1 | -1) => {
  if (!album.value) return;
  await albumStore.vote(album.value.id, value);
  await fetchAlbum(); // Refresh album data
};

const handleUpdate = async (data: Partial<Album>) => {
  if (!album.value) return;
  try {
    await albumStore.updateAlbum(album.value.id, data);
    showEditForm.value = false;
    await fetchAlbum(); // Refresh album data
  } catch (error) {
    console.error('Error updating album:', error);
  }
};

const handleDelete = async () => {
  if (!album.value) return;
  if (confirm('Are you sure you want to delete this album?')) {
    try {
      await albumStore.deleteAlbum(album.value.id);
      router.push('/albums');
    } catch (error) {
      console.error('Error deleting album:', error);
    }
  }
};

onMounted(fetchAlbum);
</script>

<style lang="scss" scoped>
.album-detail-page {
  max-width: 800px;
  margin: 0 auto;
  padding: 2rem;

  .album-header {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);

    .album-cover {
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 8px;
    }

    .album-info {
      h1 {
        margin: 0;
        font-size: 2rem;
      }

      .artist {
        color: #666;
        font-size: 1.2rem;
        margin: 0.5rem 0;
      }

      .votes {
        margin: 1.5rem 0;
      }

      .actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;

        button {
          flex: 1;
          padding: 0.5rem 1rem;
          border: none;
          border-radius: 4px;
          cursor: pointer;

          &.edit-btn {
            background: #2c3e50;
            color: white;

            &:hover {
              background: darken(#2c3e50, 5%);
            }
          }

          &.delete-btn {
            background: #dc3545;
            color: white;

            &:hover {
              background: darken(#dc3545, 5%);
            }
          }
        }
      }
    }
  }

  .error {
    text-align: center;
    color: #dc3545;
    font-size: 1.2rem;
    padding: 2rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
}

@media (max-width: 768px) {
  .album-detail-page {
    .album-header {
      grid-template-columns: 1fr;
      text-align: center;

      .album-cover {
        max-width: 300px;
        margin: 0 auto;
      }
    }
  }
}
</style> 