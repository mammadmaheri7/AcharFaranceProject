<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\BroadcastChat;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $friends = Auth::user()->friends();
        return view('chat.index')->withFriends($friends);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Chat $chat
     */
    public function show($id)
    {

        $friend = User::find($id);
        //$this -> authorize('showPv',$friend);
        //$this->authorize('showpv',$friend);
        return view('chat.show')->withFriend($friend);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }

    public function getChat($id)
    {
        $chats = Chat::where(function ($query) use ($id)
        {
            $query -> where('user_id','=',$id)->where('friend_id','=',Auth::user()->id);
        })->orWhere(function ($query) use ($id){
            $query->where('friend_id','=',$id) -> where('user_id','=',Auth::user()->id);
        })->get();

        return $chats;
    }

    public function sendChat(Request $request)
    {
        $chat = Chat::create([
            'user_id' => $request->user_id,
            'friend_id' => $request->friend_id,
            'chat' => $request->chat
        ]);

        //BroadcastChat trigger when ever Chat created
        //broadcast(new BroadcastChat($chat));

        return [];
    }
}
