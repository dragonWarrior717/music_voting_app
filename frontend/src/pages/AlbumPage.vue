<template>
  <div class="album-page">
    <div class="page-header">
      <search-bar 
        v-model="albumStore.searchQuery"
        @search="handleSearch"
      />
      <button 
        v-if="isAdmin"
        class="create-btn"
        @click="showCreateForm = true"
      >
        Create Album
      </button>
    </div>

    <div class="albums-container">
      <loading-spinner v-if="albumStore.isLoading" />
      
      <template v-else>
        <album-card
          v-for="album in albumStore.albums"
          :key="album.id"
          :album="album"
          @vote="handleVote"
          @delete="handleDelete"
        />
      </template>
    </div>

    <pagination
      :current-page="albumStore.currentPage"
      :last-page="albumStore.lastPage"
      @page-change="handlePageChange"
    />

    <create-album-form
      v-if="showCreateForm"
      @submit="handleCreate"
      @cancel="showCreateForm = false"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { useAlbumStore } from '@/stores/album';
import { useAuthStore } from '@/stores/auth';
import type { Album } from '@/types';
import SearchBar from '@/components/SearchBar.vue';
import AlbumCard from '@/components/AlbumCard.vue';
import Pagination from '@/components/Pagination.vue';
import LoadingSpinner from '@/components/LoadingSpinner.vue';
import CreateAlbumForm from '@/components/CreateAlbumForm.vue';

const albumStore = useAlbumStore();
const authStore = useAuthStore();
const showCreateForm = ref(false);

const isAdmin = computed(() => authStore.user?.role === 'admin');

const handleSearch = () => {
  albumStore.fetchAlbums(1, albumStore.searchQuery);
};

const handlePageChange = (page: number) => {
  albumStore.fetchAlbums(page, albumStore.searchQuery);
};

const handleVote = (albumId: number, value: 1 | -1) => {
  albumStore.vote(albumId, value);
};

const handleDelete = (albumId: number) => {
  if (confirm('Are you sure you want to delete this album?')) {
    albumStore.deleteAlbum(albumId);
  }
};

const handleCreate = async (data: Omit<Album, 'id' | 'votes_count'>) => {
  try {
    await albumStore.createAlbum(data);
    showCreateForm.value = false;
  } catch (error) {
    console.error('Error creating album:', error);
  }
};

onMounted(() => {
  albumStore.fetchAlbums();
});
</script>

<style lang="scss" scoped>
@use "sass:color";

.album-page {
  .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;

    .create-btn {
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

  .albums-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
    margin: 2rem 0;
  }
}

@media (max-width: 768px) {
  .album-page {
    .page-header {
      flex-direction: column;
      gap: 1rem;
      align-items: stretch;
    }
  }
}
</style> 