@extends('guardian.main_layout_guardian')

@section('style', asset('profilestyling/profilestyle.css'))

@section('css')
@endsection

@section('title')
    Guardian -
@endsection

@section('section1')
    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                {{-- menu bar will be added here --}}
                {{-- <button type="button" onclick="window.location.href='/performance'" class="profilebtn">Back</button> --}}
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <h3></h3>
                <div class="show_profile_info_about">
                    {{-- <h1>
                        You need to know!
                    </h1> --}}
                    <p>
                        Enter <span style="font-weight: bold">Student ID</span> and <span
                            style="font-weight: bold">Email</span> to View Assessments
                    </p>
                </div>

                <section id="Edit-courses">
                    <form method="POST" action="{{ route('show_followed_details') }}">
                        @csrf
                        <div class="form-group">
                            <label for="student_id">Student ID:</label>
                            <input type="text" name="student_id" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="student_email">Student Email:</label>
                            <input type="email" name="student_email" class="form-control" required>
                        </div>
                        <button type="submit">Submit</button>
                    </form>
                </section>
                <br><br>
                <div class="child-student-details">
                    @if (isset($student))
                        <section id="child-details">

                            <p style="background-color:#fafbff; border: 1px solid #000000; padding:2% 2%">
                                Details for {{ $student->name }}
                            </p>
                            <p><b>Followed Courses</b></p>
                            @if ($student->followedCourses->isNotEmpty())

                                <table class="details-table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Teacher</th>
                                            <th>Start Data</th>
                                            <th>End Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($student->followedCourses as $course)
                                            <tr>
                                                <td>{{ $course->title }}</td>
                                                <td>{{ $course->teacher->name }}</td>
                                                <td>{{ $course->start_date }}</td>
                                                <td>{{ $course->end_date }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p style="background-color:#eeeded; border: 1px solid #000000; padding:2% 2%">
                                    No Data to be displayed
                                </p>
                            @endif
                            <p><b>Assessments</b></p>
                            @if ($student->followedAssessments->isNotEmpty())

                                <table class="details-table">
                                    <thead>
                                        <tr>
                                            <th>Course ID</th>
                                            <th>Course Title</th>
                                            <th>Type</th>
                                            <th>Instructions</th>
                                            <th>Total Marks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($student->followedAssessments as $assessment)
                                            <tr>
                                                <td>{{ $assessment->course->id }}</td>
                                                <td>{{ $assessment->course->title }}</td>
                                                <td>{{ $assessment->type }}</td>
                                                <td>{{ $assessment->instructions }}</td>
                                                <td>{{ $assessment->Total_Marks }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p style="background-color:#eeeded; border: 1px solid #000000; padding:2% 2%">
                                    No Data to be displayed
                                </p>
                            @endif
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style>
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .details-table th, .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .details-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .details-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .details-table tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
@endsection
