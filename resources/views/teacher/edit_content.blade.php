@extends('teacher.main_layout_teacher')
@section('style', asset('profilestyling/profilestyle.css'))


@section('title')
    Teacher - Edit Content
@endsection


@section('section1')

    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                <div class="profile-page-part1">
                    <div class="side-menu-list">
                        <button type="button" onclick="window.location.href='{{ route('contents.index') }}'"
                            class="profilebtn">Back</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <section id="Edit_content">
                    <form action="{{ route('contents.update', $content->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $content->title }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="description">description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required>{{ $content->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="file_path">File Path</label>
                            <input type="file" class="form-control-file" id="file_path" name="file_path" required>
                        </div>
                        @if ($errors->has('file_path'))
                            <div class="error_display">{{ $errors->first('file_path') }}</div>
                        @endif

                        <div class="form-group">
                            <label for="content_type">Content Type</label>
                            <select class="form-control" id="content_type" name="content_type" value="{{ $content->content_type }}"
                                required>
                                <option value="document">Document</option>
                                <option value="video">Video</option>
                                <option value="audio">Audio</option>
                                <!-- Add other content types as needed -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course_id">Course ID</label>
                            <input type="number" class="form-control" id="course_id" name="course_id" value="{{ $content->course_id }}"
                                required>
                        </div>
                        @if ($errors->has('course_id'))
                            <div class="error_display">{{ $errors->first('course_id') }}</div>
                        @endif
                        <button type="submit" class="profilebtn">Update content</button>
                        <button type="button" onclick="window.location.href = '{{ route('contents.index') }}'" class="profilebtn">Cancel</button>

                    </form>
                </section>
            </div>
        </div>
    </div>

@endsection
