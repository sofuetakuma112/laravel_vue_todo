@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        @if (session('error'))
        <div class="card-body">
          <p class="text-danger" style="margin: 0">
            {{ session('error') }}
          </p>
        </div>
        @endif

        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <ul class="list-group">
            <li class="list-group-item active">タスク</li>
          </ul>
          <ul class="list-group">
            @foreach ($posts as $post)
            <a href="{{route('posts.show', $post->id)}}" style="color: #333">
              <li class="list-group-item">{{$post->content}}</li>
            </a>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection