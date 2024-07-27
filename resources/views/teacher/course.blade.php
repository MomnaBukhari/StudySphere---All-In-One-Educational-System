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
            <div class="side-menu-list">
                <a href="#create_new_course" class="side-menu-list-item side-menu-list-item-action"
                    onclick="toggleSection('create_new_course')">Create New Course</a>
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
                                After creating a course, each course is assigned a unique <b>Course ID</b>. This ID is
                                essential
                                for content uploading and managing assessments and more.
                                <br><b>Please note</b> that the Course ID does not necessarily start from 1 and does not
                                follow a sequential order.
                            </p>
                        </div>
                        <div class="main-course-page-box">
                            <div class="main-course-page-box-1 page-box">
                                <div class="hover-circle"></div>
                                <h1>Plan Your Courses</h1>
                                <p>
                                    You start with your passion and knowledge. Then choose a promising topic to lighten up
                                    the
                                    minds of enthusiastic Learners!.
                                </p>
                            </div>
                            <div class="main-course-page-box-2 page-box">
                                <div class="hover-circle"></div>
                                <h1>Record Your Lessons</h1>
                                <p> Record Your Lessons
                                    Use basic tools like a smartphone or a DSLR camera. Add a good microphone and you’re
                                    ready
                                    to start.
                                </p>
                            </div>
                            <div class="main-course-page-box-3 page-box">
                                <div class="hover-circle"></div>
                                <h1>Upload Your Content</h1>
                                <p>
                                    Upload your content to the platform and start sharing your knowledge with the world.
                                    Remember to put a highly related and descriptive banner!
                                </p>
                            </div>
                            <div class="main-course-page-box-4 page-box">
                                <div class="hover-circle"></div>
                                <h1>Ready to Go!</h1>
                                <p>
                                    Your course is now ready to be shared with the world. You can now start teaching and
                                    fulfilling your passion!
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="create_new_course" style="display: none;">
                    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Course Title" required>
                        </div>
                        <div class="form-group">
                            <label for="overview">Overview</label>
                            <textarea class="form-control" id="overview" name="overview" rows="5" placeholder="Describe Course Goals and What's this course is about." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <div class="form-group">
                            <label for="resources">Resource Link</label>
                            <textarea class="form-control" id="resources" name="resources" rows="5" placeholder="https://www.studysphere.com/">{{ old('resources') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="banner_image">Banner Image</label>
                            <input type="file" class="form-control" id="banner_image" name="banner_image"
                                accept="image/*">
                        </div>
                        <button type="submit" class="profilebtn">Create Course</button>
                    </form>
                </section>
            </div>
        </div>
    </div>

    <script>
        function myCourses() {
            window.location.href = "{{ route('courses.index1') }}"
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

@endsection
