<?php

namespace App\Http\Controllers\Api\TestNotification;

use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Console\Command;

class TestNotificationController extends Controller
{
    public function getNotification(Request $request)
    {
        $push = new PushNotification('apn');
        $thePrams = [
            'aps' => [
                'alert' => [
                    'title' => "asdad",
                    'body' => "akusdhuaksdha audy aosydao syd",
                ],
                'sound' => 'default'
            ]

        ];
        $feedback = $push->setMessage($thePrams)
            ->setDevicesToken('afb86443474defcd8a33f7ce578c8729634dfc29bda83c7708fc4e454c238fa3')
            ->send();

        dd($feedback);
    }
}