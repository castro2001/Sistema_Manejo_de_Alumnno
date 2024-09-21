<?php

namespace App\Model\Repository;


use App\Model\User;
use RuntimeException;

class UserRepository {
    protected $user;

    public function __construct()
    {
        $this->user= new User();
    }
    
    public function login( $user,$password){
        $this->user->setUser($user);
        $this->user->setPassword($password); 
        try {
            $result = $this->user->login();
            if ($result) {
                return ['success' => true, 'data' => $result[0]];
            } else {
                return ['success' => false, 'message' => 'el usuario / contraseña no coincide.','alert_color'=>"alert-warning"];
            }

            
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
            if($e->getCode() === '23000'){
                return ['success' => false, 'message' => 'No se puede eliminar el tutor porque está asociado con registros en la tabla de alumnos.', 'alert_color' => 'alert-warning'];
            }
        }

    }
 

}