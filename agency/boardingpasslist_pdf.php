<?php 
include("../common/functions.php");
include('../html2pdf/html2pdf.class.php');
$db = new Database();
$current_val=0;
$start =0;
$nor = 20;
$limit = $nor;
$id = base64_decode($_REQUEST['id']);

if(isset($_GET['val']))
{
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}

$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM boardingpass LEFT JOIN agency_seat_allocation USING (allocation_id) WHERE agency_seat_allocation.flight_id= '".$id."' AND agency_seat_allocation.agency_id='".$_SESSION['agency_id']."' ORDER BY boardingpass.createdon DESC LIMIT $start, $nor");
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

foreach($show_disp as $val=>$key ) {
	
            $run = $db->query("SELECT full_name,bno,passport_no, seat_no, flight_id  FROM boardingpass LEFT JOIN pilgrims USING(pilgrim_id) LEFT JOIN agency_seat_allocation USING(allocation_id) WHERE bno='".$key['bno']."'");
            if($db->total()>0){	$bp1 = $db->fetch($run); $disp1=1; 
            $run = $db->query("SELECT source, destination,date1, date2,time1,time2,flight_no,gateno FROM flights WHERE flight_id='".$bp1['flight_id']."'");
            $flight1 = $db->fetch($run);
}
	
    $content .= '<page backtop="10mm" backleft="20mm" orientation="paysage" format="80x230" backbottom="0mm" >';		
	$content .='<table width="700" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td height="25" colspan="4" align="center">&nbsp;</td>
      <td colspan="2"><strong>NAME</strong>&nbsp;&nbsp;'.$bp1['full_name'].'</td>
    </tr>
    <tr>
      <td colspan="4" rowspan="2"><strong>NAME</strong>&nbsp;&nbsp;'.$bp1['full_name'].'</td>
    </tr>
    <tr>
      <td height="22" colspan="2" ><strong>FROM</strong>&nbsp;&nbsp;'.getflightlocationname($flight1['source']).'</td>
    </tr>
    <tr>
      <td colspan="3"><strong>FROM</strong>&nbsp;&nbsp;'.getflightlocationname($flight1['source']).'</td>
      <td width="227"><strong>TO</strong>&nbsp;&nbsp;'.getflightlocationname($flight1['destination']).'</td>
      <td colspan="2">
         <strong>TO</strong>&nbsp;&nbsp;'.getflightlocationname($flight1['destination']).'</td>
    </tr>
    <tr>
      <td colspan="3"><strong>TICKET NO</strong> &nbsp;&nbsp;'.$bp1['bno'].'</td>  
      <td><strong>PASSPORT NO.</strong>&nbsp;&nbsp;'.$bp1['passport_no'].'</td>
      <td colspan="2" ><strong>TICKET NO</strong>&nbsp;&nbsp;'.$bp1['bno'].'</td>
	  </tr>
    <tr>
      <td colspan="3"><strong>SEAT NO</strong>&nbsp;&nbsp;'.$bp1['seat_no'].'</td>
      <td><strong>TIME</strong>&nbsp;&nbsp;'.$flight1['time1'].'</td>
      <td colspan="2"><strong>PASSPORT NO</strong>&nbsp;&nbsp;'.$bp1['passport_no'].'</td>
      </tr>
    <tr>
      <td><strong>FLIGHT NO</strong>&nbsp;&nbsp;'.$flight1['flight_no'].'</td>
      <td colspan="2">&nbsp;</td>
      <td><strong>DATE</strong>&nbsp;&nbsp;'.changeDate($flight1['date1']).'</td>
      <td colspan="2"><strong>FLIGHT NO</strong>&nbsp;&nbsp;'.$flight1['flight_no'].'</td>
      </tr>
    <tr>
      <td width="164"><strong>GATE NO.</strong>&nbsp;&nbsp;'.$flight1['gateno'].'</td>
      <td colspan="2">&nbsp;</td>
      <td rowspan="2" align="left" valign="bottom"><barcode value="'.$bp1['bno'].'" ></barcode></td>
      <td colspan="2"><strong>DATE</strong>&nbsp;&nbsp;'.changeDate($flight1['date1']).'</td>
      </tr>
    <tr>
      <td colspan="3" style="font-size:14px;">Agnecy Name:'.getstatename($_SESSION['agency_id']).'</td>
      <td width="77"><strong>GATE NO.</strong>&nbsp;&nbsp;'.$flight1['gateno'].'</td>
      <td width="81"><strong>TIME</strong>&nbsp;&nbsp;'.$flight1['time1'].'</td>
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
$html2pdf->WriteHTML($content);	
$html2pdf->Output('manalairservice.pdf');

?>
