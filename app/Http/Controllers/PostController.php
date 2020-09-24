<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post;

        $post->content = $request->content;
        $post->user_id = \Auth::user()->id;

        $post->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 引数にPostクラスを設定することで渡されるidに合致したレコードを持ったpostインスタンスを自動的にセットする
    public function show(Post $post)
    {
        $userAuth = \Auth::user();
        
        $post->load('likes');

        $personName = User::find($post->user_id)->name;

        $defaultCount = count($post->likes);
        // 現在のアカウントで既にいいねを押していたらデータが返ってくる
        // $post-likes リンクで指定したpost_idと紐付いたlikeのみ取ってくる
        if ($userAuth) {
            $defaultLiked = $post->likes->where('user_id', $userAuth->id)->first();
        } else {
            $defaultLiked = "";
        }
        if (!$defaultLiked) { // $defaultLikedがnullだったら
            $defaultLiked == false;
        } else {
            $defaultLiked == true;
        }

        return view('posts.show', [
            'post' => $post,
            'userAuth' => $userAuth, // null(guestの場合)
            'defaultLiked' => $defaultLiked, // false(guestの場合)
            'defaultCount' => $defaultCount, // なんかしらの値(guestの場合)
            'personName' => $personName
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd(Post::find($id));

        $post = Post::find($id);
 
        if (\Auth::user()->id != $post->user_id) {
            return redirect(route('posts.index'))->with('error', '許可されていない操作です');
        }
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->content = $request->content;
        $post->save();
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/');
    }
}
