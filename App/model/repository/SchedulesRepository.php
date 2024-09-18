<?php

namespace App\Model\Repository;



use App\Model\Schedules;

class SchedulesRepository {
    protected $schedules;
    public function __construct()
    {
        $this->schedules = new Schedules();
    }
  
    public function add(int $id_materia, string $dia_semana, string $hora_inicio,string $hora_fin ){
        $this->schedules->setIdSubject($id_materia);
        $this->schedules->setDayWeek($dia_semana);
        $this->schedules->setStartTime($hora_inicio);
        $this->schedules->setEndTime($hora_fin);
        return $this->schedules->create();
    }

    public function query(){

        return $this->schedules->all();

    }
    public function edit(int $id_materia, string $dia_semana, string $hora_inicio,string $hora_fin , int $id){
        $this->schedules->setIdSubject($id_materia);
        $this->schedules->setDayWeek($dia_semana);
        $this->schedules->setStartTime($hora_inicio);
        $this->schedules->setEndTime($hora_fin);
   
        $this->schedules->setId($id);
        return $this->schedules->update();
    }

    public function remove(int $id){
        $this->schedules->setId($id);
        return $this->schedules->delete();
    }



//SELECT h.id ,m.nombre, h.dia_semana, h.hora_inicio,h.hora_fin FROM horarios h JOIN materia m ON h.id_materia = m.id  LIMIT 100
}