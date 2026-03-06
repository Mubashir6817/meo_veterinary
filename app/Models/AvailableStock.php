<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableStock extends Model
{
    use HasFactory;

    public function medicines(){
        return $this->belongsTo(Medicine::class,'medicines_id','id');
    }
}
