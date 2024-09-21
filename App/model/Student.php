<?php
namespace App\Model;
use Core\Model;
use RuntimeException;

class Student extends Model{
   
    protected $id;
    protected $name;
    protected $dateOfBirth;
    protected $address;
    protected $photo;
    protected $cellphone;
    protected $schoolOrigin;
    protected $academicStatus;
    protected $id_tutor;
    protected $status;
    protected $table;

   /*******GETTER*********/
    public function getId(){ return $this->id;}
    public function getName(){ return $this->name;}
    public function getDateOfBirth(){ return $this->dateOfBirth;}
    public function getAddress(){ return $this->address;}
    public function getPhoto() { return $this->photo;}
    public function getCellphone() {return $this->cellphone;}
    public function getSchoolOrigin() {return $this->schoolOrigin;}
    public function getAcademicStatus(){ return $this->academicStatus;}
    public function getIdTutor() {return $this->id_tutor;}
    public function getStatus() {return $this->status;}
    /*******SETTER*********/

    public function setId($id): self { $this->id = $id; return $this;}
    public function setName($name): self{$this->name = $name;return $this;}
    public function setDateOfBirth($dateOfBirth): self { $this->dateOfBirth = $dateOfBirth;return $this;}
    public function setAddress($address): self {  $this->address = $address;return $this;}
    public function setPhoto($photo): self{ $this->photo = $photo; return $this;}
    public function setCellphone($cellphone): self {$this->cellphone = $cellphone;return $this; }
    public function setSchoolOrigin($schoolOrigin): self {$this->schoolOrigin = $schoolOrigin;return $this;}
    public function setAcademicStatus($academicStatus): self{$this->academicStatus = $academicStatus;return $this;}
    public function setIdTutor($id_tutor): self{$this->id_tutor = $id_tutor;return $this; }
    public function setStatus($status): self{$this->status = $status;return $this; }


    
    /***Metodos CRUD**** */
    public function create() {
        // Implementación para guardar un horario en la base de datos
        // INSERT INTO alumno (nombre, fecha_nacimiento, direccion,foto, n_celular, escuela_procedencia, situacion_academica, id_tutor) VALUES 
        // ('Marcos López', '2010-03-12', 'Av. Principal 123', '0981234567', 'Escuela Central', 'Buen rendimiento académico', 4);
        $this->table = "alumno ";
        $data=[
            "nombre"=>$this->getName(),
            "fecha_nacimiento"=>$this->getDateOfBirth(),
            "direccion"=>$this->getAddress(),
            "foto"=>$this->getPhoto(),
            "n_celular"=>$this->getCellphone(),
            "escuela_procedencia"=>$this->getSchoolOrigin(),
            "situacion_academica"=>$this->getAcademicStatus(),
            "id_tutor"=>$this->getIdTutor()
        ];
        $this->columns= "nombre";
        
        if($this->exists($this->getName())){
            throw new RuntimeException('Ya existe un Alumno Registrado.');
        }

        $this->set_action('insert');
        // Use the prepare method to execute the insert
        return $this->prepare($data);
    }

    public function update(){
        $this->table = "alumno ";
        $data=[
          "nombre"=>$this->getName(),
            "fecha_nacimiento"=>$this->getDateOfBirth(),
            "direccion"=>$this->getAddress(),
            "foto"=>$this->getPhoto(),
            "n_celular"=>$this->getCellphone(),
            "escuela_procedencia"=>$this->getSchoolOrigin(),
            "situacion_academica"=>$this->getAcademicStatus(),
            "id_tutor"=>$this->getIdTutor()
      
        ];
        $this->set_condition("id=".$this->getId());
        $this->set_action('update');
        
       return $this->prepare($data);
    }


    public function delete(){
        $this->table = "alumno";

        $this->set_condition("id=".$this->getId());
        $this->set_action('delete');
       return $this->prepare();
    }

    public function find(){
        $this->table = "alumno a";
        $this->columns = [
            'a.id', 
            'a.nombre as Alumno', 
            'a.fecha_nacimiento', 
            'a.direccion', 
            'a.foto', 
            'a.n_celular as Telefono', 
            'a.escuela_procedencia',
            'a.situacion_academica',
            't.nombre as tutor', 
            't.n_celular AS celular_Padre',
            't.ocupacion  as Ocupacion' ,
            'a.status'
        ];
        // Establecer JOINs, condiciones y límites si es necesario
        $this->add_joins([
            'JOIN tutor t ON a.id_tutor = t.id'
        ]);
        // $this->set_limit('100');
        $this->set_condition("a.id=" . $this->getId());
        return $this->query(); 
    }
    
    public function all() {
            //SELECT  FROM alumno a JOIN 
        $this->table = "alumno a";
        $this->columns=[
            'a.id',
            'a.nombre as Alumno',
            'a.fecha_nacimiento', 
            'a.direccion', 
            'a.foto', 
            'a.n_celular as Telefono',
             'a.escuela_procedencia',
             'a.situacion_academica', 
             't.nombre as tutor',
             't.n_celular AS celular_Padre',
             't.ocupacion  as Ocupacion' ,
             'a.status'
            ];
        // Establecer JOINs, condiciones y límites si es necesario
        $this->add_joins([
            ' JOIN  tutor t ON a.id_tutor = t.id'
        ]);

        // Ejecutar la consulta
        return $this->query();
    }

    
    public function getAllStudent()
    {
        $this->table = "alumno";
        $this->columns =[
            'id AS Alumno_id',
            'nombre as Alumno'
        ];
        
        $this->set_distinct(true);
        $this->set_order_by('id ASC');
        return $this->query();
    }
    
}