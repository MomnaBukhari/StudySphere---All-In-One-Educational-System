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
                @if ($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <section id="Edit-courses">
                <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title:</label><br>
                        <input class="form-control" type="text" id="title" name="title" value="{{ old('title') }}"><br>
                    </div>
                    <div class="form-group">
                        <label for="content">Content:</label><br>
                        <textarea class="form-control" id="content" name="content" rows="4" cols="50">{{ old('content') }}</textarea><br>
                    </div>
                    <div class="form-group">
                        <label for="banner_image">Banner Image:</label><br>
                        <input class="form-control-file" type="file" id="banner_image" name="banner_image"><br><br>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="profilebtn">Create Discussion Board</button>
                    </div>
                </form>
                </section>
            </div>
        </div>
    </div>


@endsection
