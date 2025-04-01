<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'song_name',
        'artist_name',
        'cover_image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_votes' => 'integer',
    ];

    /**
     * Get the votes for the album
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Get the total votes count (upvotes - downvotes)
     */
    public function calculateTotalVotes(): int
    {
        return $this->votes()
            ->where('vote_type', 'upvote')
            ->count() - 
            $this->votes()
            ->where('vote_type', 'downvote')
            ->count();
    }
}
