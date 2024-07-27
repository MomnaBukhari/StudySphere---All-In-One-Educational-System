@extends('student.main_layout_student')

@section('style', asset('profilestyling/profilestyle.css'))
@section('css')
@endsection

@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var accordionButtons = document.querySelectorAll(".custom-accordion-button");

        accordionButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                var target = document.querySelector(button.getAttribute("data-target"));
                var expanded = button.getAttribute("aria-expanded") === "true";

                if (expanded) {
                    button.setAttribute("aria-expanded", "false");
                    target.classList.remove("show");
                } else {
                    button.setAttribute("aria-expanded", "true");
                    target.classList.add("show");
                }
            });
        });
    });
</script>
@endsection

@section('title')
    Student -
@endsection

@section('section1')
<div class="profile-page">
    <div class="profile-page-part1">
        <div class="side-menu-list">
            <button class="profilebtn" onclick="window.location.href='{{ route('inbox') }}'">Go to Inbox</button>
        </div>
    </div>
    <div class="profile-page-part2">
        <div class="profile-display">
            <div class="custom-container">
                <h5><b>Teachers</b></h5>
                <div class="custom-accordion" id="usersAccordion">
                    @foreach ($users->groupBy('role') as $role => $groupedUsers)
                        <div class="custom-accordion-item">
                            <h2 class="custom-accordion-header" id="heading{{ $loop->index }}">
                                <button class="custom-accordion-button {{ $loop->first ? 'expanded' : 'collapsed' }}" type="button"
                                    data-toggle="collapse" data-target="#collapse{{ $loop->index }}"
                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                    aria-controls="collapse{{ $loop->index }}">
                                    {{ ucwords(strtolower($role)) }}
                                </button>
                            </h2>
                            <div id="collapse{{ $loop->index }}"
                                class="custom-accordion-collapse {{ $loop->first ? 'show' : '' }}"
                                aria-labelledby="heading{{ $loop->index }}" data-parent="#usersAccordion">
                                <div class="custom-accordion-body">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Specialization</th>
                                                <th>Action</th>
                                                <th>Profile</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($groupedUsers as $user)
                                                @if ($user->id != Auth::id())
                                                    <tr>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->course_specialization ?? 'Not Set Yet' }}</td>
                                                        <td>
                                                            <a class="chatbtn" href="{{ route('initiate', ['id' => $user->id]) }}">Chat!</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('teacher.viewProfile', $user->id) }}">
                                                                <button>Profile</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <br>
        </div>
    </div>
</div>
@endsection
