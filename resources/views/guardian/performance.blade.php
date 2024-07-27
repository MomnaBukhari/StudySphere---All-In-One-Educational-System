@extends('guardian.main_layout_guardian')


@section('style', asset('profilestyling/profilestyle.css'))

@section('css')
@endsection

@section('title')
    Guardian -
@endsection

@section('section1')

    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                {{-- menu bar will be added here --}}
                {{-- <button type="button" onclick="window.location.href='/teacher_course'" class="profilebtn">Back</button> --}}
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <h1>Check Child's Performance</h1>
                <section id="Edit_content">

                    <form action="/performance" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="student_id">Enter Student ID:</label>
                            <input class="form-control" type="text" id="student_id" name="student_id" placeholder="##">
                        </div>
                        <div class="form-group">
                            <label for="student_email">Enter Student Email:</label>
                            <input class="form-control" type="email" id="student_email" name="student_email" placeholder="Enter student email" required>
                        </div>
                        <button class="profilebtn" type="submit">Submit</button>
                    </form>
                </section>
            </div>
        </div>
    </div>





@endsection
