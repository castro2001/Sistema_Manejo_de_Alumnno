<?php
namespace App\Model;

use Core\Model;
use RuntimeException;

class StudentSubject extends Model{
    protected $id;
    protected $id_alumno;
    protected $id_materia;


    /**Getter***/
    public function getId(){ return $this->id;}
    public function getIdAlumno(){return $this->id_alumno; }
    public function getIdMateria(){ return $this->id_materia;}
    /**Setter***/
    public function setId($id): self { $this->id = $id; return $this;}
    public function setIdAlumno($id_alumno): self{ $this->id_alumno = $id_alumno;return $this; }
    public function setIdMateria($id_materia): self{$this->id_materia = $id_materia;return $this;}
//SELECT 


    public function all(){
        $this->table = "alumno_materia am";
        $this->columns=[
           'am.id','a.nombre as Alumno', 'm.nombre as Materia' ,'m.docente',' m.descripcion'
        ];
        // Establecer JOINs, condiciones y límites si es necesario
        $this->add_joins([
            'JOIN alumno a ON am.id_alumno = a.id JOIN materia m ON am.id_materia = m.id;'
        ]);
        $this->set_limit('100');
        // Ejecutar la consulta
        return $this->query();

    }
    public function create(){
        $this->table = "alumno_materia";
        $datos=[
            "id_alumno"=>$this->getIdAlumno(),
            "id_materia"=>$this->getIdMateria(),
        ];
        $this->set_action('insert');
        return $this->prepare($datos);

    }

    public function update(){
        $this->table = "alumno_materia";
        $datos=[
            "id_alumno"=>$this->getIdAlumno(),
            "id_materia"=>$this->getIdMateria(),
        ];
        $this->set_condition("id=".$this->getId());
        $this->set_action('update');
      return  $this->prepare($datos);
    }

    public function delete(){
        $this->table = "alumno_materia";

        $this->set_condition("id=".$this->getId());
        $this->set_action('delete');
       return $this->prepare();
    }
}