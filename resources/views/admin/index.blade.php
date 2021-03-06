@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-3">
            <div class="alert alert-success">Devices</div>
            <ul class="list-group">
                @forelse($device as $dev)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a class="dropdown-item"
                           href="{{route('show',['lat' => $dev->lat, 'long' => $dev-> long, 'device_id'=>$dev->device_id])}}">{{$dev->device_id}}</a>
                    </li>
                @empty
                    <div>No added devices...</div>
                @endforelse
                @if (!empty($diff))
                    <div class="alert alert-success"><p>Devices which are most farthest apart are <strong>{{$farth1}}
                                and {{$farth2}}</strong> , distance
                            between them is <strong>{{$diff}}</strong> km</p></div>
            @endif
        </div>
        <div class="col-sm-9" style="min-width: 100vh; height: 75vh">
            {!! Mapper::render() !!}
        </div>
    </div>


@endsection