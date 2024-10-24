<?php
namespace App\Model;
use Fpdf\Fpdf;

class Pdf  extends Fpdf{
    public function header(){
        //Image
        $this->SetFont('Arial','B',25);
        $this->SetTextColor(255,0,0);
        $this->Text(15,22,'Recibo de Pago');
       
       $this->Image(__DIR__."/../../public/image/logo.png",148,15,55,55);

        //font cell
        $this->SetXY(225,35);
        $this->SetTextColor(246,130,14);
    }
  
  

}

