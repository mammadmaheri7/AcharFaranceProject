@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="column is-8 is-offset-2">
            <div class="panel-heading">
                List of all Friends
            </div>
            @forelse($friends as $friend)
                    <a href="{{route('chat.show',$friend->id)}}">
                        {{$friend->name}}
                    </a>

                @empty
                    <div class="panel-block">
                        You dont have any friend
                    </div>
            @endforelse
        </div>
    </div>
@endsection