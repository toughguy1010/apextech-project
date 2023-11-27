<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Position extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->hasMany(User::class, 'position_id');
    }

    public static function getPositionCodeByUser($user)
    {
        $positionId = $user->position_id;
        $position = self::find($positionId);
        return $position ? $position->position_code : 'Không có dữ liệu';
    }
    public static function getPositionNameByUser($user)
    {
        $positionId = $user->position_id;
        $position = self::find($positionId);
        return $position ? $position->position_name : 'Không có dữ liệu';
    }
    public static function getUsersByPositionCode($code = null)
    {
        $position = Position::where('position_code', 'like', '%' . $code . '%')->first();
        if ($position) {
            $users = $position->users;
            return $users;
        } else {
            return null;
        }
    }
}
