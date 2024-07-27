@extends('teacher.main_layout_teacher')

@section('css')
<link rel="stylesheet" href="teacherdashboard.css">
@endsection

@section('title')
Teacher - Performance
@endsection

@section('content')
<form id="performanceForm" action="{{ route('performance.store') }}" method="POST" style="margin-top: 20px;">
    @csrf
    <input type="hidden" name="course_id" value="{{ $course->id }}">
    <input type="hidden" name="assessment_id" value="{{ $assessment_id }}">
    <div class="form-group">
        <label for="student_id">Select Student</label>
        <select id="student_id" name="student_id" class="form-control">
            <option value="">Select a student</option>
            @foreach($students as $student)
            <option value="{{ $student->id }}">{{ $student->name }}</option>
            @endforeach
        </select>
    </div>
    <div id="answerFileContainer" class="form-group">
        <label>Answer File</label>
        <div id="answerFileLink"></div>
    </div>
    <div class="form-group">
        <label for="total_marks">Total Marks</label>
        <input type="number" id="total_marks" name="total_marks" class="form-control"
            value="{{ $selected_assessment->Total_Marks }}" readonly>
    </div>
    <div class="form-group">
        <label for="obtained_marks">Obtained Marks</label>
        <input type="number" id="obtained_marks" name="obtained_marks" class="form-control">
    </div>
    <div class="form-group">
        <label for="remarks">Remarks</label>
        <textarea id="remarks" name="remarks" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Upload Marks</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const studentSelect = document.getElementById('student_id');
    const answerFileContainer = document.getElementById('answerFileContainer');
    const studentsAnswerFiles = document.getElementById('studentsAnswerFiles');

    studentSelect.addEventListener('change', function() {
        const selectedStudentId = this.value;
        const answerFileLink = document.getElementById('answerFileLink');

        if (selectedStudentId) {
            const studentItem = studentsAnswerFiles.querySelector(
                `[data-student-id='${selectedStudentId}']`);
            const link = studentItem.querySelector('a').cloneNode(true);
            link.textContent = 'View Answer File';

            answerFileLink.innerHTML = '';
            answerFileLink.appendChild(link);

            answerFileContainer.style.display = 'block';
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