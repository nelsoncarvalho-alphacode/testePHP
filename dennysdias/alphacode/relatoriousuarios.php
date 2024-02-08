<?php
session_start();
include("seguranca.php");
include("conexao.php");
include("funcoes.php");
require("fpdf/fpdf.php");

if(!isset($_POST["usuario"])){
	header('Location: relatoriousuariospesquisa.php');
}

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set("America/Fortaleza");

$conexao = new Conexao();
$conexao->abrirConexao();

class PDF extends FPDF
{
   	var $widths;
   	var $aligns;
  
	function Header()
	{
	   	$this->SetXY(15,15);
	   	$this->Cell(563,65,"",1,1,'C');
	   	$this->SetFont('Arial','B',15);
	   	$this->SetXY(200,25);
	   	$this->Cell(5,15,utf8_decode("Relatório de usuários"));
	   	$this->SetFont('Arial','I',9);
	   	$this->SetXY(60,45);
	   	$this->Cell(5,15,utf8_decode("Data emissão: ").date("d/m/Y"));
	   	$this->SetXY(60,60);
	   	$this->Cell(5,15,utf8_decode("Funcionário: ".$_SESSION["nome_session"]."         "."Centro de custo: ".$_SESSION["centrodecusto_session"]));
	   	$this->SetXY(60,75);
		
		$this->SetFont('Arial','B',9);
        $this->SetXY(15,90);
        $this->SetWidths(array(187,188,188));
        $this->Row(array(utf8_decode("Funcionário"),utf8_decode("Nível acesso"),"Centro de Custo"));
		$this->SetX(15);
	}

	function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function SetWidths($w)
   	{
     	//Set the array of column widths
    	$this->widths=$w;
   	}
  
   	function SetAligns($a)
   	{
    	//Set the array of column alignments
     	$this->aligns=$a;
   	}
  
   	function Row($data)
   	{
     	//Calculate the height of the row
    	$nb=0;
		for($i=0;$i< count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
			$h=15*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i< count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,15,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
   }
  
   function CheckPageBreak($h)
   {
   		//If the height h would cause an overflow, add a new page immediately
   		if($this->GetY()+$h>$this->PageBreakTrigger)
        	$this->AddPage($this->CurOrientation);
   }
  
   function NbLines($w,$txt)
   {
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			 	$l+=$cw[$c];
			 	if($l>$wmax)
			 	{
					if($sep==-1)
				 	{
						if($i==$j)
							$i++;
				 	}
				 	else
						$i=$sep+1;
					$sep=-1;
				 $j=$i;
				 $l=0;
				 $nl++;
			 	}
			 	else
					$i++;
		 }
   		return $nl;
   }
	
}

   $pdf=new PDF("P","pt","A4");
   $pdf->AliasNbPages();
   $pdf->AddPage();

    $sql   = " select u.*,c.centrodecusto, n.nivelacesso as nivel from usuario u       "; 
	$sql  .= " inner join centrodecusto c on ";
	$sql  .= "  u.idcentrodecusto = c.idcentrodecusto ";
	$sql  .= " inner join nivelacesso n on ";
	$sql  .= "  u.idnivelacesso = n.idnivelacesso ";
	$sql  .= " where 1=1 ";
    if(!empty($_POST["usuario"])){
   		$sql .= " and nome like '%".$_POST["usuario"]."%' ";
	}
    $sql .= " order by u.nome ";
  
   $queryusuario = $conexao->query($sql);
     
   while($resultsetusuario = $conexao->listarQuery($queryusuario))
   {

	   $pdf->SetFont('Arial');
       $pdf->SetX(15);
	   $pdf->SetWidths(array(187,188,188));
	   $pdf->Row(array(utf8_decode($resultsetusuario["nome"]),utf8_decode($resultsetusuario["nivel"]),utf8_decode($resultsetusuario["centrodecusto"])));
	 
  }
  
  $pdf->Output();
?>