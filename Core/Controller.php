<?php
namespace Core;

abstract class Controller{
    protected function render(string $view,array $data = []){
        extract($data);
        $router= str_replace(".","/",$view);
        if(file_exists(__DIR__."/../App/views/frontend/$router.php")){
          ob_start();
            require_once __DIR__."/../App/views/layout/header.php";
            require_once __DIR__."/../App/views/frontend/$router.php";
            require_once __DIR__."/../App/views/layout/footer.php";
            ob_end_flush();
        }else{
            echo("Arcchivo no disponible");
        }
    }
    
 
    protected function render_2(string $view,array $data = []){
        extract($data);
        $router= str_replace(".","/",$view);
        if(file_exists(__DIR__."/../App/views/frontend/$router.php")){
          ob_start();
           
            require_once __DIR__."/../App/views/frontend/$router.php";
            
            ob_end_flush();
        }else{
            echo("Arcchivo no disponible");
        }
    }

  

    protected function checkRequest() : void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo  "405 metodo no disponible";
            exit;  // Asegúrate de detener la ejecución después de mostrar el error
        }
    }
}