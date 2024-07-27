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
                <a href="#available_courses" class="side-menu-list-item side-menu-list-item-action">Available
                    Courses</a>
                <a href="#My_courses" class="side-menu-list-item side-menu-list-item-action" onclick="myCourses()">My
                    Courses</a>
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <section id="main-course">
                    <div class="main-course-page">
                        <div class="show_profile_info_about">
                            <h1>
                                You need to know!
                            </h1>
                            <p>
                                After Following a Course, you need to go to <b><a href="/student_content"
                                        style="text-decoration: none">Content Section </a></b>to see related content!
                            </p>
                        </div>
                        <div class="main-course-page-box">
                            <div class="main-course-page-box-1 page-box">
                                <div class="hover-circle"></div>
                                <h1>Plan Your Learning</h1>
                                <p>
                                    Start with your curiosity and goals. Use our system to find the best courses for your
                                    needs. The way you learn — how you approach it — is entirely up to you!
                                </p>
                            </div>
                            <div class="main-course-page-box-2 page-box">
                                <div class="hover-circle"></div>
                                <h1>Engage with Lessons</h1>
                                <p> Use any device to access your courses. Whether it’s a smartphone, tablet, or computer,
                                    you’re ready to
                                    learn. If you prefer, you can even download materials for offline study.
                                </p>
                            </div>
                            <div class="main-course-page-box-3 page-box">
                                <div class="hover-circle"></div>
                                <h1>Connect & Collaboratet</h1>
                                <p>
                                    Chat now with you favourite tutor, participate in Discussion Boards, and collaborate on
                                    projects with
                                    peers from around the globe!
                                </p>
                            </div>
                            <div class="main-course-page-box-4 page-box">
                                <div class="hover-circle"></div>
                                <h1>Celebrate Your Success!</h1>
                                <p>
                                    Complete your course and earn your certificate. Share it with your network to showcase your new skills!
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="available_courses" style="display: none;">
                    <div class="courses-container">
                        @if ($courses->isEmpty())
                            <div style="width: 100%; height:100%; display: flex; justify-content: space-between;">
                                <div style="width: 50%; height:100%">
                                    <h1>No courses found!</h1>
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
                                        alt="ProfilePicture">
                                    </div>
                                    <div class="course-footer">
                                        <p>Offered by</p>
                                        <b><p>{{ $course->teacher->name }}</p></b>
                                        <a href="{{ route('teacher.viewProfile', $course->teacher->id) }}">
                                            <button>View</button>
                                        </a>
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
                                        @auth
                                            @php
                                                $userCourses = Auth::user()->courses ?? collect();
                                            @endphp
                                            @if ($userCourses->contains($course->id))
                                                <form method="POST" action="{{ route('student.unfollowCourse') }}">
                                                    @csrf
                                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                    <button type="submit" class="btndanger">Unfollow</button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('student.followCourses') }}">
                                                    @csrf
                                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                    <button type="submit" class="btnprimary">Follow</button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </section>

                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
    <script>
        function myCourses() {
            window.location.href = "{{ route('student.myCourses') }}"
        }

        // JavaScript to handle sidebar menu navigation and form visibility
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarLinks = document.querySelectorAll('.side-menu-list-item-action ');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => {
                    const sectionId = link.getAttribute('href').replace('#', '');
                    const sections = document.querySelectorAll('section');
                    sections.forEach(section => {
                        section.style.display = 'none';
                    });
                    document.getElementById(sectionId).style.display = 'block';
                });
            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const courses = @json($courses->keyBy('id'));

            document.querySelectorAll('.read-more').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const courseId = this.getAttribute('data-course-id');
                    const overviewText = document.getElementById('course-overview-text-' +
                        courseId);
                    overviewText.textContent = courses[courseId].overview; // Set the full content
                    this.style.display = 'none';
                    document.querySelector(`.read-less[data-course-id="${courseId}"]`).style
                        .display = 'inline';
                });
            });

            document.querySelectorAll('.read-less').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const courseId = this.getAttribute('data-course-id');
                    const overviewText = document.getElementById('course-overview-text-' +
                        courseId);
                    overviewText.textContent = courses[courseId].overview.substring(0, 100) +
                        '...'; // Set the truncated content
                    this.style.display = 'none';
                    document.querySelector(`.read-more[data-course-id="${courseId}"]`).style
                        .display = 'inline';
                });
            });
        });
    </script>

@endsection
