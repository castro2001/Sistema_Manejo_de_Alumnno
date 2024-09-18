<?php
namespace App\Controller;

use App\Model\Repository\StudentRepository;
use Core\Controller;
use DateTime;

class AlumnoController extends Controller{
    private $studentRepository;
    public function __construct()
    {
        $this->studentRepository = new StudentRepository();
    }

    public function view_Alumno(){
        $information=array(
            "title"=>"Alumno",
            "styles"=>[
              "custom",
              "table",  
            ],
            "scripts"=>['alumno']
        );
    
        $this->render("alumno.alumno",$information);
       
    }



    public function getDataStudent() {
        $this->checkRequest();
            $dataArray = array();
            foreach ($this->studentRepository->query() as $data) {
                $dataArray[] = array(
                    "id" => $data->id,
                    "Alumno" => $data->Alumno,
                    "ruta_img"=>$data->foto,
                    "direccion" => $data->direccion,
                    "foto" => "<img src='public/image/subidas/$data->foto' width=80 height=100 alt='$data->foto' />",
                    "fecha_nacimiento" => $data->fecha_nacimiento,
                    "status"=>$data->status,
                 
                    "editar" => "
                        <button class='btn btn-success' type='button' data-id='$data->id' data-bs-toggle='modal' id='editarButtonAlumno' data-bs-target='#modal_reutilizable_Alumno'>
                        <span class='material-icons'>edit</span> </button>",
                    "Informacion" => "
                        <button class='btn btn-warning' type='button' data-id='$data->id' data-bs-toggle='modal' id='informationButtonAlumno' data-bs-target='#modal_reutilizable_Alumno'>
                        <span class='material-icons'>visibility</span> </button>",
                    "eliminar" => "
                        <button class='btn btn-danger' data-id='$data->id' type='button' data-bs-toggle='modal' id='borrarButtonAlumno' data-bs-target='#modal_reutilizable_Alumno'
                        onclick='obtenerAlumnoPorId($data->id)'>
                        <span class='material-icons'>delete</span> </button>",
                );
                
            }
            echo json_encode(array("data" => $dataArray));
    }
  
    public function getByStudent(){
        $this->checkRequest();
        $id = isset($_POST['id']) ? $_POST['id'] : 'id no encontrado';
        $dataArray = array();
        foreach ($this->studentRepository->findById($id) as $data) {
            $dataArray = array(
                "id" => $data->id,
                "Alumno" => $data->Alumno,
                "fecha_nacimiento" => $data->fecha_nacimiento,
                "direccion" => $data->direccion,
                "ruta_img"=>$data->foto,
                "foto" => "<img src='public/image/subidas/$data->foto' width=80 height=100 alt='$data->foto' />",
                "Telefono" => $data->Telefono,
                "escuela_procedencia" => $data->escuela_procedencia,
                "situacion_academica" => $data->situacion_academica,
                "tutor" => $data->tutor,
                "celular_padre"=>$data->celular_Padre,
                "Ocupacion"=>$data->Ocupacion

            );
        }
      
        echo json_encode(array("data" => $dataArray));
    }
   
