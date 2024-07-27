@extends('teacher.main_layout_teacher')
@section('style', asset('profilestyling/profilestyle.css'))
@section('css')
@endsection
@section('title')
    Teacher -
@endsection

@section('section1')

    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                {{-- <a href="{{ route('post.create') }}" class="side-menu-list-item side-menu-list-item-action">Create New --}}
                {{-- Discussion</a> --}}
                <button type="button" onclick="window.location.href='/discussionboard'" class="profilebtn">Back</button>
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <section id="Edit-courses">
                <form action="{{ route('post.update', ['id' => $post->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" value="{{ $post->title }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" class="form-control" id="content" rows="5" required>{{ $post->content }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="banner_image">Banner Image</label>
                        <input type="file" name="banner_image" class="form-control-file" id="banner_image">
                        @if ($post->banner_image)
                            <img src="{{ Storage::url($post->banner_image) }}" class="img-thumbnail mt-3"
                                alt="Banner Image" style="height: 100px">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary" style="background-color: #ddddf4; border:1px solid black; color:rgb(36, 43, 92); border-radius: 0%">Update Post</button>
                </form>
            </section>
            </div>
        </div>
    </div>
@endsection
