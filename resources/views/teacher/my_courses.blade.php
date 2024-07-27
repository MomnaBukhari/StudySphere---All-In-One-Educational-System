@extends('teacher.main_layout_teacher')

@section('style', asset('profilestyling/profilestyle.css'))

@section('title')
    Teacher -
@endsection

@section('section1')

    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                <button type="button" onclick="window.location.href='/teacher_course'" class="profilebtn">Back</button>
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
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
                                    style="background-image: url('{{ asset('images/' . $course->banner_image) }}');">
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
                                <div class="course-actions">
                                    <button type="button" class="btnprimary"
                                        onclick="editCourse({{ $course->id }})">Edit</button>
                                    <form id="edit-course-form-{{ $course->id }}"
                                        action="{{ route('teacher.Course_Edit', $course->id) }}" method="GET"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                    <button type="button" class="btndanger"
                                        onclick="confirmDelete({{ $course->id }})">Delete</button>
                                    <form id="delete-course-form-{{ $course->id }}"
                                        action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(courseId) {
            var confirmed = confirm('Are you sure you want to delete this course?');
            if (confirmed) {
                document.getElementById('delete-course-form-' + courseId).submit();
            } else {
                console.log('Deletion canceled.');
            }
        }
    </script>
    <script>
        function editCourse(courseId) {
            document.getElementById('edit-course-form-' + courseId).submit();
        }
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
