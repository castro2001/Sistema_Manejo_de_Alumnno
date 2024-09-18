<?php

namespace App\Model\Repository;
use App\Model\Tutor;
use RuntimeException;

class TutorRepository {
    
    protected $tutor;

    public function __construct()
    {
        $this->tutor= new Tutor();
    }

    public function findById(int $id){
        $this->tutor->setId($id);
        return $this->tutor->find();
    }

    public function filter($search){
        $this->tutor->setName($search);
        $this->tutor->setCellphone($search);
        $this->tutor->setOccupation($search);
       return  $this->tutor->filter();
    }

    public function query(){
        return $this->tutor->all();
    }


    public function add($nombre,$telefono,$ocupacion){

        $this->tutor->setName($nombre);
        $this->tutor->setCellphone($telefono);
        $this->tutor->setOccupation($ocupacion); 
        // Intentar crear la materia y capturar el resultado
        try {
             $result =$this->tutor->create();
            if ($result) {
                return ['success' => true, 'message' => 'Padre registrado exitosamente.','alert_color'=>"alert-success"];
            } else {
                return ['success' => false, 'message' => 'Ya existe un Padre registrado con ese nombre.','alert_color'=>"alert-warning"];
            }
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function edit(string $nombre, string $telefono, string $ocupacion, int $id){

        $this->tutor->setName($nombre);
        $this->tutor->setCellphone($telefono);
        $this->tutor->setOccupation($ocupacion);
        $this->tutor->setId($id);

        try {
            $result = $this->tutor->update();
            if ($result) {
                return ['success' => true, 'message' => 'Los datos del padre  actualizado exitosamente.','alert_color'=>"alert-success"];
            } else {
                return ['success' => false, 'message' => 'Los datos del Padre ya a sido Actualizado.','alert_color'=>"alert-warning"];
            }
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }

    }

    public function remove(int $id){

        $this->tutor->setId($id);
        try {
            $result = $this->tutor->delete();
            if ($result) {
                return ['success' => true, 'message' => 'Los datos del Padre a sido Eliminado del registro.','alert_color'=>"alert-success"];
            } else {
                return ['success' => false, 'message' => 'el padre  registrado con ese nombre ya no existe.','alert_color'=>"alert-warning"];
            }

            
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
            if($e->getCode() === '23000'){
                return ['success' => false, 'message' => 'No se puede eliminar el tutor porque está asociado con registros en la tabla de alumnos.', 'alert_color' => 'alert-warning'];
            }
        }
       
        
    }

  
}