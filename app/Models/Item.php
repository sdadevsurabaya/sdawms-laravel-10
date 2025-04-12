<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['rack_id', 'name', 'qr_code', 'barcode', 'description'];

    public function rack()
    {
        return $this->belongsTo(Rack::class);
    }
}
