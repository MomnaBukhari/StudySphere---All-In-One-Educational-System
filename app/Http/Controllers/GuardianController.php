<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class GuardianController extends Controller
{
    public function index()
    {
        return view('guardian.dashboard');
    }

    public function getPerformance(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'student_email' => 'required|email|exists:users,email',
        ]);

        $student = User::with('performances')
            ->where('id', $request->student_id)
            ->where('email', $request->student_email)
            ->first();

        if (!$student) {
            return redirect()->back()->withErrors(['student_id' => 'Student not found or email does not match.']);
        }

        // Store student_id in session
        session(['student_id' => $request->student_id]);

        return view('guardian.showperformance', compact('student'));
    }

    public function showFollowedDetailsForm()
    {
        return view('guardian.assesment');
    }

    public function showFollowedDetails(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'student_email' => 'required|email|exists:users,email',
        ]);

        $student = User::with(['followedCourses.teacher', 'followedAssessments'])
            ->where('id', $request->input('student_id'))
            ->where('email', $request->input('student_email'))
            ->first();

        // if (!$student) {
        //     return back()->withErrors(['student_id' => 'Student not found or email does not match']);
        // }

        session(['student_id' => $request->input('student_id')]);

        return view('guardian.assesment', compact('student'));
    }
}
