<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authware;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChatController;

use App\Http\Middleware\CheckUserRole;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;

// Public Routes

Route::get('/user/{id}', [UserController::class, 'showTeacherProfile'])->name('teacher.viewProfile');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [UserController::class, 'welcomepage']);


Route::get('/help', function () {
    return view('help.help');
});

Route::get('/join', function () {
    return view('Authentication.join');
});

Route::get('/teacher-instructions', function () {
    return view('teacher_instructions');
})->name('teacher_instructions');

Route::get('/student-instructions', function () {
    return view('student_instructions');
})->name('student_instructions');

Route::get('/guardian-instructions', function () {
    return view('guardian_instructions');
})->name('guardian_instructions');

Route::get('/authentication', function () {
    return view('Authentication.authentication');
})->name('authenticationForm');



Route::get('/redirect-dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('authenticationForm');
    }

    switch ($user->role) {
        case 'student':
            return redirect()->route('student.dashboard');
        case 'teacher':
            return redirect()->route('teacher.dashboard');
        case 'guardian':
            return redirect()->route('guardian.dashboard');
        default:
            return redirect()->route('authenticationForm');
    }
})->name('redirect.dashboard');



Route::group(['middleware' => Authware::class], function () {
    // Chat routes
    Route::get('/chat/initiate/{id}', [ChatController::class, 'initiateChat'])->name('initiate');
    Route::post('/message/submit/{pe}', [ChatController::class, 'addMessage'])->name('add-message');
    Route::get('/chat/{id?}', [ChatController::class, 'showChat']);


    Route::get('/users', function () {
        $users = User::all();

        return view('teacher.users', compact('users'));
    });

});



// Authentication Routes
Route::post('/login', [UserController::class, 'loginForm'])->name('loginForm');
Route::post('/signup', [UserController::class, 'signupForm'])->name('signupForm');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Role-Based Routes
Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', [UserController::class, 'redirectBasedOnRole'])->name('redirect.dashboard');
    Route::get('/profile', [UserController::class, 'showProfileForm'])->name('profile.show');
    Route::post('/profile/update', [UserController::class, 'storeProfile'])->name('profile.update');
});


// Role-Specific Routes
Route::middleware(['role:student'])->group(function () {
    Route::get('/student/dashboard', [UserController::class, 'studentDashboard'])->name('student.dashboard');
    //// Profile Routes of student
    Route::get('student_profile', [UserController::class, 'showProfileForm'])->name('student.profile'); // Show profile form
    Route::post('student/profile/store', [UserController::class, 'storeProfile'])->name('student.profile.store'); // Store profile data
    Route::post('student/profile/updatePassword', [UserController::class, 'updatePassword'])->name('student.profile.updatePassword'); // Update password
    Route::post('student/profile/updatePrivacy', [UserController::class, 'updatePrivacy'])->name('student.profile.updatePrivacy'); // Update privacy settings
    Route::post('student/logout', [UserController::class, 'logout'])->name('student.logout'); //
    Route::post('student/deleteAccount', [UserController::class, 'deleteAccount'])->name('student.deleteAccount');

    Route::get('student/courses/available', [CourseController::class, 'availableCourses'])->name('student.availableCourses');
    Route::post('student/follow-course', [CourseController::class, 'followCourses'])->name('student.followCourses');
    Route::get('student/my-courses', [CourseController::class, 'myCourses'])->name('student.myCourses');
    Route::post('student/unfollow-course', [CourseController::class, 'unfollowCourse'])->name('student.unfollowCourse');

    Route::get('student_content', [ContentController::class, 'showContents'])->name('contents');
    Route::get('content/download/{filename}', [ContentController::class, 'downloadContent'])->name('content.download');
    //   Route::get('/performance',[AssessmentController::class, 'performance'])->name('assessment');
    Route::get('student_assessments', [AssessmentController::class, 'showAssessments'])->name('assessment_show');
    Route::get('download/assessment/{filename}', [AssessmentController::class, 'download'])->name('download.assessment');
    Route::post('/assessments/{assessment}/answers', [AssessmentController::class, 'store1'])->name('answers.store');
    Route::get('/assessments/{assessment}/view-answer', [AssessmentController::class, 'viewAnswer'])->name('assessments.view-answer');
    Route::get('/student/performances', [PerformanceController::class, 'showStudentPerformances'])->name('student.performance');
    Route::get('student_chat', function () {
        $users = User::where('role', 'teacher')->get();
        return view('student.users', compact('users'));
    });
    Route::get('/student_discussionboard', [PostController::class, 'studentdiscussionBoard'])->name('studentdiscussion.board');
Route::get('/student/post/{slug}', [PostController::class, 'display'])->name('post.display');
Route::post('student/post/{postId}/comment', [CommentController::class, 'store'])->name('student.comment')->middleware('auth');
Route::post('/post/{postId}/comment', [CommentController::class, 'store'])->name('post.comment1');


    Route::get('/chat', [ChatController::class, 'inbox'])->name('inbox');
    // Route::get('/student/chat/{id?}', [ChatController::class, 'showChat'])->name('student.chat');
});


