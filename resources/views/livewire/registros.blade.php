<div>
    

<table class="table">
  <thead class="table-dark">
    <th>Acción</th>
    <th>Usuario</th>
    <th>Email</th>
    <th>Fecha</th>
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

<div class="d-flex justify-content-end">
      {{ $registrosAuditoria->links() }}
</div>

</div>
