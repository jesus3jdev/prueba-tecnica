<div>

<!-- Botón para agregar una nueva tarea (Por defecto en estado 'Pendiente')-->
<button type="button" class="btn btn-secondary mb-5" wire:click="mostrarTareaVacia()"><i class="fa-solid fa-square-plus"></i> Crear nueva tarea</button>
 

@if (session()->has('mensajeTareaCreada'))
<div class="alert alert-success  alert-dismissible fade show mensajeCreacionTarea" role="alert">
    {{ session('mensajeTareaCreada') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
@endif

<div class="row">

    <!--Recorremos el array de estados y mostramos una columna para cada uno de ellos-->
    @foreach($estados as $estado)
        <div class="col-sm-12 col-md-4 text-center" >
            <h3 class="font-semibold">{{ $estado }} </h3>
            <!--Cuando movemos una tarea emitimos un evento a Livewire en el que pasamos como parámetros
            el ID de la tarea que estamos moviendo y el nuevo estado (asignado a cada col)-->
            <div
                class=" dropzone"
                data-estado="{{ $estado }}"
                ondrop="handleDrop(event, '{{ $estado }}')"
                ondragover="event.preventDefault();"
            >

                <!-- Si no hay tareas en alguno de los estados mostramos mensaje por pantalla -->
                @if($tareasUsuario->where('estado', $estado)->count() == 0)
                    <div class="alert alert-warning" role="alert">No hay tareas en este estado</div>
                @endif

                <!-- Creamos una card vacía para mostrar y poder rellenar cuando pulsemos en -Crear nueva tarea-
                 por defecto en estado pendiente -->
                @if($estado == "Pendiente")
                     <div class="card mt-5" style="display:{{$visibilidadCrearTarea}}">
                            <input class="card-header"  type="text" wire:model="tituloTareaCrear" >
                            @error('tituloTareaCrear')<p class="text-danger text-sm">{{ $message }}</p> @enderror
                        <div class="card-body">
                            <textarea class="card-title text-start" wire:model="descripcionTareaCrear"></textarea>
                            @error('descripcionTareaCrear') <p class="text-danger text-sm">{{ $message }}</p> @enderror
                            <p class="card-text text-start mt-4 text-sm"><strong>Estado (por defecto):</strong>&nbsp;Pendiente</p>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-success card-link" wire:click="crearTarea()" >Crear tarea</button>
                            <button type="button" class="btn btn-warning card-link" wire:click="ocultarEdicionTareaNueva()" >Cancelar</button>
                        </div>
                    </div>
                @endif


                <!--Recorremos las tareas correspondientes a cada estado -->
                @foreach($tareasUsuario->where('estado', $estado) as $tarea)


                    <!--Anidamos componente Livewire para poder realizar las acciones necesarias
                    (Editar y Eliminar) por cada tarea-->
                      @livewire('card-tarea', ['tarea' => $tarea], key($tarea->id))


                @endforeach
            </div>
        </div>
    @endforeach
</div>


</div>