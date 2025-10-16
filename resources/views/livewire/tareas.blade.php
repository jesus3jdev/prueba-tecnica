<div>

<div class="row">
    <!--Recorremos el array de estados y mostramos una columna para cada uno de ellos-->
    @foreach($estados as $estado)
        <div class="col-sm-12 col-md-4 text-center" >
            <h3 class="font-semibold">{{ $estado }}</h3>
            <!--Cuando movemos una tarea emitimos un evento a Livewire en el que pasamos como parámetros
            el ID de la tarea que estamos moviendo y el nuevo estado (asignado a cada col)-->
            <div
                class=" dropzone"
                data-estado="{{ $estado }}"
                ondrop="handleDrop(event, '{{ $estado }}')"
                ondragover="event.preventDefault();"
            >
                <!--Recorremos las tareas correspondientes a cada estado -->
                @foreach($tareasUsuario->where('estado', $estado) as $tarea)
                    <div
                        class="card mt-5"
                        draggable="true"
                        id="tarea-{{ $tarea->id }}"
                        ondragstart="event.dataTransfer.setData('tarea-id', '{{ $tarea->id }}')"
                    >
                        <h5 class="card-header" wire:click="visibilidadEditarCampo('{{$tarea->id}}','titulo')" style="display:{{$visibilidadTitulo}}">{{ $tarea->titulo }}</h5>
                        <input class="card-header"  type="text" wire:model="titulo" value="{{$tarea->titulo}}" style="display:{{$visibilidadInputTitulo}}">
                        <div class="card-body">
                            <p class="card-title text-start" wire:click="visibilidadEditarCampo('{{$tarea->id}}','descripcion')" style="display:{{$visibilidadDescripcion}}">{{ $tarea->descripcion }}</p>
                            <textarea class="card-title text-start" wire:model="descripcion" style="display:{{$visibilidadTextareaDescripcion}}">{{ $tarea->descripcion }}</textarea>
                            <p class="card-text text-start mt-4 text-sm"><strong>Estado:</strong>&nbsp;{{ $tarea->estado}}</p>
                            <p class="card-text text-start text-sm"><strong>Creada:</strong>&nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $tarea->created_at)->addHour(2)->format('d-m-Y - H:i')}}</p>
                            <p class="card-text text-start text-sm"><strong>Modificada:</strong>&nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $tarea->updated_at)->addHour(2)->format('d-m-Y - H:i')}}</p>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-success card-link" wire:click="editarCampos('{{$tarea->id}}')" style="display: {{$visibilidadbotonGuardar}}">Guardar</button>
                            <button type="button" class="btn btn-warning card-link"  style="display: {{$visibilidadbotonCancelar}}">Cancelar</button>
                            <button type="button" class="btn btn-danger card-link">Eliminar</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<script>
    function handleDrop(event, nuevoEstado) {
    event.preventDefault();
    const tareaId = event.dataTransfer.getData('tarea-id');
    if (tareaId) {
        Livewire.emit('eventoActualizarEstado', tareaId, nuevoEstado);
    }
}
</script>

</div>