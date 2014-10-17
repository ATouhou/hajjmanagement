<?php 
include("../common/functions.php");
include('../html2pdf/html2pdf.class.php');
$path = BASEURL.'image_content/carriers/carriers_images_th/';
$db = new Database();
$current_val = 0;
$start = 0;
$nor = 20;
$limit = $nor;
$id = base64_decode( $_GET[ 'id' ] );
if ( isset( $_GET[ 'val' ] ) ) {
    $current_val = $_GET[ 'val' ];
    $start = ($nor * $current_val);
    $limit = ($current_val + 1) * $nor;
}
$run_disp = $db->query( "SELECT SQL_CALC_FOUND_ROWS * FROM agency_seat_allocation LEFT JOIN eticket ON agency_seat_allocation.allocation_id = eticket.allocation_id LEFT JOIN flights USING(flight_id) WHERE agency_seat_allocation.flight_id='" . $id . "' AND agency_seat_allocation.agency_id='" . $_SESSION[ 'agency_id' ] . "' ORDER BY eticket.createdon DESC LIMIT $start, $nor" );
$num_disp = $db->total();
$run_total = $db->query( "SELECT FOUND_ROWS() num;" );
$row_total = $db->fetch( $run_total );
$total_val = $row_total[ 'num' ];
$nop = ceil( $total_val / $nor );
if ( isset( $_GET[ 'val' ] ) ) {
    $current_val = $_GET[ 'val' ];
    $start = ($nor * $current_val);
    $limit = ($current_val + 1) * $nor;
}
$show_disp = array();
while ( $row_disp = $db->fetch( $run_disp ) ) {
    $show_disp[] = $row_disp;
}

