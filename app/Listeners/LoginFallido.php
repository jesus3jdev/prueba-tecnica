<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Registro;

class LoginFallido
{
    
    public function handle(Failed $event)
    {
        
        $user = $event->user; // Si existe devolverá datos del usuario, si no, null

        if($user)   {
            $registro = new Registro();
            $registro->user_id = $user->id;
            $registro->accion = 'Intento fallido de inicio de sesión';
            $registro->save();
        }


    }
}
