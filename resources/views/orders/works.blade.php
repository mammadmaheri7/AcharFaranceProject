@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit your works</h2>
            </div>
        </div>
    </div>



    @foreach ($orders as $order)
        <br>
        <form action="/orders/{{$order->id}}/change_status" method="POST">

            @csrf
            @method('POST')

            <div class="row">
                <h4 style="float: left">Skill : {{$order->skill->name_english}}</h4>

                <div style="margin-top: 60px">
                    <p style="float: left">
                    {{$order->body}}
                    </p>
                </div>

                <br>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Status:</strong>
                        <select name="order_status" id="order_status" class="form-control">
                            @foreach($statuses as $status)
                                @if($status->id != $order->order_status_id)
                                    <option value="{{$status->id}}"> {{$status->name}} </option>
                                @else
                                    <option selected="selected" value="{{$status->id}}"> {{$status->name}} </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <a class="btn btn-info" href="{{ route('orders.show',$order->id) }}">Show</a>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>


        </form>
        <br>
        <hr>
    @endforeach


@endsection