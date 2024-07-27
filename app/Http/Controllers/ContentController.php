<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\User;
use App\Models\Course;  // Assuming you have a separate Course model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;// For user authorization
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index()
    {
        $teacher_id = auth()->user()->id;
        $contents = Content::where('teacher_id', $teacher_id)->get();

        return view('teacher.content.view_content', compact('contents'));
    }

    public function create()
    {
        // Retrieve all courses for the dropdown selection (assuming a relationship)
        $courses = Course::all();

        return view('teacher.content', compact('courses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'required|file|max:2048',  // Restrict file size (adjust as needed)
            'content_type' => 'required|in:document,video,audio', // Add other content types as needed
            'course_id' => 'required|exists:courses,id',
        ]);
        if($request->hasfile('file_path')){
            $file=$request->file('file_path');
        }
        $mimeType = $file->getMimeType();
        if (strstr($mimeType, "image/")) {
            $directory = 'uploads/images';
        } elseif (strstr($mimeType, "video/")) {
            $directory = 'uploads/videos';
        } elseif (strstr($mimeType, "audio/")) {
            $directory = 'uploads/audios';
        } else {
            $directory = 'uploads/documents';
        }
        // Ensure the directory exists
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory, 0775, true); // Set appropriate permissions
        }

        // Generate a unique filename
        $filename = time() . '.' . $file->getClientOriginalExtension();

        // Store the file in the determined directory
        $path = $file->storeAs($directory, $filename, 'public');

        // Get the URL of the stored file
        $url = Storage::url($path);

        // $file = $request->file('file_path');
        // $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        // // Determine the directory based on content type
        // $directory = 'content';
        // if ($request->content_type === 'video') {
        //     $directory .= '/videos';
        // } elseif ($request->content_type === 'audio') {
        //     $directory .= '/audios';
        // } else {
        //     $directory .= '/documents';
        // }

        // // Store the file in the appropriate directory
        // $path = $file->storeAs($directory, $filename, 'public');
        // $url = Storage::url($path);

        $content = new Content();
        $content->title = $request->title;
        $content->description = $request->description;
        $content->file_path = $url;
        $content->content_type = $request->content_type;
        $content->course_id = $request->course_id;
        $content->teacher_id = auth()->user()->id;
        $content->save();

        return redirect()->route('contents.index')->with('success', 'Content created successfully!');
    }


    public function edit(Content $content)
    {
        // Return a view for editing the content
        return view('teacher.edit_content', compact('content'));
    }

    public function update(Request $request, Content $content)
    {
        // Validate and update the content
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'required|string|max:255',
            'content_type' => 'required|in:document,video,audio', // Add other content types as needed
            'course_id' => 'required|exists:courses,id',
            // You may add more validation rules as per your requirements
        ]);

        $content->update($validatedData);

        return redirect()->route('contents.index')->with('success', 'Content updated successfully!');
    }

    public function destroy(Content $content)
    {
        // Delete the content
        $content->delete();

        return redirect()->route('contents.index')->with('success', 'Content deleted successfully!');
    }
    public function showContents()
    {
        $user = Auth::user();
        $followedCourses = $user->followedcourses;

        $contents = [];
        foreach ($followedCourses as $course) {
            // Get contents as an array directly
            $courseContents = $course->contents->toArray();

            // Add course title to each content
            foreach ($courseContents as &$content) {
                $content['course_title'] = $course->title;
            }

            $contents = array_merge($contents, $courseContents);
        }

        return view('student.content', compact('contents'));
    }

    public function downloadContent($filename)
    {
       // dd($filename);
        $path = storage_path('app/public/uploads/' . $filename);

        if (file_exists($path)) {
            return response()->download($path);
        }

        return redirect()->back()->with('error', 'File not found.');
        // $content = Content::findOrFail($contentId);

        // if (is_null($content->file_path)) {
        //     return abort(404, 'Content path not available for download.');
        // }

        // // Get the file path from the database
        // $filePath = $content->file_path;

        // // Check if the file exists in storage
        // if (!Storage::exists($filePath)) {
        //     return abort(404, 'Content not found or unavailable for download.');
        // }

        // // Get the file's contents
        // $fileContents = Storage::get($filePath);

        // // Return a download response with the file contents
        // return response()->download(storage_path('app/public/' . $filePath), $content->title . '.' . $content->content_type);
    }

    public function viewContent($contentId)
{
    $content = Content::findOrFail($contentId);

    if (is_null($content->file_path)) {
        return abort(404, 'Content path not available for viewing.');
    }

    // Get the path from the database
    $filePath = $content->file_path;

    // Check if the file exists in storage
    if (!Storage::exists($filePath)) {
        return abort(404, 'Content not found or unavailable for viewing.');
    }

    // Get the file's contents
    $fileContents = Storage::get($filePath);

    // Return a response with the file contents
    return response()->make($fileContents, 200, [
        'Content-Type' => 'application/' . $content->content_type,
        'Content-Disposition' => 'inline; filename="' . $content->title . '.' . $content->content_type . '"'
    ]);
}
}
