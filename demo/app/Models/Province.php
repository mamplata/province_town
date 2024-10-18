<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{

    protected $table = "provinces";
    protected $primaryKey = "province_id";

    protected $hidden = [
        'region_id',
    ];

    public function citytowns()
    {
        return $this->hasMany(CityTown::class, 'province_id', 'province_id')
            ->select('citytown_id', 'province_id', 'citytown_name') // Select the necessary fields
            ->orderBy('citytown_name', 'asc');
    }
}
