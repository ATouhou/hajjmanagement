<?php
include("../common/functions.php");
include('../html2pdf/html2pdf.class.php');
$id = base64_decode($_REQUEST['id']);
$db= new Database();
$flight_carrier_run = $db->query("SELECT * FROM flights LEFT JOIN carriers ON agency_id=carriers_id WHERE flights.flight_id='".$id."'");
$flight_carrier_data = $db->fetch($flight_carrier_run);
$logo = '../image_content/carriers/carriers_images_th/'.$flight_carrier_data['agency_id'].'.'.$flight_carrier_data['carriers_logo'];
$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS pilgrim_id,eno FROM agency_seat_allocation LEFT JOIN eticket ON agency_seat_allocation.allocation_id = eticket.allocation_id LEFT JOIN flights USING(flight_id) WHERE flight_id='".$id."' ORDER BY eticket.createdon DESC");
$check =0;
while($row_disp = $db->fetch($run_disp))
{
	$check++;
	$show_disp[] = $row_disp;
}
$nor=35;
$total =  count($show_disp);
$content ='';
$header ='';
//$pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15', array(mL, mT, mR, mB)); 
$html2pdf = new HTML2PDF('P','A4','en',false, 'ISO-8859-15', array(8,8, 8, 10)); 
 
 
 
 
	$header .="<page_header>";
	$header .='<table width="800" border="1">';
	$header .='<tr>
					<td width="200" rowspan="5"><img src="'.$logo.'"></td>
	  				<td colspan="2" align="center">PASSENGER MANIFEST</td>
			  </tr>';
	$header .='<tr>
	  				<td width="250">'.getcarriername($_SESSION['agency_id']).'&nbsp;</td>
					<td>&nbsp;</td>
			  </tr>';
	$header .='<tr>
	  				<td width="250">POINT OF EMBARKATION:'.getflightlocationname($flight_carrier_data['source']).'</td>
					<td>POINT OF DISEMARKATION:'.getflightlocationname($flight_carrier_data['destination']).'</td>
			  </tr>';
	$header .='<tr>
	  				<td width="250">Flight No:'.$flight_carrier_data['flight_no'].' </td>
					<td >Date:'.$flight_carrier_data['date1'].' Time:'.$flight_carrier_data['time1'].'</td>
			  </tr>';
	$header .='<tr>
	  				<td width="250">Owner of Operator '.getcarriername($_SESSION['agency_id']).'</td>
					<td>Marks of Nationality Registration</td>
			  </tr>';
	$header .='</table>';


	$header .="</page_header>";
	
//$content .= '<page backtop="45mm">';	
//$content .=	$header;
		$content .= '<page backtop="45mm">';			
		$content .= $header;
		$content .='<table border="1">';
		$content .='<thead>
					<tr style="color:#FFF;background-color:red;">
						<th width="30">Sno</th>
						<th width="260">Passenger Name</th>
						<th width="80">Passport No</th>
						<th width="80">Nationality</th>
						<th width="50">Sex</th>
						<th width="50">Status</th>
						<th width="100">Ticket No</th>
					</tr>
					</thead>';		

$male=0;
$female =0;
$i=1;
$nop = ceil($total/$nor);
foreach($show_disp as $val=>$key ) {
			$run_info = $db->query("SELECT * FROM pilgrims WHERE pilgrim_id='".$key['pilgrim_id']."' AND status='Active'");
			$row_info = $db->fetch($run_info);
	if(($i%$nor)==0){
		$content .= '<page backtop="45mm">';			
		$content .= $header;
		$content .='<table border="1">';
		$content .='<thead>
					<tr style="color:#FFF;background-color:red;">
						<th width="30">Sno</th>
						<th width="260">Passenger Name</th>
						<th width="80">Passport No</th>
						<th width="80">Nationality</th>
						<th width="50">Sex</th>
						<th width="50">Status</th>
						<th width="100">Ticket No</th>
					</tr>
					</thead>';		
	}
			if($row_info['sex']=='Male')
			{
				$male++;
			}
			
			if($row_info['sex']=='Female')
			{
				$female++;
			}			
	if($i!= count($show_disp)){
	$content .='<tr>
					<td>'.$i.'</td>
					<td>'.$row_info['full_name'].'</td>
					<td>'.$row_info['passport_no'].'</td>
					<td>'.$row_info['nationality'].'</td>
					<td>'.$row_info['sex'].'</td>
					<td>'.$row_info['pilgrim_status'].'</td>
					<td>'.$key['eno'].'</td>
				</tr>';
				 }
$i++;
	if(($i%$nor)==0){
	$content .='<tr style="color:#FFF;background-color:red;">
					<td colspan="3"> MALE:'.$male.'</td>
					<td colspan="4"> FEMALE:'.$female.'</td>
				</tr>';
		$currentpage = ceil($i/$nor);		
		$content .= '</table>';
		$content .= '<p align="center">Page '.$currentpage.'/ '.$nop.' Copyright @2013 malanalairservices.com</p>';
		$content .="</page>";
		$male=0;
		$female=0;
	}
	
}	
	$content .='<tr style="color:#FFF;background-color:red;">
					<td colspan="3"> MALE:'.$male.'</td>
					<td colspan="4"> FEMALE:'.$female.'</td>
				</tr>';
	$content .='</table>';
	$content .= '<p align="center">Page '.$currentpage.'/ '.$nop.' Copyright @2013 malanalairservices.com</p>';
	$content .="</page>";
/*echo '<pre>';
echo $content;
echo '</pre>';
*/$html2pdf->WriteHTML($content);	
$html2pdf->Output('manalairservice.pdf');

?>