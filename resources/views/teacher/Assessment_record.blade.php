@extends('teacher.main_layout_teacher')

@section('style', asset('profilestyling/profilestyle.css'))

@section('title')
    Teacher -
@endsection

@section('section1')
    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                <button type="button" onclick="window.location.href='/teacher_assesment'" class="profilebtn">Back</button>
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <div class="courses-container">
                    @if ($assessments->isEmpty())
                        <div style="width: 100%; height:100%; display: flex; justify-content: space-between;">
                            <div style="width: 50%; height:100%">
                                <h1>No Assessments made yet!</h1>
                            </div>
                            <div style="width: 50%; height:100%; padding:0%">
                                <img style="width: 100%; height:40%"
                                    src="{{ asset('Illustrations/NoContentUploadedYet.png') }}" alt="No Courses Yet">
                            </div>
                        </div>
                    @else
                        @php
                            $courses = $assessments->groupBy('course.title');
                        @endphp

                        @foreach ($courses as $courseTitle => $courseAssessments)
                            <div class="contentaccordion">
                                <div class="contentaccordion-header" id="heading-{{ Str::slug($courseTitle) }}">
                                    <button class="contentaccordion-button" type="button" data-toggle="collapse"
                                        data-target="#collapse-{{ Str::slug($courseTitle) }}" aria-expanded="true"
                                        aria-controls="collapse-{{ Str::slug($courseTitle) }}">
                                        <b>></b> {{ $courseTitle }}
                                    </button>
                                </div>
                                <div id="collapse-{{ Str::slug($courseTitle) }}" class="collapse"
                                    aria-labelledby="heading-{{ Str::slug($courseTitle) }}" data-parent="#contentaccordion">
                                    <div class="contentaccordionbody">
                                        <table class="content-table">
                                            <thead class="content-table-head">
                                                <tr class="content-table-row">
                                                    <th>ID</th>
                                                    <th>Type</th>
                                                    <th>Instructions</th>
                                                    <th>Total Marks</th>
                                                    <th>File</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="content-table-body">
                                                @foreach ($courseAssessments as $assessment)
                                                    <tr>
                                                        <td>{{ $assessment->id }}</td>
                                                        <td>{{ $assessment->type }}</td>
                                                        <td>{{ $assessment->instructions }}</td>
                                                        <td>{{ $assessment->Total_Marks }}</td>
                                                        <td>
                                                            @if ($assessment->file)
                                                                <a href="{{ asset('uploads/' . $assessment->file) }}"
                                                                    target="_blank">View File</a>
                                                            @else
                                                                No file
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{-- Edit button --}}
                                                            <button class="contentbtnprimary"
                                                                onclick="editAssessment({{ $assessment->id }}, '{{ $assessment->type }}', '{{ $assessment->instructions }}', '{{ $assessment->file }}' , '{{ $assessment->Total_Marks }}')">Edit</button>

                                                            {{-- Delete form --}}
                                                            <form action="{{ route('assessments.destroy', $assessment->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btndanger"
                                                                    onclick="return confirm('Are you sure you want to delete this assessment?')">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <section id="assessment_edit">
                    {{-- Form for editing an existing assessment --}}
                    <form id="edit-form" action="" method="POST" enctype="multipart/form-data"
                        style="display:none;">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit-type">Type</label>
                            <select name="type" id="edit-type" class="form-control">
                                <option value="assignment">Assignment</option>
                                <option value="quiz">Quiz</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-instructions">Instructions</label>
                            <textarea name="instructions" id="edit-instructions" class="form-control"
                                placeholder="Please enter Instructions for Students"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="Total_Marks">Total Marks</label>
                            <input type="number" class="form-control" id="edit-Total_Marks" name="Total_Marks"
                            {{-- value="{{$assessments->Total_Marks}}" --}}
                             placeholder="Please enter Total Marks">
                        </div>

                        <div class="form-group">
                            <label for="edit-file">File</label>
                            <input type="file" name="file" id="edit-file" class="form-control">
                            <small id="edit-current-file"></small>
                        </div>
                        <button type="submit" class="profilebtn">Update</button>
                        <button href="route{{ 'assessments.show' }}" class="profilebtn">Cancel</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <script>
        function editAssessment(id, type, instructions, file) {
            const form = document.getElementById('edit-form');
            form.action = `/assessments/${id}`;
            document.getElementById('edit-type').value = type;
            document.getElementById('edit-instructions').value = instructions;
            const currentFileText = file ? `Current file: ${file}` : 'No file uploaded';
            document.getElementById('edit-current-file').textContent = currentFileText;
            form.style.display = 'block';
            window.scrollTo(0, form.offsetTop);
        }
        // JavaScript to handle sidebar menu navigation and form visibility

        document.addEventListener("DOMContentLoaded", function() {
            var contentaccordions = document.querySelectorAll('.contentaccordion-button');
            contentaccordions.forEach(function(button) {
                button.addEventListener('click', function() {
                    var target = document.querySelector(button.dataset.target);
                    target.classList.toggle('collapse');
                });
            });
        });
    </script>
@endsection