if(count($show_disp)==0)
{
	exit();	
}
$content ='';
$html2pdf = new HTML2PDF('P','A4','fr');
foreach($show_disp as $val=>$key ) {
	
    $run = $db->query( "SELECT * FROM agency_seat_allocation LEFT JOIN eticket USING (allocation_id) WHERE eno='" . $key[ 'eno' ] . "' ORDER BY eticket.flight_order" );
    $rec = $db->total();
    $data1 = $db->fetch( $run );

    $pilgrim_info = $db->query( "SELECT * FROM pilgrims WHERE pilgrim_id='" . $data1[ 'pilgrim_id' ] . "'" );
    $pdata = $db->fetch( $pilgrim_info );


    $flight_info = $db->query( "SELECT * FROM flights LEFT JOIN carriers ON flights.agency_id=carriers.carriers_id WHERE flight_id='" . $data1[ 'flight_id' ] . "'" );
    $fdata1 = $db->fetch( $flight_info );
    if ( $rec == 2 ) {
        // MEANS RETURN TICKET IS THERE
        $data2 = $db->fetch( $run );
        $flight_info = $db->query( "SELECT * FROM flights LEFT JOIN carriers ON flights.agency_id=carriers.carriers_id WHERE flight_id='" . $data2[ 'flight_id' ] . "'" );
        $fdata2 = $db->fetch( $flight_info );
    }		
/*
	if($data[0]['ticket_id']=='')
	{
		$data[0]['ticket_id'] ='NA';	
	} */
	if($fdata1[ 'carriers_logo' ]=='')
	{
		$logo ='';	
	}else{
		
		$logo = '<img src="'.$path . $fdata1[ 'carriers_id' ] . '.' . $fdata1[ 'carriers_logo' ].'" width="60" height="60"/>';
	}
    $content .= '<page backtop="7mm" backbottom="7mm">';		
	$content .='<table width="600" border="0" >';
	$content .='<tr>
					<td width="80" rowspan="4">'.$logo.'</td>
	  				<td width="120">&nbsp;</td>
					<td width="80">&nbsp;</td>
					<td width="140">&nbsp;</td>
					<td width="20">&nbsp;</td>
			  </tr>';
	$content .='<tr>
				  <td colspan="3" align="center"><strong><span style="color:#CC6600;">ELECTRONIC TICKET</span></strong></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3" align="center"><strong><span style="color:#CC6600;">PASSENGER ITINERARY RECEIPT</span></strong></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>';
	$content .='<tr>
					<td colspan="3"><strong><span style="color:#009966">CARRIER NAME</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>'.$fdata1['carriers_name'].'</td>
					<td><strong><span style="color:#009966">CARRIER IATA CODE:</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>'.$fdata1['iata_code'].'</td>
					<td>&nbsp;</td>
				</tr>';
	$content .='<tr>
					<td colspan="3"><strong><span style="color:#009966">CARRIER ADDRESS</span>&nbsp;&nbsp;&nbsp;&nbsp; </strong><br />
					&nbsp;'.$fdata1['carriers_address'].'</td>';
	$content .='	<td><strong><span style="color:#009966">PHONE NO.</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>+234 - '.$fdata1['carriers_phoneno'].'</td>
					<td>&nbsp;</td>
				</tr>';	
	$content .='<tr>   
					<td><b>Agency Name:&nbsp;&nbsp;&nbsp;&nbsp;</b>'.getstatename($data1['agency_id']).'</td>
					<td>&nbsp;</td>
					<td colspan="2"><strong>Email:&nbsp;&nbsp;</strong>'.$fdata1['email'].'</td>
					<td>&nbsp;</td>
				</tr>';
	$content .='<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td rowspan="3"><barcode value="'.$data1['eno'].'" ></barcode></td>
					<td>&nbsp;</td>
				 </tr>';
	$content .='<tr>
					<td colspan="3"><strong>Passenger E-ticket No.</strong>'.$data1['eno'].'</td>
					<td>&nbsp;</td>
				</tr>';		
				
	$content .='<tr>
					<td><strong>Date of Issue:</strong>'.$data1['createdon'].'</td>
					<td colspan="2"><strong>Validity :</strong>&nbsp;'.$fdata1['validity'].'</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2"><strong>Passenger Information</strong></td>
					<td>&nbsp;</td>
					<td><strong>Passenger Status:</strong>Adult</td>   
					<td>&nbsp;</td>
				</tr>';

	if($pdata['sex']=="Male"){ $title="Mr.";}else{ $title ="Mrs."; }			
				
	$content .='<tr>
					<td height="20"><strong>Full Name Title : </strong></td>    
					<td colspan="2">'.$title.'  '.$pdata['full_name'].'</td>
					<td rowspan="2"><barcode value="'.$pdata['passport_no'].'" ></barcode></td>
					<td>&nbsp;</td>
				</tr>';
	$content.='<tr>
					<td><strong>Passport</strong>: '.$pdata['passport_no'].'</td>
					<td colspan="2"><strong>Nationality</strong>: '.$pdata['nationality'].'</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td style="background-color:#333;"><span style="color:#FFF"><strong>DEPARTURE DATE:&nbsp;</strong>'.$fdata1['date2'].'</span></td>
					<td colspan="2"><strong>FLIGHT NO:</strong> &nbsp;'.$fdata1['flight_no'].'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2"><strong><span style="color:#009966">FROM</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>'.getflightlocationname($fdata1['source']).'</td>
					<td><strong><span style="color:#009966">TO</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>'.getflightlocationname($fdata1['destination']).'</td>
					<td>&nbsp;</td>
				</tr>';		
	$content .='<tr>
					<td><strong>Departing At :</strong>'.$fdata1['time1'].'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>Arriving At </strong> &nbsp;'.$fdata1['time2'].'</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><strong>Terminal</strong> &nbsp; '.getterminalname($fdata1['dterminal']).'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>Terminal</strong> &nbsp; '.getterminalname($fdata1['aterminal']).'</td>
					<td>&nbsp;</td>
				</tr>	 
				<tr>
					<td><strong>Class :</strong> &nbsp;'.$data1['class'].'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>BAG :</strong> '.$fdata1['weight'].' KG </td>
					<td>&nbsp;</td>
				</tr>	
				<tr>
					<td><strong><span style="color:#009966">BOOKING STATUS:</span>&nbsp;&nbsp;&nbsp;<span class="small">&nbsp;'.$data1['bstatus'].'</span></strong></td>
					<td colspan="2">&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>';		
	if($rec ==2){
		
	$content .='<tr>
					<td style="background-color:#333;"><span style="color:#FFF"><strong>DEPARTURE DATE:&nbsp;</strong>'.$fdata2['date2'].'</span></td>
					<td colspan="2"><strong>FLIGHT NO:</strong>&nbsp;'.$fdata2['flight_no'].' </td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2"><strong><span style="color:#009966">FROM</span>&nbsp;&nbsp;&nbsp;&nbsp; </strong>'.getflightlocationname($fdata2['source']).'</td>
					<td><strong><span style="color:#009966">TO</span>&nbsp;&nbsp;&nbsp;</strong>'.getflightlocationname($fdata2['destination']).'</td>
					<td>&nbsp;</td>
				</tr>	
				<tr>
					<td><strong>Departing At :</strong>'.$fdata2['time1'].'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>Arriving At </strong> '.$fdata2['time2'].'</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><strong>Terminal</strong> &nbsp;'.getterminalname($fdata2['dterminal']).'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>Terminal</strong> &nbsp; '.getterminalname($fdata2['aterminal']).'</td>
					<td>&nbsp;</td>
				</tr>	 
				<tr>
					<td><strong>Class :</strong> &nbsp;'.$data2['class'].'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>BAG :</strong>'.$fdata2['weight'].' KG </td>
					<td>&nbsp;</td>
				</tr>';		
				}

	$content .='<tr><td height="35">';
					if($rec==2){ 
    $content .='<strong><span style="color:#009966">BOOKING STATUS:</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>'.$data2['bstatus'];
					}
	$content .='</td>
					<td colspan="2"><strong>AIR FARE&nbsp;&nbsp;&nbsp;&nbsp;</strong>'.$fdata1['price'].'</td>
					<td><strong>MODE OF PAYMENT&nbsp;&nbsp;&nbsp;&nbsp; </strong>'.$data1['mop'].'</td>
					<td>&nbsp;</td>
				</tr>';			
	$content .='<tr>
					<td colspan="4" align="justify"><span class="small">&nbsp;AT CHECK-IN, PLEASE SHOW A PICTURE IDENTIFICATION AND THE DOCUMENT YOU GAVE FOR REFERENCE AT THE RESERVATION TIME. NOTE:RETURN DATE IS SUBJECT TO CONFIRMATION AND AVAILABILITY OF SCREENING BAY. </span></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="4"><span class="small">ENDORESEMENT: <strong>NONE ENDORESABLE</strong></span> </td>
					<td>&nbsp;</td>
				</tr>';

	$content .='<tr>
					<td colspan="4"><hr /></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="4" align="center"><strong><span style="font-size:8px; font-family: arial;color:#FF0000;" >CONDITIONS OF CARRIAGE</span></strong></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
				  <td colspan="4">'.$fdata1['terms_conditions'].'</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="4" align="right"><span style="font-size:10px;"><strong>Detailed Conditions of Carriage are available from our offices upon request</strong></span></td>
					<td>&nbsp;</td>
				</tr>
';
	$content .='</table>';
	$content .="</page>";
unset($data);	 unset($flightdatedetailscopy); unset($flightdatedetails); unset($flightnodetails); unset($flightnodetailscopy);	
}
$html2pdf->WriteHTML($content);	
$html2pdf->Output('manalairservice.pdf');

?>
