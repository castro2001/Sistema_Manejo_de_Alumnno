<?php
namespace App\Model;

use Core\Model;
use Exception;
use RuntimeException;

class Tutor extends Model{
    protected $id;
    protected $name;
    protected $cellphone;
    protected $occupation;
    protected $table;

    
    /*Getter */
    public function getId(){ return $this->id;}
    public function getName(){ return $this->name;}
    public function getCellphone() {return $this->cellphone;}
    public function getOccupation(){ return $this->occupation;}

    /**Setter */
    public function setId($id): self { $this->id = $id; return $this;}
    public function setName($name): self{$this->name = $name;return $this;}
    public function setCellphone($cellphone): self {$this->cellphone = $cellphone;return $this; }
    public function setOccupation($occupation): self  { $this->occupation = $occupation;return $this;}

    public function create(){
        $this->table = "tutor";
        $datos=[
            "nombre"=>$this->getName(),
            "n_celular"=>$this->getCellphone(),
            "ocupacion"=>$this->getOccupation()
        ];
        $this->columns= "nombre";
        
        if($this->exists($this->getName())){
            throw new RuntimeException('Padre ya existe');
        }
        $this->set_action('insert');
        return $this->prepare($datos);

    }

    public function update(){
        $this->table = "tutor";
        $datos=[
            "nombre"=>$this->getName(),
            "n_celular"=>$this->getCellphone(),
            "ocupacion"=>$this->getOccupation()
        ];
        $this->set_condition("id=".$this->getId());
        $this->set_action('update');
      return  $this->prepare($datos);
    }

    public function delete(){
        $this->table = "tutor";

        $this->set_condition("id=".$this->getId());
        $this->set_action('delete');
       return $this->prepare();
    }
    

    public function all(){
        $this->table = "tutor";
        return $this->query();

    }

    public function find(){
        $this->table = "tutor";
        $this->set_condition("id=".$this->getId());
                return $this->query(); 
    }
    
    public function filter() {
        $this->table = "tutor"; // Define la tabla de la consulta
        $filterA=[
            'nombre' => $this->getName(),
            'n_celular' => $this->getCellphone(),
            'ocupacion' => $this->getOccupation()
        ];
        // Inicializa un array para las condiciones
        $conditions = [];

        foreach ($filterA as $column => $value) {
            
                $this->set_condition("$column LIKE '$value%'");
            
        }
     
        // Ejecuta la consulta

        return $this->query(); 
    }


}