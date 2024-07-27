@extends('student.main_layout_student')
@section('style', asset('studentdashboard.css'))

@section('css')
@endsection

@section('title')
    Student -
@endsection

@section('section2')
    <div class="section2">
        <div class="homePageCenter">
            <div class="homePageCenterPart1">
                <h1>Welcome - <b>{{ Auth::user()->name }}</b></h1>
                <h3>
                    Your learning journey starts here, where you'll learn, practice, and master like never
                    before!
                </h3>
                <a class="home_page_signup_button" href="{{ route('student.availableCourses') }}">
                    Start Learning!
                </a>
            </div>
        </div>
    </div>
@endsection

@section('section3')
    {{-- <div class="student_stats">
        <div>
            <h1 class="student_stats_box">
                Followed Courses
            </h1>
            <p>
                {{ $total_courses }}
            </p>
        </div>
        <div>
            <h1>
                Quiz Given
            </h1>
            <p>
                 {{ $total_students }}
            </p>
        </div>
        <div>
            <h1>
                Assignments Given
            </h1>
            <p>
                {{ $total_assessments }}
            </p>
        </div>
        <div>
            <h1>
                Content Uploaded
            </h1>
            <p>
               {{ $total_content }}
            </p>
        </div>
    </div> --}}


    <div class="section3">
        <div class="About">
            <h1>Many Reasons to Get Start Today!</h1>
        </div>
        <div class="quote-boxes-container">
            <div class="quote-box">
                {{-- <a href="" class="quote_link"> --}}
                <h4>Achieve Your Goals</h4>
                <p>"Set your learning goals, track your progress, and celebrate your achievements with personalized
                    milestones."</p>
                {{-- </a> --}}
            </div>
            <div class="quote-box">
                {{-- <a href="" class="quote_link"> --}}
                <h4>Connect & Collaborate</h4>
                <p>"Chat now with you favourite tutor, participate in Discussion Boards, and collaborate on projects with
                    peers from around the globe."</p>
                {{-- </a> --}}
            </div>
            <div class="quote-box">
                {{-- <a href="#guardian" class="quote_link"> --}}
                <h4>Flexible Learning</h4>
                <p>"Learn anytime, anywhere with our flexible course schedules and mobile-friendly platform."</p>
                {{-- </a> --}}
            </div>
        </div>
    </div>
@endsection



@section('section5')
    <div class="section5">
        <div class="About">
            <h1>Only 4 Steps to Get Started</h1>
        </div>
        <div class="carousel">
            <div class="carousel-slide" id="slide1">
                <h4>1: Plan Your Learning</h4>
                <p>Start with your curiosity and goals. Use our system to find the best courses for your
                    needs.</p>
                <p>The way you learn — how you approach it — is entirely up to you.</p>
                <br>
                <p style="font-weight: bold"> How we help you </p>
                <p>We provide a wealth of resources to help you choose the right course. Our personalized dashboard keeps
                    you organized.</p>
            </div>
            <div class="carousel-slide" id="slide2">
                <h4>2: Engage with Lessons</h4>
                <p>Use any device to access your courses. Whether it’s a smartphone, tablet, or computer, you’re ready to
                    learn.</p>
                <p>If you prefer, you can even download materials for offline study. We recommend dedicating a couple of
                    hours a week for the best experience.</p>
                <br>
                <p style="font-weight: bold">How we help you</p>
                <p>Our support team is here to assist you throughout your learning journey and provide feedback on your
                    progress.</p>
            </div>
            <div class="carousel-slide" id="slide3">
                <h4>3: Apply Your Knowledge</h4>
                <p>Share your achievements by applying what you’ve learned in real-world scenarios and projects.</p>
                <p>Join our community to exchange ideas and gain insights from other learners.</p>
            </div>
            <div class="carousel-slide" id="slide4">
                <h4>4: Celebrate Your Success!</h4>
                <p>Complete your course and earn your certificate. Share it with your network to showcase your new skills.
                </p>
            </div>
        </div>
        <div class="crousal_button">
            <button id="prev">
                < </button>
                    <button id="next">
                        >
                    </button>
        </div>
    </div>
@endsection

@section('javascript')
    {{ asset('studentdashboard.js') }}
@endsection
