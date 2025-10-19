<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /*Definimos la relación 1:N entre usuario y tareas. En esta linea creamos la función
    que nos devolverá todas las tareas de un usuario*/
    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }

    /*Definimos la relación 1:N entre usuario y registros.*/
        public function registros()
    {
        return $this->hasMany(Registro::class);
    }

}
