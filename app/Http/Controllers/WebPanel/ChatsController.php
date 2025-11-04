<?php

namespace App\Http\Controllers\WebPanel;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChatsController extends Controller
{
    //
    public function index()
    {
        return view('webPanel.chats.chat');
    }

    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages()
    {
        $user = Auth::user();

        $chatMessage = DB::table('chat_message')
            ->join('wsec_user', 'chat_message.to_user_no_fk', 'wsec_user.user_no_pk')
            ->where('to_user_no_fk', $user->user_no_pk)
            ->get();
        return $chatMessage;
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        //$message = $request->input('message');

        $sequence = DB::getSequence();
        $message_no_pk_seq = $sequence->nextValue('message_no_pk_seq');
        $message = Message::insert(
            [
                'message_no_pk' =>  $message_no_pk_seq,
                'user_no_fk' =>  $user->user_no_pk,
                'message_text' =>  $request->message,
                'to_user_no_fk' => 2504,
                'au_entry_by' => $user->user_no_pk,
                'au_entry_at' => Carbon::now(),
                'au_entry_session' => "CHAT",
                'au_entry_hospital_pk_no' => 141,
            ]
        );
        $message = Message::orderBy('message_no_pk', 'desc')->first();

        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
