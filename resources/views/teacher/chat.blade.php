@extends('teacher.main_layout_teacher')

@section('style', asset('profilestyling/profilestyle.css'))

@section('css')
    <style>
        .text-small {
            font-size: 0.9rem;
        }

        .messagebox {
            /*This is the background of box where chats (people) are displayed */
            height: 50vh;
            overflow-y: scroll;
            /* background: linear-gradient(180deg, #FAF9F9, #EDEFFF); */
            background-color: #ffffff;
            border: 1px solid #041439;
        }

        .chat-box {
            height: 50vh;
            background-color: #ffffff;
            overflow-y: scroll;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-bottom: 1px solid #041439;
            border-right: 1px solid #041439;
            border-left: 1px solid #041439;
        }

        input::placeholder {
            font-size: 0.9rem;
            color: #999;
        }
    </style>
@endsection

@section('javascript2')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        function sendMessage() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('add-message', ['pe' => $broadOn]) }}',
                data: {
                    msg: $('#msgfield').val(),
                    chat_id: $('#chat_id_field').val()
                },
                dataType: 'json',
                success: function(data) {
                    var chatMessage = $('<div>').addClass('sendermessagebox');
                    chatMessage.append($('<div>').addClass('actualmessage').append(
                        $('<div>').addClass('sendermessage').append(
                            $('<p>').addClass('textmessage').text($('#msgfield').val())
                        )
                    ));

                    $('#chat_box').append(chatMessage);

                    // Scroll logic
                    var chatBox = document.getElementById("chat_scroll");
                    chatBox.scrollTop = chatBox.scrollHeight;

                    $('#msgfield').val('');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    console.error('Response:', xhr.responseText);
                }
            });
        }

        // Scroll logic
        var chatBox = document.getElementById("chat_scroll");
        chatBox.scrollTop = chatBox.scrollHeight;

        Pusher.logToConsole = true;

        var pusher = new Pusher('bd895c93ea5dca384f93', {
            cluster: 'ap2',
            forceTLS: true
        });

        var channel = pusher.subscribe('chat-channel');
        channel.bind('chat-event', function(data) {
            var message = data.message;

            var chatMessage = $('<div>').addClass('receivermessagebox');
            chatMessage.append($('<div>').addClass('actualmessage').append(
                $('<div>').addClass('receivermessage').append(
                    $('<p>').addClass('textmessage').text(message.msg),
                    $('<span>').addClass('spandate').text(message.created_at)
                )
            ));

            $('#chat_box').append(chatMessage);

            // Scroll logic
            var chatBox = document.getElementById("chat_scroll");
            chatBox.scrollTop = chatBox.scrollHeight;
        });

        var all_channel = pusher.subscribe('all-chat');
        all_channel.bind('all-chat-event', function(data) {
            var message = data.message;
            if (message.chat_id === {{ $id }}) {
                // Do nothing, the current chat message is already being managed by another pusher event
            } else {
                var chatElement = $('#chat-' + message.chat_id);
                chatElement.find('.font-italic').text(message.msg);

                var unreadMessagesBadge = chatElement.find('.badge');
                if (unreadMessagesBadge.length) {
                    var currentValue = parseInt(unreadMessagesBadge.text());
                    unreadMessagesBadge.text(currentValue + 1);
                } else {
                    chatElement.find('#badge-wrapper').after(
                        '<strong class="badge rounded-pill text-bg-danger m-0">1</strong>');
                }

                var createdAtDate = getFormattedDateTime();
                chatElement.find('.font-weight-bold').text(createdAtDate);
            }
        });

        function getFormattedDateTime() {
            var currentDate = new Date();
            var hours = currentDate.getHours();
            var minutes = String(currentDate.getMinutes()).padStart(2, '0');
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // Handle midnight
            var monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            var month = monthNames[currentDate.getMonth()];
            var day = String(currentDate.getDate()).padStart(2, '0');
            return hours + ':' + minutes + ' ' + ampm + ', ' + day + ' ' + month;
        }
    </script>
@endsection

@section('title')
    Teacher - Chat
@endsection

