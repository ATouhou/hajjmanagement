<?php
ini_set('max_execution_time', 500);
include("../common/functions.php");
include('../html2pdf/html2pdf.class.php');

$id = base64_decode($_REQUEST['id']);
$db= new Database();
$flight_carrier_run = $db->query("SELECT * FROM flights LEFT JOIN carriers ON agency_id=carriers_id WHERE flights.flight_id='".$id."'");
$flight_carrier_data = $db->fetch($flight_carrier_run);
$_SESSION['headercontent1'] = getcarriername($_SESSION['agency_id']);
$_SESSION['headercontent2']= 'ACTUAL PASSENGERS ON BOARD';
$_SESSION['headercontent3'] = 'Flight No:'.$flight_carrier_data['flight_no'].' Date:'.$flight_carrier_data['date1'].' Time:'.$flight_carrier_data['time1'].' From:'.getflightlocationname($flight_carrier_data['source']).' To '.getflightlocationname($flight_carrier_data['destination']);

$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM agency_seat_allocation asa, boardingpass bp, flights f WHERE asa.flight_id='".$id."' AND f.flight_id='".$id."' AND asa.allocation_id=bp.allocation_id AND bp.bconfirmation='Yes' ORDER BY f.createdon DESC");
$check =0;
$show_disp= array();
$total_records = mysql_result($db->query("SELECT FOUND_ROWS()"),0,0);
$sno=0;
while($row_disp = $db->fetch($run_disp))
{
	$check++;
	$show_disp[] = $row_disp;
}

