<?php
namespace App\Model\Repository;

use App\Model\StudentSubject;
use Exception;

class StudentSubjectRepository {
    protected $studentSubject;
    
    public function __construct()
    {
        $this->studentSubject= new StudentSubject();
    }

    public function add(int $id_alumno, int $id_materia) {
        try {
            $this->studentSubject->setIdAlumno($id_alumno);
            $this->studentSubject->setIdMateria($id_materia);
        
            return $this->studentSubject->create();
            
        } catch (\Exception $e) {
          
          echo $e->getMessage() ;
           
        }
    }
    

    public function query(){

        return $this->studentSubject->all();

    }

    public function edit(int $id_alumno, int $id_materia,int $id){
       
        try {
            $this->studentSubject->setIdAlumno($id_alumno);
            $this->studentSubject->setIdMateria($id_materia);
 
         $this->studentSubject->setId($id);
         return $this->studentSubject->update();
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    public function remove(int $id){
        $this->studentSubject->setId($id);
        return $this->studentSubject->delete();
    }
}