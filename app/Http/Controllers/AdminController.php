<?php

namespace App\Http\Controllers;

use App\Device;
use App\Helpers\AppHelper;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        Mapper::map(53,15, ['ui' => false, 'zoom' => 5, 'center' => true, 'marker' => false]);
        $device=Device::all();
        return view('admin.index',['device' => $device]);

    }
    public function show($lat,$long, $device_id)
    {
        $device=Device::all();

        $result = AppHelper::instance()->Nominatim($lat,$long);

        $cont = ['<strong>Device name:</strong>',$device_id,'','<strong>Address:</strong>',$result['display_name']];

        $content = implode("<br> ",$cont);

        Mapper::map($lat,$long, ['zoom' => 7, 'center' => true, 'marker' => false])->informationWindow($lat, $long, $content, ['open' => false, 'maxWidth'=> 200]);

        return view('admin.index',['device' => $device, 'lat' => $lat, 'long' =>$long, 'device_id' => $device_id]);

    }

    public function calculate()
    {

    }
}
