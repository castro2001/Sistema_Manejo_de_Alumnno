<?php
namespace Core;
use App\Controller\LoginController;

class Routes{
    private $listWhite;

    public function __construct()
    {
        // Iniciar la sesión
        $this->getUrl();
    }

    public function getUrl(){
        // Definir las vistas permitidas solo para usuarios autenticados
        $this->listWhite = array(
            "Administrador",'Alumno','Horario','Pagos','Tutor','Materia','AgregarAlumno'
        );

        if(!isset($_GET['views'])){
            $controller = new LoginController();
            call_user_func(array($controller,'view_login'));
        }else{
            $controller = $_GET['views'];
            $method= isset($_GET['action']) ? $_GET['action']:null;
            if(in_array($controller,$this->listWhite)){
                if(file_exists(__DIR__."/../App/controller/".$controller."Controller.php")){
                    $controllerName = ucwords($controller . "Controller");
                    $controllerClass = "App\\Controller\\" . $controllerName;
                    if(class_exists($controllerClass)){
                        $controllerInstance = new $controllerClass();
                        if(!$method){
                            $method = "view_".$controller;
                        }
                        if(method_exists($controllerInstance,$method)){
                            call_user_func(array($controllerInstance,$method));  
                        }else{
                            echo "Metodo no definido 405";
                        }
                    }
                }else{
                    echo "archivo no disponible";
                }
            }else{
                echo "controller no definido 404";
            }
        }

    }
       

}
