@extends('teacher.main_layout_teacher')

@section('css')
    <link rel="stylesheet" href="teacherdashboard.css">
@endsection

@section('title')
    Teacher - Performance
@endsection

@section('content')
<div class="container">
    <h2>Performance Section</h2>


    <div>
        <label for="courseDropdown">Select Course:</label>
        <select id="courseDropdown" class="form-control"></select>
    </div>

    <div>
        <label for="assessmentDropdown">Select Assessment:</label>
        <select id="assessmentDropdown" class="form-control"></select>
    </div>

    <div id="studentsList">
        <!-- Students and their submissions will be displayed here -->
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const courseDropdown = document.getElementById('courseDropdown');
        const assessmentDropdown = document.getElementById('assessmentDropdown');
        const studentsList = document.getElementById('studentsList');

        // Fetch courses
        fetch('/performance/courses')
            .then(response => response.json())
            .then(data => {
                data.forEach(course => {
                    let option = document.createElement('option');
                    option.value = course.id;
                    option.textContent = course.name;
                    courseDropdown.appendChild(option);
                });
            });

        // Fetch assessments when a course is selected
        courseDropdown.addEventListener('change', function() {
            const courseId = this.value;
            fetch(`/performance/assessments/${courseId}`)
                .then(response => response.json())
                .then(data => {
                    assessmentDropdown.innerHTML = '';
                    data.forEach(assessment => {
                        let option = document.createElement('option');
                        option.value = assessment.id;
                        option.textContent = assessment.name;
                        assessmentDropdown.appendChild(option);
                    });
                });
        });

        // Fetch students and submissions when an assessment is selected
        assessmentDropdown.addEventListener('change', function() {
            const assessmentId = this.value;
            fetch(`/performance/students/${assessmentId}`)
                .then(response => response.json())
                .then(data => {
                    studentsList.innerHTML = '';
                    data.forEach(submission => {
                        let div = document.createElement('div');
                        div.innerHTML = `
                            <p>${submission.student.name} - ${submission.file_path}</p>
                            <input type="number" value="${submission.marks || ''}" data-submission-id="${submission.id}" class="marks-input">
                        `;
                        studentsList.appendChild(div);
                    });

                    // Attach event listeners to marks inputs
                    document.querySelectorAll('.marks-input').forEach(input => {
                        input.addEventListener('change', function() {
                            const submissionId = this.getAttribute('data-submission-id');
                            const marks = this.value;
                            fetch('/performance/marks', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ submission_id: submissionId, marks: marks })
                            })
                            .then(response => response.json())
                            .then(data => {
                                alert(data.message);
                            });
                        });
                    });
                });
        });
    });
</script>
@endsection
