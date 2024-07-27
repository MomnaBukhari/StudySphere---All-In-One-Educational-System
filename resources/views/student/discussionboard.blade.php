@extends('student.main_layout_student')

@section('style', asset('profilestyling/profilestyle.css'))

@section('css')
@endsection

@section('title')
    Student -
@endsection



@section('section1')

    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                {{-- <a href="{{ route('teacher.post.create') }}" class="side-menu-list-item side-menu-list-item-action">Create New --}}
                {{-- Discussion</a> --}}

                {{-- <button type="button" onclick="window.location.href='/post/create'" class="profilebtn">Create New Discussion</button> --}}
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                {{-- <div class="courses-container"> --}}
                @if ($posts->isEmpty())
                    <div style="width: 100%; height:100%; display: flex; justify-content: space-between;">
                        <div style="width: 40%; height:100%">
                            <h3>No discussion board created Yet!</h3>
                        </div>
                        <div style="width: 50%; height:100%; padding:0">
                            <img style="height:500px" src="{{ asset('Illustrations/NoCourseUploadedYet.png') }}"
                                alt="No Courses Yet">
                        </div>
                    </div>
                @else
                    @foreach ($posts as $post)
                        <div class="discussion-board-inside-box">
                            <div class="board-part1">
                                <div class="board-part1-1">
                                    <h2 class="card-title">
                                        <a
                                            href="{{ route('post.display', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                                    </h2>
                                </div>

                                <div class="board-part2">
                                    <p class="card-text">By {{ $post->user->name }} on
                                        {{ $post->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                            {{-- @if ($post->banner_image)
                                    <img src="{{ Storage::url($post->banner_image) }}" class="card-img-top"
                                        alt="Banner Image">
                                @endif --}}
                        </div>
                    @endforeach

                    {{ $posts->links() }}

                @endif
            </div>
        </div>
    </div>
    </div>
@endsection
