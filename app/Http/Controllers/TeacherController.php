<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\CourseStudent;
use App\Models\Course;
use App\Models\Performance;
use App\Models\Assessment;
use App\Models\Content;
use Auth;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;


class TeacherController extends Controller
{
    public function index(){
        $teacher = Auth::user();
        $total_courses = Course::where('teacher_id', $teacher->id)->count();
        $total_students = CourseStudent::whereHas('course', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->distinct('student_id')->count('student_id');

        $total_assessments = Assessment::whereHas('course', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->count();
        $total_content = Content::where('teacher_id', $teacher->id)->count();

        return view('teacher.dashboard', compact('total_courses', 'total_students', 'total_assessments', 'total_content'));
    }

    public function makeProfile(Request $request)
{
    $request->validate([
        'full_name' => 'required',
        'bio' => 'nullable',
        'address' => 'nullable',
        'phone' => 'nullable',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'specialization_subjects' => 'nullable|string|max:255', // Validation for specialization field
        // we will add validation rules for additional fields here
    ]);
    // Retrieve the profile based on the user ID or create a new profile

    $profile = MyProfile::firstOrNew(['user_id' => auth()->id()]);

    // Sanitize the bio input
    $bio = Purifier::clean($request->input('bio'));

    $profile->full_name = $request->input('full_name');
    $profile->bio = $bio;
    $profile->specialization_subjects = $request->input('specialization_subjects'); // Assign specialization data

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/profiles', $fileName);
        $profile->profile_picture = $fileName;
    }

    $profile->address = $request->input('address');
    $profile->phone = $request->input('phone');

    $profile->save();

    echo "profile updated successfully";

    return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
}


    public function manage($teacherId = null) // Optional teacher ID parameter
    {
        // Get the current teacher's ID (assuming you're using auth middleware)
        $currentTeacherId = auth()->id();

        // Query builder approach (alternative to Eloquent):
        $query = User::with(['courses' => function ($query) use ($currentTeacherId) {
            $query->where('courses.teacher_id', $currentTeacherId);
        }])
            ->select('users.id', 'users.name', 'users.contact_number', 'users.email', 'users.contact_number')
            ->where('users.role', 'student')  // Filter for students
            ->join('course_student', 'course_student.student_id', '=', 'users.id')
            ->join('courses', 'courses.id', '=', 'course_student.course_id')
            ->where('courses.teacher_id', $currentTeacherId);  // Filter courses by current teacher

        $students = $query->get();
        // dd($students);

        return view('teacher.manage_students', compact('students'));
    }
    public function removeStudentFromCourse(Request $request)
    {
        $studentId = $request->student_id;
        $courseId = $request->course_id;

        // Check if the course belongs to the current teacher
        $course = Course::find($courseId);
        if ($course->teacher_id !== auth()->id()) {
            return redirect()->route('teacher.manage_students')->with('error', 'You are not authorized to remove students from this course.');
        }

        // Remove the student from the course
        \DB::table('course_student')
            ->where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->delete();

        return redirect()->route('teacher.manage_students')->with('success', 'Student removed from the course successfully.');
    }
public function create()
{
    $teacher = Auth::user();
    $courses = $teacher->courses; // Assuming there's a relationship between User and Course models
    $students = User::whereHas('courses', function($query) use ($teacher) {
        $query->where('teacher_id', $teacher->id);
    })->get();
    $assessments = Assessment::all();

    return view('teacher.performance', compact('students', 'courses', 'assessments'));
}

public function addPerformance(Request $request)
{
    $request->validate([
        'performance.*.student_id' => 'equired|exists:users,id',
        'performance.*.course_id' => 'equired|exists:courses,id',
        'performance.*.assessment_id' => 'equired|exists:assessments,id',
        'performance.*.total_marks' => 'equired|integer',
        'performance.*.obtained_marks' => 'equired|integer',
        'performance.*.remarks' => 'nullable|string'
    ]);

    $teacher = Auth::user();

    foreach ($request->performance as $perf) {
        $student = User::find($perf['student_id']);
        $course = Course::find($perf['course_id']);
        $assessment = Assessment::find($perf['assessment_id']);

        if (!$student->courses->contains($course->id)) {
            return response()->json(['error' => 'Student is not following this course'], 403);
        }

        if ($course->teacher_id!= $teacher->id) {
            return response()->json(['error' => 'You are not the instructor of this course'], 403);
        }

        Performance::create([
            'teacher_id' => $teacher->id,
            'tudent_id' => $student->id,
            'tudent_name' => $student->name,
            'course_id' => $course->id,
            'course_title' => $course->title,
            'assessment_id' => $assessment->id,
            'assessment_title' => $assessment->title,
            'assessment_type' => $assessment->type,
            'total_marks' => $perf['total_marks'],
            'obtained_marks' => $perf['obtained_marks'],
            'emarks' => $perf['remarks']
        ]);
    }

    return redirect()->back()->with('success', 'Marks uploaded successfully');
}
public function performance()
{
    $students = User::where('role', 'student')->get();
    $courses = Course::all();
    $assessments = Assessment::all();

    return view('teacher.performance', compact('students', 'courses', 'assessments'));
}
}
