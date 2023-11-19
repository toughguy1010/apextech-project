<?php

namespace App\Http\Controllers;

use App\Models\ReceiverNotification;
use App\Models\ReportNotification;
use App\Models\User;
use Illuminate\Http\Request;
class Notification extends Controller
{
    //
    public function getNotification($id){
        $notifications = ReceiverNotification::getAllNotificationsByReceiverId($id);
        return view('layouts.notifications',[
            'notifications' => $notifications
        ]);

    }

}
