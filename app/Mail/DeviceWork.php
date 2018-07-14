<?php

namespace App\Mail;

use App\Device;
use App\Helpers\AppHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeviceWork extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Device $device)
    {
        $this->device = $device;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $lat = $this->device->lat;
        $long = $this->device->long;

        $result = \AppHelper::instance()->Nominatim($lat, $long);
        return $this->view('emails.devices')
            ->with([
                'deviceName' => $this->device->device_id,
                'address' => $result['display_name']
            ]);
    }

}
