@extends('student.main_layout_student')
@section('style', asset('profilestyling/profilestyle.css'))

{{-- @section('css')
    <link rel="stylesheet" href="{{ asset('studentdashboard.css') }}">
@endsection --}}

@section('title')
    Student - {{ $post->title }} -
@endsection

@section('section1')

    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                {{-- <a href="{{ route('post.create') }}" class="side-menu-list-item side-menu-list-item-action">Create New --}}
                {{-- Discussion</a> --}}
                <button type="button" onclick="window.location.href='/student_discussionboard'"
                    class="profilebtn">Back</button>
            </div>
        </div>

        <div class="profile-page-part2">
            <div class="profile-display">
                <div class="discussion-board-display">
                    <div class="discussion-board-display-banner">
                        <h1>{{ $post->title }}</h1>
                        <p>By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="discussion-board-body">
                        <div class="d-description">
                            <p class="description-text">{{ $post->content }}</p>
                        </div>
                        <div class="d-image">
                            @if ($post->banner_image)
                                <img src="{{ Storage::url($post->banner_image) }}" class="card-img-top" alt="Banner Image">
                            @endif
                        </div>
                    </div>
                    <div class="commentsection">
                        <h2>All Comments</h2>
                        <section id="Edit-courses">
                            <form action="{{ route('student.comment', ['postId' => $post->id]) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <textarea name="comment" rows="3" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" style="background-color: #ddddf4; border:1px solid black; color:rgb(36, 43, 92); border-radius: 0%">Add Comment</button>
                            </form>
                        </section>
                        @include('partials.comments', ['comments' => $post->comments])
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
