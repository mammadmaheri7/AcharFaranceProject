@extends('layout')

@section('content')
    <h1>Adding Skill ?</h1>

    <form action="/skills" method="post" role="form" enctype="multipart/form-data" class="col-md-6">

        {{csrf_field()}}

        <div class="form-group">
            <label for="name_english">Name (English) :</label>
            <input type="text" class="form-control" name="name_english" id="name_english" value="{{old('name_english')}}">
        </div>

        <div class="form-group">
            <label for="name_farsi">Name (Farsi) :</label>
            <input type="text" class="form-control" name="name_farsi" id="name_farsi" value="{{old('name_farsi')}}">
        </div>

        <div class="form-group">
            <label for="body">Scope Description</label>
            <textarea class="form-control" name="body" id="body" rows="10">
                {{old('body')}}
            </textarea>
        </div>

        <div class="form-group">
            <label for="scope">Scope</label>
            <select name="scope" id="scope" class="form-control">
                @foreach($scopes as $scope )
                    <option value="{{$scope->id}}"> {{$scope->name_english}} </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <button type="submit"  class="btn btn-primary">Create Skill</button>
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