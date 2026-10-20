<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    public function availableStocks()
    {
        return $this->hasMany(AvailableStock::class, 'medicines_id');
    }
    public function stockIn()
    {
        return $this->hasMany(StockIn::class, 'medicines_id');
    }
}
