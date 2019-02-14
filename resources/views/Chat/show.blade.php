@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <audio id="ChatAudio">
        <source src="{{asset('sounds/chatNotification.mp3')}}">
    </audio>

    <meta name="friendId" content="{{$friend->id}}">
    <div class="containter">
        <div class="column is-8 is-offset-2">
            <div class="panel">
                <div class="panel-heading">
                    <div>
                        {{$friend->name}}

                    </div>

                    <div class="contain is-pulled-right">
                        <a href="{{url('/chat')}}" class="is-link">
                            <i class="fa fa-arrow-left"></i>
                            Back
                        </a>
                        </br>
                    </div>

                    <chat v-bind:chats="chats" v-bind:userid="{{Auth::user()->id}}"
                          v-bind:friendid="{{$friend->id}}">
                    </chat>


                </div>
            </div>
        </div>
    </div>
@endsection