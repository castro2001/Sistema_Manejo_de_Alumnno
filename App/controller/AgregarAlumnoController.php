<?php
namespace App\Controller;

use App\Model\Repository\StudentSubjectScheduleRepository;
use Core\Controller;

class AgregarAlumnoController extends Controller{
    protected $studentSubjectRepository;
    
    public function __construct()
    {
        $this->studentSubjectRepository= new StudentSubjectScheduleRepository();
    }
    public function view_AgregarAlumno(){
        $information=array(
            "title"=>"Agregar Materia al Alumno",
            "styles"=>[
                "custom","table"
            ],
            "scripts"=>['alumno_materia']
        );
     
            $this->render("alumno_materia.alumno_materia",$information);  
       
       
    }


    /**@ Metodos DATATABLE */
    public function getDataAgregarAlumno() {
        $this->checkRequest();
        $dataArray = array();
        foreach ($this->studentSubjectRepository->query() as $data) {
            $dataArray[] = array(
                "id" => $data->Id,
                "Alumno_id"=>$data->Alumno_id,
                "Alumno" => $data->Alumno,
                "Materia_id"=>$data->Materia_id,
                "Dia" => $data->Dia,
                "Materia" => $data->Materia,
                "Inicio" => $data->Inicio,
                "Fin" => $data->Fin,
                    "editar"=>"
                        <button class='btn btn-success ' type='button' data-bs-toggle='modal' id='editarButtonAgregarAlumnoMateria' data-bs-target='#modal_reutilizable_materia_alumno'
                        data-id=$data->Id ><span class='material-icons'>edit</span> </button>",

                    "eliminar"=>"<button class='btn btn-danger ' type='button' data-bs-toggle='modal' id='borrarButtonAgregarAlumnoMateria' data-bs-target='#modal_reutilizable_materia_alumno'
                    data-id=$data->Id    ><span class='material-icons'>delete</span> </button>"
            );
        }
        echo json_encode(array("data" => $dataArray));
    }

    public function getDataByAgregarAlumno() {

        $this->checkRequest();
        $id = isset($_POST['id']) ? $_POST['id'] : 'id no encontrado';
        $dataArray = array();
        foreach ($this->studentSubjectRepository->findById($id) as $data) {
            $dataArray = array(
                "id" => $data->Id,
                "Alumno_id"=>$data->Alumno_id,

                "Alumno" => $data->Alumno,
                "Dia" => $data->Dia,
                "Materia_id"=>$data->Materia_id,
                "Materia" => $data->Materia,
                "Inicio" => $data->Inicio,
                "Fin" => $data->Fin,
                    "editar"=>"
                        <button class='btn btn-success ' type='button' data-bs-toggle='modal' id='editarButtonAgregarAlumnoMateria' data-bs-target='#modal_reutilizable_materia_alumno'
                        data-id=$data->Id ><span class='material-icons'>edit</span> </button>",

                    "eliminar"=>"<button class='btn btn-danger ' type='button' data-bs-toggle='modal' id='borrarButtonAgregarAlumnoMateria' data-bs-target='#modal_reutilizable_materia_alumno'
                    data-id=$data->Id    ><span class='material-icons'>delete</span> </button>"
            );
        }
        echo json_encode(array("data" => $dataArray));
    }
    
    public function getDataAlumnoMMateriaHorario() {
       $this->checkRequest();
        $dataResponse = [
            "Alumnos" => [],
            "Horarios" => [],
            "Materias" => []
        ];
    
        // Agregar alumnos
        foreach ($this->studentSubjectRepository->getAllDataStudent() as $data) {
            $dataResponse["Alumnos"][] = [
                "id" => $data->Alumno_id,
                "Alumno" => $data->Alumno
            ];
        }
    
        // Agregar horarios
        foreach ($this->studentSubjectRepository->getAllDataSchedule() as $data) {
            $dataResponse["Horarios"][] = [
                "Dia" => $data->dia_semana
            ];
        }
    
        // Agregar materias
        foreach ($this->studentSubjectRepository->getAllDataSubject() as $datos) {
            $dataResponse["Materias"][] = [
                "Materia_id" => $datos->Materia_id,
                "Materia" => $datos->Materia
            ];
        }
    
        // Retornar como JSON
        echo json_encode(["data" => $dataResponse]);
    }

