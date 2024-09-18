<?php
namespace App\Model;

use Core\Model;
use RuntimeException;

class User extends Model{
    
    protected $id;
    protected $user;
    protected $password;
    protected $role;
    protected $table;
    protected $columns;

    /**Getter***/
    public function getId(){return $this->id;}
    public function getUser() {return $this->user;}
    public function getPassword(){ return $this->password;}
    public function getRole() {return $this->role;}
    /**Setter***/
    public function setId($id): self{$this->id = $id;return $this;}
    public function setUser($user): self { $this->user = $user;return $this; }
    public function setPassword($password): self{$this->password = $password;return $this;}
    public function setRol($role): self {$this->role = $role; return $this;}

    public function login() {
        try {
            $this->table = "usuario";
            $this->columns = [
                "usuario",
                "password"
            ];
    
            // Usar parámetros preparados
            $this->condition = "usuario = :usuario AND password = :password";
            $params = [
                ':usuario' => $this->getUser(),
                ':password' => $this->getPassword()
            ];
    
            // Ejecutar la consulta con parámetros
            return $this->query($params);
    
        } catch (\Throwable $th) {
            // Manejar y lanzar la excepción según sea necesario
            throw new RuntimeException("Error en login: " . $th->getMessage());
        }
    }
    

}