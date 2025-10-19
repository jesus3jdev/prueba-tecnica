<div>
    
<div class="row">

<!-- Implementamos filto de registros por usuario -->
<div class="col-sm-12 col-md-3">
<select class="form-select mb-4" wire:model="usuarioSeleccionado">
  <option value="">Todos los usuarios</option>
  @foreach($usuarios as $usuario)
    <option value="{{$usuario->id}}">{{$usuario->name}}</option>
  @endforeach
</select>
</div>

<!-- Implementamos filto de registros por acción -->
<div class="col-sm-12 col-md-3">
<select class="form-select mb-4" wire:model="accionSeleccionada">
  <option value="">Todas las acciones</option>
  <option value="Creación de nuevo usuario">Creación de usuario</option>
  <option value="Inicio de sesión correcto">Inicio de sesión</option>
  <option value="Cierre de sesión">Cierre de sesión</option>
  <option value="Intento fallido de inicio de sesión">Intento de inicio de sesión</option>
  <option value="Creación de nueva tarea">Crear tarea</option>
  <option value="Edición de tarea">Modificar tarea</option>
  <option value="Edición de estado en la tarea">Modificar estado tarea</option>
  <option value="Eliminación de tarea">Eliminar tarea</option>
</select>
</div>


</div>


<div>
<table class="table">
  <thead class="table-dark">
    <th>Acción</th>
    <th>Usuario</th>
    <th>Email</th>
    <th wire:click="cambiarOrden()" class="cursor">Fecha <i class="fa-solid {{$iconoFecha}}"></i> </th>
  </thead>
  <tbody>
    <!-- Mostramos todos los registros de un usuario y los mostramos por pantalla con paginación. -->
    @foreach($registrosAuditoria as $registro)

    <tr>
        <td class="text-sm">{{$registro->accion}}</td>
        <td class="text-sm">{{$registro->user->name}}</td>
        <td class="text-sm">{{$registro->user->email}}</td>
        <td class="text-sm">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $registro->created_at)->addHour(2)->format('d-m-Y - H:i')}}</td>
    </tr>
    @endforeach

  </tbody>
</table>
</div>

<div class="d-flex justify-content-end">
      {{ $registrosAuditoria->links() }}
</div>

</div>
