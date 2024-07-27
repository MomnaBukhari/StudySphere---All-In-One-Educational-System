@extends('student.main_layout_student')

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

    <script>
        function sendMessage() {
            console.log(123);
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
                    console.log('Success:', data);
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
        // Scroll page
        window.scrollTo(0, document.body.scrollHeight);
        // Pusher code
        Pusher.logToConsole = true;
        var pusher = new Pusher('bd895c93ea5dca384f93', {
            cluster: 'ap2'
        });
        var channel = pusher.subscribe('my-channel');
        channel.bind('{{ $listenOn }}', function(data) {
            alert(JSON.stringify(data));
            // If listened mark that message as read:
            var messageId = data.message['id'];
            $.ajax({
                url: '/read/' + messageId,
                type: 'GET',
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
        // Listening for all chats:
        Pusher.logToConsole = true;
        var all_pusher = new Pusher('bd895c93ea5dca384f93', {
            cluster: 'ap2'
        });
        var all_channel = all_pusher.subscribe('all-chat');
        all_channel.bind('{{ auth()->user()->pusher_event }}', function(data) {
            // alert(JSON.stringify(data));
            if (data.message['chat_id'] === {{ $id }}) {
                // Do nothing the current chat message is already being managed by another pusher event
            } else {
                chat_element_id = data.message['chat_id'];
                var chatElement = $('#chat-' + chat_element_id);
                var lastMessage = data.message['message'];
                chatElement.find('.font-italic').text(lastMessage);
                var unreadMessagesBadge = chatElement.find('.badge');
                if (unreadMessagesBadge.length) {
                    // If the badge already exists, increment its value
                    var currentValue = parseInt(unreadMessagesBadge.text());
                    unreadMessagesBadge.text(currentValue + 1);
                } else {
                    chatElement.find('#badge-wrapper').after(
                        '<strong class="badge rounded-pill text-bg-danger m-0">1</strong>');
                }
                var createdAtDate =
                    getFormattedDateTime(); //Date and time is also coming from the backend which has to be removed soon
                chatElement.find('.font-weight-bold').text(createdAtDate);
            }
        });
    </script>

@endsection
@section('title')
    Student -
@endsection

@section('section1')
    <div class="profile-page">
        <div class="profile-page-part1">
            <div class="side-menu-list">
                <button class="profilebtn" onclick="window.location.href='/student_chat'">Back</button>
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