Route::middleware(['role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');
    Route::get('teacher/profile', [UserController::class, 'showProfileForm'])->name('teacher.profile'); // Show profile form
    Route::post('teacher/profile/store', [UserController::class, 'storeProfile'])->name('teacher.profile.store'); // Store profile data
    Route::post('teacher/profile/updatePassword', [UserController::class, 'updatePassword'])->name('teacher.profile.updatePassword'); // Update password
    Route::post('teacher/profile/updatePrivacy', [UserController::class, 'updatePrivacy'])->name('teacher.profile.updatePrivacy'); // Update privacy settings
    Route::post('teacher/logout', [UserController::class, 'logout'])->name('teacher.logout'); // Logout
    Route::post('/delete-account', [UserController::class, 'deleteAccount'])->name('delete.account');
    Route::get('teacher_course', function () {
        return view('teacher.course');
    });
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store'); // Updated route for storing courses
    Route::get('/courses', [CourseController::class, 'index1'])->name('courses.index1');
    Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->name('teacher.Course_Edit');
    Route::put('/courses/{id}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');
    Route::get('teacher_content', function () {
        return view('teacher.content');
    });
    Route::get('/contents/create', [ContentController::class, 'create'])->name('contents.create');
    Route::post('/contents', [ContentController::class, 'store'])->name('contents.store');
    Route::get('/contents', [ContentController::class, 'index'])->name('contents.index');
    Route::get('/contents/{content}/edit', [ContentController::class, 'edit'])->name('contents.edit');
    Route::put('/contents/{content}', [ContentController::class, 'update'])->name('contents.update');
    Route::delete('n/contents/{content}', [ContentController::class, 'destroy'])->name('contents.destroy');
    Route::get('teacher_assesment', function () {
        return view('teacher.assesment');
    });
    Route::get('/assessments', [AssessmentController::class, 'index'])->name('assessments.index');
    Route::post('/assessments/upload', [AssessmentController::class, 'store'])->name('assessments.store');
    Route::get('/assessments/{assessment}', [AssessmentController::class, 'show'])->name('assessments.show');
    Route::put('/assessments/{assessment}', [AssessmentController::class, 'update'])->name('assessments.update');
    Route::delete('/assessments/{assessment}', [AssessmentController::class, 'destroy'])->name('assessments.destroy');
    Route::get('/manage_students', [TeacherController::class, 'manage'])
        ->name('teacher.manage_students');
    Route::post('/teacher/manage_students/remove_student', [TeacherController::class, 'removeStudentFromCourse'])->name('teacher.remove_student');
    Route::get('/teacher/performance', [PerformanceController::class, 'index'])->name('performance.main');
    Route::get('performance/create/{course_id}', [PerformanceController::class, 'create'])->name('performance.create');
    Route::post('/performance/uploaded-students', [PerformanceController::class, 'getUploadedStudents'])->name('performance.uploadedStudents');
    Route::post('/student/performance', [PerformanceController::class, 'store'])->name('performance.store');

    Route::get('teacher_chat', function () {
        $users = User::all();
        return view('teacher.users', compact('users'));
    });

    Route::get('/chat', [ChatController::class, 'inbox'])->name('inbox');

    //
// Teacher Discussion Board
    Route::get('/dd', [PostController::class, 'index'])->name('post.welcome');
    Route::get('/discussionboard', [PostController::class, 'discussionBoard'])->name('discussion.board');
    Route::get('/teacher/post/create', [PostController::class, 'create'])->name('teacher.post.create');
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/{slug}', [PostController::class, 'view'])->name('post.view');
    Route::post('/teacher/post/{postId}/comment', [CommentController::class, 'store'])->name('post.comment');
    Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/post/{id}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/{id}', [PostController::class, 'destroy'])->name('post.destroy');
});



Route::middleware(['role:guardian'])->group(function () {
    Route::get('/guardian/dashboard', [UserController::class, 'guardianDashboard'])->name('guardian.dashboard');
    Route::get('guardian_profile', [UserController::class, 'showProfileForm'])->name('guardian.profile'); // Show profile form
    Route::post('guardian/profile/store', [UserController::class, 'storeProfile'])->name('guardian.profile.store'); // Store profile data
    Route::post('guardian/profile/updatePassword', [UserController::class, 'updatePassword'])->name('guardian.profile.updatePassword'); // Update password
    Route::post('guardian/profile/updatePrivacy', [UserController::class, 'updatePrivacy'])->name('guardian.profile.updatePrivacy'); // Update privacy settings
    Route::post('guardian/logout', [UserController::class, 'logout'])->name('guardian.logout'); // Logout

    Route::get('guardian_chat', function () {
        $users = User::where('role', 'teacher')->get();
        return view('guardian.users', compact('users'));
    });

    Route::get('/chat', [ChatController::class, 'inbox'])->name('inbox');
    Route::post('/performance', [GuardianController::class, 'getPerformance']);

    Route::get('/followed_details', [GuardianController::class, 'showFollowedDetailsForm'])->name('followed_details');
Route::post('/followed_details', [GuardianController::class, 'showFollowedDetails'])->name('show_followed_details');

    Route::get('/performance', function () {
        return view('guardian.performance');
    });
    // Route::post('/performance', [GuardianController::class, 'getPerformance']);
    Route::post('/guardian/delete-account', [UserController::class, 'deleteAccount'])->name('guardian.deleteaccount');


});
