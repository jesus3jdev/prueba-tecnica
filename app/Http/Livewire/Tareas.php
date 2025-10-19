<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Tarea;
use App\Models\Registro;

class Tareas extends Component
{

    public $tareasUsuario;
    public $usuariologueado;
    public $visibilidadCrearTarea = "none";
    public $tituloTareaCrear;
    public $descripcionTareaCrear;

    public $estados = ['Pendiente', 'En progreso', 'Completado'];

    //Evento lanzado tras mover una tarea de columna. Su función es volver a pintar el tablero.
    protected $listeners = ['refrescarTareas' => 'mount'];


    public function mount()
    {
        //Obtenemos el usuario logueado y todas sus tareas ordenadas de más actuales a más antiguas
        $this->usuariologueado= Auth::user();
        $this->tareasUsuario =  User::find($this->usuariologueado->id)->tareas()->get()->sortByDesc('created_at');
    }



    public function mostrarTareaVacia(){
       $this->visibilidadCrearTarea = "flex";
    }

    //Creamos una nueva tarea por defecto en estado 'Pendiente'
    public function crearTarea(){

        //Validamos los campos
        $validacion = $this->validate([
           'tituloTareaCrear' => 'required|string|max:200',
           'descripcionTareaCrear' => 'required|string',
            ], 
            [
            'tituloTareaCrear.required' => 'El título es obligatorio.',
            'descripcionTareaCrear.required' => 'La descripción es obligatoria.',
            ]
        );

       $nuevaTarea = new Tarea();
       $nuevaTarea->titulo = $validacion['tituloTareaCrear'];
       $nuevaTarea->descripcion = $validacion['descripcionTareaCrear'];
       $nuevaTarea->estado = 'Pendiente';
       $nuevaTarea->user_id = $this->usuariologueado->id;
       $nuevaTarea->save();
       $this->ocultarEdicionTareaNueva();

       
        /*Creamos registro de creación de tarea nueva*/
        $registro= new Registro;
        $registro->user_id= $this->usuariologueado->id;
        $registro->accion= "Creación de nueva tarea: ". $nuevaTarea->titulo . " (ID: " . $nuevaTarea->id . ")";
        $registro->save();

        $this->mount();

        session()->flash('mensajeTareaCreada', 'Tarea creada correctamente.');
    }


    public function ocultarEdicionTareaNueva(){
        $this->visibilidadCrearTarea = "none";
        $this->tituloTareaCrear = null;
        $this->descripcionTareaCrear = null;
    }


    public function render()
    {
        return view('livewire.tareas');
    }
}
