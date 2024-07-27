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

                <a href="#Take_new_Assessment" class="side-menu-list-item side-menu-list-item-action"
                    onclick="toggleSection('Take_new_Assessment')">Take a new Assessment</a></li>
                <a href="{{ route('assessments.index') }}"
                    class="side-menu-list-item side-menu-list-item-action">Assessments Record</a>
            </div>
        </div>

        <div class="profile-page-part2">
            <div class="profile-display">
                <section id="main-course">
                    <div class="main-course-page">
                        <div class="show_profile_info_about">
                            <h1>
                                Take Assesment Now
                            </h1>
                            <p style="background-color:#eeeded; border: 1px solid #000000">
                                You need course ID to take Assesment!
                            </p>
                        </div>
                        {{-- <div class="main-course-page-box">
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
                        </div> --}}
                    </div>
                </section>

                    <section id="Take_new_Assessment" style="display: none;">
                        <form action="{{ route('assessments.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="assignment">Assignment</option>
                                    <option value="quiz">Quiz</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="instructions">Instructions</label>
                                <textarea name="instructions" id="instructions" class="form-control" placeholder="Please enter Instructions for Students"></textarea>
                            </div>
                            @if ($errors->has('instructions'))
                                <div class="error_display">{{ $errors->first('instructions') }}</div>
                            @endif
                            <div class="form-group">
                                <label for="Total_Marks">Total_Marks</label>
                                <input type="number" class="form-control" id="Total_Marks" name="Total_Marks" placeholder="Please enter Total Marks">
                            </div>
                            @if ($errors->has('Total_Marks'))
                                <div class="error_display">{{ $errors->first('Total_Marks') }}</div>
                            @endif
                            <div class="form-group">
                                <label for="file">File</label>
                                <input type="file" name="file" id="file" class="form-control">
                            </div>
                            @if ($errors->has('file'))
                                <div class="error_display">{{ $errors->first('file') }}</div>
                            @endif
                            <div class="form-group">
                                <label for="course_id">Course ID</label>
                                <input type="number" class="form-control" id="course_id" name="course_id" placeholder="Please enter Course ID" required>
                            </div>
                            @if ($errors->has('course_id'))
                                <div class="error_display">{{ $errors->first('course_id') }}</div>
                            @endif
                            <button type="submit" class="profilebtn">Submit</button>
                        </form>
                    </section>
            </div>
        </div>
    </div>


    <script>
        function Assessmentsrecord() {
            console.log('press')
            window.location.href = "{{ route('assessments.index') }}"
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
