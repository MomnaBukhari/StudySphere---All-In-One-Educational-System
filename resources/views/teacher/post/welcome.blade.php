@extends('teacher.main_layout_teacher')

@section('style', asset('profilestyling/profilestyle.css'))


@section('css')
@endsection


@section('title')
Teacher -
@endsection


@section('content')
<div class="container">
    <h1>All Discussion Topics</h1>

    @foreach ($posts as $post)
    <div class="card mb-3">
        <div class="card-body">
            <h2 class="card-title"><a href="{{ route('post.view', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
            </h2>
            <p class="card-text">By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</p>
        </div>
        @if($post->banner_image)
        <img src="{{ Storage::url($post->banner_image) }}" class="card-img-top" alt="Banner Image">
        @endif
    </div>
    @endforeach

    {{ $posts->links() }}
</div>
@endsection