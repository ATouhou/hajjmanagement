<?php
include("../common/functions.php");
include('../html2pdf/html2pdf.class.php');
//$id = $_REQUEST['id'];
$db= new Database();
//$agency_id = $_REQUEST['agency_id'];	
$str='';

					$checkdate1 = strtotime(date('Y-m-d'));
					$checkdate2 = strtotime('2016-02-17');
					if(($checkdate1-$checkdate2)>0){ 
						exit();
					}

$id = base64_decode($_REQUEST['id']);

$run_accomodationinfo = $db->query("SELECT * FROM accomodation WHERE agency_id='".$_SESSION['agency_id']."' AND id='".$id."'");
$row_accomodationinfo = $db->fetch($run_accomodationinfo);


$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM accomodation_manifest WHERE agency_id='".$_SESSION['agency_id']."' AND accomodation_id='".$id."' ORDER BY created_on DESC");

//$run_disp = $db->query("SELECT * FROM pilgrims WHERE state='".$_SESSION['agency_id']."' ORDER BY  registration_date DESC,full_name, pilgrim_status");
$check =0;
$show_disp= array();
while($row_disp = $db->fetch($run_disp))
{
	$check++;
	$show_disp[] = $row_disp;
}

if($check==0){
	echo 'No Records Found';
	exit();

}else{

$nor=17;
$total =  count($show_disp);
$content ='';
$header ='';
//$pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15', array(mL, mT, mR, mB)); 
$html2pdf = new HTML2PDF('P','A4','en',false, 'ISO-8859-15', array(8,8, 8, 10)); 
 
$image_th = BASEURL.'image_content/pilgrim/pilgrim_images_th/';

 
 
	$header .="<page_header>";
	$header .='<table width="100%" border="0" align="center">';
	$header .='<tr>
	  	   <th>Name</th>
          <th>Accomodation Duration</th>
          <th>Phone No</th>
          <th>Address</th>
          <th>Capacity</th>
	    </tr>
        <tbody>
		  <tr>
    		<td>'.$row_accomodationinfo['name'].'</td>
    		<td>'.$row_accomodationinfo['email_id'].'</td>
    		<td>'.$row_accomodationinfo['phone_no'].'</td>
    		<td>'.$row_accomodationinfo['address'].'</td>
    		<td>'.$row_accomodationinfo['capacity'].'</td>
		  </tr></tbody>';
	$header .='</table>';
	$header .="</page_header>";
$currentpage =1;
$i=0;
$nop = ceil($total/$nor);
foreach($show_disp as $val=>$key ) {
			$run_pilgrim = $db->query("SELECT * FROM pilgrims WHERE pilgrim_id='".$key['pilgrim_id']."' AND status='Active'");
			$row_pilgrim = $db->fetch($run_pilgrim);
	
	if(($i%$nor)==0){
		$flag =0;
		$content .= '<page backtop="20mm">';			
		$content .= $header;
		$content .='<table border="0">';
		$content .='<thead>
					<tr style="color:#FFF;background-color:red;">
						<th height="24">Sno</th>
						<th>Pilgrim Name</th>
						<th>Passport No</th>
						<th>LGA</th>
						<th>Room No</th>
						<th>Status</th>
						<th>Agency</th>
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

	
	$content .='<tr '.$css1.'>
					<td width="30">'.$sno.'</td>
					<td>'.$row_pilgrim['full_name'].'</td>
					<td width="80">'.$row_pilgrim['passport_no'].'</td>
					<td width="80">'.getlganame($row_pilgrim['lga']).'</td>
					<td width="50">'.$key['bed_no'].'</td>
					<td width="50">'.$row_pilgrim['sex'].'</td>
					<td width="100">'.getstatename($row_pilgrim['state']).'</td>
				</tr>';
				$css1 ='';
				 }
$i++;
	if(($i%$nor)==0){
		$flag =1;		
		$currentpage = ceil($i/$nor);		
		$content .= '</table>';
		$content .= '<p align="center">Page '.$currentpage.'/ '.$nop.' Copyright @2013 malanalairservices.com</p>';
		$content .="</page>";
	}
	
}	
	if($flag==0){	

	$content .='</table>';
	$content .= '<p align="center">Page '.$currentpage.'/ '.$nop.' Copyright @2013 malanalairservices.com</p>';
	$content .="</page>";
	}
/*echo '<pre>';
echo $content;
echo '</pre>';
*/$html2pdf->WriteHTML($content);	
$html2pdf->Output('manalairservice.pdf');
}

?>