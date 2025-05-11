<?php

namespace App\Http\Controllers\API\V1;

use PgSql\Lob;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use App\Http\Requests\PostUpdateRequest;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $posts = Post::all();
            if (!$posts) {
                return response()->json([
                    'message' => 'Not found',
                    'status' => 404
                ]);
            }

            return response()->json(new PostCollection($posts));
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => "An Error occurred",
                'status' => 500,

            ], 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {

        try {

            $validated = $request->validated();
            //dd($validation->getData());
            $post =  Post::create([

                'title' => $request->title,
                'body' => $request->body,
                "created_at" => now(),
                'updated_at' => now(),
            ]);
            return response()->json([
                'data' => new PostResource($post),
                'message' => 'successful',
                'status' => '201',
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => "An Error occurred",
                'status' => 500,

            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            $post = Post::find($id);
            if (!$post) {
                return response()->json([
                    'message' => 'Post not found',
                    'status' => 404,
                ], 404);
            }
            return response()->json(
                [
                    'data' =>  new PostResource($post),
                    'message' => 'post found',
                    'status' => 200
                ],
                200

            );
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => "An Error occurred",
                'status' => 500,

            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, string $id)
    {
        try {

            $post  = Post::find($id);

            if (!$post) {
                return response()->json([
                    'message' => 'Post not found',
                    'status' => 404
                ]);
            }
            $validated = $request->validated();
            $post->update([
                'title' => $request->title,
                'body'  => $request->body,
                'updated_at' => now(),
            ]);
            return response()->json([
                'data' => new PostResource($post),
                'message' => 'Post Updated successfully',
                'status' => 200,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => "An Error occurred",
                'status' => 500,

            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $post = Post::find($id);
            if (!$post) {
                return response()->json([
                    'message' => 'Post not found',
                    'status' => 404,
                ], 404);
            }
            $post->delete();
            return response()->json([
                'message' => 'Post deleted successfully',
                'status' => 200,
            ], 200);
        } catch (\Throwable  $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => "An Error occurred",
                'status' => 500,

            ], 500);
        }
    }
}
