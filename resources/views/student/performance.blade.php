@extends('student.main_layout_student')
@section('style', asset('profilestyling/profilestyle.css'))

@section('title')
    Student -
@endsection

@section('css')
    <style>
        .accordion-container {
            width: 100%;
        }

        .accordion {
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .accordion-header {
            background: linear-gradient(180deg, #EDEFFF, #FAF9F9);
            border-bottom: 1px solid #ddd;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            color: #000000;
            text-align: left;
        }

        .accordion-content {
            display: none;
            padding: 15px;
            border-top: 1px solid #ddd;
        }

        .accordion-content p {
            margin: 0;
        }

        .accordion-header.active {
            background-color: #e9ecef;
        }

        .accordion-content.show {
            display: block;
        }
    </style>
@endsection

@section('section1')
    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                {{-- <a href="/student_content" class="side-menu-list-item side-menu-list-item-action">View Content</a>
                <a href="/student_assessments" class="side-menu-list-item side-menu-list-item-action">View Assessments</a>
                <button type="button" onclick="window.location.href='/student/courses/available'" class="profilebtn">Back</button> --}}
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <div class="container accordion-container">
                    @if (isset($performances) && $performances->isNotEmpty())
                        @php
                            $groupedPerformances = $performances->groupBy('course.title');
                        @endphp

                        @foreach ($groupedPerformances as $courseTitle => $performancesByCourse)
                            <div class="accordion">
                                <div class="accordion-header">
                                    {{ $courseTitle }}
                                </div>
                                <div class="accordion-content">
                                    @foreach ($performancesByCourse as $performance)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <p>Assessment ID: {{ $performance->assessment->id }}</p>
                                                <p>Obtained Marks: {{ $performance->obtained_marks }} /
                                                    {{ $performance->assessment->Total_Marks }}</p>
                                                <p>Remarks: {{ $performance->remarks }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="width: 100%; height:100%; display: flex; justify-content: space-between;">
                            <div style="width: 50%; height:100%">
                                <h1>Nothing to Show!</h1>
                            </div>
                            <div style="width: 50%; height:100%; padding:0%">
                                <img style="width: 100%; height:40%"
                                    src="{{ asset('Illustrations/nostudents.png') }}" alt="No Courses Yet">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var accHeaders = document.querySelectorAll('.accordion-header');

            accHeaders.forEach(function(header) {
                header.addEventListener('click', function() {
                    // Toggle active class on header
                    this.classList.toggle('active');

                    // Get the corresponding accordion content
                    var content = this.nextElementSibling;

                    // Toggle the visibility of the content
                    if (content.classList.contains('show')) {
                        content.classList.remove('show');
                    } else {
                        content.classList.add('show');
                    }
                });
            });
        });
    </script>
@endsection
