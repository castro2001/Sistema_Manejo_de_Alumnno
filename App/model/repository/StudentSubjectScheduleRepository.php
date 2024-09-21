<?php
namespace App\Model\Repository;

use App\Model\Student;
use App\Model\StudentSubjectSchedule;
use App\Model\Subject;
use Exception;
use RuntimeException;

class StudentSubjectScheduleRepository {
    protected $studentSubjectSchedule;
    protected $student;
    protected $subject;
    public function __construct()
    {
        $this->studentSubjectSchedule= new StudentSubjectSchedule();
        $this->student= new Student();
        $this->subject= new Subject();
    }
 
    /**CONSULTAS */
    public function query(){

        return $this->studentSubjectSchedule->all();

    }
    public function findById(int $id){
        $this->studentSubjectSchedule->setId($id);
        return $this->studentSubjectSchedule->find();
    }
    public function findByAlumno(int $id){
        $this->studentSubjectSchedule->setId($id);
        return $this->studentSubjectSchedule->findStudent();
    } 

    public function getAllDataSchedule() {
       
        return $this->studentSubjectSchedule->getAllDayWeeks();
    }
    

    public function getAllDataStudent(){
     return $this->student->getAllStudent(); 
    }

    public function getAllDataSubject(){
        return  $this->subject->getAllSubject();
    }
    /**Insercciones */
    public function add($alumno,$materia,$horario,$inicio,$fin){

        $this->studentSubjectSchedule->setIdAlumno($alumno);
        $this->studentSubjectSchedule->setIdMateria($materia);
        $this->studentSubjectSchedule->setDayWeek($horario); 
        $this->studentSubjectSchedule->setStartTime($inicio);
        $this->studentSubjectSchedule->setEndTime($fin); 
        // Intentar crear la materia y capturar el resultado
        try {
             $result =$this->studentSubjectSchedule->create();
            if ($result) {
                return ['success' => true, 'message' => 'el registrado fue creado exitosamente.','alert_color'=>"alert-success"];
            } else {
                return ['success' => false, 'message' => 'Ya existe un  registrado.','alert_color'=>"alert-warning"];
            }
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    
    public function edit($alumno,$materia,$horario,$inicio,$fin,$id){

        $this->studentSubjectSchedule->setIdAlumno($alumno);
        $this->studentSubjectSchedule->setIdMateria($materia);
        $this->studentSubjectSchedule->setDayWeek($horario); 
        $this->studentSubjectSchedule->setStartTime($inicio);
        $this->studentSubjectSchedule->setEndTime($fin);
        $this->studentSubjectSchedule->setId($id); 
        // Intentar crear la materia y capturar el resultado
        try {
             $result =$this->studentSubjectSchedule->update();
            if ($result) {
                return ['success' => true, 'message' => 'Los registrado fue Actualizado exitosamente.','alert_color'=>"alert-success"];
            } else {
                return ['success' => false, 'message' => 'Ya se Actualizo  el  registrado.','alert_color'=>"alert-warning"];
            }
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function remove($id){

        $this->studentSubjectSchedule->setId($id); 

        // Intentar crear la materia y capturar el resultado
        try {
             $result =$this->studentSubjectSchedule->delete();
            if ($result) {
                return ['success' => true, 'message' => 'El  registrado Fue eliminado .','alert_color'=>"alert-success"];
            } else {
                return ['success' => false, 'message' => 'el  registrado no disponible.','alert_color'=>"alert-warning"];
            }
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

}