<?php
namespace App\Controller;

use App\Model\Repository\TutorRepository;
use Core\Controller;

class TutorController extends Controller{
    protected $tutorRepository;
    public function __construct()
    {
        $this->tutorRepository= new TutorRepository();
    }
    /***VIEWS****/
    public function view_Tutor(){
        $information=array(
            "title"=>"Tutor",
            "styles"=>["custom","table" ],
            "scripts"=>['tutor']
        );
    
        $this->render("tutor.tutor",$information);
    }

        /***consultar de ajax****/
    
    public function getDataTutor() {
        $this->checkRequest();
        
        $dataArray = array();
        foreach ($this->tutorRepository->query() as $data) {
            $dataArray[] = array(
                "id" => $data->id,
                "nombre" => $data->nombre,
                "telefono" => $data->n_celular,
                "ocupacion" => $data->ocupacion,
              
                "editar"=>"
                            <button class='btn btn-success ' type='button' data-bs-toggle='modal' id='editarButton' data-bs-target='#modal_reutilizable_tutor'
                         onclick='obtenerTutorPorId($data->id)' ><span class='material-icons'>edit</span> </button>                ",
                "eliminar"=>"<button class='btn btn-danger ' type='button' data-bs-toggle='modal' id='borrarButton' data-bs-target='#modal_reutilizable_tutor'
                             onclick='obtenerTutorPorId($data->id)'    ><span class='material-icons'>delete</span> </button>"
            );
        }
        echo json_encode(array("data" => $dataArray));
    }

    public function getAllTutor(){
        $this->checkRequest();

        $dataArray = array();
           foreach ($this->tutorRepository->query() as $data) {
            $dataArray[] = array(
                "id" => $data['id'],
                "nombre" => $data['nombre'],
                "telefono" => $data['n_celular'],
                "ocupacion" => $data['ocupacion'],
        
            );
        }
        echo json_encode(array($dataArray));
       
    }

    /*** Operaciones CRUD ***/

    public function getByTutor(){
        $this->checkRequest();
        $id = isset($_POST['id']) ? $_POST['id'] : 'id no encontrado';
        $dataArray = array();
        foreach ($this->tutorRepository->findById($id) as $data) {
            $dataArray = array(
                "id" => $data->id,
                "nombre" => $data->nombre,
                "telefono" => $data->n_celular,
                "ocupacion" => $data->ocupacion
            );
        }
      
        echo json_encode(array("data" => $dataArray));
    }
    
    public function crearTutor(){
        $this->checkRequest();
        $nombre= $_POST['nombre']; 
        $celular= $_POST['telefono'];
        $ocupacion = $_POST['ocupacion'];

        if(!empty($nombre) && !empty($celular) && !empty($ocupacion) )
        {
            if(preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/",$nombre) && preg_match("/^\d{10}$/",$celular)   && preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/",$ocupacion)  ) 
            {
            
                $response = $this->tutorRepository->add($nombre,$celular,$ocupacion);
                if( $response['success']){
                    echo json_encode(['message'=>$response['message'],"alert"=>"alert-success"  ]);
                }else{
                    echo json_encode(['message'=>$response['message'],"alert"=> "alert-warning" ] );
       
                }

            }else{
                echo json_encode(['message'=>" inserte Campos valido","alert"=> "alert-warning" ]);

            }
        }else{
            // http_response_code(404);
            echo json_encode([ "status"=> 404 , 'message'=>"Rellenar los campos vacios","alert"=> "alert-warning"]);

        }


    }

    public function editarTutor(){
        $this->checkRequest();
        $id= $_POST['id'];
        $nombre= $_POST['nombre']; 
        $celular= $_POST['telefono'];
        $ocupacion = $_POST['ocupacion'];

        if(!empty($nombre) && !empty($celular) && !empty($ocupacion)  )
        {
            $response = $this->tutorRepository->edit($nombre,$celular,$ocupacion,$id);
         if( $response['success']){
             echo json_encode(['message'=>$response['message'],"alert"=>"alert-success"  ]);
         }else{
             echo json_encode(['message'=>$response['message'],"alert"=> "alert-warning" ] );

         }
            
            

        }else{
            // http_response_code(404);
            echo json_encode([ "status"=> 404 , 'message'=>"Rellenar los campos vacios"]);

        }
        //echo json_encode([ "status"=> 404 , 'message'=>"Rellenar los campos vacios","POSTT"=>$_POST]);
    }
    
    public function borrarTutor(){
        $this->checkRequest();
        $id= $_POST['id'];
      
         $response = $this->tutorRepository->remove($id);
         if( $response['success']){
             echo json_encode(['message'=>$response['message'],"alert"=>"alert-success"  ]);
         }else{
             echo json_encode(['message'=>$response['message'],"alert"=> "alert-warning" ] );

         }
    }
    
}

/*


   public function getDataTutor() {
        $this->checkRequest();
        /*$draw = $_POST['draw']; // Para el número de dibujado
        $start = $_POST['start']; // Para la paginación
        $length = $_POST['length']; // Número de registros a mostrar por página
        $orderColumnIndex = $_POST['order'][0]['column']; // Columna por la que se está ordenando
        $orderDirection = $_POST['order'][0]['dir']; // Dirección del orden (asc o desc)
        $searchValue = $_POST['search']['value']; // Valor de búsqueda si hay

        $columns = ['id', 'nombre', 'n_celular', 'ocupacion'];

            // Si hay búsqueda, aplicamos un filtro
        if (!empty($searchValue)) {
            $this->tutorRepository->where('nombre', 'LIKE', "%$searchValue%")
                                ->orWhere('n_celular', 'LIKE', "%$searchValue%")
                                ->orWhere('ocupacion', 'LIKE', "%$searchValue%");
        }

    $dataArray = array();
    foreach ($this->tutorRepository->query() as $data) {
        $dataArray[] = array(
            "id" => $data->id,
            "nombre" => $data->nombre,
            "telefono" => $data->n_celular,
            "ocupacion" => $data->ocupacion,
        
            "editar"=>"
                        <button class='btn btn-success ' type='button' data-bs-toggle='modal' id='editarButton' data-bs-target='#modal_reutilizable_tutor'
                    onclick='obtenerTutorPorId($data->id)' ><span class='material-icons'>edit</span> </button>                ",
            "eliminar"=>"<button class='btn btn-danger ' type='button' data-bs-toggle='modal' id='borrarButton' data-bs-target='#modal_reutilizable_tutor'
                        onclick='obtenerTutorPorId($data->id)'    ><span class='material-icons'>delete</span> </button>"
        );
    }
    echo json_encode(array("data" => $dataArray));

    if(isset($_POST['search']['value'] )){
        // echo json_encode(array("data" => 1));
    }
    }
*/