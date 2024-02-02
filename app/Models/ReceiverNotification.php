<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiverNotification extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_notification_id',
        'receiver_ids',
        'is_readed',
    ];

    public function notifications()
    {
        return $this->belongsTo(ReportNotification::class, 'report_notification_id');
    }
    public static function getAllNotificationsByReceiverId($receiverId)
    {
        return self::with('notifications')
            ->where('receiver_ids', $receiverId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public static function countUnreadNotifications($receiverId)
    {
        return self::where('receiver_ids', $receiverId)
        ->where('is_readed', 0)
        ->whereHas('notifications', function ($query) {
            $query->whereNotNull('task_id');
        })
        ->count();
    }
}
