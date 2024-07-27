@foreach ($replies as $reply)
    <div class="card mt-3" id="reply-{{ $reply->id }}">
        <div class="card-body">
            <p class="card-text">{{ $reply->comment }}</p>
            <p class="card-text">By {{ $reply->user->name }} on {{ $reply->created_at->format('M d, Y') }}</p>
        </div>
    </div>
@endforeach
