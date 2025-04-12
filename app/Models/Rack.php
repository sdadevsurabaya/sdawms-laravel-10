<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rack extends Model
{
    use HasFactory;

    protected $fillable = ['warehouse_id', 'rack_number', 'barcode', 'gr_code'];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
