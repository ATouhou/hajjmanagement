<?php 
include("../common/functions.php");
include('../html2pdf/html2pdf.class.php');
$content ='';
  $html2pdf = new HTML2PDF('P','A4','fr');
  
for($i=0;$i<=5;$i++){
    $content .= "<page>";
	$content .='<barcode type="C39E" value="gaurav porwal from lucknow" label="none"></barcode>';	
//	$content .="<barcode type=\"EAN13\" value='45' label=\"label\" style=\"width:30mm; height:6mm; color: #770000; font-size: 4mm\"></barcode>";	
	
	$content .="</page>";
	
  
    
}	
$html2pdf->WriteHTML($content);	
$html2pdf->Output('exemple.pdf');
?>
