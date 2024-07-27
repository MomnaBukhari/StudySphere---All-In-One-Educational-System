@extends('student.main_layout_student')
@section('style', asset('profilestyling/profilestyle.css'))
@section('title')
Student - Profile
@endsection

@section('section1')
    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="user_info">
                <div class="profile_image">
                    <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('defaultprofilepicture.jpg') }}" alt="Profile Picture">
                </div>
                <p class="user-name">{{ $user->name ?? 'Not Set Yet' }}</p>
                <p class="user-specialization"><b>User ID: </b>{{ $user->id ?? 'Not Set Yet' }}</p>
            </div>
            <div class="side-menu-list">
                <a href="{{ route('student.profile') }}" class="side-menu-list-item side-menu-list-item-action">Show Profile</a>
                <a href="#Edit-profile" class="side-menu-list-item side-menu-list-item-action">Edit Profile</a>
                <a href="#account-security" class="side-menu-list-item side-menu-list-item-action">Account Security</a>
                {{-- <form action="{{ route('student.deleteAccount') }}" method="POST" class="side-menu-list-item side-menu-list-item-action">
                    @csrf
                    @method('DELETE')
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="side-menu-list-item">Delete Account</a>
                </form> --}}
                {{-- <section id="delete-account"> --}}
                    <form action="{{ route('student.deleteAccount') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                        @csrf
                       <a class="side-menu-list-item side-menu-list-item-action"><button type="submit" style="background-color: rgb(240, 207, 207)">Delete Account</button></a>
                    </form>
                {{-- </section> --}}
            </div>
        </div>

        <div class="profile-page-part2">
            <div class="profile-display">
                <section id="show-profile">
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
                                    @if (!empty($user->email))
                                        <a href="mailto:{{ $user->email }}" class="mail-send-button">Send Mail</a>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Role:</th>
                                <td>{{ $user->role ?? 'Not Set Yet' }}</td>
                            </tr>

                            <tr>
                                <th>Address:</th>
                                <td>
                                    @if (!empty($user->address))
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($user->address) }}" target="_blank">{{ $user->address }}</a>
                                    @else
                                        <span style="color:rgb(152, 152, 152)">Not Set Yet</span>
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($user->address))
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($user->address) }}" target="_blank" class="mail-send-button">Locate Now</a>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>CNIC:</th>
                                <td>
                                    @if (!empty($user->cnic))
                                        {{ $user->cnic }}
                                    @else
                                        <span style="color:rgb(152, 152, 152)">Not Set Yet</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Gender:</th>
                                <td>
                                    @if (!empty($user->gender))
                                        {{ $user->gender }}
                                    @else
                                        <span style="color:rgb(152, 152, 152)">Not Set Yet</span>
                                    @endif
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
                                        <a href="{{ $socialMediaLink }}" target="_blank" class="mail-send-button">Visit Link</a>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </section>

                <!-- Profile Basics Section -->
                <section id="Edit-profile" style="display: none;">
                    <form action="{{ route('student.profile.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $user->name ?? '' }}" placeholder="Enter New Name">
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $user->address ?? '' }}" placeholder="Enter New Address">
                        </div>

                        <div class="form-group">
                            <label for="cnic">CNIC</label>
                            <input type="text" class="form-control" id="cnic" name="cnic" value="{{ $user->cnic ?? '' }}" placeholder="Enter New CNIC">
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <input type="text" class="form-control" id="gender" name="gender" value="{{ $user->gender ?? '' }}" placeholder="Enter New Gender">
                        </div>

                        <div class="form-group">
                            <label for="contact_number">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ $user->contact_number ?? '' }}" placeholder="Enter New Contact Number">
                        </div>

                        <div class="form-group">
                            <label for="social_media_links">Social Media Links</label>
                            <input type="text" class="form-control" id="social_media_links" name="social_media_links" value="{{ $user->social_media_links ?? '' }}" placeholder="Enter New Social Media Links">
                        </div>

                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" placeholder="Enter New Bio">{{ $user->bio ?? '' }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="profile_picture">Profile Picture</label>
                            <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </section>

                <!-- Account Security Section -->
                <section id="account-security" style="display: none;">
                    <form action="{{ route('student.profile.updatePassword') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
@endsection
