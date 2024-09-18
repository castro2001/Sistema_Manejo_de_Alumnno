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
        $information=array(
            "styles"=>["custom"],
            "scripts"=>['login']
        );
    
        
        $this->render("login",$information);
    }

  


}
