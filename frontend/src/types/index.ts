export interface User {
    id: number;
    name: string;
    email: string;
    role: 'user' | 'admin';
}

export interface Album {
    id: number;
    song_name: string;
    artist_name: string;
    cover_image: string;
    votes_count: number;
    upvotes: number;
    downvotes: number;
    user_vote?: -1 | 1 | null;
}

export interface PaginatedResponse<T> {
    data: T[];
    meta: {
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
} 