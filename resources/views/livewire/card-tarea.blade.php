<div>
        <div
                        class="card mt-5"
                        draggable="true"
                        id="tarea-{{ $tarea->id }}"
                        ondragstart="event.dataTransfer.setData('tarea-id', '{{ $tarea->id }}')"
                    >
                        <h5 class="card-header" wire:click="visibilidadEditarCampo('titulo')" style="display:{{$visibilidadTitulo}}">{{ $tarea->titulo }}</h5>
                        <input class="card-header"  type="text" wire:model="titulo" value="{{$tarea->titulo}}" style="display:{{$visibilidadInputTitulo}}">
                        <div class="card-body">
                            <p class="card-title text-start" wire:click="visibilidadEditarCampo('descripcion')" style="display:{{$visibilidadDescripcion}}">{{ $tarea->descripcion }}</p>
                            <textarea class="card-title text-start" wire:model="descripcion" style="display:{{$visibilidadTextareaDescripcion}}">{{ $tarea->descripcion }}</textarea>
                            <p class="card-text text-start mt-4 text-sm"><strong>Estado:</strong>&nbsp;{{ $tarea->estado}}</p>
                            <p class="card-text text-start text-sm"><strong>Creada:</strong>&nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $tarea->created_at)->addHour(2)->format('d-m-Y - H:i')}}</p>
                            <p class="card-text text-start text-sm"><strong>Modificada:</strong>&nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $tarea->updated_at)->addHour(2)->format('d-m-Y - H:i')}}</p>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-success card-link" wire:click="editarCampos()" style="display: {{$visibilidadbotonGuardar}}">Guardar</button>
                            <button type="button" class="btn btn-warning card-link" wire:click="cancelarEdicion()" style="display: {{$visibilidadbotonCancelar}}">Cancelar</button>
                            <button type="button" class="btn btn-danger card-link" data-bs-toggle="modal" data-bs-target="#modalEliminarTarea-{{$tarea->id}}">Eliminar</button>
                        </div>
        </div>
  

        <!-- Modal eliminar tarea -->
        <div wire:ignore.self class="modal fade" id="modalEliminarTarea-{{$tarea->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Tarea</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-lg mb-4 fw-bold">¿Está seguro de que desea eliminar esta tarea?</p>

                <div class="card">
                        <h5 class="card-header">{{ $tarea->titulo }}</h5>
                        <div class="card-body">
                            <p class="card-title text-start" >{{ $tarea->descripcion }}</p>
                           
                            <p class="card-text text-start mt-4 text-sm"><strong>Estado:</strong>&nbsp;{{ $tarea->estado}}</p>
                            <p class="card-text text-start text-sm"><strong>Creada:</strong>&nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $tarea->created_at)->addHour(2)->format('d-m-Y - H:i')}}</p>
                            <p class="card-text text-start text-sm"><strong>Modificada:</strong>&nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $tarea->updated_at)->addHour(2)->format('d-m-Y - H:i')}}</p>
                        </div>
                </div>
                       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" wire:click="eliminarTarea()">Confirmar</button>
            </div>
            </div>
        </div>
        </div>



<script>
    function handleDrop(event, nuevoEstado) {
        event.preventDefault();
        let tareaId = event.dataTransfer.getData('tarea-id');
        if (tareaId) {
            Livewire.emit('eventoActualizarEstado', tareaId, nuevoEstado);
        }
    }

    document.addEventListener('cerrarModalEliminar', function (e) {
        let id = e.detail.id;
        let modalEliminar = document.getElementById('modalEliminarTarea-' + id);
        if (!modalEliminar) return;

        // Cerrar con la API de Bootstrap
        let modalInstancia = bootstrap.Modal.getInstance(modalEliminar) || new bootstrap.Modal(modalEliminar);
        modalInstancia.hide();
    });

    
</script>

</div>
