<?php 
include("../common/functions.php");
include('../html2pdf/html2pdf.class.php');
$path = BASEURL.'image_content/carriers/carriers_images_th/';
$db = new Database();
$current_val=0;
$start =0;
$nor = 205;
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


$html2pdf = new HTML2PDF('P','A4','fr');

$css1='';

	
//print_r($show_disp);
//exit();
$content = '<page backtop="7mm" backbottom="7mm">';	
$content .='<table style="padding:2px; width="800">';
$start =0;
if(isset($_GET['val']))
{
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}
$male =0;
$female =0;
foreach($show_disp as $val=>$key ) {
				$run_details = $db->query("SELECT * FROM custom_eticket LEFT JOIN flights USING(flight_no) LEFT JOIN carriers ON carriers.carriers_id=flights.agency_id WHERE passport_no='".$key['passport_no']."' AND flight_no='".base64_decode($_REQUEST['id'])."'");			
		$details = $db->fetch($run_details);	
			

			if($details['gender']=='M')
			{
				$male++;
			}
			
			if($details['gender']=='F')
			{
				$female++;
			}	


        if(($start%35)==0){ ?>
<?php
		$content .='<tr>
	<td colspan="7" style="border:none; ">
    
<table width="680" border="1">
  <tr>
    <td width="180" rowspan="5"><img src="'.$path.$details['carriers_id'].'.'.$details['carriers_logo'].'" /></td>
    <td colspan="2" align="center"><b>PASSENGER MANIFEST</b></td>
    </tr>
  <tr>
    <td colspan="2"  align="center"><b>'.$details['carriers_name'].'</b></td>
    </tr>
  <tr>
    <td width="240">POINT OF EMBARKATION <b>'.getflightlocationname($details['source']).'</b></td>
    <td width="240">POINT OF DISEMBARKATION <b> '.getflightlocationname($details['destination']).'</b></td>
    </tr>
  <tr>
    <td>FLIGHT NO:<b> '.$details['flight_no'].'</b></td>
    <td>DATE :<b>'.$details['date1'].'</b> TIME: <b>'.$details['time1'].'</b></td>
    </tr>
  <tr>
    <td>Owner of Operator <b>'.$details['agency_code'].'</b></td>
    <td>Marks of Nationality Registration</td>
    </tr>
</table>
    
	</td>
</tr>  
<tr>
	<td colspan="7">&nbsp;</td>
</tr>
<tr style="background-color:red; color:#FFF;padding:4px;">
    <td height="17" width="30"><strong>S.No</strong></td>
    <td width="260"><strong>Passenger Name</strong></td>
    <td width="80"><strong>Passport No</strong></td>
    <td width="80"><strong>Nationality</strong></td>
    <td width="50"><strong>Sex </strong></td>
    <td width="50"><strong>Status</strong></td>
    <td width="100"><strong>TicketNo</strong></td>
  </tr>';
}

	if(($start%2)==0){
	 $css1 = 'style="background-color:#B0EAE9;color:#000;"';
	}else{
		$cssl='style="background-color:#fff;color:#000;"';
	}

  $content .='<tr  '.$css1.'>
    <td height="16">'.++$start.'&nbsp;</td>
    <td>'.$details['title'].'. '.$details['first_name'].' '.$details['last_name'].'</td>
    <td>'.$details['passport_no'].'</td>
    <td>'. $details['country'].'</td>
    <td>'.$details['gender'].'</td>
    <td>Adult</td>
    <td>'.$details['ticket_id'].'</td>
  </tr>';
  if(($start%35)==0){ 
  
	$content .='<tr style="color:#FFF;background-color:red;">
					<td colspan="3" height="16"> MALE:'.$male.'</td>
					<td colspan="4"> FEMALE:'.$female.'</td>
				</tr>';
  $male =0;
  $female=0;
  
  }
		$css1 ='';
}
	if(($start%35)!=0){
	$content .='<tr style="color:#FFF;background-color:red;">
					<td colspan="3" height="16"> MALE:'.$male.'</td>
					<td colspan="4"> FEMALE:'.$female.'</td>
				</tr>';
	}
	$content .='</table>';
				
	
	$content .="</page>";
			

//echo $content;
//unset($data);	 unset($flightdatedetailscopy); unset($flightdatedetails); unset($flightnodetails); unset($flightnodetailscopy);	
  
    



$html2pdf->WriteHTML($content);	
$html2pdf->Output('manalairservice.pdf');

?>
