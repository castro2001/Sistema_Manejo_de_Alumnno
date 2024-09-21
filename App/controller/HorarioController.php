<?php
namespace App\Controller;

use App\Model\Repository\SchedulesRepository;
use App\Model\Repository\StudentRepository;
use App\Model\Repository\StudentSubjectScheduleRepository;
use Core\Controller;
use DateTime;
/**Este Controller va hacer cambiado la funcion */
class HorarioController extends Controller{
    protected $StudentSubjectScheduleRepository;
    protected $studentRepository;
    public function __construct()
    {
        $this->studentRepository = new StudentRepository();
        $this->StudentSubjectScheduleRepository= new StudentSubjectScheduleRepository();
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

  

    public function getDatasHorario() {
        $this->checkRequest(); // Asegúrate de que esta función esté correctamente implementada
    
        $dataArray = array();
        foreach ($this->studentRepository->query() as $data) {
            $dataArray[] = array(
               "id" => $data->id,
                "Alumno" => $data->Alumno,
                "ruta_img"=>$data->foto,
            );
        }
        // Devuelve los datos en formato JSON para que AJAX los consuma
        echo json_encode(array("data" => $dataArray));
    }
    
    public function getByHorario() {
        // $this->checkRequest(); // Asegúrate de que esta función esté correctamente implementada
        $id = isset($_POST['id']) ? $_POST['id'] : 'id no encontrado';
    $dataArray = array();
        foreach ($this->StudentSubjectScheduleRepository->findByAlumno($id) as $data) {
            $dataArray[] = array(
               "id" => $data->Id,
                "Alumno" => $data->Alumno,
                "Dia"=>$data->Dia,
                "Materia"=>$data->Materia,
                "Inicio"=>$data->Inicio,
                "Fin"=>$data->Fin,

            );
        }
    //     // Devuelve los datos en formato JSON para que AJAX los consuma
        echo json_encode(array("data" => $dataArray));
    }
   
}