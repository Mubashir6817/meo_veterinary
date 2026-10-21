<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sales_id', 'id');
    }

    public function medicines()
    {
        return $this->belongsTo(Medicine::class, 'medicines_id', 'id');
    }
}
