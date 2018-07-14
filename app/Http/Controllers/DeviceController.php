<?php

namespace App\Http\Controllers;

use App\Device;
use App\Mail\AddedWorkDevice;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Session;
use Illuminate\Support\Facades\Mail;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('device.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'device_id' => 'required|max:50|min:3',
            'long' => 'required|min:2',
            'lat' => 'required|min:2',
        ]);

        $data = $request->all();
        $device = new Device();
        $device->device_id = $data['device_id'];
        $device->long = $data['long'];
        $device->lat = $data['lat'];
        $device->location = $data['location'];

        if ($device->location === 'Home') {
            $device->save();
            $request->session()->flash('status', 'Coords sent!');
            return redirect(route('device.index'));
        }
        else {
            $device->save();

            Mail::to($request->user())->send(new AddedWorkDevice($device));

            $request->session()->flash('status', 'Coords & Mail sent!');
            return redirect(route('device.index'));
        }
    }

    public function send(Request $request)
    {

    }
}
