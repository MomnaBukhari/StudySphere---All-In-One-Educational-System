<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Course;
use App\Mail\welcomemail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function loginForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'login')
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed, redirect based on user's role
            return $this->redirectBasedOnRole(Auth::user());
        } else {
            // Authentication failed, redirect back with error message
            return redirect()->back()->withErrors(['login_error' => 'Invalid credentials. Please try again.']);
        }
    }

    public function redirectBasedOnRole(User $user)
    {
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
    }

    public function signupForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$/'],
            'name' => 'required',
            'role' => 'required',
        ], [
            'email.required' => 'The email field is required.',
            'password.required' => 'The password field is required.',
            'name.required' => 'The name field is required.',
            'role.required' => 'The role field is required.',
            'email.ends_with' => 'The email domain must be Gmail, Yahoo, Hotmail, Outlook, or GMX.',
            'password.regex' => 'The password must be at least 8 characters long and include at least one letter, one number, and one special character.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Please fix the following errors:')
                ->withErrors($validator)
                ->withInput();
        }

        // Proceed with user registration if email domain is acceptable
        $user = new User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->name = $request->name;
        $user->save();

        // Send welcome email
        $toEmail = $user->email;
        $message = "Thank You for Joining StudySphere, Your Own Educational World!";
        $subject = "Welcome to StudySphere";

        Mail::to($toEmail)->send(new welcomemail($message, $subject, $user));

        // Store the email and password in the session to pre-fill the login form
        session()->flash('signup_email', $request->email);
        session()->flash('signup_password', $request->password);

        // Redirect to login page with a success message
        return redirect()->route('authenticationForm')->with('success', 'Account created successfully. Please login to your Account');
    }

    public function showProfileForm()
    {
        $user = auth()->user();

        if ($user->role == 'teacher') {
            return view('teacher.profile', compact('user')); // Assuming the profile view is in the teacher folder
        } elseif ($user->role == 'student') {
            return view('student.profile', compact('user'));
        } else {
            return view('guardian.profile', compact('user'));
        }
    }

    public function storeProfile(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('uploads', $filename, 'public');
                $user->profile_picture = 'storage/' . $path;
            }
            $user->name = $request->full_name;
            $user->address = $request->address;
            $user->cnic = $request->cnic;
            $user->gender = $request->gender;
            $user->social_media_links = $request->social_media_links;
            $user->course_specialization = $request->course_specialization;
            $user->contact_number = $request->contact_number;
            $user->bio = $request->bio;
            $user->save();
        } else {
            $user = new User();
            if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('uploads', $filename, 'public');
                $user->profile_picture = 'storage/' . $path;
            }
            $user->name = $request->name;
            $user->address = $request->address;
            $user->cnic = $request->cnic;
            $user->gender = $request->gender;
            $user->social_media_links = $request->social_media_links;
            $user->course_specialization = $request->course_specialization;
            $user->contact_number = $request->contact_number;
            $user->bio = $request->bio;
            $user->save();
        }
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('authenticationForm')->with('success', 'Logged out successfully.');
    }

    public function studentDashboard()
    {
        $user = Auth::user();
        return view('student.dashboard', compact('user'));
    }

    public function teacherDashboard()
    {
        $user = Auth::user();
        return view('teacher.dashboard', compact('user'));
    }

    public function guardianDashboard()
    {
        $user = Auth::user();
        return view('guardian.dashboard', compact('user'));
    }
    public function welcomepage()
    {
        $teachersCount = User::where('role', 'teacher')->count();
        $studentsCount = User::where('role', 'student')->count();
        $guardiansCount = User::where('role', 'guardian')->count();
        $coursesCount = Course::count();
        return view('welcome', compact('teachersCount', 'studentsCount', 'guardiansCount', 'coursesCount'));
    }
    public function showTeacherProfile($id)
    {
        $user = User::findOrFail($id);

        $authUserRole = auth()->user()->role ?? 'student'; // Default to 'student' if role is not set

        $layout = 'student.main_layout_student'; // Default layout
        if ($authUserRole === 'teacher') {
            $layout = 'teacher.main_layout_teacher';
        } elseif ($authUserRole === 'guardian') {
            $layout = 'guardian.main_layout_guardian';
        }

        return view('main_user_details', compact('user', 'layout'));
    }
    public function deleteAccount()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Perform the deletion operation based on user role
        if ($user->role === 'teacher') {
            // Additional logic specific to teacher deletion if needed
        } elseif ($user->role === 'student') {
            // Additional logic specific to student deletion if needed
        } elseif ($user->role === 'guardian') {
            // Additional logic specific to guardian deletion if needed
        }

        // Delete the user record
        $user->delete();

        // Optionally, log out the user after deletion
        Auth::logout();

        // Redirect to a confirmation page or the home page
        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }

}
