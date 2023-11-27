<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class ReportNotification extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_user',
        'type',
        'task_id',
        'datetime',
    ];
    public function receivers()
    {
        return $this->hasMany(ReceiverNotification::class);
    }

    public static function addNotification($from_user, $receiver_ids, $type, $task_id)
    {
        $notification = self::create([
            'from_user' => $from_user,
            'type' => $type,
            'task_id' => $task_id,
            'datetime' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);
        foreach ($receiver_ids as $receiver_id) {
            $notification->receivers()->create(['receiver_ids' => $receiver_id]);
        }
    
        return $notification;
    }
    
}
