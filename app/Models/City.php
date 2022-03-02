<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'price', 'country_id'];

    public function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
