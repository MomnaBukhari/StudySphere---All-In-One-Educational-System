<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;
use Str;

use Storage;

class PostController extends Controller
{
    public function index()
    {
        // Fetch posts with user information
        $posts = Post::with('user:id,name')
            ->select('user_id', 'title', 'slug', 'banner_image', 'created_at')
            ->paginate(10);

        return view('teacher.post.welcome', ['posts' => $posts]);
    }
    public function discussionBoard()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->paginate(10);

//        if ($posts->isEmpty()) {
//            return redirect()->route('post.create');
//        }

        return view('teacher.post.discussionboard', ['posts' => $posts]);
    }
        public function studentdiscussionBoard()
    {
           // Get the courses the authenticated student is enrolled in
        $studentCourses = Auth::user()->courses->pluck('id')->toArray();

        // Get the teacher IDs for the courses the student is enrolled in
        $teacherIds = \App\Models\Course::whereIn('id', $studentCourses)->pluck('teacher_id')->toArray();

        // Fetch posts where the post's user_id matches any of the teacher IDs
        $posts = Post::with(['user:id,name'])
            ->whereIn('user_id', $teacherIds)
            ->select('user_id', 'title', 'slug', 'banner_image', 'created_at')
            ->paginate(10);

        return view('student.discussionboard', ['posts' => $posts]);
    }

    public function display($slug)
    {
        $post = Post::where('slug', $slug)
            ->with(['user:id,name', 'comments.replies'])
            ->firstOrFail();

        return view('student.display', ['post' => $post]);
    }
    public function view($slug)
    {
        $post = Post::whereSlug($slug)
            ->with(['user:id,name', 'comments.user:id,name'])
            ->firstOrFail(); // Ensure post exists, or return 404

        return view('teacher.post.detail', compact('post'));
    }


    public function create()
    {
        return view('teacher.post.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        // Handle the banner image upload
        $bannerImagePath = null;
        if ($request->hasFile('banner_image')) {
            $bannerImagePath = $request->file('banner_image')->store('banner_images', 'public');
        }

        // Create the post
        $post = new Post();
        $post->user_id = auth()->user()->id; // Assuming authenticated user
        $post->title = $request->input('title');
        $post->slug = Str::slug($request->input('title'));
        $post->content = $request->input('content');
        $post->banner_image = $bannerImagePath;
        $post->save();

        return redirect()->route('post.view', ['slug' => $post->slug])->with('success', 'Post created successfully!');
    }

    // public function storeComment(Request $request, $postId)
    // {
    //     $request->validate([
    //         'comment' => 'required|string',
    //         'parent_id' => 'nullable|exists:comments,id'
    //     ]);

    //     // Check if the post exists
    //     // $post = Post::findOrFail($postId);

    //     // Create the comment
    //     $comment = new Comment();
    //     $comment->user_id = auth()->user()->id; // Assuming authenticated user
    //     $comment->post_id = $postId;
    //     $comment->parent_id = $request->input('parent_id', null); // Default to null if not provided
    //     $comment->comment = $request->input('comment');
    //     $comment->save();

    //     return back()->with('success', 'Comment added successfully!');
    // }
public function storeComment(Request $request, $postId)
{
    // Validate the request
    $request->validate([
        'comment' => 'required|string',
        'parent_id' => 'nullable|exists:comments,id'
    ]);

    // Fetch the authenticated user
    $user = auth()->user();

    // Ensure the post exists
    $post = Post::findOrFail($postId);

    // Create the comment using Eloquent
    $comment = $post->comments()->create([
        'user_id' => $user->id,
        'parent_id' => $request->input('parent_id', null),
        'comment' => $request->input('comment')
    ]);

    return back()->with('success', 'Comment added successfully!');
}


    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Ensure the user is authorized to edit the post
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('discussion.board')->with('error', 'Unauthorized action.');
        }

        return view('teacher.post.edit', ['post' => $post]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post = Post::findOrFail($id);

        // Ensure the user is authorized to update the post
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('discussion.board')->with('error', 'Unauthorized action.');
        }

        $post->title = $request->input('title');
        $post->slug = Str::slug($request->input('title'));
        $post->content = $request->input('content');

        if ($request->hasFile('banner_image')) {
            $bannerImagePath = $request->file('banner_image')->store('banner_images', 'public');
            $post->banner_image = $bannerImagePath;
        }

        $post->save();

        return redirect()->route('post.view', ['slug' => $post->slug])->with('success', 'Post updated successfully!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Ensure the user is authorized to delete the post
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('discussion.board')->with('error', 'Unauthorized action.');
        }

        $post->delete();

        return redirect()->route('discussion.board')->with('success', 'Post deleted successfully!');
    }
}
