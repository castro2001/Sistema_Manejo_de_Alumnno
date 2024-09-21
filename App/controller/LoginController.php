<?php
namespace App\Controller;
use Core\Controller;
use App\Model\Repository\UserRepository;
use App\Model\User;

class LoginController extends Controller {
    protected $userRepository;
    protected $user;

    public function __construct() {
        $this->userRepository = new UserRepository(); 
        $this->user = new User();
    }

    public function view_login() {
        // Mostrar la vista de login
     
    
        
        $this->render_2("login");
    }

    public function login(){
        $this->checkRequest();
      

        
            $user = $_POST['user'];
            $pass= $_POST['clave'];
            $response = $this->userRepository->login($user,$pass);
            if( $response['success']){
               
                $_SESSION['User'] = $response['data'];
                header('location:http://localhost/Sistema_Manejo_de_Alumnno/Administrador');
                 //echo json_encode(['message'=>$response['message'],"alert"=>"alert-success"  ]);
            }else{
                $_SESSION['messagge'] =$response['message'];
            //  echo json_encode(['message'=>$response['message'],"alert"=> "alert-warning" ] );
             header('location:http://localhost/Sistema_Manejo_de_Alumnno/');;
            }

        
    }
  
    public function logout(){
        unset($_SESSION['User']);;
        session_destroy();
        header('location:http://localhost/Sistema_Manejo_de_Alumnno');
    }


}
