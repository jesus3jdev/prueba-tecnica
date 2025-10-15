<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Tarea;

class Tareas extends Component
{

    public $tareasUsuario;
    public $usuariologueado;

    //Con esta linea declaramos el listener que escuchará al evento que emitamos al mover y soltar una tarea
    protected $listeners = ['eventoActualizarEstado' => 'actualizarEstado'];

    public function mount()
    {
        /*Obtenemos el usuario logueado y todas sus tareas*/
        $this->usuariologueado= Auth::user();
        $this->tareasUsuario =  User::find($this->usuariologueado->id)->tareas()->get();
    }

    public function actualizarEstado($tareaId, $nuevoEstado)
    {
        /*Comprobamos que la tarea que hemos movido exista, posteriormente cambiamos su estamos
        volvemos a pintar todas las tareas del usuario con los valores actualizados*/
        $tarea = Tarea::find($tareaId);
        if ($tarea) {
            $tarea->estado = $nuevoEstado;
            $tarea->save();
            $this->mount();
        }
    }


    public function render()
    {
        return view('livewire.tareas');
    }
}
