@extends('layout')

@section('content')
    <h1>Adding Scope ?</h1>

    <form action="/scopes" method="post" role="form" enctype="multipart/form-data" class="col-md-6">

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
            <label for="photo">Photo</label>
            <input type="file" class="form-control" name="photo" id="photo" value="{{old('photo')}}" >
        </div>

        <div class="form-group">
            <button type="submit"  class="btn btn-primary">Create Scope</button>
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