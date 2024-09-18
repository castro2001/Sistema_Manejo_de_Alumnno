<?php
namespace App\Model;

use Core\Model;
use RuntimeException;

class Subject extends Model{

    protected $id;
    protected $name;
    protected $teacher;
    protected $description;
    protected $table;

    /**Getter***/
    public function getId(){ return $this->id;}
    public function getName(){ return $this->name;}
    public function getDescription() {return $this->description; }
    public function getTeacher() { return $this->teacher;}
    /**SSetter***/
    public function setId($id): self { $this->id = $id; return $this;}
    public function setName($name): self{$this->name = $name;return $this;}
    public function setTeacher($teacher): self {$this->teacher = $teacher;return $this;}
    public function setDescription($description): self {$this->description = $description; return $this;}


    

    public function all(){
        $this->table = "materia";
        return $this->query();

    }

    public function find(){
        $this->table = "materia";
        $this->set_condition("id=".$this->getId());
                return $this->query(); 
    }

    public function create(){
        $this->table = "materia";
        $datos=[
            "nombre"=>$this->getName(),
            "docente"=>$this->getTeacher(),
            "descripcion"=>$this->getDescription()
        ];
        $this->columns= "nombre";
        
        if($this->exists($this->getName())){
            throw new RuntimeException(' Ya existe una materia registrada  ');
        }

        $this->set_action('insert');
        return $this->prepare($datos);

    }

    public function update(){
        $this->table = "materia";
        $datos=[
            "nombre"=>$this->getName(),
            "docente"=>$this->getTeacher(),
            "descripcion"=>$this->getDescription()
        ];
        $this->set_condition("id=".$this->getId());
        $this->set_action('update');
      return  $this->prepare($datos);
    }

    public function delete(){
        $this->table = "materia";

        $this->set_condition("id=".$this->getId());
        $this->set_action('delete');
       return $this->prepare();
    }
    
}