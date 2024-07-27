<style>
    .wholecomment{
        background-color: #f5f5fa;
    }
    .commentbody {
        padding: 1% 4% 0% 4%;
        display: flex;
        justify-content: space-between;
    }

    .commentbody-content {
        font-size: 150%
    }

    .commentbody-username {
        color: rgb(123, 123, 123);
    }
    .btn{
        background-color: #d6d4df;
        padding:  1% 2%;
        /* width: 40px;
        height: 20px; */
    }
</style>

@foreach ($comments as $comment)
    <div class="card mt-3" id="comment-{{ $comment->id }}">
        <div class="wholecomment">
            <div class="commentbody">
                <div class="commentbody1">
                    <p class="commentbody-content">{{ $comment->comment }}</p>
                </div>
                <div class="commentbody2">
                    <p class="commentbody-username">By {{ $comment->user->name }} on

                        {{ $comment->created_at->format('M d, Y') }}</p>
                </div>

            <button class="btn btn-link" onclick="toggleReplyForm({{ $comment->id }})">Reply</button>
            @if ($comment->replies->count() > 0)
                <button class="btn btn-link" onclick="toggleReplies({{ $comment->id }})">Toggle Replies</button>
            @endif
        </div>
        </div>

        <!-- Reply Form -->
        <div class="reply-form" id="reply-form-{{ $comment->id }}" style="display: none;">
            <form action="{{ route('post.comment', ['postId' => $post->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <div class="form-group">
                    <textarea name="comment" rows="2" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Reply</button>
            </form>
        </div>

        @if ($comment->replies->count() > 0)
            <div class="replies" id="replies-{{ $comment->id }}" style="display: none; margin-left: 20px;">
                @include('partials.comments', ['comments' => $comment->replies])
            </div>
        @endif
    </div>
@endforeach

<script>
    function toggleReplies(commentId) {
        var repliesDiv = document.getElementById('replies-' + commentId);
        if (repliesDiv.style.display === 'none') {
            repliesDiv.style.display = 'block';
        } else {
            repliesDiv.style.display = 'none';
        }
    }

    function toggleReplyForm(commentId) {
        var replyFormDiv = document.getElementById('reply-form-' + commentId);
        if (replyFormDiv.style.display === 'none') {
            replyFormDiv.style.display = 'block';
        } else {
            replyFormDiv.style.display = 'none';
        }
    }
</script>
