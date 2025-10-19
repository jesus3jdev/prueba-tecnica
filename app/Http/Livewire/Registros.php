<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Registro;
use App\Models\User;

class Registros extends Component
{

    public $usuarios;
    //Declaramos esta variable para los filtros.
    public $usuarioSeleccionado = "";
    public $accionSeleccionada = "";
    public $ordenFechas = "desc";
    public $iconoFecha = "fa-circle-arrow-down";

    //Indicamos que el componente use paginación y le aplicamos el el estilo de la librería Bootstrap
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public function mount()
    {
        //Obtenemos todos los usuarios para realizar los filtros en la vista
        $this->usuarios= User::all();
    }


    public function cambiarOrden(){
        if($this->iconoFecha == "fa-circle-arrow-down"){
            $this->iconoFecha = "fa-circle-arrow-up";
            $this->ordenFechas = "asc";
        }else{
            $this->iconoFecha = "fa-circle-arrow-down";
            $this->ordenFechas = "desc";
        }
    }


    public function render()
    {

        //Creamos la consulta
        $registrosAuditoria = Registro::orderBy("created_at", $this->ordenFechas);

        //Si se ha seleccionado algún usuario en el filtro añadimos a la consulta
        if (!empty($this->usuarioSeleccionado)) {
            $registrosAuditoria->where('user_id', $this->usuarioSeleccionado);
        }

        //Si se ha seleccionado alguna acción en el filtro añadimos a la consulta
        if (!empty($this->accionSeleccionada)) {
            $registrosAuditoria->Where('accion', 'like', '%'. $this->accionSeleccionada . '%');
        }

        
        //Obtenemos todos los registros de la consulta y los paginamos de 10 en 10
        $registrosAuditoria = $registrosAuditoria->paginate(10);
        return view('livewire.registros', ["registrosAuditoria"=>$registrosAuditoria]);
    }
}
