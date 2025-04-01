<?php

namespace App\Docs;

/**
 * @OA\Tag(
 *     name="Albums",
 *     description="API Endpoints for album management"
 * )
 */
class AlbumDoc
{
    /**
     * @OA\Get(
     *     path="/api/albums",
     *     summary="Get list of albums with pagination and search",
     *     tags={"Albums"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term for song name or artist name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of albums retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Album")),
     *             @OA\Property(property="total", type="integer", example=10),
     *             @OA\Property(property="per_page", type="integer", example=10)
     *         )
     *     )
     * )
     */
    public function index() {}

    /**
     * @OA\Post(
     *     path="/api/albums",
     *     summary="Create a new album",
     *     tags={"Albums"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"song_name","artist_name"},
     *             @OA\Property(property="song_name", type="string", example="Bohemian Rhapsody"),
     *             @OA\Property(property="artist_name", type="string", example="Queen"),
     *             @OA\Property(property="cover_image", type="string", format="binary", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Album created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Album")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         ref="#/components/schemas/ErrorResponse"
     *     )
     * )
     */
    public function store() {}

    /**
     * @OA\Get(
     *     path="/api/albums/{album}",
     *     summary="Get album details",
     *     tags={"Albums"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="album",
     *         in="path",
     *         required=true,
     *         description="Album ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Album details retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Album")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Album not found",
     *         ref="#/components/schemas/ErrorResponse"
     *     )
     * )
     */
    public function show() {}

    /**
     * @OA\Put(
     *     path="/api/albums/{album}",
     *     summary="Update album details",
     *     tags={"Albums"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="album",
     *         in="path",
     *         required=true,
     *         description="Album ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="song_name", type="string", example="Bohemian Rhapsody"),
     *             @OA\Property(property="artist_name", type="string", example="Queen"),
     *             @OA\Property(property="cover_image", type="string", format="binary", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Album updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Album")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Album not found",
     *         ref="#/components/schemas/ErrorResponse"
     *     )
     * )
     */
    public function update() {}

    /**
     * @OA\Delete(
     *     path="/api/albums/{album}",
     *     summary="Delete an album (Admin only)",
     *     tags={"Albums"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="album",
     *         in="path",
     *         required=true,
     *         description="Album ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Album deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized. Admin access required.",
     *         ref="#/components/schemas/ErrorResponse"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Album not found",
     *         ref="#/components/schemas/ErrorResponse"
     *     )
     * )
     */
    public function destroy() {}

    /**
     * @OA\Post(
     *     path="/api/albums/{album}/vote",
     *     summary="Vote on an album",
     *     tags={"Albums"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="album",
     *         in="path",
     *         required=true,
     *         description="Album ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"vote_type"},
     *             @OA\Property(property="vote_type", type="string", enum={"up", "down"}, example="up")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Vote recorded successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Vote recorded successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid vote type",
     *         ref="#/components/schemas/ErrorResponse"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Album not found",
     *         ref="#/components/schemas/ErrorResponse"
     *     )
     * )
     */
    public function vote() {}
} 