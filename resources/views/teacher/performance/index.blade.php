@extends('teacher.main_layout_teacher')

@section('style', asset('profilestyling/profilestyle.css'))

@section('title')
    Teacher -
@endsection

@section('section1')

    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                <a href="/teacher_course" class="side-menu-list-item side-menu-list-item-action">Create New Course</a>
            </div>
            {{-- <div class="side-menu-list">
                <button type="button" onclick="window.location.href='/teacher_course'" class="profilebtn">Back</button>
            </div> --}}
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <section id="performance-edit"></section>
                <div class="courses-container">

                    @if ($courses->isEmpty())
                        <div style="width: 100%; height:100%; display: flex; justify-content: space-between;">
                            <div style="width: 50%; height:100%">
                                <h1>No courses for Performance!</h1>
                            </div>
                            <div style="width: 50%; height:100%; padding:0%">
                                <img style="width: 100%; height:40%"
                                    src="{{ asset('Illustrations/pageexpired.png') }}" alt="No Courses Yet">
                            </div>
                        </div>
                    @else
                        <p
                            style="font-size: 100% ; color:#041439; background-color:aliceblue; padding: 10px; border:1px solid #041439">
                            <b style="color:#041439">Note: </b>To Evalute Performance, Please select Course First!</p>
                        <form action="{{ route('performance.create', ['course_id' => ':course_id']) }}" method="get"
                            id="performance-form">
                            <div class="form-group">
                                <label for="course_id">Select Course</label>
                                <select id="course_id" name="course_id" class="form-control">
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="profilebtn">Next</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        const form = document.getElementById('performance-form');
        const courseIdSelect = document.getElementById('course_id');
        courseIdSelect.addEventListener('change', () => {
            form.action = form.action.replace(':course_id', courseIdSelect.value);
        });
    </script>
@endsection
