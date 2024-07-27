<?php
namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Performance;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

 class PerformanceController extends Controller
{
    public function index()
    {
        $teacher_id = Auth::user()->id; // assuming you are using Laravel's built-in auth system
        $courses = Course::where('teacher_id', $teacher_id)->get();
        // dd($courses);
        return view('teacher.performance.index', compact('courses'));
    }

    public function create(Request $request)
    {
        $course_id = $request->input('course_id');
        $course = Course::find($course_id);
        $assessments = $course->assessments;

        // Debugging line
        foreach ($assessments as $assessment) {
            Log::info($assessment);
        }

        return view('teacher.performance.create', compact('course', 'assessments'));
    }

//     public function create(Request $request)
// {
//     $course_id = $request->input('course_id');
//     $course = Course::with('assessments')->find($course_id); // Eager load assessments
//     return view('teacher.performance.create', compact('course'));
// }

    public function getUploadedStudents(Request $request)
    {
        // dd($request->all());
        $assessment_id = $request->input('assessment_id');
        $course_id = $request->input('course_id');

        // Retrieve users who have uploaded answer files for the selected assessment
        $students = \DB::table('users')
                      ->join('answers', 'users.id', '=', 'answers.student_id')
                      ->where('answers.assessment_id', $assessment_id)
                      ->select('users.id', 'users.name', 'answers.answer_file')
                      ->get();

        $course = Course::find($course_id);
        $assessments = Assessment::where('course_id', $course_id)->get();
        $selected_assessment = Assessment::find($assessment_id);
    // dd($selected_assessment);
        return view('teacher.performance.create', compact('students', 'course', 'assessments', 'assessment_id', 'selected_assessment'));
    }

    public function store(Request $request)
    {
        // dd(1122);
        // Validation (optional but recommended)
        $validatedData = $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'assessment_id' => 'required|exists:assessments,id',
            // 'total_marks' => 'required|integer',
            'obtained_marks' => 'required|integer',
            'remarks' => 'nullable|string',
        ]);
        // Check if performance data already exists for the student, course, and assessment
        $existingPerformance = Performance::where([
            'student_id' => $validatedData['student_id'],
            'course_id' => $validatedData['course_id'],
            'assessment_id' => $validatedData['assessment_id']
        ])->first();

        if ($existingPerformance) {
            // Return a message indicating the performance data already exists
            return redirect()->back()->with('error', 'Marks already uploaded for this student, course, and assessment.');
        }

        // Save performance data
        $performance = new Performance();
        $performance->student_id = $validatedData['student_id'];
        $performance->course_id = $validatedData['course_id'];
        $performance->assessment_id = $validatedData['assessment_id'];
        // $performance->total_marks = $validatedData['total_marks'];
        $performance->obtained_marks = $validatedData['obtained_marks'];
        $performance->remarks = $validatedData['remarks'];
        $performance->save();

        return redirect()->route('performance.main')->with('success', 'Marks uploaded successfully!');
    }
    public function showStudentPerformances()
    {
        $student = Auth::user();
        $performances = Performance::where('student_id', $student->id)
                                    ->whereIn('course_id', $student->courses->pluck('id'))
                                    ->with('course', 'assessment') // Assuming you have an assessment relationship
                                    ->get();

        return view('student.performance', compact('performances'));
    }
}
