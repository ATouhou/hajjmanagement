<?php
ini_set('max_execution_time', 500);
include("../common/functions.php");
include('../html2pdf/html2pdf.class.php');

$id = $_REQUEST['id'];
$db= new Database();
$flight_carrier_run = $db->query("SELECT * FROM flights LEFT JOIN carriers ON agency_id=carriers_id WHERE flights.flight_id='".$id."'");
$flight_carrier_data = $db->fetch($flight_carrier_run);
$carrier_allowed_weight = $flight_carrier_data['weight'];
$logo = '../image_content/carriers/carriers_images_th/'.$flight_carrier_data['agency_id'].'.'.$flight_carrier_data['carriers_logo'];
//$_SESSION['headercontent0'] = 'Luggage List';
$_SESSION['headercontent0'] = getcarriername($_SESSION['agency_id']);
$_SESSION['headercontent1'] = 'LUGGAGE DETAILS FOR';
//$_SESSION['headercontent2']= 'POINT OF EMBARKATION:'.getflightlocationname($flight_carrier_data['source']).'    POINT OF DISEMARKATION:'.getflightlocationname($flight_carrier_data['destination']);
$_SESSION['headercontent2'] = 'Flight No:'.$flight_carrier_data['flight_no'].' Date:'.$flight_carrier_data['date1'].' Time:'.$flight_carrier_data['time1'].'          FROM '.getflightlocationname($flight_carrier_data['source']).' TO:'.getflightlocationname($flight_carrier_data['destination']);
//$_SESSION['headercontent4'] = 'Owner of Operator '.getcarriername($_SESSION['agency_id']).'      Marks of Nationality Registration';
$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM luggage WHERE flight_id='".$id."' ORDER BY createdon DESC");
$total_records = mysql_result($db->query("SELECT FOUND_ROWS()"),0,0);

$check =0;
while($row_disp = $db->fetch($run_disp))
{
	$check++;
	$show_disp[] = $row_disp;
}

