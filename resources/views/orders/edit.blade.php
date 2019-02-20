@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Order</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('orders.index') }}"> Dashboard</a>
            </div>
        </div>
    </div>

    <form action="{{ route('orders.destroy',$order->id) }}" method="POST">

        <a class="btn btn-info" href="{{ route('orders.show',$order->id) }}">Show</a>

        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">Delete</button>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('orders.update',$order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Skill:</strong>
                    <select name="skill" id="skill" class="form-control">
                        @foreach($skills as $skill )
                            @if($order -> skill_id != $skill->id)
                                <option value="{{$skill->id}}"> {{$skill->name_english}} </option>
                            @else
                                <option selected="selected" value="{{$skill->id}}"> {{$skill->name_english}} </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Detail:</strong>
                    <textarea class="form-control" style="height:150px" name="body" placeholder="Detail">{{ $order->body }}</textarea>
                </div>
            </div>

            @if($order->recommended_price != null)
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Recommended Price:</strong>
                        <input type="text" name="recommended_price" value="{{ $order->recommended_price }}" class="form-control" placeholder="Name">
                    </div>
                </div>
            @endif

            <!--@if($order->recommended_deadline != null)
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Recommended Deadline:</strong>
                        <input type="text" name="recommended_deadline" value="{{ $order->recommended_deadline }}" class="form-control" placeholder="Name">
                    </div>
                </div>
            @endif
            -->

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Status : {{$order -> order_status -> name}}</strong>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>

@endsection