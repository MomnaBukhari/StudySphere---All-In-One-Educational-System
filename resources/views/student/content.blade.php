@extends('student.main_layout_student')

@section('style', asset('profilestyling/profilestyle.css'))

@section('css')
    <style>
        .accordion {
            width: 100%;
            border: 1px solid #000000;
        }

        .accordion-header {
            background: linear-gradient(180deg, #EDEFFF, #FAF9F9);
            padding: 0.5%;
            cursor: pointer;
            border-bottom: 1px solid #000000;
            font-size: 100%;
            color: #333;
        }

        .accordion-body {
            padding: 15px;
            display: none;
        }

        .accordion-body.show {
            display: block;
        }

        .accordion-header.active {
            background-color: #e9ecef;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
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
            color: #007bff;
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
                <a href="/student/courses/available" class="side-menu-list-item side-menu-list-item-action">Available Courses</a>
                <a href="{{ route('student.myCourses') }}" class="side-menu-list-item side-menu-list-item-action">My Courses</a>
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                @if (empty($contents))
                    <div style="width: 100%; height:100%; display: flex; justify-content: space-between;">
                        <div style="width: 50%; height:100%; overflow-y:hidden">
                            <h1>No content available.</h1>
                        </div>
                        <div style="width: 50%; height:100%; padding:0%">
                            <img style="width: 100%; height:40%" src="{{ asset('Illustrations/NoContentUploadedYet.png') }}" alt="No Courses Yet">
                        </div>
                    </div>
                @else
                    @php
                        $courses = [];
                        foreach ($contents as $content) {
                            $courseId = $content['course_id'];
                            if (!isset($courses[$courseId])) {
                                $courses[$courseId] = [
                                    'course_title' => $content['course_title'],
                                    'contents' => []
                                ];
                            }
                            $courses[$courseId]['contents'][] = $content;
                        }
                    @endphp

                    <div class="accordion">
                        @foreach ($courses as $courseId => $course)
                            <div class="accordion-item">
                                <div class="accordion-header" id="heading-{{ $courseId }}">
                                    <p>{{ $course['course_title'] }}</p>
                                </div>
                                <div id="collapse-{{ $courseId }}" class="accordion-body">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>Course Title</th>
                                                <th>Content Title</th>
                                                <th>Description</th>
                                                <th>Content Type</th>
                                                <th>Download</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($course['contents'] as $content)
                                                <tr>
                                                    <td>{{ $content['course_title'] }}</td>
                                                    <td>{{ $content['title'] }}</td>
                                                    <td>{{ $content['description'] }}</td>
                                                    <td>{{ $content['content_type'] }}</td>
                                                    <td>
                                                        @if ($content['file_path'] && $content['file_path'] != 'No file attached')
                                                            <a href="{{ $content['file_path'] }}" target="_blank" data-toggle="tooltip" title="Click to download the assessment file">Download</a>
                                                        @else
                                                            No file attached
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
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
