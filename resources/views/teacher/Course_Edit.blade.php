@extends('teacher.main_layout_teacher')

@section('style', asset('profilestyling/profilestyle.css'))

@section('title')
    Teacher - Edit Course
@endsection

@section('section1')

    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                <div class="profile-page-part1">
                    <div class="side-menu-list">
                        <button type="button" onclick="window.location.href='{{ route('courses.index1') }}'"
                            class="profilebtn">Back</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <section id="Edit-courses">
                    <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ $course->title }}" placeholder="Enter Course Title" required>
                        </div>
                        <div class="form-group">
                            <label for="overview">Overview</label>
                            <textarea class="form-control" id="overview" name="overview" rows="5" placeholder="Describe Course Goals and What's this course is about." required>{{ $course->overview }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ $course->start_date }}" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ $course->end_date }}" required>
                        </div>
                        <div class="form-group">
                            <label for="resources">Resource Link</label>
                            <textarea class="form-control" id="resources" name="resources" rows="5" placeholder="https://www.studysphere.com/" >{{ $course->resources }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="banner_image">Banner Image</label>
                            <input type="file" class="form-control-file" id="banner_image" name="banner_image"
                                accept="image/*">
                            @if ($course->banner_image)
                                <img src="{{ asset('images/' . $course->banner_image) }}" alt="Banner Image" width="100">
                            @endif
                        </div>
                        <button type="submit" class="profilebtn">Update Course</button>
                        {{-- <button type="submit" class="profilebtn" onclick="confirmUpdate()">Update Course</button> --}}
                        {{-- <a href="{{ route('courses.index1') }}" class="profilebtn">Cancel</a> --}}
                        <button type="button" onclick="window.location.href='/courses'" class="profilebtn">Cancel</button>
                    </form>
                </section>

            </div>
        </div>
    </div>

    {{-- <script>
        function confirmUpdate() {
            if (confirm('Are you sure you want to update this course?')) {
                document.getElementById('update-course-form').submit();
            }
        }
    </script> --}}
@endsection
