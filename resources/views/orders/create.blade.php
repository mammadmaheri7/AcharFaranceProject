@extends('layout')


@section('content')
    <br>
    <h1>Adding Order ?</h1>

    <form action="/orders" method="post" role="form" enctype="multipart/form-data" class="col-md-6">

        {{csrf_field()}}


        <div class="form-group">
            <label for="skill">Skill</label>
            <select name="skill" id="skill" class="form-control">
                @foreach($skills as $skill )
                    <option value="{{$skill->id}}"> {{$skill->name_english}} </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="body">Order Description</label>
            <textarea class="form-control" name="body" id="body" rows="10">
                {{old('body')}}
            </textarea>
        </div>



        <div class="form-group">
            <button type="submit"  class="btn btn-primary">Create Order</button>
        </div>


        <div class="form-group">
            <label for="time">Time :</label>
            <input type="text" class="form-control" name="time" id="time" value="{{old('time')}}">
        </div>
        <div class="form-group">
            <label for="url">Url :</label>
            <input type="text" class="form-control" name="url" id="url" value="{{old('url')}}">
        </div>

    </form>

    @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all()   as $error )
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection