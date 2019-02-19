<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\BroadcastChat;
use App\User;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;

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
        $user_id = Auth::user()->getAuthIdentifier();
        $friends = Auth::user()->friends() ;
        $array = null;

        foreach ($friends as $f)
        {
            $array[] = $f->id;

        }
        Log::info(print_r($array, true));
        //$friends_id = array_map(create_function('$o', 'return $o->id;'), (array)$friends);
        //$friends_id = array_column((array)$friends, 'id');



        /*
        if(!Validator::make($request->toArray(), [
            'friend_id' => [
                'required',
                Rule::in([$array]),
            ],

        ]))
        {
            return response([
                'success' => false,
                'message' => 'unvalid send message'
            ], 404);
        }
        */

        Validator::make($request->toArray(), [
            'friend_id' => [
                'required',
                Rule::in($array),
            ],

        ])->validate();

        $user = Auth::user();
        $chat = Chat::create([
            'user_id' => $user->getAuthIdentifier(),
            'friend_id' => $request->friend_id,
            'chat' => $request->chat
        ]);

        //BroadcastChat trigger when ever Chat created
        //broadcast(new BroadcastChat($chat));

        return [];
    }
}
