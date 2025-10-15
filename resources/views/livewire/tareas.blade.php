<div>

<div class="row">
    @foreach(['Pendiente', 'En progreso', 'Completado'] as $estado)
        <div class="col-sm-12 col-md-4 text-center" >
            <h3 class="font-semibold">{{ $estado }}</h3>
            <div
                class=" dropzone"
                data-estado="{{ $estado }}"
                ondrop="handleDrop(event, '{{ $estado }}')"
                ondragover="event.preventDefault();"
            >
                @foreach($tareasUsuario->where('estado', $estado) as $tarea)
                    <div
                        class="card mt-5"
                        draggable="true"
                        id="tarea-{{ $tarea->id }}"
                        ondragstart="event.dataTransfer.setData('tarea-id', '{{ $tarea->id }}')"
                    >
                        <h5 class="card-header">{{ $tarea->estado }}</h5>
                        <div class="card-body">
                            <h5 class="card-title">{{ $tarea->titulo }}</h5>
                            <p class="card-text">{{ $tarea->descripcion }}</p>
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