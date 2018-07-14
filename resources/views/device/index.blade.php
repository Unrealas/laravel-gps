@extends('layouts.app')
@section('content')
    <div class="containter">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Create new post
                    </div>
                    <div class="card-body">
                        {{--Form Start--}}
                        <form action={{route('device.store')}} method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">Device id</label>
                                <input type="text" class="form-control" id="device_id" name="device_id"
                                       placeholder="BMW 530">
                            </div>
                            <div class="form-group">
                                <label for="title">Latitude</label>
                                <input type="text" class="form-control" id="lat" name="lat" placeholder="54.707082">
                            </div>
                            <div class="form-group">
                                <label for="title">Longitude</label>
                                <input type="text" class="form-control" id="long" name="long" placeholder="25.288027">
                            </div>
                            <div class="form-group">
                                <label for="category">Select location</label>
                                <select class="form-control" id="location" name="location">
                                    <option>Home</option>
                                    <option>Work</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Send</button>
                            <br>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                {{--Form end--}}
            </div>
        </div>
    </div>
@endsection