@extends('teacher.main_layout_teacher')
@section('style', asset('profilestyling/profilestyle.css'))
@section('title')
    Teacher -
@endsection

@section('section1')
    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="user_info">
                {{-- <img src="{{ $user->profile_picture?? asset('images/default-profile-picture.jpg') }}" alt="ProfilePicture"> --}}
                <div class="profile_image">
                    <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('defaultprofilepicture.jpg') }}"
                        alt="Profile Picture">
                </div>

                {{-- <div class="user-name"> --}}
                <p class="user-name">{{ $user->name ?? 'Not Set Yet' }}</p>
                {{-- </div> --}}
                <p class="user-specialization">{{ $user->course_specialization ?? 'Not Set Yet' }}</p>
            </div>
            <div class="side-menu-list">
                <a href="/teacher/profile" class="side-menu-list-item side-menu-list-item-action">Show Profile</a>
                <a href="#Edit-profile" class="side-menu-list-item side-menu-list-item-action">Edit Profile </a>
                <a href="#account-security" class="side-menu-list-item side-menu-list-item-action">Account Security</a>
                {{-- <a href="#privacy-settings" class="side-menu-list-item side-menu-list-item-action">Privacy Settings</a>
                <form action="{{ route('teacher.logout') }}" method="POST"
                    class="side-menu-list-item side-menu-list-item-action">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="side-menu-list-item">Logout</a>
                </form> --}}
                <form action="{{ route('delete.account') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                    @csrf
                   <a class="side-menu-list-item side-menu-list-item-action"><button type="submit" style="background-color: rgb(240, 207, 207)">Delete Account</button></a>
                </form>
            </div>
        </div>

        {{-- Profile section Part 2 --}}


        <div class="profile-page-part2">
            <div class="profile-display">
                <section id="show-profile">
                    {{-- <h1 class="heading_profile">Profile</h1> --}}
                    {{-- @dd($user) --}}
                    <div class="show_profile_info">
                        <div class="show_profile_info_about">
                            <h1>About: </h1>
                            @if (!empty($user->bio))
                                <p>{{ $user->bio }}</p>
                            @else
                                <p><span style="color:rgb(152, 152, 152)">Not Set Yet</span></p>
                            @endif
                        </div>

                        <table>
                            <tr>
                                <th>Email:</th>
                                <td>
                                    @if (!empty($user->email))
                                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                    @else
                                        <span style="color:rgb(152, 152, 152)">Not Set Yet</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- @if (!empty($user->email))
                                        <a href="mailto:{{ $user->email }}" class="mail-send-button">Send Mail</a>
                                    @endif --}}
                                </td>
                            </tr>
                            <tr>
                                <th>Role: </th>
                                <td>{{ $user->role ?? 'Not Set Yet' }}</td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td>
                                    @if (!empty($user->address))
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($user->address) }}"
                                            target="_blank">{{ $user->address }}</a>
                                    @else
                                        <span style="color:rgb(152, 152, 152)">Not Set Yet</span>
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($user->address))
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($user->address) }}"
                                            target="_blank" class="mail-send-button">Locate now</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>CNIC: </th>
                                <td>
                                    @if (!empty($user->cnic))
                                        {{ $user->cnic }}
                                    @else
                                        <span style="color:rgb(152, 152, 152)">Not Set Yet</span>
                                    @endif
                                    {{-- {{ $user->cnic ?? 'Not Set Yet' }} --}}
                                </td>
                            </tr>
                            <tr>
                                <th>Gender: </th>
                                <td>
                                    @if (!empty($user->gender))
                                        {{ $user->gender }}
                                    @else
                                        <span style="color:rgb(152, 152, 152)">Not Set Yet</span>
                                    @endif

                                    {{-- {{ $user->gender ?? 'Not Set Yet' }} --}}
                                </td>
                            </tr>
                            <tr>
                                <th>Contact:</th>
                                <td>
                                    @if (!empty($user->contact_number))
                                        <a href="tel:{{ $user->contact_number }}">{{ $user->contact_number }}</a>
                                    @else
                                        <span style="color:rgb(152, 152, 152)">Not Set Yet</span>
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($user->contact_number))
                                        <a href="tel:{{ $user->contact_number }}" class="mail-send-button">Call Now</a>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Social Media Link:</th>
                                <td>
                                    @php
                                        $socialMediaLink = $user->social_media_links ?? '';

                                        // Check if the link starts with http:// or https://
                                        if (!preg_match('~^(?:f|ht)tps?://~i', $socialMediaLink)) {
                                            $socialMediaLink = 'https://' . $socialMediaLink;
                                        }
                                    @endphp

                                    @if (!empty($socialMediaLink))
                                        <a href="{{ $socialMediaLink }}" target="_blank">{{ $socialMediaLink }}</a>
                                    @else
                                    <span style="color:rgb(152, 152, 152)">Not Set Yet</span>
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($socialMediaLink))
                                        <a href="{{ $socialMediaLink }}" target="_blank" class="mail-send-button">Visit
                                            Link</a>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </section>

                <!-- Profile Basics Section -->
                <section id="Edit-profile" style="display: none;">
                    <!--@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif-->
                    <form id="edit-profile-form" action="{{ route('teacher.profile.store') }}" method="POST"
                        enctype="multipart/form-data">

                        {{-- <form action="{{ route('teacher.profile.store') }}" method="POST" enctype="multipart/form-data"> --}}
                        @csrf
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name"
                                value="{{ $user->name ?? '' }}" placeholder="Enter New Name">
                        </div>
                        <div class="form-group">
                            <label for="course_specialization">Course Specialization</label>
                            <input type="text" class="form-control" id="course_specialization"
                                name="course_specialization" value="{{ $user->course_specialization ?? '' }}"
                                placeholder="Enter your Major Course"required>
                        </div>
                        <div class="form-group">
                            <label for="profile_picture">Profile Picture</label>
                            <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
                        </div>
                        <div class="form-group">
                            <label for="bio">About</label>
                            <textarea class="form-control" id="bio" name="bio" placeholder="Tell about yourself, interests and hobbies">{{ $user->bio ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="Enter Google Registered Location for better experience"
                                value="{{ $user->address ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="cnic">CNIC</label>
                            <input type="text" class="form-control" id="cnic" name="cnic"
                                placeholder="Enter Your National ID card number" value="{{ $user->cnic ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male
                                </option>
                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="contact_number">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number"
                                placeholder="Enter Contact Number" value="{{ $user->contact_number ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="social_media_links">Social Media Links</label>
                            <input type="text" class="form-control" id="social_media_links" name="social_media_links"
                                placeholder="https://www.studysphere.com/" value="{{ $user->social_media_links ?? '' }}">
                        </div>
                        <button type="button" class="profilebtn" onclick="confirmSave()">Save</button>
                        <button type="button" class="profilebtn" onclick="confirmBack()">Back</button>
                        {{-- <button type="submit" class="profilebtn">Save</button>
                        <button type="button" onclick="window.location.href='/teacher/profile'"
                            class="profilebtn">Back</button> --}}
                    </form>
                </section>
                <!-- Account Security Section -->
                <section id="account-security" style="display: none;">
                    <h1 class="heading_profile">Account Security</h1>
                    <form action="{{ route('teacher.profile.updatePassword') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="old_password">Old Password</label>
                            <input type="password" class="form-control" id="old_password" name="old_password"
                                placeholder="Please enter your old Password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                placeholder="Please enter your new Password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation"
                                name="new_password_confirmation" placeholder="Confirm your new Password" required>
                        </div>
                        <button type="submit" class="profilebtn">Change Password</button>
                    </form>
                </section>
                <!-- Privacy Settings Section -->
                <section id="privacy-settings" style="display: none;">
                    <h1 class="heading_profile">Privacy Settings</h1>
                    <form action="{{ route('teacher.profile.updatePrivacy') }}" method="POST">
                        @csrf
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="show_profile" name="show_profile">
                            <label class="form-check-label" for="show_profile">
                                Show your profile to logged-in users
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="show_courses" name="show_courses">
                            <label class="form-check-label" for="show_courses">
                                your profile page
                            </label>
                        </div>
                        <button type="submit" class="profilebtn">Save Settings</button>
                    </form>

                </section>
            </div>
        </div>

    </div>



    <script>
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

        function confirmSave() {
            if (confirm('Are you sure you want to save the changes?')) {
                document.getElementById('edit-profile-form').submit();
            }
        }

        function confirmBack() {
            if (confirm('Are you sure you want to go back? Any unsaved changes will be lost.')) {
                window.location.href = '/teacher/profile';
            }
        }
    </script>
@endsection
