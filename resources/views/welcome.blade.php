@extends('main_layout')


{{-- @section('title')
    Home -
@endsection --}}


@section('section1')
    <div class="homePageCenter">
        <div class="homePageCenterPart1">
            <h1>Ready to Simplify Your Educational Journey?</h1>
            <p>
                StudySphere is here to help! With our user-friendly platform, you can navigate Teaching, Learning and
                Parenting with ease.
                <span class="highlight">Let's explore StudySphere a bit more together
                    by doing hands-on interaction.</span> Join now and see how we can revolutionize your educational
                experience!
            </p>
            {{-- <button class="home_page_signup_button"> --}}
            <a class="home_page_signup_button" href="/authentication">
                Sign Up Today!
            </a>
            {{-- </button> --}}
        </div>
        <div class="homePageCenterPart2">
            <img src="{{ asset('Illustrations/TeacherDashboard2.png') }}" alt="StudySphere Illustration">
            <div class="scrollcirlce">Scroll</div>
        </div>

    </div>
@endsection

@section('section1-1')
    <div class="memberSectionparent">
        <div class="memberSection">
            <h3>Member of StudySphere World?</h3>
            <p>
                Welcome back! As a valued member of the StudySphere community, you have access to resources and tools
                designed to enhance your educational journey. Click the link below to access your dashboard and continue
                your learning experience.
            </p>
            <a class="dashboardLink" href="{{ route('redirect.dashboard') }}">Go to Dashboard</a>
        </div>
    </div>

    <!-- Dynamic statistics section -->
    <div class="dynamic-stats">
        <h2 class="dynamic-stats-heading">Get Inspired by Others</h2>
        <div class="dynamic-stats-section">

            <div class="dynamic-stats-box stats-box1">
                <ul>
                    <li class="counter" data-target="{{ $teachersCount }}">{{ $teachersCount }}+ TEACHERS</li>
                </ul>
            </div>
            <div class="dynamic-stats-box stats-box2">
                <ul>
                    <li class="counter" data-target="{{ $studentsCount }}">{{ $studentsCount }}+ STUDENTS</li>
                </ul>
            </div>
            <div class="dynamic-stats-box stats-box3">
                <ul>
                    <li class="counter" data-target="{{ $guardiansCount }}">{{ $guardiansCount }}+ GUARDIANS</li>
                </ul>
            </div>
            <div class="dynamic-stats-box stats-box4">
                <ul>
                    <li>More than {{ $coursesCount }} courses are available.</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('section2')
    <section>
        <div class="section2">
            {{-- <div class="divbigtext">
                <h1 class="bigtext">All - In - One Educational Space to Learn - Connect - Excel</h1>
            </div> --}}
            <div class="benefits">
                <H2 class="benefits_heading">What Benefits You will get?</H2>
                {{--  <p class="benefits_text">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repellendus eaque a iusto? Animi facilis earum cumque, deserunt impedit distinctio atque est doloremque minus et tenetur explicabo corrupti itaque? Provident, expedita!</p> --}}
            </div>
            <div class="boxes">
                <div class="elem line1 left">
                    <h4>Enhanced Collaboration</h4>
                    <p>
                        Study Sphere fosters seamless collaboration of educators with Learners and Guardians, promoting an
                        interactive and engaging learning environment.
                    </p>
                </div>
                <div class="elem line2 right">
                    <h4>Tailored User Experience</h4>
                    <p>
                        Study Sphere offers role-based dashboards customized to the needs and responsibilities of educators
                        and learners, ensuring a personalized and efficient user experience.
                    </p>
                </div>
                <div class="elem line3 left">
                    <h4>Comprehensive Analytics</h4>
                    <p>
                        Study Sphere provides detailed analytics and insights, allowing educators to track student progress,
                        identify areas for improvement, and make data-driven decisions to enhance teaching effectiveness.
                    </p>
                </div>
                <div class="elem line4 right">
                    <h4>Personalized Learning Pathways</h4>
                    <p>
                        With Study Sphere, users can customize their learning experiences, accessing tailored resources and
                        content to suit their individual needs and preferences.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('section3')
    <section>
        <div class="section3">
            {{-- <div class="divbigtext">
                <h1 class="bigtext">All - In - One Educational Space to Learn - Connect - Excel</h1>
            </div> --}}
            <div class="rollbaseddasboard">
                <div class="rollbaseddasboardpart1">
                    <H2 class="rollbaseddasboardheading">
                        What More You can Get?
                    </H2>
                    <p class="rollbaseddasboardparagraph">
                        Your own Dashboard Experience!
                    </p>

                    <a class="rollbaseddashboardbutton" href="{{ route('redirect.dashboard') }}">
                        My Dashboard
                    </a>
                </div>
                <div class="rollbaseddasboardpart2">
                    <img src="{{ asset('Illustrations/Dashboard.png') }}" alt="Dashboard Showcase Illustration">
                </div>
            </div>
            <div class="rolefeatureintro">
                <div class="roleintrocards">
                    <div class="cards roleteacherdashboard">
                        <div class="card-text">StudySphere for Teachers</div>
                        <div class="card-button"><a href="{{ route('teacher_instructions') }}">Instructions</a></div>
                    </div>
                    <div class="cards rolestudentdashboard">
                        <div class="card-text">StudySphere for Students</div>
                        <div class="card-button"><a href="{{ route('student_instructions') }}">Instructions</a></div>
                    </div>
                    <div class="cards roleguardiandashboard">
                        <div class="card-text">StudySphere for Guardians</div>
                        <div class="card-button"><a href="{{ route('guardian_instructions') }}">Instructions</a></div>
                    </div>
                </div>
            </div>

                <div class="rollbaseddasboard" style="padding-bottom:0%">
                    <div class="rollbaseddasboardpart1">
                        <h2>
                            So What are you waiting for?
                        </h2>
                        <p>
                            Join the StudySphere community today and start your journey towards academic excellence!
                        </p>

                        <a class="home_page_signup_button" href="/authentication">
                            Join Today!
                        </a>
                    </div>
                    <div class="rollbaseddasboardpart2">
                        <img src="{{ asset('Illustrations/joinnow.png') }}" alt="Dashboard Showcase Illustration">
                    </div>
                </div>
            </div>
    </section>
@endsection

@section('FullContent')
@endsection

@section('javascript')
    homepage.js
@endsection
