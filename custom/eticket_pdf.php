<?php 
include("../common/functions.php");
include('../html2pdf/html2pdf.class.php');
$path = BASEURL.'image_content/carriers/carriers_images_th/';
$db = new Database();
$current_val=0;
$start =0;
$nor = 20;
$limit = $nor;

if(isset($_GET['val']))
{
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}
$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT(passport_no) FROM custom_eticket WHERE createdby='".$_SESSION['uid']."' ORDER BY id DESC LIMIT $start, $nor");
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
	exit();	
}


$content ='';
$html2pdf = new HTML2PDF('P','A4','fr');
//$html2pdf->setDefaultFont('dejavusansbi');
//print_r($show_disp);
//exit();
foreach($show_disp as $val=>$key ) {
	
	
			
		$run_flightdate = $db->query("SELECT * FROM custom_eticket WHERE passport_no='".$key['passport_no']."' ORDER BY flight_date ASC");
		while($row_flightdate = $db->fetch($run_flightdate))
		{
			$data[] = $row_flightdate;
			$date_man = explode('-',$row_flightdate['flight_date']);
			$date_month = $month_num[$date_man[1]];
			if(count($date_man[2])==2){			
				$date_year = '20'.$date_man[2];
			}else{
				$date_year = $date_man[2];
			}			
			$flightdatedetailscopy[] = $date_year.'-'.$date_month.'-'.$date_man[0];
			$flightnodetailscopy[] = $row_flightdate['flight_no'];
			
		}
		$way = $db->total();
		
		if($way==2)
		{

			if(strtotime($flightdatedetailscopy[0])>strtotime($flightdatedetailscopy[1]))
			{
				$flightdatedetails[0] = $flightdatedetailscopy[1];
				$flightdatedetails[1] = $flightdatedetailscopy[0];
				$flightnodetails[0] = $flightnodetailscopy[1];
				$flightnodetails[1] = $flightnodetailscopy[0];
//				echo 'first is greator';	
			}else
			{
				$flightdatedetails[0] = $flightdatedetailscopy[0];
				$flightdatedetails[1] = $flightdatedetailscopy[1];
				$flightnodetails[0] = $flightnodetailscopy[0];
				$flightnodetails[1] = $flightnodetailscopy[1];
//				echo 'second is greator';	
			}
			
//		print_r($flightdatedetails);
//		print_r($flightnodetails);
			
		}else{
				$flightdatedetails[0] = $flightdatedetailscopy[0];
				$flightnodetails[0] = $flightnodetailscopy[0];			
		}
		
		$run_flightinfo1 = $db->query("SELECT * FROM flights LEFT JOIN carriers ON carriers.carriers_id=flights.agency_id WHERE flight_no='".$flightnodetails[0]."' AND date1='".$flightdatedetails[0]."'");
		$get_flightinfo1 = $db->fetch($run_flightinfo1);		
?><?php		

	if($data[0]['ticket_id']=='')
	{
		$data[0]['ticket_id'] ='NA';	
	}
	if($get_flightinfo1['carriers_logo']=='')
	{
		$logo ='';	
	}else{
		
		$logo = '<img src="'.$path.$get_flightinfo1['carriers_id'].'.'.$get_flightinfo1['carriers_logo'].'" width="60" height="60"/>';
	}
    $content .= '<page backtop="7mm" backbottom="7mm">';		
	$content .='<table width="600" border="0" >';
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
					<td colspan="2"><strong><span style="color:#009966">CARRIER NAME</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>'.$get_flightinfo1['carriers_name'].'</td>
					<td>&nbsp;</td>
					<td><strong><span style="color:#009966">CARRIER IATA CODE:</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>'.$get_flightinfo1['iata_code'].'</td>
					<td>&nbsp;</td>
				</tr>';
	$content .='<tr>
					<td colspan="2"><strong><span style="color:#009966">CARRIER ADDRESS</span>&nbsp;&nbsp;&nbsp;&nbsp; </strong><br />
					&nbsp;'.$get_flightinfo1['carriers_address'].'</td>
					<td>';
					$checkdate1 = strtotime(date('Y-m-d'));
					$checkdate2 = strtotime('2015-12-07');
					if(($checkdate1-$checkdate2)>0){ 
	$content .='<span style="color:#FF0000">Dummy E-Ticket</span>';
					}
	$content .='	</td>
					<td><strong><span style="color:#009966">PHONE NO.</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>+234 - '.$get_flightinfo1['carriers_phoneno'].'</td>
					<td>&nbsp;</td>
				</tr>';	
	$content .='<tr>   
					<td><b>Agency Name:&nbsp;&nbsp;&nbsp;&nbsp;</b>'.$data[0]['agency_code'].'</td>
					<td>&nbsp;</td>
					<td colspan="2"><strong>Email:&nbsp;&nbsp;</strong>'.$get_flightinfo1['email'].'</td>
					<td>&nbsp;</td>
				</tr>';
	$content .='<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td rowspan="3"><barcode value="'.$data[0]['ticket_id'].'" ></barcode></td>
					<td>&nbsp;</td>
				 </tr>';
	$content .='<tr>
					<td colspan="3"><strong>Passenger E-ticket No.</strong>'.$data[0]['ticket_id'].'</td>
					<td>&nbsp;</td>
				</tr>';		
				
	$content .='<tr>
					<td><strong>Date of Issue:</strong>'.$data[0]['issue_date'].'</td>
					<td colspan="2"><strong>Validity :</strong>&nbsp;'.$data[0]['exp_date'].'</td>
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
					<td colspan="2">'.$data[0]['title'].'.  '.$data[0]['first_name'].' '.$data[0]['last_name'].'</td>
					<td rowspan="2"><barcode value="'.$data[0]['passport_no'].'" ></barcode></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><strong>Passport</strong>: '.$data[0]['passport_no'].'</td>
					<td colspan="2"><strong>Nationality</strong>: '.$data[0]['country'].'</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td style="background-color:#333;"><span style="color:#FFF"><strong>DEPARTURE DATE:&nbsp;</strong>'.$get_flightinfo1['date1'].'</span></td>
					<td colspan="2"><strong>FLIGHT NO:</strong> &nbsp;'.$get_flightinfo1['flight_no'].'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2"><strong><span style="color:#009966">FROM</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>'.getflightlocationname($get_flightinfo1['source']).'</td>
					<td><strong><span style="color:#009966">TO</span>&nbsp;&nbsp;&nbsp;&nbsp;</strong>'.getflightlocationname($get_flightinfo1['destination']).'</td>
					<td>&nbsp;</td>
				</tr>';		
	$content .='<tr>
					<td><strong>Departing At :</strong>'.$get_flightinfo1['time1'].'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>Arriving At </strong> &nbsp;'.$get_flightinfo1['time2'].'</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><strong>Terminal</strong> &nbsp; '.getterminalname($get_flightinfo1['dterminal']).'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>Terminal</strong> &nbsp; '.getterminalname($get_flightinfo1['aterminal']).'</td>
					<td>&nbsp;</td>
				</tr>	 
				<tr>
					<td><strong>Class :</strong> &nbsp;'.$data[0]['class'].'</td>
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
		$run_flightinfo2 = $db->query("SELECT * FROM flights LEFT JOIN carriers ON carriers.carriers_id=flights.agency_id WHERE flight_no='".$flightnodetails[1]."' AND date1='".$flightdatedetails[1]."'");
		$get_flightinfo2 = $db->fetch($run_flightinfo2);
		
	$content .='<tr>
					<td style="background-color:#333;"><span style="color:#FFF"><strong>DEPARTURE DATE:&nbsp;</strong>'.$get_flightinfo2['date1'].'</span></td>
					<td colspan="2"><strong>FLIGHT NO:</strong>&nbsp;'.$get_flightinfo2['flight_no'].' </td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2"><strong><span style="color:#009966">FROM</span>&nbsp;&nbsp;&nbsp;&nbsp; </strong>'.getflightlocationname($get_flightinfo2['source']).'</td>
					<td><strong><span style="color:#009966">TO</span>&nbsp;&nbsp;&nbsp;</strong>'.getflightlocationname($get_flightinfo2['destination']).'</td>
					<td>&nbsp;</td>
				</tr>	
				<tr>
					<td><strong>Departing At :</strong>'.$get_flightinfo2['time1'].'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>Arriving At </strong> '.$get_flightinfo2['time2'].'</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><strong>Terminal</strong> &nbsp;'.getterminalname($get_flightinfo2['dterminal']).'</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><strong>Terminal</strong> &nbsp; '.getterminalname($get_flightinfo2['aterminal']).'</td>
					<td>&nbsp;</td>
				</tr>	 
				<tr>
					<td><strong>Class :</strong> &nbsp;'.$data[1]['class'].'</td>
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
