<?php
namespace App\Model;

use Core\Model;
use Traits\TraitId;

class Schedules extends Model{
    // use TraitId;
    protected $id;
    protected $idSubject;
    protected $dayWeek;
    protected $startTime;
    protected $endTime;
    protected $table;
    protected $joins;
    protected $columns;

    /**Getter*** */
    public function getId(){ return $this->id;}
    public function getIdSubject(){return $this->idSubject;}
    public function getDayWeek() {return $this->dayWeek;}
    public function getEndTime(){return $this->endTime;}
    public function getStartTime() {return $this->startTime;}

    /*** Setter*/
    public function setId($id): self { $this->id = $id; return $this;}
    public function setIdSubject($idSubject): self {$this->idSubject = $idSubject;return $this;}
    public function setDayWeek($dayWeek): self { $this->dayWeek = $dayWeek;return $this;}
    public function setStartTime($startTime): self{ $this->startTime = $startTime; return $this;}
    public function setEndTime($endTime): self{$this->endTime = $endTime; return $this;}

    /***Metodos CRUD**** */
    public function create(){
        $this->table = "horarios";
        $datos=[
            "id_materia"=>$this->getIdSubject(),
            "dia_semana"=>$this->getDayWeek(),
            "hora_inicio"=>$this->getStartTime(),
            "hora_fin"=>$this->getEndTime()
        ];
        $this->set_action('insert');
        return $this->prepare($datos);

    }

    public function update(){
        $this->table = "horarios";
        $datos=[
            "id_materia"=>$this->getIdSubject(),
            "dia_semana"=>$this->getDayWeek(),
            "hora_inicio"=>$this->getStartTime(),
            "hora_fin"=>$this->getEndTime()
        ];
        $this->set_condition("id=".$this->getId());
        $this->set_action('update');
      return  $this->prepare($datos);
    }

    public function delete(){
        $this->table = "horarios";

        $this->set_condition("id=".$this->getId());
        $this->set_action('delete');
       return $this->prepare();
    }
    

    public function all() {
        //SELECT * FROM horarios h JOIN  materia m ON h.id_materia = m.id LIMIT 100 TIME_FORMAT(hora_inicio,"%H:%i")
        $this->table = "horarios h";
        $this->columns=[
            'h.id , m.nombre , h.dia_semana,  h.hora_inicio ,h.hora_fin'
        ];
        // Establecer JOINs, condiciones y límites si es necesario
        $this->add_joins([
            ' JOIN  materia m ON h.id_materia = m.id'
        ]);
        $this->set_limit('100');

        // Ejecutar la consulta
        return $this->query();
    }
    

}