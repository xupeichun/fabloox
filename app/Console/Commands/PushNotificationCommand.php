<?php

namespace App\Console\Commands;

use App\Models\Access\Device\Device;
use Carbon\Carbon;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class PushNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Push notification to users devices';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return
     * mixed
     */

    private function makeLogs($data)
    {
        file_put_contents('/var/log/httpd/fabloox-push.log', PHP_EOL . print_r($data, true) . PHP_EOL . Carbon::now(),
            FILE_APPEND);
        chmod('/var/log/httpd/fabloox-push.log', 0777);
    }


    public function sendIosNotification($device, $notify)
    {
        $this->makeLogs("Inside IOS payload");
        $payload = [
            'aps' => [
                'alert' => [
                    'id' => $notify->id,
                    'title' => $notify->title,
                    "description" => $notify->detail
                ],

            ]
        ];


        $push = new PushNotification('apn');

        $feedback = null;


        $thePrams = [
            'aps' => [
                'alert' => [
                    'title' => $notify->title,
                    'body' => $notify->detail,
                ],
                'sound' => 'default'
            ]

        ];


        try {
            $feedback = $push->setMessage($thePrams)
                ->setDevicesToken($device->device_token)
                ->send()
                ->getFeedback();

            $this->info(print_r($feedback));

            $notify->notification_sent_at = Carbon::now();
            $notify->update();
        } catch (\Exception $e) {

            $this->makeLogs('notification failed for ');
            $this->makeLogs($device);

        }


        $param['request'] = request()->all();
        $param['response'] = print_r($feedback);
        try {
            $client = new Client([
                // Base URI is used with relative requests
                'base_uri' => 'https://script.google.com/macros/u/0/s/AKfycbxfS5GHdd26aRe0Q-x3vVrDVvdC_RukAi1mCfpVJ37WW8I2Gyr_/exec',
                // You can set any number of default request options.
                'timeout' => 0,
            ]);

            $response = $client->post('', [
                'form_params' => $param,
                /*            'headers' => [
                                'Authorization' => 'Bearer ' . $token,
                                'Accept' => 'application/json',
                            ]*/
            ]);
        } catch (\Exception $e) {

        }


    }

    public function sendAndroidNotification($device, $notify)
    {
        $this->makeLogs("Inside Android payload");
        $payload = [
            'title' => $notify->title,
            'body' => $notify->detail,
        ];

        $push = new PushNotification('fcm');


        $thePrams = [
            'data' =>
                [
                    'id' => $notify->id,
                    'title' => $notify->title,
                    'description' => $notify->detail
                ]
        ];

        try {
            $feedback = $push->setMessage($thePrams)
                ->setDevicesToken($device->device_token)
                ->send()
                ->getFeedback();

            $this->info(print_r($feedback));
            $this->info(print_r($thePrams));

            $notify->notification_sent_at = Carbon::now();
            $notify->update();
        } catch (\Exception $e) {

            $this->makeLogs('notification failed for ');
            $this->makeLogs($device);

        }


        $param['response'] = print_r($feedback);
        $param['notification'] = $thePrams;
        try {
            $client = new Client([
                // Base URI is used with relative requests
                'base_uri' => 'https://script.google.com/a/origamistudios.us/macros/s/AKfycbzEUtB0vl4PxHPDBwEYPECcqQ4rSbBZwKduYcl3efgMSbjLnuk/exec?usp=sharing',
                // You can set any number of default request options.
                'timeout' => 0,
            ]);

            $response = $client->post('', [
                'form_params' => $param,
                /*            'headers' => [
                                'Authorization' => 'Bearer ' . $token,
                                'Accept' => 'application/json',
                            ]*/
            ]);
        } catch (\Exception $e) {

        }


    }


    public function handle()
    {
        //

        $this->makeLogs('Cron Job Started');


        $notifications = \App\Models\Admin\PushNotification::whereNull('notification_sent_at')
//            ->where('time', Carbon::now());
            ->where('time', '<', \DB::raw('DATE_SUB(NOW(),INTERVAL 1 MINUTE)'))
            ->get();


        $this->info('Notifications table', print_r($notifications));

        $devices = Device::all();


        foreach ($notifications as $notify) {


            foreach ($devices as $device) {


                $this->info('Inside Devices', print_r($device));


                if (strtolower($device->device_type) == 'ios') {

                    $this->info('Inside Devices ios devices');
                    $this->sendIosNotification($device, $notify);;
                } elseif (strtolower($device->device_type) == 'android') {

                    $this->info('Inside Devices android devices');
                    $this->sendAndroidNotification($device, $notify);
                } else {

                    $this->makeLogs("Device Type is wrong");
                    $this->makeLogs($device);
                }
            }


        }

        $this->info("Cron Job Running");

    }
}
