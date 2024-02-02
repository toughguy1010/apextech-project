<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAssignee extends Model
{
    protected $fillable = [
        'id',
        'task_id',
        'user_id',
        'created_at',
        'updated_at',
     
    ];
    use HasFactory;
}
