<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Events\AllChatEvent;
use App\Models\Chat;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function initiateChat(string $id)
    {
        $id = (int) $id;

        if (!User::find($id)) {
            return redirect()->back()->withErrors('User not found.');
        }

        if ($id === Auth::id()) {
            return redirect()->back();
        }

        $user = Auth::user();
        $relatedChatExists = false;
        $existingChatId = null;

        if ($user->chats) {
            foreach ($user->chats as $chat) {
                if ($chat->users()->where('users.id', $id)->exists()) {
                    $relatedChatExists = true;
                    $existingChatId = $chat->id;
                    break;
                }
            }
        }

        if ($relatedChatExists) {
            return redirect('/chat/' . $existingChatId);
        }

        $chat = Chat::create([
            'pe_1' => Str::random(),
            'pe_2' => Str::random(),
        ]);

        $chat->users()->attach([Auth::id(), $id]);

        return redirect('/chat/' . $chat->id);
    }

    public function showChats($id = null)
    {
        $user = Auth::user();
        $chats = $user->chats()->with(['users', 'messages' => function ($query) {
            $query->latest();
        }])->get()->sortByDesc(function ($chat) {
            return $chat->messages->isNotEmpty() ? $chat->messages->first()->created_at : $chat->created_at;
        });

        $currentChatMessages = null;
        $otherUser = null;

        if ($id) {
            $currentChat = $user->chats()->with(['messages' => function ($query) {
                $query->latest();
            }, 'users'])->findOrFail($id);

            $currentChatMessages = $currentChat->messages;
            $otherUser = $currentChat->users->where('id', '!=', $user->id)->first();
        }

        return view('chats', compact('chats', 'currentChatMessages', 'otherUser', 'id'));
    }

    public function addMessage(Request $request, string $pe)
    {
        $chat = Chat::find($request->chat_id);
        if (Auth::id() == $chat->users->first()->id || Auth::id() == $chat->users->last()->id) {
            $msg = Message::create([
                'msg' => $request->msg,
                'user_id' => Auth::id(),
                'chat_id' => $request->chat_id,
            ]);

            broadcast(new ChatEvent($msg))->toOthers();

            return response()->json(['message' => 'Message sent successfully']);
        } else {
            return response()->json(['message' => 'You can\'t send to another chat'], 400);
        }
    }

    public function showChat(string $id = 'none')
    {
        $user = Auth::user();

        // Determine the role of the user and get their chats
        if (in_array($user->role, ['teacher', 'guardian', 'student'])) {
            $chats = $user->chats()->with(['users', 'messages'])->get();
            $sortedChats = $chats->sortByDesc(function ($chat) {
                $latestMessage = $chat->messages->last();
                return $latestMessage ? $latestMessage->created_at : $chat->created_at;
            });

            $otherUser = null;
            $broadON = 'random';
            $listenOn = 'random';
            $currentChatMessages = collect(); // Initialize as empty collection

            if ($id != 'none') {
                $currentChat = Chat::find($id);

                if ($currentChat) {
                    $unreadMessages = $currentChat->messages()->where('user_id', '!=', $user->id)->where('receipt', 0)->get();
                    foreach ($unreadMessages as $message) {
                        $message->receipt = 1;
                        $message->save();
                    }

                    if (!$currentChat->users->contains($user)) {
                        return redirect('/chat');
                    }

                    $currentChatMessages = $currentChat->messages()->orderBy('created_at', 'asc')->get();
                    $otherUser = $currentChat->users()->where('users.id', '!=', $user->id)->first()->name;

                    $broadON = ($currentChat->pe_1 == $user->id) ? $currentChat->pe_2 : $currentChat->pe_1;
                    $listenOn = ($currentChat->pe_1 == $user->id) ? $currentChat->pe_1 : $currentChat->pe_2;
                } else {
                    return redirect('/chat');
                }
            }

            // Determine the view based on the user role
            $viewName = '';
            switch ($user->role) {
                case 'teacher':
                    $viewName = 'teacher.chat';
                    break;
                case 'guardian':
                    $viewName = 'guardian.chat';
                    break;
                case 'student':
                    $viewName = 'student.chat';
                    break;
            }

            return view($viewName, [
                'id' => $id,
                'chats' => $sortedChats,
                'currentChatMessages' => $currentChatMessages,
                'otherUser' => $otherUser,
                'broadOn' => $broadON,
                'listenOn' => $listenOn,
            ]);
        }

        // Redirect if the user role is not one of the expected roles
        return redirect('/login');
    }

}
