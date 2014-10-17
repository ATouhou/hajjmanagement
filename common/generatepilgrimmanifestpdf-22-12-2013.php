<?php
include("../common/functions.php");
require('pdf_common.php');


$id = base64_decode($_REQUEST['id']);
$db= new Database();
$flight_carrier_run = $db->query("SELECT * FROM flights LEFT JOIN carriers ON agency_id=carriers_id WHERE flights.flight_id='".$id."'");
$flight_carrier_data = $db->fetch($flight_carrier_run);
$_SESSION['logo'] = '../image_content/carriers/carriers_images_th/'.$flight_carrier_data['agency_id'].'.'.$flight_carrier_data['carriers_logo'];
$_SESSION['headercontent0'] = 'Passenger Manifest';
$_SESSION['headercontent1'] = $flight_carrier_data['carriers_name'];
$_SESSION['headercontent2']= 'POINT OF EMBARKATION:'.getflightlocationname($flight_carrier_data['source']).'    POINT OF DISEMARKATION:'.getflightlocationname($flight_carrier_data['destination']);
$_SESSION['headercontent3'] = 'Flight No:'.$flight_carrier_data['flight_no'].'                                 Date:'.$flight_carrier_data['date1'].' Time:'.$flight_carrier_data['time1'];
$_SESSION['headercontent4'] = 'Owner of Operator '.$flight_carrier_data['carriers_name'].'      Marks of Nationality Registration';
$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS pilgrim_id,eno FROM agency_seat_allocation LEFT JOIN eticket ON agency_seat_allocation.allocation_id = eticket.allocation_id LEFT JOIN flights USING(flight_id) WHERE flight_id='".$id."' AND agency_seat_allocation.agency_id='".$_SESSION['agency_id']."' ORDER BY eticket.createdon DESC");
$check =0;
while($row_disp = $db->fetch($run_disp))
{
	$check++;
	$show_disp[] = $row_disp;
}

if($check>1)
{

$sno =1;
$i=0;
$male = 0;
$female =0;
foreach($show_disp as $val=>$key ) {
			$run_info = $db->query("SELECT * FROM pilgrims WHERE pilgrim_id='".$key['pilgrim_id']."' AND status='Active'");
			$row_info = $db->fetch($run_info);
			$data[$i][0] = $sno;
			$data[$i][1] = $row_info['full_name']; 
			$data[$i][2] =  $row_info['passport_no'];
			$data[$i][3] =$row_info['nationality'];
			$data[$i][4] = $row_info['sex'];
			$data[$i][5] = $row_info['pilgrim_status'];
			$data[$i][6] = $key['eno'];
			if($row_info['sex']=='Male')
			{
				$male++;
			}
			if($row_info['sex']=='Female')
			{
				$female++;
			}
			
$sno++;
$i++;
}
$_SESSION['columncount'] =7;
$_SESSION['totaltitle'] =5;
$_SESSION['columnwidth'] =  array(8,62,25,22, 20,26, 26);
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$header = array('SNo.', 'Passenger Name', 'Passport No','Nationality','Sex','Status','Ticket No');
$pdf->FancyTable($header,$data);
$pdf->Ln();
$pdf->Cell(95,6,'Male: '.$male,'LR',0,'L',false);
$pdf->Cell(94,6,'Female: '.$female,'LR',0,'L',false);
$totalnop = $male + $female;
$pdf->Ln();
$pdf->Cell(189,0,'','T');
$pdf->Ln();
$pdf->Cell(189,6,'Total No of Pilgrim: '.$totalnop,'LR',0,'L',false);
$pdf->Ln();
$pdf->Cell(189,0,'','T');
$pdf->Output();
}else
{
	echo 'No passenger data';	
}


?>