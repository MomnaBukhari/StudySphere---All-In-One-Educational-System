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
            </div>
        </div>
    </div>
@endsection
