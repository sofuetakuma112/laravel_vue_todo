@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$personName}}の投稿</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @guest
                    <p style="font-size: 2rem">{{$post->content}}</p>
                    @endguest
                    @auth
                    <p style="font-size: 2rem">{{$post->content}}</p>
                    {{-- 個コンポーネントに値を渡すときはケバブケースで書いた名前を個コンポーネントでパスカルケースで受け取る --}}
                    <div class="d-flex">
                        <like-component class="mr-3" :post-id="{{json_encode($post->id)}}"
                            :user-id="{{json_encode($userAuth->id)}}" :default-Liked="{{json_encode($defaultLiked)}}"
                            :default-Count="{{json_encode($defaultCount)}}">
                        </like-component>
                        @if ($userAuth->id == $post->user_id)
                        <form action="" method="post" class="mr-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <form action="{{url('posts/' . $post->id . '/edit')}}" method="get">
                            @csrf
                            {{-- <input type="hidden" value="{{$userAuth->id}}" name="id"> --}}
                            <button type="submit" class="btn btn-success">編集</button>
                        </form>
                        @endif
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection