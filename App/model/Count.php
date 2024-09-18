<?php 
namespace App\Model;

use Core\Model;

class Count extends Model{
    protected $table;

    public function countStudent(){
        $this->table='alumno';
        $this->columns=['COUNT(*) as student'];

        return $this->query();
    }

    public function countPayment(){
        $this->table='pagos';
        $this->columns=['COUNT(*) as pagos'];

        return $this->query();
    }

    public function countSubject(){
        $this->table='materia';
        $this->columns=['COUNT(*) as materia'];

        return $this->query(); 
    }

    public function countTutor(){
        $this->table='tutor';
        $this->columns=['COUNT(*) as tutor'];

        return $this->query();
    }
}