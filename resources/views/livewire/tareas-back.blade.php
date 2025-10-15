<div>
    
    @foreach ($tareasUsuario as $tarea)

                    <div class="row">

                        <!-- Columna tareas Pendientes-->
                        <div class="col-sm-12 col-md-4 text-center">
                            <h3 class="font-semibold">Pendiente</h3>


                            @if($tarea->estado == 'Pendiente')
                                <div class="card mt-5">
                                    <h5 class="card-header">$tarea->estado</h5>
                                    <div class="card-body">
                                        <h5 class="card-title">Special title treatment</h5>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                        <a href="#" class="btn btn-primary">Go somewhere</a>
                                    </div>
                                </div>
                            @endif


                        </div>
                        <!-- Fin columna tareas Pendientes-->

                        <!-- Columna tareas En Progreso-->
                        <div class="col-sm-12 col-md-4 text-center">
                            <h3 class="font-semibold">En Progreso</h3>
                        </div>
                        <!-- Fin columna tareas En Progreso-->

                        <!-- Columna tareas Completadas-->
                        <div class="col-sm-12 col-md-4 text-center">
                            <h3 class="font-semibold">Completado</h3>
                        </div>
                         <!-- Fin columna tareas Completadas-->

                    </div>

    @endforeach


</div>