if($check>=1)
{

$nor=16;
$total =  count($show_disp);
$content ='';
$header ='';

$totalnoofpages = ceil($total_records/$nor);

$html2pdf = new HTML2PDF('L','A4','en',false, 'ISO-8859-15', array(8,8, 8, 10)); 
 
	$header .="<page_header>";
	$header .='<table width="100%" border="0" align="center">';
	$header .='<tr>
	  				<td align="center" style="font-size:20px;"><b>'.$_SESSION['headercontent1'].'</b></td>
			  </tr>';
	$header .='<tr>
	  				<td align="center" style="font-size:20px;">'.$_SESSION['headercontent2'].'&nbsp;</td>
			  </tr>';
	$header .='<tr>
	  				<td align="center" style="font-size:20px;">'.$_SESSION['headercontent3'].'&nbsp;</td>
			  </tr>';
	$header .='</table>';
	$header .="</page_header>";

$i=0;

foreach($show_disp as $val=>$key ) {
			$run_info = $db->query("SELECT * FROM pilgrims WHERE pilgrim_id='".$key['pilgrim_id']."' AND status='Active'");
			$row_info = $db->fetch($run_info);
	
	
	if(($i%$nor)==0){
		$flag =0;
		$content .= '<page backtop="20mm">';			
		$content .= $header;
		$content .='<table border="0">';
		$content .='
					<tr style="color:#FFF;background-color:red;">
						<th height="24">Sno</th>
						<th>Passenger Name</th>
						<th>Passport No</th>
						<th>Agency</th>
						<th>Nationality</th>
						<th>Ticket No</th>
						<th>Boarding No</th>
					</tr>';		
	}
			$css1='';
	if($i!= count($show_disp)){
		$sno = $s+$i+1;
	if(($sno%2)==0){
	 $css1 = 'style="background-color:#B0EAE9;color:#000;"';
	}else{
		$cssl='style="background-color:#fff;color:#000;"';
	}
	
	
	
	$content .='<tr '.$css1.'>
					<td width="30">'.$sno.'</td>
					<td  width="260">'.$row_info['full_name'].'</td>
					<td width="80">'.getstatename($row_info['state']).'</td>
					<td width="80">'.$key['nationality'].'</td>
					<td width="50">'. $row_info['passport_no'].'</td>
					<td width="50">'.$key['eno'].'</td>
					<td width="100">'.$key['bno'].'</td>
				</tr>';
				$css1 ='';
				 }
	if(($i%$nor)==0){
		$flag =1;		
		$currentpage = ceil($i/$nor);		
		$content .= '</table>';
		$content .= '<p align="center">Page '.$currentpage.'/ '.$nop.' Copyright @2013 malanalairservices.com</p>';
		$content .="</page>";
		$currentpage++;

	}
	
	
	

$i++;

}

	if($flag==0){	

	$content .='</table>';
	$content .= '<p align="center">Page '.$currentpage.'/ '.$nop.' Copyright @2013 malanalairservices.com</p>';
	$content .="</page>";
	}



//$content .="</page>";

$html2pdf->WriteHTML($content);	
$html2pdf->Output('manalairservice.pdf');


/*
$sno =1;
$i=0;
$nor=35;
$html2pdf = new HTML2PDF('L','A4','en',false, 'ISO-8859-15', array(8,8, 8, 10)); 
 
 
 
 
	$header .="<page_header>";
	$header .='<table width="680" border="1">';
	$header .='<tr>
					<td width="180" rowspan="5"><img src="'.$logo.'"></td>
	  				<td colspan="2" align="center"><b>PASSENGER MANIFEST</b></td>
			  </tr>';
	$header .='<tr>
	  				<td width="220">'.getcarriername($_SESSION['agency_id']).'&nbsp;</td>
					<td width="220">&nbsp;</td>
			  </tr>';
	$header .='<tr>
	  				<td width="220">POINT OF EMBARKATION:</td>
					<td width="220">POINT OF DISEMARKATION:</td>
			  </tr>';
	$header .='<tr>
	  				<td width="220">Owner of Operator </td>
					<td width="220">Marks of Nationality Registration</td>
			  </tr>';
	$header .='</table>';


	$header .="</page_header>";
$currentpage =1;

$i=0;
$nop = ceil($total/$nor);


foreach($show_disp as $val=>$key ) {
	
	if(($i%$nor)==0){
		$content .= '<page backtop="45mm">';			
		$content .= $header;
		$content .='<table border="0">';
		$content .='<thead>
					<tr style="color:#FFF;background-color:red;">
						<th height="24">Sno</th>
						<th>Passenger Name</th>
						<th>Passport No</th>
						<th>Agency</th>
						<th>Nationality</th>
						<th>Ticket No</th>
						<th>Boarding No</th>
					</tr>
					</thead>';		
	}
	
	
			$css1='';
	if($i!= count($show_disp)){
		$sno = $i+1;
	if(($sno%2)==0){
	 $css1 = 'style="background-color:#B0EAE9;color:#000;"';
	}else{
		$cssl='style="background-color:#fff;color:#000;"';
	}
				$run_info = $db->query("SELECT * FROM pilgrims WHERE pilgrim_id='".$key['pilgrim_id']."' AND status='Active'");
				$row_info = $db->fetch($run_info);

	$content .='<tr '.$css1.'>
					<td width="30">'.$sno.'</td>
					<td  width="260">'.$row_info['full_name'].'</td>
					<td width="80">'.$row_info['passport_no'].'</td>
					<td width="80">'.getstatename($row_info['state']).'</td>
					<td width="80">'.$row_info['nationality'].'</td>
					<td width="50">'.$key['eno'].'</td>
					<td width="100">'.$key['bno'].'</td>
				</tr>';
				$css1 ='';
				 }
$i++;
	
	
	if(($i%$nor)==0){
		$currentpage = ceil($i/$nor);		
		$content .= '</table>';
		$content .= '<p align="center">Page '.$currentpage.'/ '.$nop.' Copyright @2013 malanalairservices.com</p>';
		$content .="</page>";
		$male=0;
		$female=0;
	}
	
}	
	$content .='</table>';
	$content .= '<p align="center">Page '.$currentpage.'/ '.$nop.' Copyright @2013 malanalairservices.com</p>';
	$content .="</page>";
echo '<pre>';
echo $content;
echo '</pre>';
$html2pdf->WriteHTML($content);	
$html2pdf->Output('manalairservice.pdf');
*/

}else{
	echo 'No Records Found';
} 
?>