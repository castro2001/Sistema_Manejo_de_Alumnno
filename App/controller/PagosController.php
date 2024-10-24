<?php
namespace App\Controller;

use App\Model\Repository\PaymentRepository;
use Core\Controller;

class PagosController extends Controller{
    protected $paymentRepository;

    public function __construct()
    {
        $this->paymentRepository= new PaymentRepository();
    }

    public function view_Pagos(){
        $information=array(
            "title"=>"Pagos",
            "styles"=>["custom","table"],
            "scripts"=>['pagos']
        );
    
        $this->render("pagos.pagos",$information);
    }

    public function reportes(){
        
    }

    public function pdfPagos(){
   
    
        $this->paymentRepository->pdfGeneratePaymentById($_GET['id']);
   
   
    }

    public function getDataPagos() {
        $this->checkRequest();
        $dataArray = array();
        foreach ($this->paymentRepository->query() as $data) {
          
            $dataArray[] = array(
                "id" => $data->id,
                "codigo" => $data->codigo,
                "id_Alumno"=>$data->Alumno_id,
                "Alumno" => $data->Alumno,
                "Metodo_Pago" => $data->metodo_pago,
                "Monto" => $data->monto,
                "Descuento"=>$data->descuentos,
                "Observacion" => $data->observacion,
                "Total" => $data->total,
                "status" => $data->status,             
                "editar"=>"
                            <button class='btn btn-success ' type='button' data-bs-toggle='modal' id='editarButtonPago' data-bs-target='#modal_reutilizable_pagos'
                         data-id=$data->id ><span class='material-icons'>edit</span> </button>                ",
                "eliminar"=>"<button class='btn btn-danger ' type='button' data-bs-toggle='modal' id='borrarButtonPago' data-bs-target='#modal_reutilizable_pagos'
                             data-id=$data->id><span class='material-icons'>delete</span> </button>",
              "pdf"=>"<a class='btn btn-warning'  href='Pagos/pdfPagos/$data->id'>
                <span class='material-icons'>print</span> </a>",
            );
        }
        echo json_encode(array("data" => $dataArray));
    }



    public function getByPagos(){
        $this->checkRequest();
        $id = isset($_POST['id']) ? $_POST['id'] : 'id no encontrado';
        $dataArray = array();
        foreach ($this->paymentRepository->findById($id) as $data) {
            $dataArray = array(
                "id" => $data->id,
                "codigo" => $data->codigo,
                "id_Alumno"=>$data->Alumno_id,
                "Alumno" => $data->Alumno,
                "Metodo_Pago" => $data->metodo_pago,
                "Monto" => $data->monto,
                "Descuento"=>$data->descuentos,
                "Observacion" => $data->observacion,
                "Total" => $data->total,
                "status" => $data->status,
        
            );
        }
      
        echo json_encode(array("data" => $dataArray,"id"=>$id));
    }

