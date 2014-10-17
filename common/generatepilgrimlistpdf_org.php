<?php
ini_set('max_execution_time', 500);
include("../common/functions.php");
include('../html2pdf/html2pdf.class.php');
//$id = $_REQUEST['id'];
$db= new Database();
//$agency_id = $_REQUEST['agency_id'];	
$str='';

					$checkdate1 = strtotime(date('Y-m-d'));
					$checkdate2 = strtotime('2014-02-17');
					if(($checkdate1-$checkdate2)>0){ 
						exit();
					}
$s = $_REQUEST['s']-1;					
$l = 160;
$run_disp = $db->query("SELECT * FROM pilgrims WHERE state='".$_SESSION['agency_id']."' ORDER BY  registration_date DESC,full_name, pilgrim_status LIMIT $s,$l");
$check =0;
$show_disp= array();
while($row_disp = $db->fetch($run_disp))
{
	$check++;
	$show_disp[] = $row_disp;
}
$nor=16;
$total =  count($show_disp);
$content ='';
$header ='';

$totalnoofpages = ceil($_REQUEST['totalrecord']/$nor);
$startpageno = (($_REQUEST['bno']-1)*10)+1;

//$pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15', array(mL, mT, mR, mB)); 
$html2pdf = new HTML2PDF('P','A4','en',false, 'ISO-8859-15', array(8,8, 8, 10)); 
 
$image_th = BASEURL.'image_content/pilgrim/pilgrim_images_th/';

 
 
	$header .="<page_header>";
	$header .='<table width="100%" border="0" align="center">';
	$header .='<tr>
	  				<td align="center" style="font-size:20px;"><b>PILGRIM LIST</b></td>
			  </tr>';
	$header .='<tr>
	  				<td align="center" style="font-size:20px;">Agency: '.getstatename($_SESSION['agency_id']).'&nbsp;</td>
			  </tr>';
	$header .='</table>';
	$header .="</page_header>";
//$currentpage =1;
$currentpage = $startpageno;
$male=0;
$female =0;
$i=0;
//$nop = ceil($total/$nor);
$nop = $totalnoofpages;
foreach($show_disp as $val=>$key ) {
	if(($i%$nor)==0){
		$flag =0;
		$content .= '<page backtop="20mm">';			
		$content .= $header;
		$content .='<table border="0">';
		$content .='<thead>
					<tr style="color:#FFF;background-color:red;">
						<th height="24">Sno</th>
						<th>Picture</th>
						<th>Name</th>
						<th>Passport No</th>
						<th>Nationality</th>
						<th>Gender</th>
						<th>Status</th>
						<th>Registered On</th>
					</tr>
					</thead>';		
	}
		
		
		if($key['sex']=='Male')
			{
				$male++;
				if($key['image']==''){
					$logo = '../images/male.png';	
				}else{
					$logo = $image_th.$key['pilgrim_id'].'.'.$key['image']; 				
				}				
			}
			
			if($key['sex']=='Female')
			{
				$female++;
				if($key['image']==''){
					$logo = '../images/female.png';	
				}else{
					$logo = $image_th.$key['pilgrim_id'].'.'.$key['image']; 				
				}								
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
					<td><img src="'.$logo.'" width="50" height="50" /></td>
					<td  width="260">'.$key['full_name'].'</td>
					<td width="80">'.$key['passport_no'].'</td>
					<td width="80">'.$key['nationality'].'</td>
					<td width="50">'.$key['sex'].'</td>
					<td width="50">'.$key['pilgrim_status'].'</td>
					<td width="100">'.$key['registration_date'].'</td>
				</tr>';
				$css1 ='';
				 }
$i++;
	if(($i%$nor)==0){
	$content .='<tr style="color:#FFF;background-color:red;">
					<td colspan="3"> MALE:'.$male.'</td>
					<td colspan="5"> FEMALE:'.$female.'</td>
				</tr>';
		$flag =1;		
//		$currentpage = ceil($i/$nor);		
		$content .= '</table>';
		$content .= '<p align="center">Page '.$currentpage.'/ '.$nop.' Copyright @2013 malanalairservices.com</p>';
		$content .="</page>";
		$male=0;
		$female=0;
		$currentpage++;

	}
	
}	
	if($flag==0){	

	$content .='<tr style="color:#FFF;background-color:red;">
					<td colspan="3"> MALE:'.$male.'</td>
					<td colspan="5"> FEMALE:'.$female.'</td>
				</tr>';
	$content .='</table>';
	$content .= '<p align="center">Page '.$currentpage.'/ '.$nop.' Copyright @2013 malanalairservices.com</p>';
	$content .="</page>";
	}
/*echo '<pre>';
echo $content;
echo '</pre>';
*/$html2pdf->WriteHTML($content);	
$html2pdf->Output('manalairservice.pdf');

?>