<?php
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
function Header()
{
    // Logo
    $this->Image('../images/logo_pdf.png',10,6,20);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(70);
    // Title
    $this->Cell(60,7,$_SESSION['headercontent1'],0,0,'C');
	$this->Ln();
	$this->Cell(70);
    $this->Cell(60,7,$_SESSION['headercontent2'],0,0,'C');
	$this->Ln();
	$this->Cell(70);
	$this->Cell(60,20,$_SESSION['headercontent3'],0,0,'C');
    // Line break
    $this->Ln(15);
	unset($_SESSION['headercontent1']);
	unset($_SESSION['headercontent2']);
	unset($_SESSION['headercontent3']);
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
	
// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Simple table
function BasicTable($header, $data)
{
    // Header
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

// Better table
function ImprovedTable($header, $data)
{
    // Column widths
    $w = array(40, 35, 40, 45);
    // Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0][0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}

// Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B','10');
    // Header
    $w = array(8,62,25,22, 20,26, 26);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
	$i=0;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$data[$i]['sno'],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$data[$i]['name'],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$data[$i]['pno'],'LR',0,'L',$fill);
        $this->Cell($w[3],6,$data[$i]['state'],'LR',0,'L',$fill);
        $this->Cell($w[4],6,$data[$i]['nationality'],'LR',0,'L',$fill);
        $this->Cell($w[5],6,$data[$i]['eno'],'LR',0,'L',$fill);
        $this->Cell($w[6],6,$data[$i]['bno'],'LR',0,'L',$fill);
        $this->Ln();
        $fill = !$fill;
		$i++;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}
}

?>