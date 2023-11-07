<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskProcess extends Model
{
    use HasFactory;
    public function task() {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function assignees() {
        return $this->belongsToMany(User::class, 'task_process_assignees', 'task_process_id', 'user_id');
    }

}
