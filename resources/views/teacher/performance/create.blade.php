@extends('teacher.main_layout_teacher')

@section('style', asset('profilestyling/profilestyle.css'))

@section('title')
    Teacher -
@endsection

@section('section1')

    <div class="profile-page">
        <div class="profile-page-part1">
            {{-- <div class="side-menu-list">
                <a href="/teacher_course" class="side-menu-list-item side-menu-list-item-action">Create New Course</a>
            </div> --}}
            <div class="side-menu-list">
                <button type="button" onclick="window.location.href='/teacher/performance'" class="profilebtn">Back</button>
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <h4
                    style="font-size: 100% ; color:#041439; background-color:aliceblue; padding: 10px; border:1px solid #041439">
                    You have selected <b> {{ $course->title }} </b>for performance uploading!</h4>
                <!-- Form to fetch students with uploaded answers -->


                @if ($assessments->isEmpty())
                    <div style="width: 100%; height:100%; display: flex; justify-content: space-between;">
                        <div style="width: 50%; height:100%">
                            <h3 style="margin-top: 2%">No Assesments made for this course!</h3>

                            <button type="button" onclick="window.location.href='/teacher_assesment'"
                                class="profilebtn">Create Assesment Now!</button>
                        </div>
                        <div style="width: 50%; height:100%; padding:0%">
                            <img style="width: 100%; height:40%; "
                                src="{{ asset('Illustrations/NoContentUploadedYet.png') }}" alt="No Assesments Yet">
                        </div>
                    </div>
                @else
                    <form id="studentsForm" method="POST" action="{{ route('performance.uploadedStudents') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <div class="form-group">
                            <label for="assessment_id">Select Assessment</label>
                            <select id="assessment_id" name="assessment_id" class="form-control">
                                @foreach ($assessments as $assessment)
                                    <option value="{{ $assessment->id }}">
                                        {{ $assessment->id }} - {{ strtoupper($assessment->type) }} -
                                        {{ $assessment->instructions }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="profilebtn">Fetch Students with Answer Files</button>
                    </form>
                @endif

                @isset($students)
                    <!-- List of students with uploaded answers (Initially Hidden) -->

                    @if ($students->isEmpty())
                        <div style="width: 100%; height:100%; display: flex; justify-content: space-between;">
                            <div style="width: 50%; height:100%">
                                <p style="color: rgb(255, 25, 0)">No Students have uploaded yet!</p>
                            </div>
                            {{-- <div style="width: 50%; height:100%; padding:0%">
                                <img style="width: 100%; height:40%" src="{{ asset('Illustrations/NoCourseUploadedYet.png') }}"
                                    alt="No Courses Yet">
                            </div> --}}
                        </div>
                    @else
                        {{-- <div id="studentsList" style="margin-top: 20px; display: none;">
                            <h3>Students with Uploaded Answers</h3>
                            <ul id="studentsAnswerFiles" class="list-group">
                                @foreach ($students as $student)
                                    <li class="list-group-item" data-student-id="{{ $student->id }}">
                                        <strong>{{ $student->name }}</strong> -
                                        <a href="{{ asset($student->answer_file) }}" target="_blank">View Answer File</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div> --}}

                        <!-- Form to upload marks and remarks -->
                        <section id="performanceFormSection">
                            <form id="performanceForm" action="{{ route('performance.store') }}" method="post"
                                style="margin-top: 20px;">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <input type="hidden" name="assessment_id" value="{{ $assessment_id }}">
                                <div class="form-group-custom">
                                    <label for="student_id_custom">Select Student</label>
                                    <select id="student_id_custom" name="student_id" class="form-control-custom">
                                        <option value="">Select a student</option>
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="answerFileContainerCustom" class="form-group-custom" style="display: none;">
                                    <label>Answer File</label>
                                    <div id="answerFileLinkCustom"></div>
                                </div>
                                <div class="form-group-custom">
                                    <label for="total_marks_custom">Total Marks</label>
                                    <input type="number" id="total_marks_custom" name="total_marks" class="form-control-custom"
                                        value="{{ $selected_assessment->Total_Marks }}" readonly>
                                </div>
                                <div class="form-group-custom">
                                    <label for="obtained_marks_custom">Obtained Marks</label>
                                    <input type="number" id="obtained_marks_custom" name="obtained_marks"
                                        class="form-control-custom">
                                </div>
                                <div class="form-group-custom">
                                    <label for="remarks_custom">Remarks</label>
                                    <textarea id="remarks_custom" name="remarks" class="form-control-custom"></textarea>
                                </div>
                                <button type="submit" class="profilebtn-custom">Upload Marks</button>
                            </form>
                        </section>
                    @endif
                @endisset
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studentSelect = document.getElementById('student_id');
            const answerFileContainer = document.getElementById('answerFileContainer');
            const answerFileLink = document.getElementById('answerFileLink');
            const studentsAnswerFiles = document.getElementById('studentsAnswerFiles');

            studentSelect.addEventListener('change', function() {
                const selectedStudentId = this.value;

                if (selectedStudentId) {
                    // Send a POST request
                    fetch('{{ route('performance.uploadedStudents') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                student_id: selectedStudentId
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            const link = document.createElement('a');
                            link.textContent = 'View Answer File';
                            link.setAttribute('href', data.answer_file);
                            link.setAttribute('target', '_blank');

                            answerFileLink.innerHTML = '';
                            answerFileLink.appendChild(link);

                            answerFileContainer.style.display = 'block';
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                } else {
                    answerFileContainer.style.display = 'none';
                }
            });

            document.getElementById('studentsForm').addEventListener('submit', function() {
                document.getElementById('studentsList').style.display = 'block';
            });
        });
    </script>

@endsection
