<?php
include("../common/functions.php");
include('../html2pdf/html2pdf.class.php');
$db= new Database();
$flight_id = base64_decode($_REQUEST['flight_id']);

$run_flightinfo = $db->query("SELECT source, destination,date1, carriers_name FROM flights LEFT JOIN carriers ON carriers.carriers_id=flights.agency_id WHERE flights.flight_id=$flight_id");
$row_flightinfo = $db->fetch($run_flightinfo);
$flight_date = explode('-',$row_flightinfo['date1']);
$f_date = $flight_date[2].'-'.$flight_date[1].'-'.$flight_date[0];
$agency_id = base64_decode($_REQUEST['agency_id']);
$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM boardingpass  LEFT JOIN agency_seat_allocation USING(allocation_id) WHERE flight_id= $flight_id AND bconfirmation='Yes' and agency_id=$agency_id ORDER BY boardingpass.createdon DESC");
$num_disp = $db->total();
$run_total = $db->query("SELECT FOUND_ROWS() num;");
$row_total = $db->fetch($run_total);
$total_val = $row_total['num'];
$nop = ceil($total_val/NOR);
$show_disp = array();
while($row_disp = $db->fetch($run_disp))
{
	$show_disp[] = $row_disp;
}
if(count($show_disp)==0)
{
	$content ='<page>No Records Found</page>';
}else{

$content ='';
$header ='';
$html2pdf = new HTML2PDF('P','A4','en',false, 'ISO-8859-15', array(8,8, 8, 10)); 
		$content .= '<page backtop="8mm">';			
		$content .='
		<page_footer>
		<table class="page_footer" align="center">
			<tr>
				<td style="width: 100%; text-align: right">
					 Page [[page_cu]]/[[page_nb]]  Copyright@manalairservices.com
				</td>
			</tr>
		</table>
		</page_footer>
	<table border="0">
		<thead>
		<tr>
			<th colspan="2">Flight No: </th>
			<th colspan="4">'.getflightno($flight_id).'</th>
		</tr>
		<tr>
			<th colspan="2">Agency Name:</th>
			<th colspan="4">'.getstatename($agency_id).'</th>
		</tr>
		<tr>
			<th colspan="2">Carrier Name: </th>
			<th colspan="4">'.$row_flightinfo['carriers_name'].'</th>
		</tr>
		<tr>
			<th colspan="2">From:  '.getflightlocationname($row_flightinfo['source']).' </th>
			<th colspan="2">To: '.getflightlocationname($row_flightinfo['destination']).'</th>
			<th colspan="2">Date: '.$f_date.'</th>
		</tr>
		<tr>
			<th colspan="6">&nbsp;</th>
		</tr>
        <tr style="background-color:red;color:#FFF;">
          <th height="24">S.No</th>
          <th>Name</th>
          <th>Passport No</th>
          <th>State</th>
          <th>Nationality</th>
          <th>Boarding No</th>
       </tr>
        </thead>
		<tbody>';		
	$sno = ($current_val*$nor+1);  		foreach($show_disp as $val=>$key ) {
	$run_info = $db->query("SELECT * FROM pilgrims WHERE pilgrim_id='".$key['pilgrim_id']."' AND status='Active'");
	$row_info = $db->fetch($run_info);
	if(($sno%2)==0){
	 $css1 = 'style="background-color:#B0EAE9;color:#000;"';
	}else{
		$cssl='style="background-color:#fff;color:#000;"';
	}
    $content .='<tr '.$css1.'>
          <td width="30">'.$sno++.'</td>
          <td width="180">'.$row_info['full_name'].'</td>
          <td width="80">'.$row_info['passport_no'].'</td>
          <td width="200">'.getstatename($row_info['state']).'</td>
          <td width="80">'.$row_info['nationality'].'</td>
          <td width="100">'.$key['bno'].'</td>
       </tr>';
	$css1 ='';
	   
		}

	$content .='</tbody></table>';
	$content .="</page>";
	
}
$html2pdf->WriteHTML($content);	
$html2pdf->Output('manalairservice.pdf');

?>