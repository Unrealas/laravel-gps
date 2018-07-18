<?php

namespace App\Http\Controllers;

use App\Device;
use App\Helpers\AppHelper;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Illuminate\Http\Request;
use Location\Coordinate;
use Location\Distance\Vincenty;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        Mapper::map(30, 0, ['ui' => false, 'zoom' => 2, 'center' => true, 'marker' => false]);
        $device = Device::all();

        $latLonArr = Device::select(['device_id', 'lat', 'long', 'id'])
            ->get()
            ->toArray();

        if (count($latLonArr) > 1) {
            $idLotLanArr = [];
            foreach ($latLonArr as $key => $value) {
                $idLotLanArr[$value['id']] = $value;
            }

            $zeroPoint = new Coordinate(0, 0);

            $distsFrom0 = [];
            foreach ($idLotLanArr as $item) {
                $end = new Coordinate($item['lat'], $item['long']);
                $res = ($zeroPoint->getDistance($end, new Vincenty())) / 1000;
                $distsFrom0[$item['id']] = $res;
            }

            $farthest1 = array_search(max($distsFrom0), $distsFrom0);
            $latLonExFarth = array_diff_key($idLotLanArr, [$farthest1 => 0]);

            $newStart = new Coordinate($idLotLanArr[$farthest1]['lat'], $idLotLanArr[$farthest1]['long']);

            $distsFromFarth = [];
            foreach ($latLonExFarth as $item) {
                $end = new Coordinate($item['lat'], $item['long']);
                $res = ($newStart->getDistance($end, new Vincenty())) / 1000;
                $distsFromFarth[$item['id']] = $res;
            }

            $farthest2 = array_search(max($distsFromFarth), $distsFromFarth);
            $diff = round(max($distsFromFarth), 2, PHP_ROUND_HALF_EVEN);

            $farth1id = $idLotLanArr[$farthest1]['device_id'];
            $farth2id = $idLotLanArr[$farthest2]['device_id'];

            return view('admin.index', ['device' => $device, 'diff' => $diff, 'farth1' => $farth1id, 'farth2' => $farth2id]);

        }
        return view('admin.index', ['device' => $device]);

    }

    public function show($lat, $long, $device_id)
    {
        $device = Device::all();
        $result = AppHelper::instance()->Nominatim($lat, $long);
        $cont = ['<strong>Device name:</strong>', $device_id, '', '<strong>Address:</strong>', $result['display_name']];
        $content = implode("<br> ", $cont);

        Mapper::map($lat, $long, ['zoom' => 7, 'center' => true, 'marker' => false])->informationWindow($lat, $long, $content, ['open' => false, 'maxWidth' => 200]);

        return view('admin.show', ['device' => $device, 'lat' => $lat, 'long' => $long, 'device_id' => $device_id]);

    }
}
