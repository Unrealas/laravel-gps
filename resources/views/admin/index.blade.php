@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-3">
            <div class="alert alert-success">Devices</div>
            <ul class="list-group">
                @foreach($device as $dev)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a class="dropdown-item" href="{{route('show',['lat' => $dev->lat, 'long' => $dev-> long, 'device_id'=>$dev->device_id])}}">{{$dev->device_id}}</a>
                    </li>
                @endforeach
            </ul>

        </div>
        <div  class="col-sm-9" style="min-width: 100vh; height: 75vh">
            {!! Mapper::render() !!}
        </div>
    </div>


@endsection