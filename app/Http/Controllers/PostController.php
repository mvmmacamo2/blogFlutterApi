<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Post::orderBy('created_at', 'desc')
                ->with('user:id,name,image')
                ->withCount('comments', 'likes')
                ->with('likes', function ($like) {
                    return $like->where('user_id', auth()->user()->id)
                        ->select('id', 'user_id', 'post_id')->get();
                })
                ->get()
        ]);
    }

    public function show($id)
    {
        return response([
            'posts' => Post::where('id', $id)
                ->with('user:id,name,image')
                ->withCount('comments', 'likes')
                ->get()
        ]);
    }

    public function edit()
    {

    }

    public function store(Request $request)
    {
        $values = $this->validate($request, [
            'body' => 'required|string'
        ]);

        $image = $this->saveImage($request->image, 'posts');

        $post = Post::create([
            'body' => $values['body'],
            'user_id' => auth()->user()->id,
            'image' => $image
        ]);

        return response([
            'message' => 'Post created',
            'post' => $post
        ], 200);
    }

    public function update(Request $request, $id)
    {

        $post = Post::find($id);

        if (!$post) {
            return response([
                'message' => 'Post no found'
            ], 403);
        }

        if ($post->user_id != auth()->user()->id) {
            return response([
                'message' => 'Cannot update'
            ], 403);
        }

        $values = $this->validate($request, [
            'body' => 'required|string'
        ]);
        $post->update([
            'body' => $values['body']
        ]);

        return response([
            'message' => 'Post updated',
            'post' => $post
        ]);

    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response([
                'message' => 'Post no found'
            ], 403);
        }

        if ($post->user_id != auth()->user()->id) {
            return response([
                'message' => 'Cannot delete'
            ], 403);
        }

        $post->comments()->delete();
        $post->likes()->delete();
        $post->delete();


        return response([
            'message' => 'Post deleted'
        ]);
    }
}
