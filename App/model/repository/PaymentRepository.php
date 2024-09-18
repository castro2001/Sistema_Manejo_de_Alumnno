<?php
namespace App\Model\Repository;

use App\Core\Database;
use App\Model\Interface\IPaymentRepository;
use App\Model\Payment;
use Exception;
use RuntimeException;

class PaymentRepository {
    protected $payment;
    
    public function __construct()
    {
        $this->payment= new Payment();
    }

    public function findById(int $id){
        $this->payment->setId($id);
        return $this->payment->find();
    }

    public function query(){
        return $this->payment->all();
    }

    public function add(string $codigo, int $id_alumno, string $metodo_pago, string $monto, string $descuento, string $observacion, float $total, int $status) {
        $this->payment->setCodigo($codigo);
        $this->payment->setIdStudent($id_alumno);
        $this->payment->setPaymentMethod($metodo_pago);
        $this->payment->setAmount($monto);
        $this->payment->setDiscount($descuento);
        $this->payment->setObservacion($observacion);
        $this->payment->setTotal($total);
        $this->payment->setStatus($status);
        // Intentar crear la materia y capturar el resultado
        try {
            $result = $this->payment->create();
            if ($result) {
                return ['success' => true, 'message' => 'Pago registrado exitosamente.','alert_color'=>"alert-success"];
            } else {
                return ['success' => false, 'message' => 'Ya existe un codigo Registrado con ese Pago.','alert_color'=>"alert-warning"];
            }
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
           
        
    }
    
    public function edit(string $codigo, int $id_alumno, string $metodo_pago, string $monto, string $descuento, string $observacion, float $total, int $status, int $id){
        $this->payment->setCodigo($codigo);
        $this->payment->setIdStudent($id_alumno);
        $this->payment->setPaymentMethod($metodo_pago);
        $this->payment->setAmount($monto);
        $this->payment->setDiscount($descuento);
        $this->payment->setObservacion($observacion);
        $this->payment->setTotal($total);
        $this->payment->setStatus($status);
        $this->payment->setId($id);
            // Intentar crear la materia y capturar el resultado
        try {
            $result = $this->payment->update();
            if ($result) {
                return ['success' => true, 'message' => 'Pago actualizado exitosamente.','alert_color'=>"alert-success"];
            } else {
                return ['success' => false, 'message' => 'Los datos del Pago ya a sido Actualizado.','alert_color'=>"alert-warning"];
            }
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
      
            
 
        

    }

    public function remove(int $id){
        $this->payment->setId($id);
        try {
            $result =  $this->payment->delete();
            if ($result) {
                return ['success' => true, 'message' => 'Pago a sido Eliminado del registro.','alert_color'=>"alert-success"];
            } else {
                return ['success' => false, 'message' => 'el codigo registrado con ese pago ya no existe.','alert_color'=>"alert-warning"];
            }
        } catch (RuntimeException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
  
}