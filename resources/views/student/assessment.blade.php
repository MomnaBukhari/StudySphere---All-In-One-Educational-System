@extends('student.main_layout_student')
@section('style', asset('profilestyling/profilestyle.css'))

@section('css')
    <style>
        .accordion {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .accordion-header {
            background: linear-gradient(180deg, #EDEFFF, #FAF9F9);
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #000000;
            font-size: 16px;
            color: #333;
            transition: background-color 0.3s;
        }

        .accordion-header.active {
            background-color: #e9ecef;
        }

        .accordion-body {
            padding: 15px;
            display: none;
        }

        .accordion-body.show {
            display: block;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-table th,
        .custom-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .custom-table th {
            background-color: #f2f2f2;
            color: #333;
        }

        .custom-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .custom-table tbody tr:hover {
            background-color: #e9ecef;
        }

        .custom-table a {
            text-decoration: none;
            color: #2a2880;
        }

        .custom-table button {
            padding: 6px 12px;
            background-color: #e9e9fa;
            color: black;
            border: 1px solid black;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .custom-table button:hover {
            background-color: #dadaf8;
        }
    </style>
@endsection

@section('title')
    Student -
@endsection

@section('section1')
    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                {{-- <a href="#available_courses" class="side-menu-list-item side-menu-list-item-action">Available Courses</a>
                <a href="#my_courses" class="side-menu-list-item side-menu-list-item-action" onclick="myCourses()">My Courses</a> --}}
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                @if (isset($assessments) && !empty($assessments))
                    @php
                        $courses = [];
                        foreach ($assessments as $assessment) {
                            $courseId = $assessment->course->id;
                            if (!isset($courses[$courseId])) {
                                $courses[$courseId] = [
                                    'course_title' => $assessment->course->title,
                                    'assessments' => []
                                ];
                            }
                            $courses[$courseId]['assessments'][] = $assessment;
                        }
                    @endphp

                    <div class="accordion">
                        @foreach ($courses as $courseId => $course)
                            <div class="accordion-item">
                                <div class="accordion-header" id="heading-{{ $courseId }}">
                                    <p>{{ $course['course_title'] }}</p>
                                </div>
                                <div id="collapse-{{ $courseId }}" class="accordion-body">
                                    @foreach ($course['assessments'] as $assessment)
                                        <table class="custom-table">
                                            <thead>
                                                <tr>
                                                    <th>Course Title</th>
                                                    <th>Type</th>
                                                    <th>Instructions</th>
                                                    <th>Total Marks</th>
                                                    <th>File</th>
                                                    <th>Upload Answer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $assessment->course->title }}</td>
                                                    <td>{{ $assessment->type }}</td>
                                                    <td>{{ $assessment->instructions }}</td>
                                                    <td>{{ $assessment->Total_Marks }}</td>
                                                    <td>
                                                        @if ($assessment->file && $assessment->file != 'No file attached')
                                                            <a href="{{ $assessment->file }}" target="_blank" data-toggle="tooltip" title="Click to download the assessment file">Download</a>
                                                        @else
                                                            No file attached
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @auth
                                                            @if (auth()->user()->answers()->where('assessment_id', $assessment->id)->where('student_id', auth()->user()->id)->count() == 0)
                                                                <form method="POST" action="{{ route('answers.store', $assessment->id) }}" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="file" name="answer_file" id="answer_file">
                                                                    <button type="submit">Upload Answer</button>
                                                                </form>
                                                            @else
                                                                <p>Answer Uploaded</p>
                                                            @endif
                                                        @endauth
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="width: 100%; height:100%; display: flex; justify-content: space-between;">
                        <div style="width: 50%; height:100%">
                            <h1>No Assessments Yet, Chill!</h1>
                        </div>
                        <div style="width: 50%; height:100%; padding:0%">
                            <img style="width: 100%; height:40%" src="{{ asset('Illustrations/NoContentUploadedYet.png') }}" alt="No Courses Yet">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const headers = document.querySelectorAll('.accordion-header');

            headers.forEach(header => {
                header.addEventListener('click', function() {
                    const body = document.getElementById(header.id.replace('heading-', 'collapse-'));
                    const isActive = header.classList.contains('active');

                    document.querySelectorAll('.accordion-body').forEach(body => {
                        body.classList.remove('show');
                    });

                    document.querySelectorAll('.accordion-header').forEach(header => {
                        header.classList.remove('active');
                    });

                    if (!isActive) {
                        body.classList.add('show');
                        header.classList.add('active');
                    }
                });
            });
        });
    </script>
@endsection
