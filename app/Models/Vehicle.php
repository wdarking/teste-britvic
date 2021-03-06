<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'year',
        'model',
        'brand',
        'license_plate',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Getter for vehicle description.
     *
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return sprintf(
            "%s | %s | %s | %s",
            $this->model,
            $this->year,
            $this->brand,
            $this->license_plate
        );
    }
}
