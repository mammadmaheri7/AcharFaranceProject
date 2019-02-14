@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="column is-8 is-offset-2">
            <div class="panel">
            <div class="panel-heading">
                List of all Friends
            </div>
            @forelse($friends as $friend)
                    <a href="{{route('chat.show',$friend->id)}}"
                     class="panel-block" style="justify-content: space-between;">
                        <div>
                           {{$friend->name}}
                        </div>

                        <onlineuser v-bind:friend="{{$friend}}"
                                    v-bind:online-users="onlineUsers">
                        </onlineuser>

                    </a>

                @empty
                    <div class="panel-block">
                        You dont have any friend
                    </div>
            @endforelse
            </div>
        </div>
    </div>
@endsection