<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;
    public static function getAllBenefits($limit, $search, $all){
        $limit = $limit !== null ? $limit : 10;
        $query = Benefit::query();
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if($all == null){
            $benefits = $query->paginate($limit);
        }else{
            $benefits = $query->get();
            
        }
        return $benefits;
    }
}
