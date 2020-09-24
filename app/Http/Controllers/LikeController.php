<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;

class LikeController extends Controller
{
    public function like(Post $post, Request $request) {
        $like = Like::create(['user_id' => $request->user_id, 'post_id' => $post->id]);

        if (Like::where('post_id', $post->id)->get()) {
            $likeCount = count(Like::where('post_id', $post->id)->get());
        } else {
            $likeCount = 0;
        }

        return response()->json(['likeCount' => $likeCount]);
    }

    public function unlike(Post $post, Request $request) {
        $like = Like::where('user_id', $request->user_id)->where('post_id', $post->id)->first();
        $like->delete();

        if (Like::where('post_id', $post->id)->get()) {
            $likeCount = count(Like::where('post_id', $post->id)->get());
        } else {
            $likeCount = 0;
        }

        return response()->json(['likeCount' => $likeCount]);
    }
}
