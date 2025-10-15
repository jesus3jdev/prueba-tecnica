<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;


    /*Definimos la relación 1:N entre usuario y tareas. En esta linea creamos la función
    que nos devolverá el usuario de una determinada tarea*/
    public function usuario()
    {

        return $this->belongsTo(User::class);

    }

}
