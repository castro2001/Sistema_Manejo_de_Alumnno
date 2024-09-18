<?php

namespace App\Model\Repository;

use App\Model\Interface\IStudentRepository;
use App\Model\Student;
use RuntimeException;

class StudentRepository {
    protected $student;
    public function __construct()
    {
        $this->student= new Student();
    }

    public function findById(int $id){
        $this->student->setId($id);
        return $this->student->find();
    }

    public function query(){
        return $this->student->all();
    }

    public function add(string $nombre,string $fecha,string $direccion,string $foto,int $telefono,string $escuela,string $academica,int $tutor){
        $this->student->SetName($nombre);
        $this->student->SetDateOfBirth($fecha);
        $this->student->SetAddress($direccion);
        $this->student->SetPhoto($foto);
        $this->student->SetCellphone($telefono);
        $this->student->SetSchoolOrigin($escuela);
        $this->student->SetAcademicStatus($academica);
        $this->student->SetIdTutor($tutor);

        try {
            $result =$this->student->create();
            if ($result) {
                return ['success' => true, 'message' => 'Alumno registrado exitosamente.','alert_color'=>"alert-success"];
            } else {
                return ['success' => false, 'message' => 'Ya existe un Alumno Registrado.','alert_color'=>"alert-warning"];
            }
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }

    }


    public function edit(string $nombre,string $fecha,string $direccion,string $foto,int $telefono,string $escuela,string $academica,int $tutor,int $id){
        $this->student->SetName($nombre);
        $this->student->SetDateOfBirth($fecha);
        $this->student->SetAddress($direccion);
        $this->student->SetPhoto($foto);
        $this->student->SetCellphone($telefono);
        $this->student->SetSchoolOrigin($escuela);
        $this->student->SetAcademicStatus($academica);
        $this->student->SetIdTutor($tutor);
        $this->student->setId($id);
        
        try {
            $result =  $this->student->update();
            if ($result) {
                return ['success' => true, 'message' => 'Alumno actualizado exitosamente.','alert_color'=>"alert-success"];
            } else {
                return ['success' => false, 'message' => 'Los datos del Alumno ya a sido Actualizado.','alert_color'=>"alert-warning"];
            }
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
   

    public function remove($id){
        $this->student->setStatus(0);
        $this->student->setId($id);
    
        try {
            $result = $this->student->delete();
            if ($result) {
                return ['success' => true, 'message' => 'El Alumno a sido Eliminado del registro.','alert_color'=>"alert-success"];
            } else {
                return ['success' => false, 'message' => 'El Alumno registrado con ese nombre ya no existe.','alert_color'=>"alert-warning"];
            }
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
       
    }

}