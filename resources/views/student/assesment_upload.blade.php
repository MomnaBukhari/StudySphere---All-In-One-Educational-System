@extends('student.main_layout_student')

@section('css')
studentdashboard.css
@endsection

@section('title')
Student -
@endsection


@section('content')
<div class="container">
    <h2>Upload Answer for Assessment {{ $assessment->id }}</h2>
    <form action="{{ route('assessments.uploads.store1', $assessment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="answer">Answer</label>
            <input type="file" name="answer" id="answer" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection
