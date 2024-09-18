<?php
namespace App\Model;
use Core\Model;
use RuntimeException;

class Payment extends Model{
    protected $id;
    protected $codigo;
    protected $idStudent;
    protected $paymentMethod;
    protected $amount;
    protected $discount;
    protected $observacion;
    protected $total;
    protected $status;
    protected $table;

    /**GETTER**/
    public function getId(){ return $this->id;}
    public function getCodigo(){ return $this->codigo;}
    public function getIdStudent() {return $this->idStudent; }
    public function getPaymentMethod(){ return $this->paymentMethod;}
    public function getAmount() {return $this->amount; }
    public function getDiscount(){ return $this->discount; }
    public function getObservacion(){return $this->observacion;}
    public function getTotal(){return $this->total;}
    public function getStatus() {return $this->status;}

    /***SETTER**/
    public function setId($id): self { $this->id = $id; return $this;}
    public function setCodigo($codigo): self { $this->codigo = $codigo; return $this;}
    public function setIdStudent($idStudent): self{ $this->idStudent = $idStudent; return $this;}
    public function setPaymentMethod($paymentMethod): self  {$this->paymentMethod = $paymentMethod;return $this; }
    public function setAmount($amount): self {$this->amount = $amount;return $this;}
    public function setDiscount($discount): self  { $this->discount = $discount; return $this; }
    public function setObservacion($observacion): self{ $this->observacion = $observacion;  return $this;}
    public function setTotal($total): self{$this->total = $total;return $this;}
    public function setStatus($status): self{$this->status = $status;return $this; }

    public function create(){
        $this->table = "pagos";
        $datos=[
            "codigo"=>$this->getCodigo(),
            "id_alumno"=>$this->getIdStudent(),
            "metodo_pago"=>$this->getPaymentMethod(),
            "monto"=>$this->getAmount(),
            "descuentos"=>$this->getDiscount(),
            "observacion"=>$this->getObservacion(),
            "total"=>$this->getTotal(),
            "status"=>$this->getStatus()
        ];
        $this->columns= "codigo";
        
        if($this->exists($this->getCodigo())){
            throw new RuntimeException('Este codigo ya existe');
        }
        $this->set_action('insert');
        return $this->prepare($datos);

        

    }

    public function update(){
        $this->table = "pagos";
        $datos=[
            "codigo"=>$this->getCodigo(),
            "id_alumno"=>$this->getIdStudent(),
            "metodo_pago"=>$this->getPaymentMethod(),
            "monto"=>$this->getAmount(),
            "descuentos"=>$this->getDiscount(),
            "observacion"=>$this->getObservacion(),
            "total"=>$this->getTotal(),
            "status"=>$this->getStatus()
        ];
        $this->set_condition("id=".$this->getId());
        $this->set_action('update');
      return  $this->prepare($datos);
     
    }

    public function delete(){
        $this->table = "pagos";

        $this->set_condition("id=".$this->getId());
        $this->set_action('delete');
       return $this->prepare();
    }

    public function all(){
        // SELECT  FROM  
        $this->table = "pagos p";
        $this->columns=[
           ' p.id ', 'p.codigo','a.id as Alumno_id','a.nombre AS Alumno' , 'p.metodo_pago', 'p.monto','p.descuentos',' p.observacion' , 'p.total', 'p.status'
        ];
        // Establecer JOINs, condiciones y límites si es necesario
        $this->add_joins([
            ' JOIN alumno a ON p.id_alumno = a.id;'
        ]);
        $this->set_limit('100');
        // Ejecutar la consulta
        return $this->query();

    }
    public function find(){
        $this->table = "pagos p";
        $this->columns=[
           ' p.id ', 'p.codigo','a.id as Alumno_id','a.nombre AS Alumno' , 'p.metodo_pago', 'p.monto','p.descuentos',' p.observacion' , 'p.total', 'p.status'
        ];
        // Establecer JOINs, condiciones y límites si es necesario
        $this->add_joins([
            ' JOIN alumno a ON p.id_alumno = a.id'
        ]);
        $this->set_limit('100');
       
        $this->set_condition("p.id=".$this->getId());
                return $this->query(); 
    }
}