    public function crearPago(){
        $this->checkRequest();
        $codigo = $_POST['codigo']; 
        $id_alumno = $_POST['select_Alumno']; 
        $metodo_pago = $_POST['select_pago'];
        $monto = $_POST['monto'];
        $descuento = $_POST['descuentos']; 
        $observacion = $_POST['observacion'];
        $total = isset( $_POST['total']) ?  $_POST['total'] :0.00  ;
        $status = $_POST['select_status'];
      
        
            // Definir las expresiones regulares en un array
    
            $validations = [
                'codigo' => [
                    'regex' => "/^[a-zA-Z0-9]+$/",
                    'error' => 'El código solo debe contener letras y números.'
                ],
                'id_alumno' => [
                    'regex' => "/^[0-9]+$/",
                    'error' => 'El ID del alumno solo debe contener números.'
                ],
                'metodo_pago' => [
                    'regex' => "/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/",
                    'error' => 'El método de pago solo debe contener letras y espacios.'
                ],
                'monto' => [
                    'regex' => "/^\d+(\.\d{1,2})?$/",
                    'error' => 'El monto debe ser un número válido con hasta dos decimales.'
                ],
                'descuento' => [
                    'regex' => "/^\d+$/",
                    'error' => 'El descuento debe ser un número entero.'
                ],
                'observacion' => [
                    'regex' => "/^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]{9,}$/",
                    'error' => 'La observación debe tener exactamente 9 caracteres y solo contener letras, puntos o espacios.'
                ],
                'total' => [
                    'regex' => "/^\d+(\.\d{1,2})?$/",
                    'error' => 'El total debe ser un número válido con hasta dos decimales.'
                ],
                'status' => [
                    'regex' => "/^[0-9]+$/",
                    'error' => 'El estado solo debe contener números.'
                ]
            ];

            // Datos a validar
            $data = [
                'codigo' => $codigo, // Asignar tus variables aquí
                'id_alumno' => $id_alumno,
                'metodo_pago' => $metodo_pago,
                'monto' => $monto,
                'descuento' => $descuento,
                'observacion' => $observacion,
                'total' => $total,
                'status' => $status
            ];

            // Array para almacenar los errores
            $errors = [];

            // Validar cada campo
            foreach ($validations as $field => $validation) {
                if (!preg_match($validation['regex'], $data[$field])) {
                    $errors[] = $validation['error'];
                }
            }

            // Mostrar los errores
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo json_encode(['message'=>$error,"alert"=>"alert-danger",'·post'=>$_POST]);
                }
            } else {

                $response = $this->paymentRepository->add($codigo,$id_alumno,$metodo_pago,$monto,$descuento,$observacion,$total,$status);
                if( $response['success']){
                    echo json_encode(['message'=>$response['message'],"alert"=>"alert-success"  ]);
                }else{
                    echo json_encode(['message'=>$response['message'],"alert"=> "alert-warning" ] );

                }

            }
  
      


    }

    public function editarPago(){
        $this->checkRequest();
        $id= $_POST['id'];
        $codigo = $_POST['codigo']; 
        $id_alumno = $_POST['select_Alumno']; 
        $metodo_pago = $_POST['select_pago'];
        $monto = $_POST['monto'];
        $descuento = $_POST['descuentos']; 
        $observacion = $_POST['observacion'];
        $total = isset( $_POST['total']) ?  $_POST['total'] :0.00  ;
        $status = $_POST['select_status'];

 
        
            // Definir las expresiones regulares en un array
    
            $validations = [
                'codigo' => [
                    'regex' => "/^[a-zA-Z0-9]+$/",
                    'error' => 'El código solo debe contener letras y números.'
                ],
                
                'metodo_pago' => [
                    'regex' => "/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/",
                    'error' => 'El método de pago solo debe contener letras y espacios.'
                ],
                'monto' => [
                    'regex' => "/^\d+(\.\d{1,2})?$/",
                    'error' => 'El monto debe ser un número válido con hasta dos decimales.'
                ],
                'descuento' => [
                    'regex' => "/^\d+$/",
                    'error' => 'El descuento debe ser un número entero.'
                ],
                'observacion' => [
                    'regex' => "/^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]{9,}$/",
                    'error' => 'La observación debe tener exactamente 9 caracteres y solo contener letras, puntos o espacios.'
                ],
                'total' => [
                    'regex' => "/^\d+(\.\d{1,2})?$/",
                    'error' => 'El total debe ser un número válido con hasta dos decimales.'
                ],
                'status' => [
                    'regex' => "/^[0-9]+$/",
                    'error' => 'El estado solo debe contener números.'
                ]
            ];

            // Datos a validar
            $data = [
                'codigo' => $codigo, // Asignar tus variables aquí
             
                'metodo_pago' => $metodo_pago,
                'monto' => $monto,
                'descuento' => $descuento,
                'observacion' => $observacion,
                'total' => $total,
                'status' => $status
            ];

            // Array para almacenar los errores
            $errors = [];

            // Validar cada campo
            foreach ($validations as $field => $validation) {
                if (!preg_match($validation['regex'], $data[$field])) {
                    $errors[] = $validation['error'];
                }
            }

            // Mostrar los errores
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo json_encode(['message'=>$error,"alert"=>"alert-danger",'·post'=>$_POST]);
                }
            } else {

                $response = $this->paymentRepository->edit($codigo,$id_alumno,$metodo_pago,$monto,$descuento,$observacion,$total,$status,$id);
                if( $response['success']){
                    echo json_encode(['message'=>$response['message'],"alert"=>"alert-success"  ]);
                }else{
                    echo json_encode(['message'=>$response['message'],"alert"=> "alert-warning" ] );
    
                }

            }
  
      

         

        
       
    }
    
    public function borrarPago(){
        $this->checkRequest();
        $id= $_POST['id'];
    
        if(preg_match("/^[0-9]+$/",$id)   ) 
        {  
            $response = $this->paymentRepository->remove($id);
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