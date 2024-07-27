@extends($layout)

@section('style', asset('profilestyling/profilestyle.css'))
@section('title', 'Teacher Profile')

@section('section1')
    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="user_info">
                <div class="profile_image">
                    <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('defaultprofilepicture.jpg') }}"
                        alt="Profile Picture">
                </div>
                <p class="user-name">{{ $user->name ?? 'Not Set Yet' }}</p>
                <p class="user-specialization">{{ $user->course_specialization ?? 'Not Set Yet' }}</p>
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
                            </tr>
                            <tr>
                                <th>CNIC: </th>
                                <td>
                                    @if (!empty($user->cnic))
                                        {{ $user->cnic }}
                                    @else
                                        <span style="color:rgb(152, 152, 152)">Not Set Yet</span>
                                    @endif
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
            </div>
        </div>
    </div>

@endsection
