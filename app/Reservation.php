<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'usuario_id', 'valor_reservado', 'fecha', 'modo_reserva',
    ];

    protected $table = 'reservas';

    public function week(){
        return $this->hasOne(Week::class, 'semana_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}