    public function crearAgregarAlumno(){
        $this->checkRequest();
        
        $alumno= $_POST['select_alumno'];
        $materia= $_POST['select_materia'];
        $horario=$_POST['select_dia'];
        $horaInicio = $_POST['hora_inicio'];
        $horaFin = $_POST['hora_fin'];
        
        $validations = [
            'select_alumno' => [
                'regex' => "/^[0-9]+$/",
                'error' => 'El ID del alumno solo debe contener números.'
            ],
            'select_materia' => [
                'regex' => "/^[0-9]+$/",
                'error' => 'El ID del materia solo debe contener números.'
            ],
            'select_dia' => [
                'regex' => "/^[a-zA-Z]+$/",
                'error' => 'El valor esperado es letras'
            ],
            'hora_inicio' => [
                'regex' => "/^([01]\d|2[0-3]):([0-5]\d)$/",
                'error' => 'La hora de inicio debe estar en el formato HH:mm.'
            ],
            'hora_fin' => [
                'regex' => "/^([01]\d|2[0-3]):([0-5]\d)$/",
                'error' => 'La hora de fin debe estar en el formato HH:mm.'
            ]
        ];
     
        // Array para almacenar los errores
        $errors = [];

        // Validar cada campo
        foreach ($validations as $field => $validation) {
            if (!preg_match($validation['regex'], $_POST[$field])) {
                $errors[] = $validation['error'];
            }
        }

        // Mostrar los errores
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo json_encode(['message'=>$error,"alert"=>"alert-danger"]);
            }
        } else {
            $response = $this->studentSubjectRepository->add($alumno,$materia,$horario,$horaInicio,$horaFin);
            if( $response['success']){
                echo json_encode(['message'=>$response['message'],"alert"=>"alert-success"  ]);
            }else{
             echo json_encode(['message'=>$response['message'],"alert"=> "alert-warning" ] );

            }

        }



    }
    
    public function editarAgregarAlumno(){
        $this->checkRequest();
        $id=$_POST['id'];
        $alumno= $_POST['select_alumno'];
        $materia= $_POST['select_materia'];
        $horario=$_POST['select_dia'];
        $horaInicio = $_POST['hora_inicio'];
        $horaFin = $_POST['hora_fin'];
        $id = $_POST['id'];
        $validations = [
            'id' => [
                'regex' => "/^[0-9]+$/",
                'error' => 'El ID del  solo debe contener números.'
            ],
            'select_alumno' => [
                'regex' => "/^[0-9]+$/",
                'error' => 'El ID del alumno solo debe contener números.'
            ],
            'select_materia' => [
                'regex' => "/^[0-9]+$/",
                'error' => 'El ID del materia solo debe contener números.'
            ],
            'select_dia' => [
                'regex' => "/^[a-zA-Z]+$/",
                'error' => 'Debe escoger un dia de la semana'
            ],
            'hora_inicio' => [
                'regex' => "/^([01]\d|2[0-3]):([0-5]\d)$/",
                'error' => 'La hora de inicio debe estar en el formato HH:mm.'
            ],
            'hora_fin' => [
                'regex' => "/^([01]\d|2[0-3]):([0-5]\d)$/",
                'error' => 'La hora de fin debe estar en el formato HH:mm.'
            ]
        ];

        // Array para almacenar los errores
        $errors = [];

        // Validar cada campo
        foreach ($validations as $field => $validation) {
            if (!preg_match($validation['regex'], $_POST[$field])) {
                $errors[] = $validation['error'];
            }
        }

        // Mostrar los errores
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo json_encode(['message'=>$error,"alert"=>"alert-danger"]);
            }
        } else {

        // echo json_encode(['message'=>"Liso para actuaalizar","alert"=>"alert-success" ]);

            $response = $this->studentSubjectRepository->edit($alumno,$materia,$horario,$horaInicio,$horaFin,$id);
            if( $response['success']){
                echo json_encode(['message'=>$response['message'],"alert"=>"alert-success"  ]);
            }else{
            echo json_encode(['message'=>$response['message'],"alert"=> "alert-warning" ] );

            }

        }

    }

    public function borrarAgregarAlumno(){
        $this->checkRequest();
        $id=$_POST['id']; 
        
        $validations = [
            'id' => [
                'regex' => "/^[0-9]+$/",
                'error' => 'El ID del  solo debe contener números.'
            ]
        ];
        $errors = [];

        // Validar cada campo
        foreach ($validations as $field => $validation) {
            if (!preg_match($validation['regex'], $_POST[$field])) {
                $errors[] = $validation['error'];
            }
        }

        // Mostrar los errores
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo json_encode(['message'=>$error,"alert"=>"alert-danger"]);
            }
        } else {
            $response = $this->studentSubjectRepository->remove($id);
            if( $response['success']){
                echo json_encode(['message'=>$response['message'],"alert"=>"alert-success"  ]);
            }else{
            echo json_encode(['message'=>$response['message'],"alert"=> "alert-warning" ] );

            }
        }

    }
}