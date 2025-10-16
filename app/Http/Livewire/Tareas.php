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
    public $titulo;
    public $descripcion;
    public $visibilidadInputTitulo = "none";
    public $visibilidadTitulo = "block";
    public $visibilidadTextareaDescripcion = "none";
    public $visibilidadDescripcion = "block";
    public $visibilidadbotonGuardar = "none";
    public $visibilidadbotonCancelar = "none";

    //Con esta linea declaramos el listener que escuchará al evento que emitimos al mover y soltar una tarea
    protected $listeners = ['eventoActualizarEstado' => 'actualizarEstado'];

    public $estados = ['Pendiente', 'En progreso', 'Completado'];

    public function mount()
    {
        /*Obtenemos el usuario logueado y todas sus tareas*/
        $this->usuariologueado= Auth::user();
        $this->tareasUsuario =  User::find($this->usuariologueado->id)->tareas()->get();
    }

    public function actualizarEstado($tareaId, $nuevoEstado)
    {
        /*Comprobamos que la tarea que hemos movido exista, posteriormente cambiamos su estado y 
        volvemos a pintar todas las tareas del usuario con los valores actualizados*/
        $tarea = Tarea::find($tareaId);
        if ($tarea) {
            $tarea->estado = $nuevoEstado;
            $tarea->save();
            $this->mount();
        }
    }

    public function visibilidadEditarCampo($id,$campo){
        /*Asignamos a las variables los valores de la BBDD para que nos aparezca a la hora de editar el campo.
        Además mostramos botones Cancelar y Guardar.*/
        $this->titulo = Tarea::find($id)->titulo;
        $this->descripcion = Tarea::find($id)->descripcion;
        $this->visibilidadbotonCancelar = "inline";
        $this->visibilidadbotonGuardar = "inline";
        
        /*Mostramos los campos editables al pinchar*/
        if($campo == "titulo"){
            $this->visibilidadInputTitulo = "block";
            $this->visibilidadTitulo = "none";  
 
        }

        if($campo == "descripcion"){
            $this->visibilidadTextareaDescripcion = "block";
            $this->visibilidadDescripcion = "none";  
        }
 
    }

      public function editarCampos($id){
        /*Buscamos la tarea a editar, asignamos los nuevos valores, guardamos y ocultamos botones.*/
        $tarea = Tarea::find($id);
        if ($tarea) {
            $tarea->titulo = $this->titulo;
            $tarea->descripcion = $this->descripcion;
            $tarea->save();
            $this->mount();

            $this->visibilidadInputTitulo = "none";
            $this->visibilidadTitulo = "block"; 
            $this->visibilidadTextareaDescripcion = "none";
            $this->visibilidadDescripcion = "block";
            $this->visibilidadbotonCancelar = "none";
            $this->visibilidadbotonGuardar = "none";
        }
      }


      public function cancelarEdicion(){
        /*Ocultamos los campos editables y botones*/
        $this->visibilidadInputTitulo = "none";
        $this->visibilidadTitulo = "block"; 
        $this->visibilidadTextareaDescripcion = "none";
        $this->visibilidadDescripcion = "block";
        $this->visibilidadbotonGuardar = "none";
        $this->visibilidadbotonCancelar = "none";
      }


    public function render()
    {
        return view('livewire.tareas');
    }
}
