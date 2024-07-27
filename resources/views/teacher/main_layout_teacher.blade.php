<head>
    <title> @yield('title')Study Sphere</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--    <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <link rel="stylesheet" href="{{ asset('teacherdashboard.css') }}">
    <link rel="stylesheet" href="@yield('style')">
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    {{-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @yield('css')
</head>

<body>
    {{-- <div id="cursor"></div> --}}

    <div>
        <nav class='main-nav'>
            <div class='logo'>
                <h2>
                    <span><a href="/" style="text-decoration: none; color: inherit;">S</span>tudy
                    <span>S</span>phere</a>
                    - <a style="text-decoration: none; color: inherit;" href="/teacher/dashboard">Teacher</a>
                </h2>
            </div>
            {{-- <div class= {showMediaIcon? "menu-link mobile-menu-link" :"menu-link"}>  --}}
            <div class="menu-link">
                <a href="{{ route('teacher.profile') }}">Profile</a>
                <a href="/teacher_course">Courses</a>
                <a href="/teacher_content">Content</a>
                <a href="/teacher_assesment">Assesment</a>
                <a href="/manage_students">Manage Students</a>
                <a href="/teacher/performance">Performance</a>
                <a href="/discussionboard">Discussion Board</a>
                <a href="/teacher_chat">Chat</a>
                <form action="{{ route('teacher.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class=" logoutbtn">Logout</button>
                </form>
            </div>
        </nav>
    </div>

    <div class="childNavBar">
        @yield('childNavBar')
    </div>

    <div class="content">
        @yield('content')
    </div>
    @yield('section1')
    @yield('section2')
    @yield('section3')
    @yield('section4')
    @yield('section5')
    @yield('section6')

    {{-- <footer class="footer">
    All rights reserved @StudySphere
</footer> --}}


    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    {{-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('script.js') }}"></script>

    <script src="@yield('javascript')"></script>
    @yield('script')
    @yield('javascript2')
</body>

</html>
