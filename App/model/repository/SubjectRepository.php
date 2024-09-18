<?php

namespace App\Model\Repository;
use App\Model\Subject;
use RuntimeException;

class SubjectRepository {
    protected $subject;

    public function __construct()
    {
        $this->subject= new Subject();
    }
  

    public function findById(int $id){
        $this->subject->setId($id);
        return $this->subject->find();
    }

    public function query(){

        return $this->subject->all();

    }

 
    public function add(string $nombre, string $docente, string $descripcion)
    {
        // Configurar los valores en el objeto 'subject'
        $this->subject->setName($nombre);
        $this->subject->setTeacher($docente);
        $this->subject->setDescription($descripcion);

        // Intentar crear la materia y capturar el resultado
        try {
            $result = $this->subject->create();
            if ($result) {
                return ['success' => true, 'message' => 'Materia creada exitosamente.','alert_color'=>"alert-success"];
            } else {
                return ['success' => false, 'message' => 'No se pudo crear la materia.','alert_color'=>"alert-warning"];
            }
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }


    public function edit(string $nombre,string $docente ,string $descripcion, int $id){
        $this->subject->setName($nombre);
        $this->subject->setTeacher($docente);
        $this->subject->setDescription($descripcion);
        $this->subject->setId($id);
        // Intentar crear la materia y capturar el resultado
        try {
            $result = $this->subject->update();
            if ($result) {
                return ['success' => true, 'message' => 'Materia Actualizada exitosamente.','alert_color'=>"alert-success"];
            } else {
                return ['success' => false, 'message' => 'La Materia ya se Actualizo.','alert_color'=>"alert-warning"];
            }
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
     
    }

    public function remove(int $id){
        $this->subject->setId($id);
        try {
            $result =$this->subject->delete();
            if ($result) {
                return ['success' => true, 'message' => 'Materia Eliminada.','alert_color'=>"alert-success"];
            } else {
                return ['success' => false, 'message' => 'La Materia ya se elimino.','alert_color'=>"alert-warning"];
            }
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
        
    }

}