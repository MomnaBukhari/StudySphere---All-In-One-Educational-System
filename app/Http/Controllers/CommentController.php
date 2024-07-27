<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{

    public function store(Request $request, $postId)
    {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        // Validate the request
        $request->validate([
            'comment' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        // Create the comment
        $comment = new Comment();
        $comment->user_id = auth()->user()->id; // Assuming authenticated user
        $comment->post_id = $postId;
        $comment->parent_id = $request->input('parent_id', null); // Default to null if not provided
        $comment->comment = $request->input('comment');
        $comment->save();

        return back()->with('success', 'Comment added successfully!');
    }

    public function view($slug)
    {
        $post = Post::where('slug', $slug)
            ->with('user:id,name')
            ->with('comments.replies')
            ->firstOrFail();

        return view('student.view', ['post' => $post]);
    }
}
