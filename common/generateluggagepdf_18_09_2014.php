<?php
include("../common/functions.php");
require('pdf_common.php');


$id = $_REQUEST['id'];
$db= new Database();
$flight_carrier_run = $db->query("SELECT * FROM flights LEFT JOIN carriers ON agency_id=carriers_id WHERE flights.flight_id='".$id."'");
$flight_carrier_data = $db->fetch($flight_carrier_run);
$carrier_allowed_weight = $flight_carrier_data['weight'];
$_SESSION['logo'] = '../image_content/carriers/carriers_images_th/'.$flight_carrier_data['agency_id'].'.'.$flight_carrier_data['carriers_logo'];
//$_SESSION['headercontent0'] = 'Luggage List';
$_SESSION['headercontent0'] = getcarriername($_SESSION['agency_id']);
$_SESSION['headercontent1'] = 'LUGGAGE DETAILS FOR';
//$_SESSION['headercontent2']= 'POINT OF EMBARKATION:'.getflightlocationname($flight_carrier_data['source']).'    POINT OF DISEMARKATION:'.getflightlocationname($flight_carrier_data['destination']);
$_SESSION['headercontent2'] = 'Flight No:'.$flight_carrier_data['flight_no'].' Date:'.$flight_carrier_data['date1'].' Time:'.$flight_carrier_data['time1'].'          FROM '.getflightlocationname($flight_carrier_data['source']).' TO:'.getflightlocationname($flight_carrier_data['destination']);
//$_SESSION['headercontent4'] = 'Owner of Operator '.getcarriername($_SESSION['agency_id']).'      Marks of Nationality Registration';
$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM luggage WHERE flight_id='".$id."' ORDER BY createdon DESC");
$check =0;
while($row_disp = $db->fetch($run_disp))
{
	$check++;
	$show_disp[] = $row_disp;
}

if($check>0)
{

$sno =1;
$i=0;
$male = 0;
$female =0;
$total_luggage =0;
$total_extra_luggage =0;
$total_payment =0;
$total_pieces =0;
foreach($show_disp as $val=>$key ) {
			$run_info = $db->query("SELECT l.createdby,p.full_name,p.passport_no, e.eno,p.state,l.luggage,l.extra_payment FROM eticket e RIGHT JOIN luggage l ON l.eticket_id=e.id LEFT JOIN pilgrims p USING(pilgrim_id) WHERE l.id='".$key['id']."'");			
			$row_info = $db->fetch($run_info);
		//	print_r($row_info);
			$data[$i][0] = $sno;			
			$data[$i][1] = $row_info['full_name']; 
			$data[$i][2] = $row_info['passport_no'];
			$data[$i][3] = $row_info['eno'];
			$data[$i][4] = getusername($row_info['createdby']);
			$data[$i][5] = getstatename($row_info['state']);
			$data[$i][6] = array_sum(explode('@',$key['luggage']));
			$diff = $data[$i][6] - $carrier_allowed_weight;
			if($diff>0)
			{
				$data[$i][7] = $diff;	
				$total_extra_luggage +=$diff;
			}else{
				$data[$i][7] = 0;				
			}
			$data[$i][8] = count(explode('@',$key['luggage']));
			$total_pieces += $data[$i][8];
			$data[$i][9] = $key['extra_payment'];
			$total_luggage += $data[$i][6];
			$total_payment += $key['extra_payment'];
$sno++;
$i++;
}
$_SESSION['columncount'] =10;
$_SESSION['totaltitle'] =3;
$_SESSION['columnwidth'] =  array(8,35,22,25,24,24,11,11,10,19);
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(255,0,0);
$pdf->SetFont('Arial','B',8);

$pdf->Cell(80,6,'*T = Total Kg','0',0,'L');
$pdf->Ln();
$pdf->Cell(80,6,'*E = Extra Kg','0',0,'L');
$pdf->Ln();
$pdf->Cell(80,6,'*P = Total No Of Pieces','0',0,'L');
$pdf->Ln();
$pdf->Cell(80,6,'*TP = Total Payment','0',0,'L');
$pdf->Ln();
$header = array('SNo.', 'Passenger Name', 'Passport No', 'Eticket No','Created By','Agency', 'T', 'E','P','TP');
$pdf->FancyTable($header,$data);
$pdf->Ln();
$pdf->Cell(114,6,'','LR',0,'L',false);
$pdf->Cell(24,6,'TOTAL','LR',0,'R',false);
$pdf->Cell(11,6,$total_luggage.'','LR',0,'R',false);
$pdf->Cell(11,6,$total_extra_luggage. '','LR',0,'R',false);
$pdf->Cell(10,6,$total_pieces.'','LR',0,'R',false);
$pdf->Cell(19,6,$total_payment,'LR',0,'R',false);

//$totalnop = $total_payment + $total_luggage;
$pdf->Ln();
$pdf->Cell(189,0,'','T');
$pdf->Ln();
//$pdf->Cell(189,6,'Total No of Pilgrim: '.$totalnop,'LR',0,'L',false);
$pdf->Ln();
$pdf->Cell(189,0,'','T');
$pdf->Output();
}else
{
	echo 'No passenger data';	
}


?>