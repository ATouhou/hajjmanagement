<?php
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
function Header()
{
    // Logo
	if(isset($_SESSION['logo']))
	{
    	$this->Image($_SESSION['logo'],10,10,30);
		unset($_SESSION['logo']);
	}
	// Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(30);
    // Title
	for($i= 0; $i< $_SESSION['totaltitle']; $i++)
	{
		$this->Cell(60,7,$_SESSION['headercontent'.$i],0,0,'L');
		$this->Ln();
	    $this->SetFont('Arial','B',10);		
		$this->Cell(30);
		unset($_SESSION['headercontent'.$i]);	
	}
	
    // Line break
	$distance = 7-$_SESSION['totaltitle'];
	if($distance>2){   $this->Ln($distance); }else{ $this->Ln(2); }
	unset($_SESSION['totaltitle']);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb} Copyright@2013 Manalairservices.com',0,0,'C');
}
	


// Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
//	$header = 6;
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B','10');
    // Header
	
//    $w = array(8,62,25,22, 20,26, 26);
	  $w = $_SESSION['columnwidth'];	
	
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
	$sno=0;
    foreach($data as $row)
    {
		for($i=0; $i< $_SESSION['columncount']; $i++)
		{
			$this->Cell($w[$i],6,$data[$sno][$i],'1',0,'C',$fill);
		}	
		$this->Ln();
        $fill = !$fill;
		$sno++;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
	unset($_SESSION['columncount']);
	unset($_SESSION['columnwidth']);
}
}

?>