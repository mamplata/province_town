<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityTown extends Model
{
    protected $table = "citytowns";
    protected $primaryKey = "citytown_id";

    protected $hidden = [
        "province_id",
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
