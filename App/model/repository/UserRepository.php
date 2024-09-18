<?php

namespace App\Model\Repository;


use App\Model\User;


class UserRepository {
    protected $user;

    public function __construct()
    {
        $this->user= new User();
    }
    
    public function login( $user,$password){
        $this->user->setUser($user);
        $this->user->setPassword($password);

        return  $this->user->login();

    }
 

}