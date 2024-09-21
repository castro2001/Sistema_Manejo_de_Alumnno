<?php
namespace App\Model;

use Core\Model;
use RuntimeException;

class StudentSubjectSchedule extends Model{
    protected $id;
    protected $idStudent;
    protected $idSubject;
    protected $dayWeek;
    protected $startTime;
    protected $endTime;

    /**Getter***/
    public function getId(){ return $this->id;}
    public function getIdAlumno(){return $this->idStudent; }
    public function getIdMateria(){ return $this->idSubject;}
    public function getDayWeek() {return $this->dayWeek;}
    public function getEndTime(){return $this->endTime;}
    public function getStartTime() {return $this->startTime;}
    /**Setter***/
    public function setId(int $id): self { $this->id = $id; return $this;}
    public function setIdAlumno($idStudent): self{ $this->idStudent = $idStudent;return $this; }
    public function setIdMateria($idSubject): self{$this->idSubject = $idSubject;return $this;}
    public function setDayWeek($dayWeek): self { $this->dayWeek = $dayWeek;return $this;}
    public function setStartTime($startTime): self{ $this->startTime = $startTime; return $this;}
    public function setEndTime($endTime): self{$this->endTime = $endTime; return $this;}
//SELECT 
/*
SELECT amh.id as Id  ,a.nombre as Alumno ,amh.dia_semana AS Dia, m.nombre as Materia,  amh.hora_inicio as Inicio,
 amh.hora_fin as Fin from alumno_materia_horarios amh join alumno a ON amh.id_alumno = a.id JOIN materia m on amh.id_materia = m.id 

 */

    public function all(){
        $this->table = "alumno_materia_horarios amh";
        $this->columns=[ 
            '  amh.id as Id',
            'a.id as Alumno_id',
            'a.nombre as Alumno',
            'amh.dia_semana AS Dia',
            'm.id as Materia_id',
            'm.nombre as Materia', 
          "DATE_FORMAT(amh.hora_inicio, '%H:%i') as Inicio",
            "DATE_FORMAT(amh.hora_fin, '%H:%i') as Fin",
        ];
        // Establecer JOINs, condiciones y límites si es necesario
        $this->add_joins([
            'join alumno a ON amh.id_alumno = a.id JOIN materia m on amh.id_materia = m.id '
        ]);
      
        // Ejecutar la consulta
        return $this->query();

    }

    
    public function find(){
        $this->table = "alumno_materia_horarios amh";
        $this->columns=[
            'amh.id as Id',
            'a.id as Alumno_id',
            'a.nombre as Alumno',
            'amh.dia_semana AS Dia',
            'm.id as Materia_id',
            'm.nombre as Materia', 
            "DATE_FORMAT(amh.hora_inicio, '%H:%i') as Inicio",
            "DATE_FORMAT(amh.hora_fin, '%H:%i') as Fin",

        ];
        // Establecer JOINs, condiciones y límites si es necesario
        $this->add_joins([
            'join alumno a ON amh.id_alumno = a.id JOIN materia m on amh.id_materia = m.id '
        ]);
        $this->set_distinct(true);
        $this->set_condition("amh.id = ".$this->getId());
        // Ejecutar la consulta
        return $this->query();

    }

    public function findStudent(){
        $this->table = "alumno_materia_horarios amh";
        $this->columns=[
            'amh.id as Id',
            'a.id as Alumno_id',
            'a.nombre as Alumno',
            'amh.dia_semana AS Dia',
            'm.id as Materia_id',
            'm.nombre as Materia', 
            "DATE_FORMAT(amh.hora_inicio, '%H:%i') as Inicio",
            "DATE_FORMAT(amh.hora_fin, '%H:%i') as Fin",

        ];
        // Establecer JOINs, condiciones y límites si es necesario
        $this->add_joins([
            'join alumno a ON amh.id_alumno = a.id JOIN materia m on amh.id_materia = m.id '
        ]);
        $this->set_distinct(true);
        $this->set_condition("a.id = ".$this->getId());
        // Ejecutar la consulta
        return $this->query();

    }

    public function getAllDayWeeks() {
        $this->table = "alumno_materia_horarios";
        $this->columns = ['dia_semana']; // Seleccionar la columna necesaria
        $this->set_distinct(true); // Establecer DISTINCT correctamente
        $this->set_order_by('dia_semana ASC');
        return $this->query(); // Ejecutar la consulta y devolver el resultado
    }


    public function create()
{
    $this->table = "alumno_materia_horarios";
    $datos = [
        "id_alumno" => $this->getIdAlumno(),
        "id_materia" => $this->getIdMateria(),
        "dia_semana" => $this->getDayWeek(),
        "hora_inicio" => $this->getStartTime(),
        "hora_fin" => $this->getEndTime(),
    ];

    // Verificar si el alumno ya está registrado en otra materia en el mismo horario y día
    if ($this->exists2($this->getIdAlumno(), $this->getDayWeek(), $this->getStartTime(), $this->getEndTime())) {
        throw new RuntimeException('El alumno ya está registrado en otra materia en el mismo horario.');
    }

    $this->set_action('insert');
    return $this->prepare($datos);
}


    public function update(){
        $this->table = "alumno_materia_horarios";
        $datos=[
            "id_alumno"=>$this->getIdAlumno(),
            "id_materia"=>$this->getIdMateria(),
            "dia_semana"=>$this->getDayWeek(),
            "hora_inicio"=>$this->getStartTime(),
            "hora_fin"=>$this->getEndTime(),
        ];
        $this->set_condition("id = ".$this->getId());
        $this->set_action('update');
      return  $this->prepare($datos);
    }

    public function delete(){
        $this->table = "alumno_materia_horarios";

        $this->set_condition("id=".$this->getId());
        $this->set_action('delete');
       return $this->prepare();
    }
}