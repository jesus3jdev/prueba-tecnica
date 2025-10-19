<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;


    /*Definimos la relación 1:N entre usuario y registros.*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
