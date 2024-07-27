@extends('guardian.main_layout_guardian')


@section('style', asset('profilestyling/profilestyle.css'))

@section('css')
@endsection

@section('title')
    Guardian -
@endsection

@section('section2')
    <div class="section2">
        <div class="homePageCenter">
            <div class="homePageCenterPart1">
                <h1>Welcome - <b>{{ Auth::user()->name }}</b></h1>
                <h3>
                    Your parenting journey starts here, where you'll watch your child's progress like never
                    before!
                </h3>
                <a class="home_page_signup_button" href="/performance">
                    Check Performace Now!
                </a>
            </div>
        </div>
    </div>
@endsection
