<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Property extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'pais', 'provincia', 'localidad', 'calle', 'numero', 'precio', 'estrellas', 'capacidad', 'habitaciones', 'baños', 'capacidad_vehiculos',
    ];

    public function getImageAttribute()
    {
        return $this->image_path;
    }
}
