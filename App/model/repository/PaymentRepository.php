<?php
namespace App\Model\Repository;

use App\Core\Database;
use App\Model\Interface\IPaymentRepository;
use App\Model\Payment;
use App\Model\Pdf;
use Exception;
use RuntimeException;

class PaymentRepository {
    protected $payment;
    protected $pdfRepository;
    
    public function __construct()
    {
        $this->payment= new Payment();
        $this->pdfRepository = new Pdf("L","mm","A5");
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
  
    //PDF
    public function pdfGeneratePaymentById($id){
     
        $alumnoNombre="";
        $codigo="";
        $importe="";
        $concepto="";

        foreach ($this->findById($id) as $data) {
            $alumnoNombre = $data->Alumno;
            $codigo= $data->codigo;
            $concepto= $data->observacion ;
            $importe= $data->total ;
        }

        $fileName= "Recibo de Pago {$alumnoNombre}";
        
        $this->pdfRepository->SetFont('Arial','',10);
        $this->pdfRepository->setTitle('Reporte de Pagos');
        $this->pdfRepository->AliasNbPages();
        $this->pdfRepository->SetAutoPageBreak(true,20);
   
          $this->pdfRepository->SetTopMargin(20); // Reducido de 500 a 20
          $this->pdfRepository->SetRightMargin(10);
          $this->pdfRepository->SetX(50);
        $this->pdfRepository->AddPage();
             $this->pdfRepository->SetDrawColor(68,114,151);
                $this->pdfRepository->SetFillColor(232,238,251);
                $this->pdfRepository->SetTextColor(68,114,151);
            
                $this->pdfRepository->SetFont('Arial','',18);
                $this->pdfRepository->Text(15,40,'Folio');
                $this->pdfRepository->SetXY(15,45);
            
                $this->pdfRepository->SetTextColor(0,0,0);
                $this->pdfRepository->SetFont('Arial','',15);
                $this->pdfRepository->Cell(45,9,$codigo,1,0,'C',true);
                
                $this->pdfRepository->Rect(8,8,195,130,'');
$this->pdfRepository->SetTextColor(68,114,151);
                $this->pdfRepository->SetFont('Arial','',18);
                $this->pdfRepository->Text(64,40,utf8_decode('Fecha de expedición'));
                $this->pdfRepository->SetXY(64,45);
                $this->pdfRepository->SetTextColor(0,0,0);
                $this->pdfRepository->Cell(71,9,date('d/m/Y '),1,0,'C',true);
        
                $this->pdfRepository->SetTextColor(68,114,151);
                $this->pdfRepository->SetFont('Arial','',18);
                $this->pdfRepository->Text(15,65,'Alumno');
                $this->pdfRepository->SetXY(15,70);
                $this->pdfRepository->SetTextColor(0,0,0);
                $this->pdfRepository->Cell(120,9,utf8_decode($alumnoNombre),1,0,'C',true);
                $this->pdfRepository->SetTextColor(68,114,151);
                $this->pdfRepository->SetFont('Arial','',18);
            $this->pdfRepository->Text(15,95,'Concepto');
                $this->pdfRepository->SetXY(15,102);
                $this->pdfRepository->SetTextColor(0,0,0);
                $this->pdfRepository->Cell(120,25,$concepto,1,0,'C',true);

                $this->pdfRepository->SetTextColor(68,114,151);
            $this->pdfRepository->Text(155,95,'Importe');
            $this->pdfRepository->SetXY(150,102);
            $this->pdfRepository->SetTextColor(0,0,0);
            $this->pdfRepository->Cell(45,25,"$".$importe,1,0,'C',true);
      
        $this->pdfRepository->Output('D',$fileName.".pdf",true);
       
    }

}