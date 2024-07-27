@extends('teacher.main_layout_teacher')

@section('style', asset('profilestyling/profilestyle.css'))

@section('title')
    Teacher -
@endsection

@section('section1')

    <div class="profile-page">
        <div class="profile-page-part1">
            {{-- <div class="side-menu-list">
                <a href="/teacher_course" class="side-menu-list-item side-menu-list-item-action">Create New Course</a>
            </div> --}}
            <div class="side-menu-list">
                <button type="button" onclick="window.location.href='/teacher_course'" class="profilebtn">Back</button>
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <div class="container">
                    <h2>Performance - {{ $course->name }}</h2>
                    <!-- Form to fetch students with uploaded answers -->
                    <form id="studentsForm" method="POST" action="{{ route('performance.uploadedStudents') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <div class="form-group">
                            <label for="assessment_id">Select Assessment</label>
                            <select id="assessment_id" name="assessment_id" class="form-control">
                                @foreach($assessments as $assessment)
                                    <option value="{{ $assessment->id }}">{{ $assessment->id }} - {{ $assessment->instructions }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-secondary">Fetch Students with Answer Files</button>
                    </form>

                    @isset($students)
                        <!-- List of students with uploaded answers (Initially Hidden) -->
                        <div id="studentsList" style="margin-top: 20px; display: none;">
                            <h3>Students with Uploaded Answers</h3>
                            <ul id="studentsAnswerFiles" class="list-group">
                                @foreach($students as $student)
                                    <li class="list-group-item" data-student-id="{{ $student->id }}">
                                        <strong>{{ $student->name }}</strong> -
                                        <a href="{{ asset($student->answer_file) }}" target="_blank">View Answer File</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        hellhello
                        <!-- Form to upload marks and remarks -->
                        @include('teacher.performance.performance_form')
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endsection
