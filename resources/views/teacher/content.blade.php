@extends('teacher.main_layout_teacher')
@section('style', asset('profilestyling/profilestyle.css'))
@section('title')
    Teacher -
@endsection
@section('section1')
    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                <a href="#uploadContent" id="uploadContentBtn" class="side-menu-list-item side-menu-list-item-action">Upload
                    Content</a>
                <a href="{{ route('contents.index') }}" class="side-menu-list-item side-menu-list-item-action">View
                    Content</a>
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <section id="main-course">
                    <div class="main-course-page">
                        <div class="show_profile_info_about">
                            <h1>
                                Tips for Effective Content!
                            </h1>
                            <p style="background-color:#eeeded; border: 1px solid #000000">
                                Always remember, Your Content Defines Your Credibility!
                            </p>
                        </div>
                        <div class="main-course-page-box">
                            <div class="main-course-page-box-1 page-box">
                                <div class="hover-circle"></div>
                                <h1>Short Descriptive Titles</h1>
                                <p>
                                    Start with concise and engaging titles that clearly describe what learners can expect
                                    from each lesson.
                                </p>
                            </div>
                            <div class="main-course-page-box-2 page-box">
                                <div class="hover-circle"></div>
                                <h1>High Quality Related Banner</h1>
                                <p>
                                    Include a visually appealing and relevant banner that captures the essence of your
                                    course content.
                                </p>
                            </div>
                            <div class="main-course-page-box-3 page-box">
                                <div class="hover-circle"></div>
                                <h1>Well Written Description</h1>
                                <p>
                                    Craft a compelling and informative course description that highlights the key benefits
                                    and objectives of your course.
                                </p>
                            </div>
                            <div class="main-course-page-box-4 page-box">
                                <div class="hover-circle"></div>
                                <h1>Resources Link</h1>
                                <p>
                                    Provide additional resources or links that enhance the learning experience for your
                                    students.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="uploadContent" style="display: none;">
                    <form action="{{ route('contents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="Title of the Content" required>
                        </div>
                        @if ($errors->has('title'))
                            <div class="error_display">{{ $errors->first('title') }}</div>
                        @endif
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="What this content is about?" required></textarea>
                        </div>
                        @if ($errors->has('description'))
                            <div class="error_display">{{ $errors->first('description') }}</div>
                        @endif

                        <div class="form-group">
                            <label for="file_path">File Path</label>
                            <input type="file" class="form-control-file" id="file_path" name="file_path" required>
                        </div>
                        @if ($errors->has('file_path'))
                            <div class="error_display">{{ $errors->first('file_path') }}</div>
                        @endif

                        <div class="form-group">
                            <label for="content_type">Content Type</label>
                            <select class="form-control" id="content_type" name="content_type" required>
                                <option value="document">Document</option>
                                <option value="video">Video</option>
                                <option value="audio">Audio</option>
                                <!-- Add other content types as needed -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course_id">Course ID</label>
                            <input type="number" class="form-control" id="course_id" name="course_id"
                                placeholder="Please Enter Course ID" required>
                        </div>
                        @if ($errors->has('course_id'))
                            <div class="error_display">{{ $errors->first('course_id') }}</div>
                        @endif

                        <button type="submit" class="profilebtn">Upload</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <script>
        // JavaScript to handle sidebar menu navigation and form visibility
        // document.addEventListener("DOMContentLoaded", function() {
        //     const uploadContentBtn = document.getElementById('uploadContentBtn');
        //     const uploadContentSection = document.getElementById('uploadContent');
        //     uploadContentBtn.addEventListener('click', (e) => {
        //         e.preventDefault();
        //         uploadContentSection.style.display = 'block';
        //     });
        // });

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
