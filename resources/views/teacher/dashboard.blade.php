@extends('teacher.main_layout_teacher')
@section('style', asset('teacherdashboard.css'))

@section('css')
@endsection

@section('title')
    Teacher -
@endsection

@section('section2')
    <div class="section2">
        <div class="homePageCenter">
            <div class="homePageCenterPart1">
                <h1>Welcome - <b>{{ Auth::user()->name }}</b></h1>
                <h3>
                    Your teaching journey starts here, where you'll inspire, engage, and empower your students like never
                    before!
                </h3>
                <a class="home_page_signup_button" href="/teacher_course">
                    Create new Course!
                </a>
            </div>
        </div>
    </div>
@endsection


@section('section3')
    <div class="teacher_stats">
        <div>
            <h1 class="teacher_stats_box">
                Total Courses
            </h1>
            <p>
                {{ $total_courses }}
            </p>
        </div>
        <div>
            <h1>
                Your Students
            </h1>
            <p>
                {{ $total_students }}
            </p>
        </div>
        <div>
            <h1>
                Total Assesments
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
    </div>


    <div class="section3">
        <div class="About">
            <h1>Many Reasons to Get Start Today!</h1>
        </div>
        <div class="quote-boxes-container">
            <div class="quote-box">
                {{-- <a href="" class="quote_link"> --}}
                <h4>Teach Your Way</h4>
                <p>"Publish the course you want, in the way you want, and always have control of your own
                    content."</p>
                {{-- </a> --}}
            </div>
            <div class="quote-box">
                {{-- <a href="" class="quote_link"> --}}
                <h4>Inspire learners</h4>
                <p>"Teach what you know and help learners explore their interests, gain new skills, and advance
                    their
                    careers."</p>
                {{-- </a> --}}
            </div>
            <div class="quote-box">
                {{-- <a href="#guardian" class="quote_link"> --}}
                <h4>Build Your Community</h4>
                <p>"Expand your Professional Network, Build your Expertise, Connect with diverse Students and
                    Guardians"</p>
                {{-- </a> --}}
            </div>
        </div>
    </div>
@endsection


@section('section5')
    <div class="section5">
        <div class="About">
            <h1>Only 4 Steps to get Start</h1>
        </div>
        <div class="carousel">
            <div class="carousel-slide" id="slide1">
                <h4>1: Plan your Content</h4>
                <p>You start with your passion and knowledge. Then choose a promising topic with the help of our
                    Marketplace
                    Insights tool.</p>
                <p>The way that you teach — what you bring to it — is up to you.</p>
                <br>
                <p style="font-weight: bold"> How we help you </p>
                <p>We offer plenty of resources on how to create your first course. And, our instructor
                    dashboard and
                    curriculum pages help keep you organized.</p>
            </div>
            <div class="carousel-slide" id="slide2">
                <h4>2: Record Your Lessons</h4>
                <p>Use basic tools like a smartphone or a DSLR camera. Add a good microphone and you’re ready to
                    start.</p>
                <p>If you don’t like being on camera, just capture your screen. Either way, we recommend two
                    hours or more
                    of video for a paid course.</p>
                <br>
                <p style="font-weight: bold">How we help you.</p>
                <p>Our support team is available to help you throughout the process and provide feedback on test
                    videos.</p>
            </div>
            <div class="carousel-slide" id="slide3">
                <h4>3: Launch Your Course</h4>
                <p>Gather your first ratings and reviews by promoting your course through social media and your
                    professional
                    networks.</p>

                <p>Your course will be discoverable in our marketplace where you earn revenue from each paid
                    enrollment.</p>
            </div>
            <div class="carousel-slide" id="slide4">
                <h4>4: Your Course is Ready!</h4>
                <p>Course is now all set and ready to be share</p>
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
    {{ asset('teacherdashboard.js') }}
@endsection
