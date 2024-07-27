@extends('student.main_layout_student')
@section('style', asset('profilestyling/profilestyle.css'))


@section('css')
@endsection
@section('title')
Student -
@endsection

@section('section1')
    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                <a href="/student_content" class="side-menu-list-item side-menu-list-item-action">View Content</a>
                <a href="/student_assessments" class="side-menu-list-item side-menu-list-item-action">View Assesments</a>
                <button type="button" onclick="window.location.href='/student/courses/available'"
                    class="profilebtn">Back</button>
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <div class="courses-container">
                    @if ($courses->isEmpty())
                        <div style="width: 100%; height:100%; display: flex; justify-content: space-between;">
                            <div style="width: 50%; height:100% ; overflow-y:hidden">
                                <h1>No courses followed yet. </h1>
                                {{-- <a href="{{ route('student.availableCourses') }}" class="btnprimary">Follow courses</a> --}}
                            </div>
                            <div style="width: 50%; height:100%; padding:0%">
                                <img style="width: 100%; height:40%"
                                    src="{{ asset('Illustrations/NoCourseUploadedYet.png') }}" alt="No Courses Yet">
                            </div>
                        </div>
                    @else
                        @foreach ($courses as $course)
                            <div class="course-box">
                                <div class="course-header">
                                    <h3>{{ $course->title ?? 'Not Set Yet' }}</h3>
                                    <p><b>Course ID:</b> {{ $course->id }}</p>
                                </div>
                                <div class="course-banner"
                                    style="background-image: url('{{ asset($course->banner_image ? 'images/' . $course->banner_image : 'courseofferedatstudysphere.jpg') }}');"
                                    alt="ProfilePicture" </div>
                                </div>
                                <div class="course-footer">
                                    <P>Offered by</P>
                                    <b><p>{{ $course->teacher->name }}</p></b>
                                    <button>View</button>
                                </div>
                                <div class="course-overview">
                                    <p id="course-overview-text-{{ $course->id }}">
                                        {{ Str::limit($course->overview, 100) }}</p>
                                    @if (strlen($course->overview) > 100)
                                        <a href="#" class="read-more" data-course-id="{{ $course->id }}">Read
                                            more</a>
                                        <a href="#" class="read-less" data-course-id="{{ $course->id }}"
                                            style="display: none;">Read less</a>
                                    @endif
                                </div>
                                <div class="course" style="padding-bottom: 2%">
                                    <strong>Resource:</strong>
                                    <div>
                                        @php
                                            $resourceLink = $course->resources ?? '';

                                            if (!preg_match('~^(?:f|ht)tps?://~i', $resourceLink)) {
                                                $resourceLink = 'https://' . $resourceLink;
                                            }
                                        @endphp
                                        @if (!empty($resourceLink))
                                            <a href="{{ $resourceLink }}" target="_blank"> {{ $resourceLink }}</a>
                                        @else
                                            Not Set Yet
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    @if (Auth::user()->courses->contains($course->id))
                                        <form method="POST" action="{{ route('student.unfollowCourse') }}">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <button type="submit" class="btndanger"  onclick="return confirm('Are you sure you want to unfollow this course?')"f>Unfollow</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('student.followCourses') }}">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <button type="submit" class="btnprimary">Follow Back</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach


                        {{-- <ul>
                            @foreach ($courses as $course)
                                <li>{{ $course->title }} - {{ $course->teacher->name }}
                                    <form method="POST" action="{{ route('student.unfollowCourse') }}"
                                        style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to unfollow this course?')">Unfollow</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul> --}}
                    @endif
                </div>

            </div>
        </div>
    </div>
    <script>
        function unfollowCourse(courseId) {
            // Show a confirmation dialog
            if (confirm('Are you sure you want to unfollow this course?')) {
                // Get the form element with the corresponding course_id
                var form = document.querySelector('form[action="{{ route('student.unfollowCourse') }}"][data-course-id="' +
                    courseId + '"]');
                if (form) {
                    // Submit the form
                    form.submit();
                }
            }
            // Prevent the default action of the button
            return false;
        }
    </script>

@endsection
