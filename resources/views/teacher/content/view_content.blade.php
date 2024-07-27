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
                <button type="button" onclick="window.location.href='/teacher_content'" class="profilebtn">Back</button>
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <div class="courses-container">
                    <section id="View_content" style="display: block;">
                        @if ($contents->isEmpty())
                            <div style="width: 100%; height:100%; display: flex; justify-content: space-between;">
                                <div style="width: 50%; height:100%">
                                    <h1>No Content Uploaded Yet!</h1>
                                </div>
                                <div style="width: 50%; height:100%; padding:0%">
                                    <img style="width: 100%; height:100%"
                                        src="{{ asset('Illustrations/NoContentUploadedYet.png') }}" alt="No Courses Yet">
                                </div>
                            </div>
                        @else
                            @php
                                $courses = $contents->groupBy('course.title');
                            @endphp

                            @foreach ($courses as $courseTitle => $courseContents)
                                <div class="contentaccordion">
                                    <div class="contentaccordion-header" id="heading-{{ Str::slug($courseTitle) }}">
                                        <button class="contentaccordion-button" type="button" data-toggle="collapse"
                                            data-target="#collapse-{{ Str::slug($courseTitle) }}" aria-expanded="true"
                                            aria-controls="collapse-{{ Str::slug($courseTitle) }}">
                                            <b>></b> {{ $courseTitle }}
                                        </button>
                                    </div>
                                    <div id="collapse-{{ Str::slug($courseTitle) }}" class="collapse"
                                        aria-labelledby="heading-{{ Str::slug($courseTitle) }}"
                                        data-parent="#contentaccordion">
                                        <div class="contentaccordionbody">
                                            <table class="content-table">
                                                <thead class="content-table-head">
                                                    <tr class="content-table-row">
                                                        <th>Title</th>
                                                        <th>Description
                                                        </th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="content-table-body">
                                                    @foreach ($courseContents as $content)
                                                        <tr>
                                                            <td>
                                                                {{ $content->title }}</td>
                                                            <td>
                                                                {{ $content->description }}</td>
                                                            <td>
                                                                <div style="display: flex; gap:10px">
                                                                    <button type="button"
                                                                        onclick="window.location.href='{{ route('contents.edit', $content->id) }}'"
                                                                        class="contentbtnprimary">Edit</button>

                                                                    <form
                                                                        action="{{ route('contents.destroy', $content->id) }}"
                                                                        method="POST" class="form-content">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btndanger">Delete</button>
                                                                    </form>
                                                                </div>
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

                    </section>

                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        // JavaScript to handle sidebar menu navigation and form visibility
        document.addEventListener("DOMContentLoaded", function() {
            const uploadContentBtn = document.getElementById('uploadContentBtn');
            const uploadContentSection = document.getElementById('uploadContent');
            uploadContentBtn.addEventListener('click', (e) => {
                e.preventDefault();
                uploadContentSection.style.display = 'block';
            });
        });
    </script> --}}
    <script>
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
