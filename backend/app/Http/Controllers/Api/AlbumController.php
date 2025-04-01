<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Album\StoreAlbumRequest;
use App\Http\Requests\Album\UpdateAlbumRequest;
use App\Models\Album;
use App\Models\Vote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    /**
     * Display a listing of albums with pagination and search
     */
    public function index(Request $request): JsonResponse
    {
        $user = auth()->user();
        
        $query = Album::withCount([
            'votes as upvotes' => function ($query) {
                $query->where('vote_type', 'up');
            }, 
            'votes as downvotes' => function ($query) {
                $query->where('vote_type', 'down');
            }
        ])->with(['votes' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }]);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('song_name', 'like', "%{$search}%")
                  ->orWhere('artist_name', 'like', "%{$search}%");
            });
        }

        // Calculate total votes and sort
        $query->orderByRaw('(upvotes - downvotes) DESC, song_name ASC');

        // Paginate results
        $albums = $query->paginate(10);

        // Transform the response to include vote counts and user's vote
        $albums->through(function ($album) {
            $album->votes_count = $album->upvotes - $album->downvotes;
            $userVote = $album->votes->first();
            $album->user_vote = $userVote ? ($userVote->vote_type === 'up' ? 1 : -1) : null;
            unset($album->votes); // Remove the votes relationship from response
            return $album;
        });

        return response()->json($albums);
    }

    /**
     * Store a newly created album
     */
    public function store(StoreAlbumRequest $request): JsonResponse
    {
        $album = new Album($request->validated());

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('album-covers', 'public');
            $album->cover_image = $path;
        }

        $album->save();

        return response()->json($album, 201);
    }

    /**
     * Display the specified album
     */
    public function show(Album $album): JsonResponse
    {
        $album->loadCount(['votes as upvotes' => function ($query) {
            $query->where('vote_type', 'up');
        }, 'votes as downvotes' => function ($query) {
            $query->where('vote_type', 'down');
        }]);

        return response()->json($album);
    }

    /**
     * Update the specified album
     */
    public function update(UpdateAlbumRequest $request, Album $album): JsonResponse
    {
        $album->fill($request->validated());

        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($album->cover_image) {
                Storage::disk('public')->delete($album->cover_image);
            }
            $path = $request->file('cover_image')->store('album-covers', 'public');
            $album->cover_image = $path;
        }

        $album->save();

        return response()->json($album);
    }

    /**
     * Remove the specified album
     */
    public function destroy(Album $album): JsonResponse
    {
        // Delete cover image if exists
        if ($album->cover_image) {
            Storage::disk('public')->delete($album->cover_image);
        }

        $album->delete();

        return response()->json(null, 204);
    }

    /**
     * Vote on an album
     */
    public function vote(Request $request, Album $album): JsonResponse
    {
        $user = auth()->user();
        $voteType = $request->vote_type;

        if (!in_array($voteType, ['up', 'down'])) {
            return response()->json(['message' => 'Invalid vote type'], 400);
        }

        // Update or create vote
        Vote::updateOrCreate(
            [
                'user_id' => $user->id,
                'album_id' => $album->id,
            ],
            ['vote_type' => $voteType]
        );

        // Get updated vote counts
        $album->loadCount([
            'votes as upvotes' => function ($query) {
                $query->where('vote_type', 'up');
            }, 
            'votes as downvotes' => function ($query) {
                $query->where('vote_type', 'down');
            }
        ]);

        return response()->json([
            'message' => 'Vote recorded successfully',
            'votes_count' => $album->upvotes - $album->downvotes,
            'upvotes' => $album->upvotes,
            'downvotes' => $album->downvotes,
            'user_vote' => $voteType === 'up' ? 1 : -1
        ]);
    }
}
