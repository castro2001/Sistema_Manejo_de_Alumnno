<?php
namespace App\Controller;

use App\Model\Repository\SubjectRepository;
use Core\Controller;

class MateriaController extends Controller{
    protected $subjectRepository;
    
    public function __construct()
    {
        $this->subjectRepository= new SubjectRepository();
    }
    public function view_Materia(){
        $information=array(
            "title"=>"Materia",
            "styles"=>[
               "custom",
              "table",  
            ],
            "scripts"=>['materia']
        );
    
        $this->render("materia.materia",$information);
    }


    /**@ Metodos DATATABLE */
    public function getDataMateria() {
        $this->checkRequest();
        $dataArray = array();
        foreach ($this->subjectRepository->query() as $data) {
            $dataArray[] = array(
                "id" => $data->id,
                "nombre" => $data->nombre,
                "docente" => $data->docente,
                "descripcion" => $data->descripcion,
                
                "editar"=>"
                    <button class='btn btn-success ' type='button' data-bs-toggle='modal' id='editarButtonMateria' data-bs-target='#modal_reutilizable_materia'
                     onclick='obtenerMateriaPorId($data->id)' ><span class='material-icons'>edit</span> </button>",

                "eliminar"=>"<button class='btn btn-danger ' type='button' data-bs-toggle='modal' id='borrarButtonMateria' data-bs-target='#modal_reutilizable_materia'
                 onclick='obtenerMateriaPorId($data->id)'    ><span class='material-icons'>delete</span> </button>"
            );
        }
        echo json_encode(array("data" => $dataArray));
    }

    /**@ Metodos Crud */
    public function getByMateria(){
        $this->checkRequest();
        $id = isset($_POST['id']) ? $_POST['id'] : 'id no encontrado';
        $dataArray = array();
        foreach ($this->subjectRepository->findById($id) as $data) {
            $dataArray = array(
                "id" => $data->id,
                "nombre" => $data->nombre,
                "docente" => $data->docente,
                "descripcion" => $data->descripcion,
            );
        }
      
        echo json_encode(array("data" => $dataArray));
    }
   
    public function crearMateria(){
        $this->checkRequest();
        $materia= $_POST['materia']; 
        $docente= $_POST['docente'];
        $descripcion = $_POST['descripcion'];

        if(preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 12]+$/",$materia) && preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ. ]+$/",$docente)   
        && preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/",$descripcion)  ) 
        {
 
            $response = $this->subjectRepository->add($materia,$docente,$descripcion);
            if( $response['success']){
                echo json_encode(['message'=>$response['message'],"alert"=>"alert-success"  ]);
            }else{
                echo json_encode(['message'=>$response['message'],"alert"=> "alert-warning" ] );

            }
        }else{
            echo json_encode(['message'=>" inserte Campos valido","alert"=> "alert-warning" ]);

        }
        

    }

    public function editarMateria(){
        $this->checkRequest();
        $id = $_POST['id'];
        $materia= $_POST['materia']; 
        $docente= $_POST['docente'];
        $descripcion = $_POST['descripcion'];

        if(preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 12]+$/",$materia) && preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ. ]+$/",$docente)   
        && preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/",$descripcion)  ) 
        {
 
            $response = $this->subjectRepository->edit($materia,$docente,$descripcion,$id);
            if( $response['success']){
                echo json_encode(['message'=>$response['message'],"alert"=>"alert-success"  ]);
            }else{
                echo json_encode(['message'=>$response['message'],"alert"=> "alert-warning" ] );

            }
        }else{
            echo json_encode(['message'=>" inserte Campos valido","alert"=> "alert-warning" ]);

        }

        


    }

    public function borrarMateria(){
        $this->checkRequest();
        $id = $_POST['id'];
        if(preg_match("/^[0-9]+$/",$id)   ) 
        {  
            $response = $this->subjectRepository->remove($id);
            if( $response['success']){
                echo json_encode(['message'=>$response['message'],"alert"=>"alert-success"  ]);
            }else{
                echo json_encode(['message'=>$response['message'],"alert"=> "alert-warning" ] );

            }
        }else{
            echo json_encode(['message'=>" inserte Campos valido"]);

        }
    }
    
}