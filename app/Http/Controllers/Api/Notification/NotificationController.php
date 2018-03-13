<?php

namespace App\Http\Controllers\Api\Notification;

use App\Models\Admin\PushNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    //
    public function getNotifications()
    {
        $notifications = PushNotification::whereNotNull('notification_sent_at')
            ->where('notification_sent_at','>',\DB::raw('DATE_SUB(NOW(),INTERVAL 10752 MINUTE)'))
            ->select('id','title', 'detail as description')
            ->orderBy('id','DESC')
            ->get();


        if (count($notifications)) {

            return $this->prepareResult(200, ['notifications' => $notifications], 'Result found', null);
        } else {
           return $this->prepareResult(204, null, 'No Notifications found', null);
        }
    }
}
