<?php 
include("../common/functions.php");
include('../html2pdf/html2pdf.class.php');
$path = BASEURL.'image_content/carriers/carriers_images_th/';

$db = new Database();
$current_val=0;
$start =0;
$nor = 50;
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
	exit();	
}


$content ='';
$html2pdf = new HTML2PDF('P','','en');
//$html2pdf->setDefaultFont('dejavusansbi');
//print_r($show_disp);
//exit();
foreach($show_disp as $val=>$key ) {
	
	
			
		$run_details = $db->query("SELECT * FROM custom_eticket LEFT JOIN flights USING(flight_no) LEFT JOIN carriers ON carriers.carriers_id=flights.agency_id WHERE passport_no='".$key['passport_no']."' AND flight_no='".base64_decode($_REQUEST['id'])."'");
		$details = $db->fetch($run_details);	
		$way = $db->total();
		
	
?><?php		

    $content .= '<page backtop="10mm" backleft="20mm" orientation="paysage" format="80x230" backbottom="0mm" >';		
	$content .='<table width="700" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td height="25" colspan="4" align="center">&nbsp;</td>
      <td colspan="2"><strong>NAME</strong>&nbsp;&nbsp;'.$details['title'].' '.$details['first_name'].' <br /> '.$details['last_name'].'</td>
    </tr>
    <tr>
      <td colspan="4" rowspan="2"><strong>NAME</strong>&nbsp;&nbsp;'.$details['title'].' '.$details['first_name'].' '.$details['last_name'].'</td>
    </tr>
    <tr>
      <td height="22" colspan="2" ><strong>FROM</strong>&nbsp;&nbsp;'.getflightlocationname($details['source']).'</td>
    </tr>
    <tr>
      <td colspan="3" width="270"><strong>FROM</strong>&nbsp;&nbsp;
           '. getflightlocationname($details['source']).'   </td>
      <td width="270"><strong>TO</strong>&nbsp;&nbsp;
          '.getflightlocationname($details['destination']).'  </td>
      <td colspan="2">
         <strong>TO</strong>&nbsp;&nbsp; 
         '. getflightlocationname($details['destination']).'
      </td>
    </tr>
    <tr>
      <td colspan="3"><strong>TICKET NO</strong> &nbsp;&nbsp;'.$details['bp_ticketid'].'</td>  
      <td><strong>PASSPORT NO.</strong>&nbsp;&nbsp;'.$details['passport_no'].'</td>
      <td colspan="2" ><strong>TICKET NO</strong>&nbsp;&nbsp; '.$details['bp_ticketid'].'</td>
	  </tr>
    <tr>
      <td colspan="3"></td>
      <td><strong>TIME</strong>&nbsp;&nbsp;'. $details['time1'].'
      
      
      </td>
      <td colspan="2"><strong>PASSPORT NO</strong>&nbsp;&nbsp; '. $details['passport_no'].'</td>
      </tr>
    <tr>
      <td><strong>FLIGHT NO</strong>&nbsp;&nbsp;'.$details['flight_no'].'</td>
      <td colspan="2">&nbsp;</td>
      <td><strong>DATE</strong>&nbsp;&nbsp;'. changeDate($details['date1']).'</td>
      <td colspan="2"><strong>FLIGHT NO</strong>&nbsp;&nbsp;'.$details['flight_no'].'</td>
      </tr>
    <tr>
      <td width="164"><strong>GATE NO.</strong>&nbsp;&nbsp;'. $details['gateno'].' </td>
      <td colspan="2">&nbsp;</td>
      <td rowspan="2" align="left" valign="bottom"><barcode value="'.$details['ticket_id'].'" ></barcode></td>
      <td colspan="2"><strong>DATE</strong>&nbsp;&nbsp;'. changeDate($details['date1']).'</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td width="77" valign="center"><strong>GATE NO.</strong>&nbsp;&nbsp;'. $details['gateno'].'</td>
      <td width="81" valign="center" ><strong>TIME</strong>&nbsp;&nbsp;'.$details['time1'].'</td>
      </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>';		
	$content .="</page>";
	if($way ==2){
		$details1 = $db->fetch($run_details);	

	$content .='<page  backtop="10mm" backleft="20mm" orientation="paysage" format="80x230" backbottom="0mm" >';
				
//	$content .='<barcode type="C39E" value="gaurav porwal from lucknow" label="none"></barcode>';	
//	$content .="<barcode type=\"EAN13\" value='45' label=\"label\" style=\"width:30mm; height:6mm; color: #770000; font-size: 4mm\"></barcode>";	
	$content .='<table width="700" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td height="25" colspan="4" align="center">&nbsp;</td>
      <td colspan="2"><strong>NAME</strong>&nbsp;&nbsp;'.$details1['title'].' '.$details1['first_name'].' '.$details1['last_name'].'</td>
    </tr>
    <tr>
      <td colspan="4" rowspan="2"><strong>NAME</strong>&nbsp;&nbsp;'.$details1['title'].' '.$details1['first_name'].' <br /> '.$details1['last_name'].'</td>
    </tr>
    <tr>
      <td height="22" colspan="2" ><strong>FROM</strong>&nbsp;&nbsp;'.getflightlocationname($details1['source']).'</td>
    </tr>
    <tr>
      <td colspan="3" width="270"><strong>FROM</strong>&nbsp;&nbsp;
           '. getflightlocationname($details1['source']).'   </td>
      <td width="270"><strong>TO</strong>&nbsp;&nbsp;
          '.getflightlocationname($details1['destination']).'  </td>
      <td colspan="2">
         <strong>TO</strong>&nbsp;&nbsp; 
         '. getflightlocationname($details1['destination']).'
      </td>
    </tr>
    <tr>
      <td colspan="3"><strong>TICKET NO</strong> &nbsp;&nbsp;'.$details1['bp_ticketid'].'</td>  
      <td><strong>PASSPORT NO.</strong>&nbsp;&nbsp;'.$details1['passport_no'].'</td>
      <td colspan="2" ><strong>TICKET NO</strong>&nbsp;&nbsp; '.$details1['bp_ticketid'].'</td>
	  </tr>
    <tr>
      <td colspan="3"></td>
      <td><strong>TIME</strong>&nbsp;&nbsp;'. $details1['time1'].'
      
      
      </td>
      <td colspan="2"><strong>PASSPORT NO</strong>&nbsp;&nbsp; '. $details1['passport_no'].'</td>
      </tr>
    <tr>
      <td><strong>FLIGHT NO</strong>&nbsp;&nbsp;'.$details1['flight_no'].'</td>
      <td colspan="2">&nbsp;</td>
      <td><strong>DATE</strong>&nbsp;&nbsp;'. changeDate($details1['date1']).'</td>
      <td colspan="2"><strong>FLIGHT NO</strong>&nbsp;&nbsp;'.$details1['flight_no'].'</td>
      </tr>
    <tr>
      <td width="164"><strong>GATE NO.</strong>&nbsp;&nbsp;'. $details1['gateno'].' </td>
      <td colspan="2">&nbsp;</td>
      <td rowspan="2" align="left" valign="bottom"><barcode value="'.$details1['ticket_id'].'" ></barcode></td>
      <td colspan="2"><strong>DATE</strong>&nbsp;&nbsp;'. changeDate($details1['date1']).'</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td width="77" valign="center"><strong>GATE NO.</strong>&nbsp;&nbsp;'. $details1['gateno'].'</td>
      <td width="81" valign="center" ><strong>TIME</strong>&nbsp;&nbsp;'.$details1['time1'].'</td>
      </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>';
	$content .="</page>";
	
	}
			


unset($data);	 unset($flightdatedetailscopy); unset($flightdatedetails); unset($flightnodetails); unset($flightnodetailscopy);	
  
    


}
$html2pdf->WriteHTML($content);	
$html2pdf->Output('manalairservice.pdf');

?>
