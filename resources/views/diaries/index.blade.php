<!-- laout.blade.phpをテンプレートとして使う-->
<!-- @extends('layout') -->
@extends('layouts.app')
<!-- layout.blade.phpのtitleの部分-->
@section('title','一覧')


<!-- layout.blade.phpのcontentの部分　-->
@section('content')
  <!--deleteするためのフォーム webphpの部分と合わせて、routeでdestroy-->
  <a href="{{ route('diary.create') }}" class="btn btn-primary btn-block">新規投稿</a>
  @foreach($diaries as $diary)
    <div class="m-4 p-4 border border-primary">
      <p>{{$diary->title}}</p>
      <p>{{$diary->body}}</p>
      <p>{{$diary->created_at}}</p>
      @if (Auth::check() && Auth::user()->id === $diary->user_id)
      <a href="{{route('diary.edit',['id' => $diary->id] )}}" class="btn btn-success">編集</a>
      <form action="{{ route('diary.destroy' , ['id' => $diary->id] )}}" method="POST" class="d-inline">
        @csrf
        @method('delete')

      
        <button class="btn btn-danger">削除</button>
      </form>
    @endif
    </div>
  @endforeach

  @endsection

