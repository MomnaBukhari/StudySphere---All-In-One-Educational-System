<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\User;

class CourseController extends Controller
{
    public function index()
    {
        $teacherId = auth()->id();
        $courses = Course::where('teacher_id', $teacherId)->get();
        // Add return statement if this method is meant to return a view or data
    }

    public function index1()
    {
        $teacher_id = auth()->user()->id;
        $courses = Course::where('teacher_id', $teacher_id)->get();
        return view('teacher.my_courses', compact('courses'));
    }

    public function availableCourses()
    {
        $courses = Course::all();
        return view('student.course', compact('courses'));
    }

    public function create()
    {
        return view('teacher.course');
    }

    public function edit($id)
    {
        $course = Course::find($id);
        return view('teacher.Course_Edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'overview' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'resources' => 'nullable',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $course = Course::find($id);
        $course->title = $request->title;
        $course->overview = $request->overview;
        $course->start_date = $request->start_date;
        $course->end_date = $request->end_date;
        $course->resources = $request->resources;

        if ($request->hasFile('banner_image')) {
            // Delete old image if exists
            if ($course->banner_image) {
                unlink(public_path('images') . '/' . $course->banner_image);
            }
            $imageName = time() . '.' . $request->banner_image->extension();
            $request->banner_image->move(public_path('images'), $imageName);
            $course->banner_image = $imageName;
        }

        $course->save();

        return redirect()->route('courses.index1')->with('success', 'Course updated successfully.');
    }




    public function destroy($id)
    {
        $course = Course::find($id);
        $course->delete();
        return redirect()->route('courses.index1');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'overview' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'resources' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Prepare the data for insertion
        $data = $request->only(['title', 'overview', 'start_date', 'end_date', 'resources']);
        $data['teacher_id'] = auth()->id();

        // Handle the banner image upload if it exists
        if ($request->hasFile('banner_image')) {
            $imageName = time() . '.' . $request->banner_image->extension();
            $request->banner_image->move(public_path('images'), $imageName);
            $data['banner_image'] = $imageName;
        }

        // Insert the data into the database
        try {
            $course = Course::create($data);
            return redirect()->route('courses.index1')->with('success', 'Course created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create course. Please try again.');
        }
    }

    public function followCourses(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        // Get the course ID and authenticated user ID
        $courseId = $validatedData['course_id'];
        $studentId = Auth::user()->id;

        // Check if the student is already following the course
        $alreadyFollowing = CourseStudent::where('course_id', $courseId)
            ->where('student_id', $studentId)
            ->exists();

        if (!$alreadyFollowing) {
            // Create a new course-student record if not already following
            $courseStudent = new CourseStudent;
            $courseStudent->course_id = $courseId;
            $courseStudent->student_id = $studentId;
            $courseStudent->save();

            // Return a success message
            return redirect()->back()->with('success', 'Course followed successfully!');
        } else {
            // Return a message indicating the student is already following the course
            return redirect()->back()->with('error', 'You are already following this course.');
        }
    }

    public function myCourses()
    {
        $user = Auth::user();
        $followedCourses = $user->courses()->get(); // Assuming you have a relationship set up in your User model

        return view('student.mycourses', ['courses' => $followedCourses]);
    }

    public function unfollowCourse(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = Auth::user();
        $user->courses()->detach($validatedData['course_id']);

        return redirect()->back()->with('success', 'Course unfollowed successfully.');
    }
}
