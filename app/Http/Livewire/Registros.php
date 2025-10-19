<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Registro;

class Registros extends Component
{

    //Indicamos que el componente use paginación y le aplicamos el el estilo de la librería Bootstrap
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public function render()
    {

        //Obtenemos todos los registros de la auditoría y los paginamos de 10 en 10
        $registrosAuditoria = Registro::orderByDesc("created_at")->paginate(10);
        return view('livewire.registros', ["registrosAuditoria"=>$registrosAuditoria]);
    }
}
