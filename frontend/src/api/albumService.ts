import api from './config';

interface Album {
    id: number;
    title: string;
    artist: string;
    votes_count?: number;
}

export const albumService = {
    async getAlbums() {
        const response = await api.get('/albums');
        return response.data;
    },

    async createAlbum(data: Omit<Album, 'id' | 'votes_count'>) {
        const response = await api.post('/albums', data);
        return response.data;
    },

    async deleteAlbum(id: number) {
        const response = await api.delete(`/albums/${id}`);
        return response.data;
    },

    async voteForAlbum(id: number) {
        const response = await api.post(`/albums/${id}/vote`);
        return response.data;
    }
}; 