@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif

          <form action="{{url('posts/' . $post->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="exampleFormControlTextarea1">タスク内容</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                name="content">{{$post->content}}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection