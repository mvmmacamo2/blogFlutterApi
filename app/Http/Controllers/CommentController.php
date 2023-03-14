<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($id)
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

        return response([
            'data' => $post->comments()->with('user:id,name,image')->get()
        ]);
    }

    public function store(Request $request, $id)
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
            'comment' => 'required|string'
        ]);

        Comment::create([
            'comment' => $values['comment'],
            'user_id' => auth()->user()->id,
            'post_id' => $post->id
        ]);

        return response([
            'message' => 'Comment added',
//            'post' => $post->comments()->with('user:id, name, image')->get()
        ]);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response([
                'message' => 'comment no found'
            ], 403);
        }

        if ($comment->user_id != auth()->user()->id) {
            return response([
                'message' => 'Cannot update'
            ], 403);
        }

        $values = $this->validate($request, [
            'comment' => 'required|string'
        ]);

        $comment->update([
            'comment' => $values['comment'],
        ]);

        return response([
            'message' => 'Comment updated',
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response([
                'message' => 'comment no found'
            ], 403);
        }

        if ($comment->user_id != auth()->user()->id) {
            return response([
                'message' => 'Permission denied'
            ], 403);
        }

        $comment->delete();

        return response([
            'message' => 'Comment deleted',
        ]);
    }
}
