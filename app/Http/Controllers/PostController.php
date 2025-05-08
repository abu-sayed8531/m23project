<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();

        return response()->json([[
            'data' => $posts,
        ]]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => "required|min:3|string|unique:posts,title",
            'body' => 'required|min:5',
        ]);
        if ($validation->fails()) {
            return $validation->errors();
        }
        //dd($validation->getData());
        $post =  Post::create($validation->getData());
        return response()->json([
            'data' => $post,
            'message' => 'successful',
            'status' => '200',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
