<?php
namespace App\Model\Repository;

use App\Model\Count;
use App\Model\Payment;
use Exception;


class CountRepository {
    protected $count;
    
    public function __construct()
    {
        $this->count= new Count();
    }

  
    public function studentCount(){
      

        return $this->count->countStudent();
    }

    public function paymentCount(){
        

        return $this->count->countPayment();
    }

    public function subjectCount(){
       

        return $this->count->countSubject(); 
    }

    public function tutorCount(){
       

        return $this->count->countTutor();
    }

    
  
}