@section('section1')
    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                <button class="profilebtn" onclick="window.location.href='/teacher_chat'">Back</button>
            </div>
        </div>
        <div class="profile-page-part2">
            <div class="profile-display">
                <div class="chatcontainer ">
                    <div class="row">
                        <!-- Users box-->
                        <div class="userboxoter">
                            <div class="recentwordbox">
                                <p class="recentword">All Chats</p>
                            </div>
                            <div class="messagebox">
                                @if ($chats->isEmpty())
                                    <p class="norecentchats">No recent chats available.</p>
                                @else
                                    @foreach ($chats as $chat)
                                        <a href="/chat/{{ $chat->id }}" id="chat-{{ $chat->id }}"
                                            class="listofuserschat"
                                            @if ($id == $chat->id) style="background-color: #eeeded" @endif>

                                            <div class="media">
                                                <div class="mediabody">
                                                    <div class="mediabodypart1">
                                                        {{-- <img src="{{ asset('defaultprofilepicture.jpg') }}"
                                                                    alt="Profile Picture"> --}}
                                                        <img src="{{ $user->profile_picture ?? asset('defaultprofilepicture.jpg') }}"
                                                            alt="ProfilePicture">
                                                    </div>
                                                    <div class="mediabodypart2">
                                                        <div class="mediabodypart2_1">
                                                            <div>
                                                                <h6 id="badge-wrapper">
                                                                    @if ($chat->users->first()->name == Auth::user()->name)
                                                                        {{ $chat->users->last()->name }}
                                                                    @else
                                                                        {{ $chat->users->first()->name }}
                                                                    @endif
                                                                    @if ($chat->messages->isNotEmpty())
                                                                        @if ($chat->messages->where('user_id', '!=', auth()->id())->where('receipt', 0)->isNotEmpty())
                                                                            <strong
                                                                                class="badge rounded-pill text-bg-danger">
                                                                                {{ $chat->messages->where('user_id', '!=', auth()->id())->where('receipt', 0)->count() }}
                                                                            </strong>
                                                                        @endif
                                                                    @endif
                                                                </h6>
                                                            </div>
                                                            <div>
                                                                <small class="userchattime">
                                                                    @if ($chat->messages->isNotEmpty())
                                                                        {{ $chat->messages->last()->created_at->format('g:i A, d F') }}
                                                                    @endif
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="mediabodypart2_2">
                                                            <p class="lastupdatedmessage">
                                                                @if ($chat->messages->isNotEmpty())
                                                                    {{ \Illuminate\Support\Str::limit($chat->messages->last()->msg, 40, '...') }}
                                                                @else
                                                                    No messages yet.
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>

                        </div>

                        <!-- Chat Box-->
                        <div class="userboxoter">
                            @if ($id != 'none')
                                <div class="inboxheader">
                                    <h3>
                                        {{ $otherUser }}
                                    </h3>
                                </div>
                            @endif
                            @if ($id == 'none')
                                Open a chat to start a conversation!
                            @else
                                <div class="chat-box" id="chat_scroll">
                                    <div id="chat_box">
                                        @if ($currentChatMessages->isEmpty())
                                            <p style="padding: 1% 2%;">No messages in this chat!</p>
                                        @else
                                            @foreach ($currentChatMessages as $message)
                                                @if ($message->user->id == Auth::id())
                                                    <div class="sendermessagebox">
                                                        <div class="actualmessage">
                                                            <div class="sendermessage">

                                                                <p class="textmessage">
                                                                    {{ $message->msg }}</p>
                                                                <span
                                                                    class="spandate">{{ $message->created_at->format('g:i A, d F') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="receivermessagebox">
                                                        <div class="receivermessage">
                                                            <p>
                                                                {{ $message->msg }}</p>
                                                            <span>{{ $message->created_at->format('g:i A, d F') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endif



                            @if ($id != 'none')
                                <!-- Typing area -->
                                {{-- <form action="{{ route('add-message') }}" method="post"> --}}
                                {{-- <form> --}}
                                    @csrf
                                <div class="inputmessagebox">
                                    <input type="text" placeholder="Type a message" class="form-control" name="msg"
                                        id="msgfield">
                                    <input type="hidden" name="chat_id" value="{{ $id }}" id="chat_id_field">
                                    <button id="button-addon2" onclick="sendMessage()" class="profilebtn">
                                        Send
                                    </button>
                                </div>
                                {{-- </form> --}}
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
