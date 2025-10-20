<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tarea;
use App\Models\Registro;

class CardTarea extends Component
{

    public Tarea $tarea;
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


    public function actualizarEstado($tareaId, $nuevoEstado)
    {
        /*Comprobamos que la tarea que hemos movido exista, posteriormente cambiamos su estado en bbdd y en el objeto,
         y volvemos a pintar todas las tareas del usuario con los valores actualizados*/
        $tarea = Tarea::find($tareaId);

        if ($tarea) {
            $tarea->estado = $nuevoEstado;
            $tarea->save();

            /*Refrescamos la instancia del modelo para que no utilice la vieja (!!Importante para que actualice
            los valores de las propiedades del componente CardTarea tras actualizar)*/
            $this->tarea = $tarea->fresh();

        /*Creamos registro de edición de estado*/
        $registro= new Registro;
        $registro->user_id= $tarea->user_id;
        $registro->accion= "Edición de estado en la tarea: " . $tarea->titulo  ." (ID: " . $tarea->id . ")";
        $registro->save();

        /*Emitimos evento para que el tablero se actualice sin recargar la página*/
        $this->emitUp('refrescarTareas');

        }
    }

    

     public function visibilidadEditarCampo($campo){
        /*Asignamos a las variables los valores de la BBDD para que nos aparezca a la hora de editar el campo.
        Además mostramos botones Cancelar y Guardar.*/

        $this->visibilidadbotonCancelar = "inline";
        $this->visibilidadbotonGuardar = "inline";
        
        /*Mostramos los campos editables al pinchar*/
        if($campo == "titulo"){
            $this->titulo = $this->tarea->titulo;
            $this->visibilidadInputTitulo = "block";
            $this->visibilidadTitulo = "none";  
 
        }

        if($campo == "descripcion"){
            $this->descripcion = $this->tarea->descripcion;
            $this->visibilidadTextareaDescripcion = "block";
            $this->visibilidadDescripcion = "none";  
        }
 
    }


    public function editarCampos(){
        /*Asignamos los nuevos valores, guardamos y ocultamos botones. Hago ternaria para comprobar si 
        el campo ha sido actualizado o no.*/
            $this->tarea->titulo = ($this->titulo != null) ? $this->titulo : $this->tarea->titulo;
            $this->tarea->descripcion = ($this->descripcion != null) ? $this->descripcion : $this->tarea->descripcion;
            $this->tarea->save();

            
            /*Lanzamos mensaje al editar una tarea*/
            session()->flash('mensajeTareaEditada', 'Tarea editada correctamente.');

            /*Creamos registro de edición de tarea*/
            $registro= new Registro;
            $registro->user_id= $this->tarea->user_id;
            $registro->accion= "Edición de campos en la tarea: " . $this->tarea->titulo  ." (ID: " . $this->tarea->id . ")";
            $registro->save();

            $this->visibilidadInputTitulo = "none";
            $this->visibilidadTitulo = "block"; 
            $this->visibilidadTextareaDescripcion = "none";
            $this->visibilidadDescripcion = "block";
            $this->visibilidadbotonCancelar = "none";
            $this->visibilidadbotonGuardar = "none";
      }


      public function cancelarEdicion(){
        //Ocultamos los campos editables y botones
        $this->visibilidadInputTitulo = "none";
        $this->visibilidadTitulo = "block"; 
        $this->visibilidadTextareaDescripcion = "none";
        $this->visibilidadDescripcion = "block";
        $this->visibilidadbotonGuardar = "none";
        $this->visibilidadbotonCancelar = "none";
      }


      public function eliminarTarea(){
        $id = $this->tarea->id;
        $this->tarea->delete();

        /*Creamos registro de eliminación de tarea*/
        $registro= new Registro;
        $registro->user_id= $this->tarea->user_id;
        $registro->accion= "Eliminación de tarea: " . $this->tarea->titulo  ." (ID: " . $this->tarea->id . ")";
        $registro->save();

        $this->emit('refrescarTareas');
        //Lanzamos evento al navegador para cerrar la modal tras eliminar la tarea
        $this->dispatchBrowserEvent('cerrarModalEliminar', ['id' => $id]);
      }


    public function render()
    {
        return view('livewire.card-tarea');
    }
}
