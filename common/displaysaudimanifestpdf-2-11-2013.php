<?php
include("../common/functions.php");
include('../html2pdf/html2pdf.class.php');
$db= new Database();
$flight_id = base64_decode($_REQUEST['flight_id']);
$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM boardingpass  LEFT JOIN agency_seat_allocation USING(allocation_id) WHERE flight_id= $flight_id AND bconfirmation='Yes' ORDER BY boardingpass.createdon DESC");
$num_disp = $db->total();
$run_total = $db->query("SELECT FOUND_ROWS() num;");
$row_total = $db->fetch($run_total);
$total_val = $row_total['num'];
$nop = ceil($total_val/NOR);
$show_disp = array();
while($row_disp = $db->fetch($run_disp))
{
	$show_disp[] = $row_disp;
	$carrier_id = $row_disp['carrier_id'];
}
if(count($show_disp)==0)
{
	$content ='<page>No Records Found</page>';
}else{

$content ='';
$header ='';

	$header .="<page_header>";
	$header .='	<table  width="100%" align="center">
    	<tr>
        	<td align="center" colspan="3" style="font-size:20px;"><b>NATIONAL HAJJ COMISSION OF NIGERIA(NAHCON)</b></td>
         </tr>
    	<tr>
        	<td align="center" colspan="3" style="font-size:20px;"><b>ROYALITY PAYMENT SLIP</b></td>
         </tr>
		<tr>
			<td align="left"><b>Carrier Name: </b>'.getcarriername($carrier_id).'</td>
			<td align="center"><b>Flight ID:</b> '.getflightno($flight_id).'</td>
			<td align="right"><b>Date:</b> '.getflightno($flight_id).'</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
    </table>';


	$header .="</page_header>";


$html2pdf = new HTML2PDF('P','A4','en',false, 'ISO-8859-15', array(8,8, 8, 10)); 
		$content .= '<page backtop="8mm">';			
		$content .= $header;
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
			<td colspan="8">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
        <tr style="background-color:red;color:#FFF;padding:4px;">
          <th style="padding:2px;" height="18">S.No</th>
          <th style="padding:2px;">Picture</th>
          <th style="padding:2px;">Name</th>
          <th style="padding:2px;">Passport No</th>
          <th style="padding:2px;">Agency</th>
          <th style="padding:2px;">L.Govt</th>
          <th style="padding:2px;">Gender</th>
          <th style="padding:2px;">Status</th>
       </tr>
        </thead>
		<tbody>';					
	$sno = 1;  	
	$css1='';;
	foreach($show_disp as $val=>$key ) {
	$run_info = $db->query("SELECT * FROM pilgrims WHERE pilgrim_id='".$key['pilgrim_id']."' AND status='Active'");
	$row_info = $db->fetch($run_info);
	
			if($row_info['image']==''){			
				if($row_info['sex']='Male'){
					$logo = '../images/male.png';	
				}else{
					$logo = '../images/female.png';				
				}
			}else{
				$image_th = BASEURL.'image_content/pilgrim/pilgrim_images_th/';
				$logo = $image_th.$row_info['pilgrim_id'].'.'.$row_info['image']; 
			}	
	
	if(($sno%2)==0){
	 $css1 = 'style="background-color:#999;color:#FFF;"';
	}else{
		$cssl='style="background-color:#fff;color:#000;"';
	}
	
	$content .='<tr '.$css1.'>
          <td style="padding:2px;" width="30">'.$sno++.'</td>
		  <td><img src="'.$logo.'" width="50" height="50" /></td>
          <td style="padding:2px;" width="200">'.$row_info['full_name'].'</td>
          <td style="padding:2px;" width="80">'.$row_info['passport_no'].'</td>
          <td  style="padding:2px;" width="120">'.getstatename($row_info['state']).'</td>
          <td style="padding:2px;" width="80">'.getlganame($row_info['lga']).'</td>
          <td style="padding:2px;" width="50">'.$row_info['sex'].'</td>
          <td style="padding:2px;" width="50">'.$row_info['pilgrim_status'].'</td>
       </tr>';
	   $css1 ='';
		}

	$content .='</tbody></table>';
	$content .="</page>";
	
}

//echo $content;
$html2pdf->WriteHTML($content);	
$html2pdf->Output('manalairservice.pdf');

?>