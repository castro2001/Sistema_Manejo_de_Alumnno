<?php
namespace App\Controller;

use App\Model\Repository\SchedulesRepository;
use Core\Controller;
use DateTime;
/**Este Controller va hacer cambiado la funcion */
class HorarioController extends Controller{
    protected $schedulesRepository;
    public function __construct()
    {
        $this->schedulesRepository = new SchedulesRepository();
    }
    public function view_Horario(){
     
        $information=array(
            "title"=>"Horario",
            "styles"=>[
                "custom"
            ],
            "scripts"=>['horario']
        );
    
        $this->render("horario.horario",$information);
    }

    public function view_edit(){
        // $this->render("login");
        echo "vista de editar";
    }

    public function view_add(){
        // $this->render("login");
        echo "vista de add";
    }

    public function view_remove(){
        // $this->render("login");
        echo "vista de eliminar";
    }

    public function getDatasHorario() {
        $this->checkRequest(); // Asegúrate de que esta función esté correctamente implementada
    
        $dataArray = array();
        foreach ($this->schedulesRepository->query() as $data) {
            $hora_inicio = new DateTime($data->hora_inicio);
            $hora_fin = new DateTime($data->hora_fin);
            $dataArray[] = array(
                "id" => $data->id,
              "Hora" => date_format($hora_inicio, 'H:i') . ' - ' . date_format($hora_fin, 'H:i'),

                "Lunes" => $data->dia_semana === 'Lunes' ? $data->nombre : '',
                "Martes" => $data->dia_semana === 'Martes' ? $data->nombre : '',
                "Miércoles" => $data->dia_semana === 'Miércoles' ? $data->nombre : '',
                "Jueves" => $data->dia_semana === 'Jueves' ? $data->nombre : '',
                "Viernes" => $data->dia_semana === 'Viernes' ? $data->nombre : ''
         
            );
        }
        // Devuelve los datos en formato JSON para que AJAX los consuma
        echo json_encode(array("data" => $dataArray));
    }
    
    
}