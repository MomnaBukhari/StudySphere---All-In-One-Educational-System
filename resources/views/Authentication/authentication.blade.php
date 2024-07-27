@extends('main_layout')
@section('title')
    Join -
@endsection
@section('section1')
    <div class="sectionauthetication">
        <section class="forms-section">
            {{-- <h1 class="join_heading1">Join Now</h1> --}}
            {{-- <h1 class="section-title">Join StudySphere now</h1> --}}
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>
                @endforeach
                {{-- <script>
                    let errorMessages = [
                        @foreach ($errors->all() as $error)
                            "{{ $error }}",
                        @endforeach
                    ];
                    alert(errorMessages.join("\n"));
                </script> --}}
            @endif

            <div>
                @if (session()->has('message'))
                    <span style="color:rgb(255, 0, 0);">
                        {{-- {{ session()->get('message') }} --}}
                        Please go back and fix the errors
                    </span>
                @endif
            </div>

            <div class="forms">
                <div class="form-wrapper is-active">
                    <button type="button" class="switcher switcher-login">
                        Login
                        <span class="underline"></span>
                    </button>
                    <form class="form form-login" action="{{ route('loginForm') }}" method="post">
                        @csrf
                        <fieldset>
                            <legend>Please, enter your email and password for login.</legend>
                            @if ($errors->has('login_error'))
                                {{-- <div class="alert alert-danger" role="alert"> --}}
                                    {{-- {{ $errors->first('login_error') }} --}}
                                {{-- </div> --}}
                            @endif
                            <div class="input-block">
                                <label for="login-email">E-mail</label>
                                <input name='email' id="login-email" type="email" required
                                    value="{{ session('signup_email', old('email')) }}" placeholder="Enter your email">
                            </div>

                            <div class="input-block">
                                <label for="login-password">Password</label>
                                <input name='password' id="login-password" type="password" required
                                    value="{{ session('signup_password', old('password')) }}" placeholder="Enter your password">
                            </div>
                        </fieldset>
                        <button type="submit" class="btn-login">Login</button>
                    </form>
                </div>
                <div class="form-wrapper">
                    <button type="button" class="switcher switcher-signup">
                        Sign Up
                        <span class="underline"></span>
                    </button>
                    <form class="form form-signup" action="{{ route('signupForm') }}" method="post">
                        @csrf
                        <fieldset>
                            <legend>Please, enter your email, password and password confirmation for sign up.</legend>
                            <div class="input-block">
                                <label for="signup-email">E-mail</label>
                                <input name='email' id="signup-email" type="email" required value="{{ old('email') }}" placeholder="Enter your email">
                            </div>
                            @if ($errors->has('email'))
                                <div class="error_display">{{ $errors->first('email') }}</div>
                            @endif
                            <div class="input-block">
                                <label for="signup-password">Password</label>
                                <input name='password' id="signup-password" type="password" value="{{ old('password') }}" required placeholder="Enter your password">
                            </div>
                            @if ($errors->has('password'))
                                <div class="error_display">{{ $errors->first('password') }}</div>
                            @endif
                            <div class="input-block">
                                <label for="signup-confirm-password">Confirm Password</label>
                                <input name="password_confirmation" id="signup-confirm-password" type="password" value="{{ old('password_confirmation') }}" required placeholder="Confirm your password">
                            </div>
                            <div class="input-block">
                                <label for="signup-username">Full Name</label>
                                <input id="signup-username" name='name' type="text" required value="{{ old('name') }}" placeholder="Enter your full name">
                            </div>
                            <div class="input-block">
                                <label for="role" class="form-label">Role</label><br>
                            </div>
                            <div class="radio_buttons">
                                <input type="radio" id="student" name="role" value="student" required {{ old('role') == 'student' ? 'checked' : '' }}>
                                <label for="student">Student</label><br>
                                <input type="radio" id="teacher" name="role" value="teacher" {{ old('role') == 'teacher' ? 'checked' : '' }}>
                                <label for="teacher">Teacher</label><br>
                                <input type="radio" id="guardian" name="role" value="guardian" {{ old('role') == 'guardian' ? 'checked' : '' }}>
                                <label for="guardian">Guardian</label><br>
                            </div>
                        </fieldset>
                        <button type="submit" class="btn-signup">Sign Up</button>
                    </form>

                </div>
            </div>
        </section>
    </div>
    <script type="text/javascript" src="authentication.js"></script>
@endsection