if($check>0)
{


$nor=16;
$total =  count($show_disp);
$content ='';
$header ='';

$totalnoofpages = ceil($total_records/$nor);
$nop = $totalnoofpages;
$html2pdf = new HTML2PDF('L','A4','en',false, 'ISO-8859-15', array(8,8, 8, 10)); 
 
	$header .="<page_header>";
	$header .='<table width="100%" border="0" align="center">';
	$header .='<tr>
					<td width="180" rowspan="3"><img src="'.$logo.'" height="80"></td>
	  				<td colspan="3" align="center"><b>'.getcarriername($_SESSION['agency_id']).'</b></td>
			  </tr>';
	$header .='<tr>
	  				<td colspan="3">LUGGAGE DETAILS FOR&nbsp;</td>
			  </tr>';
	$header .='<tr>
	  				<td colspan="3">Flight No:'.$flight_carrier_data['flight_no'].' Date:'.$flight_carrier_data['date1'].' Time:'.$flight_carrier_data['time1'].'          FROM '.getflightlocationname($flight_carrier_data['source']).' TO:'.getflightlocationname($flight_carrier_data['destination']).'&nbsp;</td>
			  </tr>';
	$header .='<tr>
					<td>*T = total Kg </td>
					<td>*E = Extra Kg </td>
					<td>*P = Total No Of Pieces </td>
					<td>*TP = Total Payment </td>
				</tr>';	
	$header .='</table>';
	$header .="</page_header>";


$i=0;
$total_luggage =0;
$total_extra_luggage =0;
$total_payment =0;
$total_pieces =0;
	
foreach($show_disp as $val=>$key ) {
			$run_info = $db->query("SELECT l.createdby,p.full_name,p.passport_no, e.eno,p.state,l.luggage,l.extra_payment FROM eticket e RIGHT JOIN luggage l ON l.eticket_id=e.id LEFT JOIN pilgrims p USING(pilgrim_id) WHERE l.id='".$key['id']."'");			
			$row_info = $db->fetch($run_info);
	
	
	if(($i%$nor)==0){
		$flag =0;
		$content .= '<page backtop="30mm">';			
		$content .= $header;
		$content .='<table border="0">';
		$content .='
					<tr style="color:#FFF;background-color:red;">
						<th height="24">Sno</th>
						<th>Passenger Name</th>
						<th>Passport No</th>
						<th>Eticket No</th>
						<th>Created By</th>
						<th>Agency</th>
						<th>T</th>
						<th>E</th>
						<th>P</th>
						<th>TP</th>
					</tr>';		
	}
			$css1='';
	if($i!= count($show_disp)){
		$sno = $i+1;
	if(($sno%2)==0){
	 $css1 = 'style="background-color:#B0EAE9;color:#000;"';
	}else{
		$cssl='style="background-color:#fff;color:#000;"';
	}
	
		$diff = array_sum(explode('@',$key['luggage'])) - $carrier_allowed_weight;
			if($diff>0)
			{
				$total_extra_luggage +=$diff;
			}else{
				$diff = 0;				
			}
			$total_pieces += count(explode('@',$key['luggage']));
			$total_luggage += array_sum(explode('@',$key['luggage']));
			$total_payment += $key['extra_payment'];
	
	
	$content .='<tr '.$css1.'>
					<td width="30">'.$sno.'</td>
					<td  width="260">'.$row_info['full_name'].'</td>
					<td width="100">'. $row_info['passport_no'].'</td>
					<td width="100">'.$row_info['eno'].'</td>
					<td width="120">'.getusername($row_info['createdby']).'</td>
					<td width="260">'.getstatename($row_info['state']).'</td>
					<td width="30">'.array_sum(explode('@',$key['luggage'])).'</td>
					<td width="30">'.$diff.'</td>
					<td width="20">'.count(explode('@',$key['luggage'])).'</td>
					<td width="60">'.$key['extra_payment'].'</td>
				</tr>';
				$css1 ='';
				 }
$i++;

$sno++;

	if(($i%$nor)==0){
		$flag =1;		
		$currentpage = ceil($i/$nor);
		$content .= '</table>';
		$content .='<table>
  <tr>
    <th scope="row">Total Kg</th>
    <td>'.$total_luggage.'</td>
  </tr>
  <tr>
    <th scope="row">Extra Kg</th>
    <td>'.$total_extra_luggage.'</td>
  </tr>
  <tr>
    <th scope="row">Total No of Pieces</th>
    <td>'.$total_pieces.'</td>
  </tr>
  <tr>
    <th scope="row">Total Payment</th>
    <td>'.$total_payment.'</td>
  </tr>
</table>';
		$content .= '<p align="center">Page '.$currentpage.'/ '.$nop.' Copyright @'.date('Y').' malanalairservices.com</p>';
		$content .="</page>";
		$currentpage++;
	}
}
	if($flag==0){	
		$currentpage = ceil($i/$nor);		
		$content .='</table>';
		$content .='<table>
  <tr>
  	<th colspan="2"> &nbsp;</th>
  </tr>	
  <tr>
  	<th colspan="2"> &nbsp;</th>
  </tr>	
  <tr>
    <th scope="row" width="200">Total Kg</th>
    <td>'.$total_luggage.'</td>
  </tr>
  <tr>
    <th scope="row">Extra Kg</th>
    <td>'.$total_extra_luggage.'</td>
  </tr>
  <tr>
    <th scope="row">Total No of Pieces</th>
    <td>'.$total_pieces.'</td>
  </tr>
  <tr>
    <th scope="row">Total Payment</th>
    <td>'.$total_payment.'</td>
  </tr>
</table>';
		$content .= '<p align="center">Page '.$currentpage.'/ '.$nop.' Copyright @'.date('Y').' malanalairservices.com</p>';
		$content .="</page>";
	}
$html2pdf->WriteHTML($content);	
$html2pdf->Output('manalairservice.pdf');


}else
{
	echo 'No passenger data';	
}


?>