    public function crearAlumno() {
        $this->checkRequest();
        $alumno = $_POST['alumno']; 
        $fechaNacimiento = $_POST['fecha_nacimiento']; 
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $escuelaProcedencia = $_POST['escuela_procedencia']; 
        $situacionAcademica = $_POST['situacion_academica'];
        $tutor = $_POST['select_tutor'];
       

        if (!empty($alumno) && !empty($fechaNacimiento) && !empty($telefono) && !empty($direccion) && !empty($escuelaProcedencia) && 
        !empty($situacionAcademica) && !empty($tutor)) {
    
            // Expresiones regulares
            $validations = [
                'alumno' => [
                    'regex' => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/",
                    'error' => 'El nombre del alumno solo debe contener letras y espacios.'
                ],
                'telefono' => [
                    'regex' => "/^\d{10}$/",
                    'error' => 'El teléfono solo debe contener 10 dígitos.'
                ],
                'direccion' => [
                    'regex' => "/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s. ]+$/",
                    'error' => 'La dirección solo debe contener letras, números, puntos y espacios.'
                ],
                'escuela_procedencia' => [
                    'regex' => "/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s.]+$/",
                    'error' => 'La escuela de procedencia solo debe contener letras, puntos o espacios.'
                ],
                'situacion_academica' => [
                    'regex' => "/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s. ]+$/",
                    'error' => 'La situación académica solo debe contener letras, puntos o espacios.'
                ],
                'select_tutor' => [
                    'regex' => "/^[0-9]+$/",
                    'error' => 'El tutor solo debe ser un número válido.'
                ]
            ];
    
            // Validar los campos
            $errors = [];
            foreach ($validations as $field => $validation) {
                if (!preg_match($validation['regex'], $_POST[$field])) {
                    $errors[] = $validation['error'];
                }
            }
    
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo json_encode(['message' => $error, 'alert' => 'alert-danger']);
                }
            } else {
            // Aquí el código para guardar el alumno en la base de datos
            if (!isset($_FILES["foto"]) && $_FILES["foto"]["error"] == UPLOAD_ERR_OK) {
                // Obtener la información del archivo subido
                echo json_encode(['message'=>"Formato no  aceptado elija entre jpg, png, jpeg, webp","alert"=>"alert-danger"  ]);                }
            }

            $formatosPermitidos = ['jpg', 'jpeg', 'png', 'webp'];
            $archivo = $_FILES["foto"];
            $nombreOriginal = $archivo["name"];
            $tmpImagen = $archivo["tmp_name"];
            
