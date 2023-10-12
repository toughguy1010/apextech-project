<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;


    public static function getPositionCodeByUser($user)
    {
        $positionId = $user->position_id;
        $position = self::find($positionId);
        return $position ? $position->position_code : 'unknown';
    }
}
