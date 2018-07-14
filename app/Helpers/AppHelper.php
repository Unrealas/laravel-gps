<?php
namespace App\Helpers;

use maxh\Nominatim\Nominatim;

class AppHelper
{
    public function bladeHelper($someValue)
    {
        return "increment $someValue";
    }

    public function Nominatim($lat,$long)
    {

        $url = "http://nominatim.openstreetmap.org/";
        $nominatim = new Nominatim($url);

        $reverse = $nominatim->newReverse()
            ->latlon($lat, $long)
            ->language('en');

        return $nominatim->find($reverse);
    }


    public static function instance()
    {
        return new AppHelper();
    }
}