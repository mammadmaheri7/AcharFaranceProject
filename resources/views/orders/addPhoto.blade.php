@extends('layout')

@section('content')

    <h1>Adding Photo To Order?</h1>

    <h2>{{$order->id}}</h2>
    <form class="dropzone" action="/orders/{{$order->id}}/photos" method="post" id="addPhotosForm">
        {{csrf_field()}}
    </form>

    @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error )
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <script>
        Dropzone.options.addPhotosForm = {
            paramName:"file" ,
            maxFilesize:3 ,
            acceptedFiles:'.jpg,.png,.jpeg,.gif'
        };
    </script>

@endsection