<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskProcess extends Model
{
    protected $fillable = [
        'id',
        'process_details',
        'process_status',
        'task_id',
    ];

    use HasFactory;
    public function task() {
        return $this->belongsToMany(Task::class, 'task_id', 'id');
    }

}
