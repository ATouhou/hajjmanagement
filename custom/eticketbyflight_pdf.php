<?php 
include("../common/functions.php");
include('../html2pdf/html2pdf.class.php');
$path = BASEURL.'image_content/carriers/carriers_images_th/';
$db = new Database();
$current_val=0;
$start =0;
$nor = 20;
$limit = $nor;
$flight_no = base64_decode($_REQUEST['id']);

if(isset($_GET['val']))
{
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}
$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT(passport_no) FROM custom_eticket WHERE createdby='".$_SESSION['uid']."' AND flight_no='".$flight_no."' ORDER BY id DESC LIMIT $start, $nor");
$num_disp = $db->total();
$run_total = $db->query("SELECT FOUND_ROWS() num;");
$row_total = $db->fetch($run_total);
$total_val = $row_total['num'];

$nop = ceil($total_val/$nor);
if(isset($_GET['val']))
{
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}

$show_disp = array();
while($row_disp = $db->fetch($run_disp))
{
	$show_disp[] = $row_disp;
}

if(count($show_disp)==0)
{
	echo 'No E-ticket';
	exit();	
}


$content ='';
$html2pdf = new HTML2PDF('P','A4','fr');

//print_r($show_disp);
//exit();
foreach($show_disp as $val=>$key ) {
		$run_details = $db->query("SELECT * FROM custom_eticket LEFT JOIN flights USING(flight_no) LEFT JOIN carriers ON carriers.carriers_id=flights.agency_id WHERE passport_no='".$key['passport_no']."' AND flight_no='".base64_decode($_REQUEST['id'])."'");			
		$details = $db->fetch($run_details);	
		$way = $db->total();


?><?php		

	if($details['ticket_id']=='')
	{
		$details['ticket_id'] ='NA';	
	}
	if($details['carriers_logo']=='')
	{
		$logo ='';	
	}else{
		
		$logo = '<img src="'.$path.$details['carriers_id'].'.'.$details['carriers_logo'].'" width="60" height="60"/>';
	}
    $content .= '<page backtop="7mm" backbottom="7mm">';		
	$content .='<table width="580" border="0" >';
	$content .='<tr>
					<td width="200" rowspan="4">'.$logo.'</td>
	  				<td width="80">&nbsp;</td>
					<td width="135">&nbsp;</td>
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
					<td colspan="2"><strong><span style="color:#009966">CARRIER NAME</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>'.$details['carriers_name'].'</td>
					<td>&nbsp;</td>
					<td><strong><span style="color:#009966">CARRIER IATA CODE:</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>'.$details['iata_code'].'</td>
					<td>&nbsp;</td>
				</tr>';
	$content .='<tr>
					<td colspan="2"><strong><span style="color:#009966">CARRIER ADDRESS</span>&nbsp;&nbsp;&nbsp;&nbsp; </strong><br />
					&nbsp;'.$details['carriers_address'].'</td>
					<td>';
					$checkdate1 = strtotime(date('Y-m-d'));
					$checkdate2 = strtotime('2015-12-07');
					if(($checkdate1-$checkdate2)>0){ 
	$content .='<span style="color:#FF0000">Dummy E-Ticket</span>';
					}
	$content .='	</td>
					<td><strong><span style="color:#009966">PHONE NO.</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>+234 - '.$details['carriers_phoneno'].'</td>
					<td>&nbsp;</td>
				</tr>';	
	$content .='<tr>   
					<td><b>Agency Name:&nbsp;&nbsp;&nbsp;&nbsp;</b>'.$details['agency_code'].'</td>
					<td>&nbsp;</td>
					<td colspan="2"><strong>Email:&nbsp;&nbsp;</strong>'.$details['email'].'</td>
					<td>&nbsp;</td>
				</tr>';
	$content .='<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td rowspan="3"><barcode value="'.$details['ticket_id'].'" ></barcode></td>
					<td>&nbsp;</td>
				 </tr>';
	$content .='<tr>
					<td colspan="3"><strong>Passenger E-ticket No.</strong>'.$details['ticket_id'].'</td>
					<td>&nbsp;</td>
				</tr>';		
				
	$content .='<tr>
					<td><strong>Date of Issue:</strong>'.$details['issue_date'].'</td>
					<td colspan="2"><strong>Validity :</strong>&nbsp;'.$details['exp_date'].'</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2"><strong>Passenger Information</strong></td>
					<td>&nbsp;</td>
					<td><strong>Passenger Status:</strong>Adult</td>   
					<td>&nbsp;</td>
				</tr>';
				
	$content .='<tr>
					<td height="20"><strong>Full Name Title : </strong></td>    
					<td colspan="2">'.$details['title'].'.  '.$details['first_name'].' '.$details['last_name'].'</td>
					<td rowspan="2"><barcode value="'.$details['passport_no'].'" ></barcode></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><strong>Passport</strong>: '.$details['passport_no'].'</td>
					<td colspan="2"><strong>Nationality</strong>: '.$details['country'].'</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td style="background-color:#333;"><span style="color:#FFF"><strong>DEPARTURE DATE:&nbsp;</strong>'.$details['flight_date'].'</span></td>
					<td colspan="2"><strong>FLIGHT NO:</strong> &nbsp;'.$details['flight_no'].'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2"><strong><span style="color:#009966">FROM</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>'.getflightlocationname($details['source']).'</td>
					<td><strong><span style="color:#009966">TO</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>'.getflightlocationname($details['destination']).'</td>
					<td>&nbsp;</td>
				</tr>';		
	$content .='<tr>
					<td><strong>Departing At :</strong>'.$details['time1'].'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>Arriving At </strong> &nbsp;'.$details['time2'].'</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><strong>Terminal</strong> &nbsp; '.getterminalname($details['dterminal']).'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>Terminal</strong> &nbsp; '.getterminalname($details['aterminal']).'</td>
					<td>&nbsp;</td>
				</tr>	 
				<tr>
					<td><strong>Class :</strong> &nbsp;'.$details['class'].'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>BAG :</strong>30 KG </td>
					<td>&nbsp;</td>
				</tr>	
				<tr>
					<td><strong><span style="color:#009966">BOOKING STATUS:</span>&nbsp;&nbsp;&nbsp;<span class="small">&nbsp;</span></strong></td>
					<td colspan="2">&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>';		
			
	if($way ==2){
	$details1 = $db->fetch($run_details);	
		
		
	$content .='<tr>
					<td style="background-color:#333;"><span style="color:#FFF"><strong>DEPARTURE DATE:&nbsp;</strong>'.$details1['flight_date'].'</span></td>
					<td colspan="2"><strong>FLIGHT NO:</strong>&nbsp;'.$details1['flight_no'].' </td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2"><strong><span style="color:#009966">FROM</span>&nbsp;&nbsp;&nbsp;&nbsp; </strong>'.getflightlocationname($details1['source']).'</td>
					<td><strong><span style="color:#009966">TO</span>&nbsp;&nbsp;&nbsp;</strong>'.getflightlocationname($details1['destination']).'</td>
					<td>&nbsp;</td>
				</tr>	
				<tr>
					<td><strong>Departing At :</strong>'.$details1['time1'].'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>Arriving At </strong> '.$details1['time2'].'</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><strong>Terminal</strong> &nbsp;'.getterminalname($details1['dterminal']).'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>Terminal</strong> &nbsp; '.getterminalname($details1['aterminal']).'</td>
					<td>&nbsp;</td>
				</tr>	 
				<tr>
					<td><strong>Class :</strong> &nbsp;'.$details1['class'].'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>BAG :</strong>30 KG </td>
					<td>&nbsp;</td>
				</tr>';		
				}
				
				
	$content .='<tr><td height="35">';
					if($way==2){ 
    $content .='<strong><span style="color:#009966">BOOKING STATUS:</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>CONFIRM';
					}
	$content .='</td>
					<td colspan="2"><strong>AIR FARE&nbsp;&nbsp;&nbsp;&nbsp;</strong>CHARTER</td>
					<td><strong>MODE OF PAYMENT&nbsp;&nbsp;&nbsp;&nbsp; </strong>CONFIRM</td>
					<td>&nbsp;</td>
				</tr>';			
	$content .='<tr>
					<td colspan="4" align="justify"><span class="small">&nbsp;AT CHECK-IN, PLEASE SHOW A PICTURE IDENTIFICATION AND THE DOCUMENT YOU GAVE FOR REFERENCE AT THE RESERVATION TIME. NOTE:RETURN DATE IS SUBJECT TO CONFIRMATION AND AVAILABILITY OF SCREENING BAY. </span></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="4"><span class="small">ENDORESEMENT: <strong>NONE ENDORESABLE</strong></span> </td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="4"><hr /></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="4" align="center"><strong><span style="font-size:8px; font-family: arial;color:#FF0000;" >CONDITIONS OF CARRIAGE</span></strong></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="4">
					<p align="justify">
						<span style="font-size:8px;"><strong>GENERAL</strong></span><span style="font-size:9px;"><br />
				  <span style="font-size:9px; font-family: arial;">
				  
				  Except as provided in Articles 2.2, 2.4 and 2.5 our  conditions of carriage apply only on those flights, or flight segments, where  our name or Airline Designator Code of the airline operating this charter  flight on our behalf (i.e IY, E3, PGT JAV etc.) is indicated in the carrier box  of the Ticket for that flight or flight segment. The Terms and Conditions  contained within the Ticket, your itinerary or receipt or any ticket wallet  shall form part of these Conditions of Carriage.<br /></span>
				  
				  <span style="font-size:8px;"><strong>CHARE TER OPERATIONS</strong></span><br />
				  
				  If Carriage is performed pursuant to a charter agreement,  these Conditions of Carriage apply only to the extent they are incorporated by  reference or otherwise, in the charter agreement or the Ticket.<br />
				  
				  <span style="font-size:8px;"><strong>CARRIERS</strong></span><br />
				  
				  Our Charter Flights are operated by sufficiently Airline  Operators including but not limited to Yemen Airways, Eritrean Airlines, Pegasus  Airlines, Jordan Aviation among others.<br />
				  
				  <span style="font-size:8px;"><strong>OVERRIDING LAW</strong></span><br />
				
				  These conditions of Carriage are applicable unless they are  inconsistent with our Tariffs or applicable law in which event such Tariffs or  laws shall prevail. If any provision of these Conditions of Carriage is invalid  under any applicable law, the other provisions shall nevertheless remain valid.</span></p>      </td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="4" align="right"><span style="font-size:10px;"><strong>Detailed Conditions of Carriage are available from our offices upon request</strong></span></td>
					<td>&nbsp;</td>
				</tr>
';

	$content .='</table>';
				
//	$content .='<barcode type="C39E" value="gaurav porwal from lucknow" label="none"></barcode>';	
//	$content .="<barcode type=\"EAN13\" value='45' label=\"label\" style=\"width:30mm; height:6mm; color: #770000; font-size: 4mm\"></barcode>";	
	
	$content .="</page>";
			


unset($data);	 unset($flightdatedetailscopy); unset($flightdatedetails); unset($flightnodetails); unset($flightnodetailscopy);	
  
    


}
$html2pdf->WriteHTML($content);	
$html2pdf->Output('manalairservice.pdf');

?>
