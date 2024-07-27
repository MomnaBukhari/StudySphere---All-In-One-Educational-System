@extends('main_layout')

@section('title')
Help -
@endsection

@section('section1')

<div class="sectionhelp">
    <h1 class="help_heading1">Help</h1>
    <div>
        <p>Welcome to the <a href="/" class="studysphere_link_in_help"><b>Study Sphere</b></a> Help Center! Here you'll find answers to commonly asked questions and helpful resources to enhance your Study Sphere experience. If you can't find the information you're looking for, feel free to reach out to our support team for assistance.</p>
        <br><hr><br>
    </div>
    <h1 class="help_heading1">FAQs</h1>
    <div class="faq">
        <div class="question">
            <h4 class="question_text">What is Study Sphere?</h4>
            <div class="answer">
                <p>Study Sphere is an online platform designed to facilitate interactive learning experiences for teachers, students, and guardians. It offers a wide range of features including course creation, direct communication between users, progress tracking, and more.</p>
            </div>
        </div>
        <div class="question">
            <h4>Who can use Study Sphere</h4>
            <div class="answer">
                <p>Study Sphere is accessible to teachers, students, and guardians. Whether you're an educator looking to create and manage courses, a student seeking to enroll in courses and track progress, or a guardian interested in monitoring a student's academic journey, Study Sphere has something for you.</p>
            </div>
        </div>
        <div class="question">
            <h4>How do I get started with Study Sphere?</h4>
            <div class="answer">
                <p>To get started, simply sign up for a Study Sphere account. You can choose your role as a teacher, student, or guardian during the registration process. Once logged in, you can explore courses, create content, enroll in courses, and utilize other platform features.</p>
            </div>
        </div>
        <div class="question">
            <h4>Is Study Sphere free to use?</h4>
            <div class="answer">
                <p>Yes, Study Sphere offers free environment in educational space.</p>
            </div>
        </div>
    </div>
    <br><hr><br>
    <h1 class="help_heading1">Getting Started</h1>
    <div class="faq">
        <div class="question">
            <h4 class="question_text">How do I sign up for Study Sphere?</h4>
            <div class="answer">
                <p>To create an account on Study Sphere, simply click on the "Sign Up" button on the homepage and follow the prompts to complete the registration process. You can choose to sign up as a teacher, student, or guardian, depending on your role.</p>
            </div>
        </div>
        <div class="question">
            <h4>I forgot my password. How can I reset it?</h4>
            <div class="answer">
                <p>If you've forgotten your password, you can reset it by clicking on the "Forgot Password" link on the login page. You'll receive an email with instructions on how to reset your password.</p>
            </div>
        </div>
    </div>
    <br><hr><br>
    <h1 class="help_heading1">Account Management</h1>
    <div class="faq">
        <div class="question">
            <h4 class="question_text">How can I update my profile information?</h4>
            <div class="answer">
                <p>To update your profile information, navigate to your profile settings from the dashboard. Here you can edit your name, email, profile picture, and other details as needed.</p>
            </div>
        </div>
        <div class="question">
            <h4>I'm having trouble accessing my account. What should I do?</h4>
            <div class="answer">
                <p>If you're experiencing issues accessing your account, please reach out to our support team for assistance. We'll be happy to help you resolve any login or account-related issues.</p>
            </div>
        </div>
    </div>
    <br><hr><br>


</div>
 @endsection

 @section('javascript')
homepage.js
@endsection
