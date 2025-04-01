import { defineStore } from 'pinia';
import { ref } from 'vue';
import type { Album, PaginatedResponse } from '@/types';
import api from '@/utils/api';

export const useAlbumStore = defineStore('album', () => {
    const albums = ref<Album[]>([]);
    const currentPage = ref(1);
    const lastPage = ref(1);
    const searchQuery = ref('');
    const isLoading = ref(false);

    const fetchAlbums = async (page: number = 1, search: string = '') => {
        isLoading.value = true;
        try {
            const response = await api.get<PaginatedResponse<Album>>('/albums', {
                params: { page, search }
            });
            albums.value = response.data.data;
            currentPage.value = response.data.meta.current_page;
            lastPage.value = response.data.meta.last_page;
        } catch (error) {
            console.error('Error fetching albums:', error);
        } finally {
            isLoading.value = false;
        }
    };

    const fetchAlbum = async (id: number) => {
        isLoading.value = true;
        try {
            const response = await api.get<Album>(`/albums/${id}`);
            return response.data;
        } catch (error) {
            console.error('Error fetching album:', error);
            throw error;
        } finally {
            isLoading.value = false;
        }
    };

    const createAlbum = async (data: Omit<Album, 'id' | 'votes_count'>) => {
        try {
            const response = await api.post<Album>('/albums', data);
            albums.value.unshift(response.data);
            return response.data;
        } catch (error) {
            console.error('Error creating album:', error);
            throw error;
        }
    };

    const updateAlbum = async (id: number, data: Partial<Album>) => {
        try {
            const response = await api.put<Album>(`/albums/${id}`, data);
            const index = albums.value.findIndex(a => a.id === id);
            if (index !== -1) {
                albums.value[index] = response.data;
            }
            return response.data;
        } catch (error) {
            console.error('Error updating album:', error);
            throw error;
        }
    };

    const vote = async (albumId: number, value: 1 | -1) => {
        try {
            const voteType = value === 1 ? 'up' : 'down';
            const response = await api.post(`/albums/${albumId}/vote`, { vote_type: voteType });
            
            const index = albums.value.findIndex(a => a.id === albumId);
            if (index !== -1) {
                albums.value[index] = {
                    ...albums.value[index],
                    votes_count: response.data.votes_count,
                    upvotes: response.data.upvotes,
                    downvotes: response.data.downvotes,
                    user_vote: response.data.user_vote
                };
            }
        } catch (error) {
            console.error('Error voting:', error);
            throw error;
        }
    };

    const deleteAlbum = async (albumId: number) => {
        try {
            await api.delete(`/albums/${albumId}`);
            albums.value = albums.value.filter(a => a.id !== albumId);
        } catch (error) {
            console.error('Error deleting album:', error);
        }
    };

    return {
        albums,
        currentPage,
        lastPage,
        searchQuery,
        isLoading,
        fetchAlbums,
        fetchAlbum,
        createAlbum,
        updateAlbum,
        vote,
        deleteAlbum
    };
}); 