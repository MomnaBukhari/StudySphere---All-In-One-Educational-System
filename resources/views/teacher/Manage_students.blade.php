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
            {{-- Add any side menu or navigation elements if needed --}}
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <div class="courses-container">
                    @if (count($students) > 0)
                        @foreach ($students->unique('id') as $student)
                            <div class="profile-box">
                                <div class="profile-header">
                                    <div class="profile-picture">
                                        {{-- <img src="{{ $student->profile_picture }}" alt="Profile Picture"> --}}
                                        <img src="{{ asset('defaultprofilepicture.jpg') }}" alt="Profile Picture">
                                    </div>
                                    <div class="profile-info">
                                        <h3>{{ $student->name }}</h3>
                                        <p>Student ID: {{ $student->id }}</p>
                                        <p>Email:
                                            @if ($student->email)
                                                <a href="mailto:{{ $student->email }}">{{ $student->email }}</a>
                                            @else
                                                Not Set Yet
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="profile-details">
                                    <p><strong>Contact Number:</strong> {{ $student->contact_number ?: 'Not Set Yet' }}</p>
                                    <div class="courses">
                                        <p><strong>Course Title(s):</strong></p>
                                        <div class="courses-inside">
                                            @if (count($student->courses) > 0)
                                                <ul>
                                                    @foreach ($student->courses as $key => $course)
                                                        <li>
                                                            <span>{{ $key + 1 }}. {{ $course->title }}</span>
                                                            <!-- Remove form -->
                                                            <form action="{{ route('teacher.remove_student') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="student_id"
                                                                    value="{{ $student->id }}">
                                                                <input type="hidden" name="course_id"
                                                                    value="{{ $course->id }}">
                                                                <button type="submit" class="btndanger">Remove</button>
                                                            </form>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p>No Courses Assigned</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="width: 100%; height:100%; display: flex; justify-content: space-between;">
                            <div style="width: 50%; height:100%">
                                <h1>No Students Found!</h1>
                            </div>
                            <div style="width: 50%; height:100%; padding:0%">
                                <img style="width: 100%; height:40%" src="{{ asset('Illustrations/nostudents.png') }}"
                                    alt="No Courses Yet">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
