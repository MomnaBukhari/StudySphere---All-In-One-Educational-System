<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\User;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AssessmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'teacher') {
            $assessments = Assessment::where('Teacher_id', $user->id)->get();
        } else {
            $assessments = [];
        }

        return view('teacher.assessment_record', compact('assessments'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'Total_Marks' => 'nullable',
                'type' => 'required',
                'instructions' => 'required',
                'file' => 'nullable|file|mimes:png,jpeg,jpg,pdf,doc,docx,mp4,mp3,wav|max:10240',
                'course_id' => 'required|exists:courses,id',
            ]);

            // Create a new instance of Assessment
            $assessment = new Assessment();
            // Assign values from the request to the Assessment model
            $assessment->type = $request->type;
            $assessment->Total_Marks = $request->Total_Marks;
            $assessment->instructions = $request->instructions;
            $assessment->course_id = $request->course_id;
            // Assign the authenticated user's ID as Teacher_id
            $assessment->Teacher_id = auth()->id();

            // Handle file upload if present
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $mimeType = $file->getMimeType();

                // Determine directory based on file type
                if (str_contains($mimeType, "image/")) {
                    $directory = 'uploads/images';
                } elseif (str_contains($mimeType, "video/")) {
                    $directory = 'uploads/videos';
                } elseif (str_contains($mimeType, "audio/")) {
                    $directory = 'uploads/audios';
                } else {
                    $directory = 'uploads/documents';
                }

                // Ensure directory exists, create if not
                if (!Storage::exists($directory)) {
                    Storage::makeDirectory($directory, 0775, true, true);
                }

                // Generate unique filename
                $filename = time() . '.' . $file->getClientOriginalExtension();
                // Store file in specified directory
                $path = $file->storeAs($directory, $filename, 'public');
                // Get URL of stored file
                $url = Storage::url($path);
                // Assign file URL to assessment model
                $assessment->file = $url;
            }

            // Save assessment data to database
            $assessment->save();

            // Redirect to assessments index page on successful save
            return redirect()->route('assessments.index');
        } catch (\Exception $e) {
            // Log any errors encountered during storage process
            Log::error('Error storing assessment: ' . $e->getMessage());
            // Redirect back with error message if save fails
            return back()->withInput()->withErrors(['error' => 'Failed to store assessment. Please try again.']);
        }
    }

    public function store1(Request $request, Assessment $assessment)
    {
        $request->validate([
            'answer_file' => 'required|file|mimes:png,jpeg,jpg,pdf,doc,docx,mp4,mp3,wav',
        ]);

        if ($request->hasFile('answer_file')) {
            $file = $request->file('answer_file');
            $mimeType = $file->getMimeType();

            if (str_contains($mimeType, "image/")) {
                $directory = 'uploads/answers/images';
            } else {
                $directory = 'uploads/answers/documents';
            }

            // Ensure the directory exists
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory, 0775, true);
            }

            // Generate unique filename
            $filename = time() . '.' . $file->getClientOriginalExtension();
            // Store the file in the determined directory
            $path = $file->storeAs($directory, $filename, 'public');
            $url = Storage::url($path);

            $answer = new Answer();
            $answer->student_id = auth()->id();
            $answer->assessment_id = $assessment->id;
            $answer->answer_file = $url;
            $answer->save();

            return back()->with('success', 'Answer uploaded successfully!');
        }

        return back()->with('error', 'File upload failed.');
    }

    public function create1(Assessment $assessment)
    {
        return view('student.assessment_upload', compact('assessment'));
    }

    public function show($id)
    {
        $assessment = Assessment::findOrFail($id);
        return view('teacher.assessment_show', compact('assessment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
            'instructions' => 'required',
            'Total_Marks' => 'required|numeric',
            'file' => 'nullable|file|mimes:png,jpeg,pdf,doc,docx|max:10240',
        ]);

        $assessment = Assessment::findOrFail($id);
        $assessment->type = $request->type;
        $assessment->instructions = $request->instructions;
        $assessment->Total_Marks = $request->Total_Marks;

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($assessment->file) {
                Storage::delete(str_replace('/storage/', '', $assessment->file));
            }

            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $filename, 'public');
            $assessment->file = Storage::url($path);
        }

        $assessment->save();

        return redirect()->route('assessments.index');
    }

    public function destroy($id)
    {
        $assessment = Assessment::findOrFail($id);
        if ($assessment->file) {
            Storage::delete(str_replace('/storage/', '', $assessment->file));
        }
        $assessment->delete();

        return redirect()->route('assessments.index');
    }

    public function showAssessments()
    {
        $user = Auth::user();
        $followedCourses = $user->followedcourses;
        $assessments = [];

        foreach ($followedCourses as $course) {
            $courseAssessments = $course->assessments()->with('course')->get();
            foreach ($courseAssessments as $assessment) {
                $assessment->load('answers');
            }
            $assessments = array_merge($assessments, $courseAssessments->all());
        }

        return view('student.assessment', compact('assessments'));
    }

    public function download($filename)
    {
        $path = storage_path('app/public/uploads/' . $filename);
        if (file_exists($path)) {
            return response()->download($path);
        }

        return redirect()->back()->with('error', 'File not found.');
    }

    public function viewAnswer(Assessment $assessment)
    {
        $answer = Answer::where('assessment_id', $assessment->id)->first();
        if ($answer) {
            return response()->file(storage_path('app/public/' . $answer->answer_file));
        } else {
            return back()->with('error', 'No answer file found.');
        }
    }

    public function performance()
    {
        $user = Auth::user();
        $assessments = Assessment::with('course', 'answers')->get();

        return view('student.performance', compact('assessments'));
    }
}
