<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskComments extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'task_id',
        'comment',
    ];
    public static function getCommentsByTaskId($taskId)
    {
        return self::where('task_id', $taskId)->get();
    }
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

}