            // Obtener la extensión del archivo
            $infoArchivo = pathinfo($nombreOriginal);
            $extension = strtolower($infoArchivo['extension']);
            // Generar un nuevo nombre único para la imagen
            $fecha = new DateTime();
            $nuevoNombre = $fecha->getTimestamp() . "_" . uniqid() . "." . $extension;
            // Ruta de destino para guardar la imagen
            $ubicacion = __DIR__ . "/../../public/image/subidas/" . $nuevoNombre;
            if (!in_array($extension, $formatosPermitidos)) {
                echo json_encode(['message' => "Formato no aceptado. Elija entre jpg, png, jpeg o webp.", 'alert' => 'alert-danger']);
                return;
            }

            
            $response = $this->studentRepository->add($alumno,$fechaNacimiento,$direccion,$nuevoNombre,$telefono,$escuelaProcedencia,$situacionAcademica,$tutor);
            if( $response['success']){
                move_uploaded_file($tmpImagen, $ubicacion);
                echo json_encode(['message'=>$response['message'],"alert"=>"alert-success"  ]);
            }else{
                echo json_encode(['message'=>$response['message'],"alert"=> "alert-warning" ] );

            }

        } else {
            echo json_encode(['message' => "Rellene los campos vacíos", 'alert' => 'alert-danger']);
        }
    }
    
    public function editarAlumno() {
        $this->checkRequest();
        
        $id = isset($_POST['itemID']) ?$_POST['itemID']:''; 

        $alumno = $_POST['alumno']; 
        $fechaNacimiento = $_POST['fecha_nacimiento']; 
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $escuelaProcedencia = $_POST['escuela_procedencia']; 
        $situacionAcademica = $_POST['situacion_academica'];
        $tutor = $_POST['select_tutor'];

        if (!empty($alumno) && !empty($fechaNacimiento) && !empty($telefono) && !empty($direccion) && !empty($escuelaProcedencia) && 
        !empty($situacionAcademica) && !empty($tutor) ) {
            // Expresiones regulares
            $validations = [
                'itemID'=>[
                    'regex' => "/^[0-9]+$/",
                    'error' => 'El ID  solo debe contener números.'
                ],
                'alumno' => [
                    'regex' => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/",
                    'error' => 'El nombre del alumno solo debe contener letras y espacios.'
                ],
                'telefono' => [
                    'regex' => "/^\d{10}$/",
                    'error' => 'El teléfono solo debe contener 10 dígitos.'
                ],
                'direccion' => [
                    'regex' => "/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s. ]+$/",
                    'error' => 'La dirección solo debe contener letras, números, puntos y espacios.'
                ],
                'escuela_procedencia' => [
                    'regex' => "/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s.]+$/",
                    'error' => 'La escuela de procedencia solo debe contener letras, puntos o espacios.'
                ],
                'situacion_academica' => [
                    'regex' => "/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s. ]+$/",
                    'error' => 'La situación académica solo debe contener letras, puntos o espacios.'
                ],
                'select_tutor' => [
                    'regex' => "/^[0-9]+$/",
                    'error' => 'El tutor solo debe ser un número válido.'
                ]
            ];
    
            // Validar los campos
            $errors = [];
            foreach ($validations as $field => $validation) {
                if (!preg_match($validation['regex'], $_POST[$field])) {
                    $errors[] = $validation['error'];
                }
            }
    
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo json_encode(['message' => $error, 'alert' => 'alert-danger']);
                }
            } else {
                if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
                // Validar el tipo de archivo
                    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
                    $fileType = mime_content_type($_FILES['foto']['tmp_name']);
                    if (in_array($fileType, $allowedMimeTypes)) {
                        $archivo = $_FILES["foto"];
                        $nombreOriginal = $archivo["name"];
                        $tmpImagen = $archivo["tmp_name"];
            
                        // Obtener la extensión del archivo
                        $infoArchivo = pathinfo($nombreOriginal);
                        $extension = strtolower($infoArchivo['extension']);
            
                        // Generar un nuevo nombre único para la imagen
                        $fecha = new DateTime();
                        $nuevoNombre = $fecha->getTimestamp() . "_" . uniqid() . "." . $extension;
            
                        // Ruta de destino para guardar la imagen
                        $ubicacion = __DIR__ . "/../../public/image/subidas/" . $nuevoNombre;
            
                        // Mover el archivo a la ubicación deseada
                        move_uploaded_file($tmpImagen, $ubicacion);
                        $response = $this->studentRepository->edit($alumno, $fechaNacimiento, $direccion, $nuevoNombre, $telefono, $escuelaProcedencia, $situacionAcademica, $tutor, $id);

                        if( $response['success']){
                            echo json_encode(['message'=>$response['message'],"alert"=>"alert-success"  ]);
                        }else{
                            echo json_encode(['message'=>$response['message'],"alert"=> "alert-warning" ] );
            
                        }
                    }else{
                        echo json_encode(['message' => "Formato no aceptado. Elija entre jpg, png, o webp", 'alert' => 'alert-danger']);

                    }
                }  else if (isset($_POST['foto2']) && !empty($_POST['foto2'])) {
                      // Si no se subió nueva imagen, usar 'foto2' como imagen seleccionada
                            $foto = $_POST['foto2'];

                            // Actualizar la información del alumno usando la imagen anterior
                            $response = $this->studentRepository->edit($alumno, $fechaNacimiento, $direccion, $foto, $telefono, $escuelaProcedencia, $situacionAcademica, $tutor, $id);

                            if( $response['success']){
                                echo json_encode(['message'=>$response['message'],"alert"=>"alert-success"  ]);
                            }else{
                                echo json_encode(['message'=>$response['message'],"alert"=> "alert-warning" ] );
                
                            }
                }  






            }  
        }    
      
    }

    public function borrarAlumno(){
        $this->checkRequest();
        $id= $_POST['itemID'];
    
        if(preg_match("/^[0-9]+$/",$id)   ) 
        {  
            $response = $this->studentRepository->remove($id);
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
        
   