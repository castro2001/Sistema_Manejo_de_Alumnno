<?php 

namespace App\Controller;

use App\Model\Repository\CountRepository;
use Core\Controller;

class AdministradorController extends Controller{
    protected $countRepository;
    public function __construct()
    {
      $this->countRepository = new CountRepository();
    } 
    public function view_Administrador(){
        
        $information=array(
            "title"=>"Administrador",
            "student"=> $this->countRepository->studentCount(),
            "subject"=> $this->countRepository->subjectCount(),
            "payment"=> $this->countRepository->paymentCount(),
            "tutor"=> $this->countRepository->tutorCount(),
            "styles"=>[
                "custom","card"
            ]
        );
    
        $this->render("administrador",$information);
        
        
    }
  
    
}