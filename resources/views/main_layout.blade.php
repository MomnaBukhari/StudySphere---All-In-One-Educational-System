<!DOCTYPE html>
<html>
<head>

    <title> @yield('title')Study Sphere</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">

    {{-- linking of stylesheets --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="homepage.css">
    {{-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('authentication.css') }}">

    @yield('scripts')

</head>

<body class="main">

    <div id="cursor"></div>
    {{-- <div id="squarecursor"></div> --}}
      <div id="smooth-wrapper">
    <div id="smooth-content">
    <div class="wrapper">
    <div class="maincontent">


    <section class="section1" id="NavBar">
        <nav>
            <div class="Navbartpart1">
                <h3 class="logo">
                    <a href="/" style="text-decoration: none; color: inherit;">
                      StudySphere
                    </a>
                 </h3>
            </div>
            <div class= "main_menu">
                <a href="/">Home</a>
                <a href="/authentication">Join Now</a>
                <a href="/help">Help</a>
            </div>
        </nav>
        @yield('section1')
    </section>
    @yield('section1-1')
    @yield('section2')
    @yield('section3')

    </div>

    <footer class="footer">
        All rights reserved @StudySphere
    </footer>

    {{-- javascript file linking below--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="script.js"></script>
    <script src="@yield('javascript')"></script>





</div>
    {{-- the end of the main home layout --}}
</div>
</div>

</body>
</html>
