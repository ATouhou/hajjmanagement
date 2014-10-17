<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_custom_flight.php');
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






?>

<!--************TO FETCH THE LGA VALUES***********-->
<script type="text/javascript">
function getlga(state_id)
{
	if(state_id=='')
	{
		document.getElementById('error_state').innerHTML='';		
	}else
	{
		
  	if (window.XMLHttpRequest)
  	{// code for IE7+, Firefox, Chrome, Opera, Safari
  	xmlhttp=new XMLHttpRequest();
  	}
  	else
  	{// code for IE6, IE5
  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
		xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
     {
		 document.getElementById("display_lga").innerHTML=xmlhttp.responseText;
	 }
  }
xmlhttp.open("GET","../ajax/getlga.php?value="+state_id,true);
xmlhttp.send();
	}
}


</script> 
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Flight Wise E-Ticket</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="../images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="../images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
	
	
		<!--  start step-holder -->
<!--		<div id="step-holder">
			<div class="step-no">1</div>
			<div class="step-dark-left"><a href="">Pilgrim details</a></div>
			<div class="step-dark-right">&nbsp;</div>
			<div class="step-no-off">2</div>
			<div class="step-light-left">Preview</div>
			<div class="step-light-round">&nbsp;</div>
			<div class="clear"></div>
		</div>
-->		<!--  end step-holder -->
	
		<!-- start id-form -->
        <?php notification(); ?>
           <input type="button" value="PRINT" onclick="printContent('print_area')"  />	 
<br />
<br />

<table width="850">
        <tr>
          <th width="200">
          <?php 
		  if(($current_val-1)>=0)
		  {
		 
          echo '<a href='.$_SERVER['PHP_SELF'].'?val='.($current_val-1).'&id='.$_REQUEST['id'].'  ><img src="../images/forms/prev.gif" /></a>';
         
		  }
		  ?>
          </th>
          <th  colspan="2" align="left" width="300">Total No of Records : <?php echo $total_val; ?>(<?php echo $current_val+1; ?>/<?php echo $nop; ?> )</th>
		  <th align="left"></th>
          <td><?php for($i=1;$i<=$nop; $i++){ echo '<a href='.$_SERVER['PHP_SELF'].'?val='.($i-1).'&id='.$_REQUEST['id'].'  >&nbsp;&nbsp;'.$i.'&nbsp;&nbsp;</a>'; }?></td>	
          <th width="200">
          <?php
          if($limit<$total_val)
		  {
	          echo '<a href='.$_SERVER['PHP_SELF'].'?val='.($current_val+1).'&id='.$_REQUEST['id'].'  ><img src="../images/forms/next.gif" /></a>';
		  }
          ?>
          </th>
        </tr> 
</table>
<br /><br /><br />


<?php

	$checkdate1 = strtotime(date('Y-m-d'));
	$checkdate2 = strtotime('2015-09-07');
	if(($checkdate1-$checkdate2)<0){ 
	  for($i=1; $i<=$nop; $i++){
		  $no = $i-1;
		  echo '<div style=" vertical-align:center;display:block;position:relative; float:left; width:80px; height:20px;  padding-top:8px; margin:2px; background-color:#333;text-align:center;">';
		  echo '<a style="text-decoration:none;color:#FFF;" target="_blank" href="boardingbyflight_pdf.php?val='.$no.'&id='.$_REQUEST['id'].'" >Print '.$i.'</a>';
		  echo '</div>';
	  }
 	} 
?>

<div style="clear:both"></div>
<br /><br />

<div id="print_area">
		<?php foreach($show_disp as $val=>$key ) {
			
		$run_details = $db->query("SELECT * FROM custom_eticket LEFT JOIN flights USING(flight_no) LEFT JOIN carriers ON carriers.carriers_id=flights.agency_id WHERE passport_no='".$key['passport_no']."' AND flight_no='".base64_decode($_REQUEST['id'])."'");			
		$details = $db->fetch($run_details);	
		$way = $db->total();
//			echo $key['passport_no'];
	// print_r($row_pilgrim);
			
			
			?>

<table width="700" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td height="25" colspan="4" align="center">&nbsp;</td>
      <td colspan="2"><strong>NAME</strong>&nbsp;&nbsp;<?php echo $details['title'].' '.$details['first_name'].' '.$details['last_name']; ?></td>
    </tr>
    <tr>
      <td colspan="4" rowspan="2"><p><strong>NAME</strong>&nbsp;&nbsp;<?php echo $details['title'].' '.$details['first_name'].' '.$details['last_name']; ?></td>
    </tr>
    <tr>
      <td height="22" colspan="2" ><strong>FROM</strong>&nbsp;&nbsp;<?php echo getflightlocationname($details['source']); // $loc_name = getlocationname($departure_loc);echo $loc_name; ?></td>
    </tr>
    <tr>
      <td colspan="3"><strong>FROM</strong>&nbsp;&nbsp;
           <?php echo getflightlocationname($details['source']); //$loc_name = getlocationname($departure_loc);echo $loc_name; ?>         </td>
      <td width="227"><strong>TO</strong>&nbsp;&nbsp;
          <?php  echo getflightlocationname($details['destination']);  // $loc_name = getlocationname($arriaval_loc);echo $loc_name; ?>      </td>
      <td colspan="2">
         <strong>TO</strong>&nbsp;&nbsp; 
         <?php echo getflightlocationname($details['destination']);  // $loc_name = getlocationname($arriaval_loc);echo $loc_name; ?>
      </td>
    </tr>
    <tr>
      <td colspan="3"><strong>TICKET NO</strong> &nbsp;&nbsp;<?php echo $details['bp_ticketid']; ?></td>  
      <td><strong>PASSPORT NO.</strong>&nbsp;&nbsp;<?php echo $details['passport_no']; ?></td>
      <td colspan="2" ><strong>TICKET NO</strong>&nbsp;&nbsp; <?php echo $details['bp_ticketid']; ?></td>
	  </tr>
    <tr>
      <td colspan="3"><!--<strong>SEAT NO</strong>&nbsp;&nbsp;<?php // echo $bp1['seat_no']; ?>--></td>
      <td><strong>TIME</strong>&nbsp;&nbsp;<?php echo $details['time1']; ?>
      
      
      </td>
      <td colspan="2"><strong>PASSPORT NO</strong>&nbsp;&nbsp; <?php echo $details['passport_no']; ?></td>
      </tr>
    <tr>
      <td><strong>FLIGHT NO</strong>&nbsp;&nbsp;<?php echo $details['flight_no']; ?></td>
      <td colspan="2">&nbsp;</td>
      <td><strong>DATE</strong>&nbsp;&nbsp;<?php echo $details['date1']; ?></td>
      <td colspan="2"><strong>FLIGHT NO</strong>&nbsp;&nbsp;<?php echo $details['flight_no']; ?></td>
      </tr>
    <tr>
      <td width="164"><strong>GATE NO.</strong>&nbsp;&nbsp;<?php echo $details['gateno']; // echo $gate_no; ?> </td>
      <td colspan="2">&nbsp;</td>
      <td rowspan="2" align="left" valign="bottom"><img src="<?php echo BASEURL."common/"; ?>barcode.php?barcode=<?php echo $details['bp_ticketid']; ?>&amp;height=50&amp;width=265" /></td>
      <td colspan="2"><strong>DATE</strong>&nbsp;&nbsp;<?php echo $details['date1']; ?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td width="77"><strong>GATE NO.</strong>&nbsp;&nbsp;<?php echo $details['gateno']; // echo $gate_no; ?> </td>
      <td width="81"><strong>TIME</strong>&nbsp;&nbsp;<?php echo $details['time1']; ?></td>
      </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>

<br /><br /><br /><br />
<?php if($way==2){ 
		$details1 = $db->fetch($run_details);	

?>
<table width="700" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td height="25" colspan="4" align="center">&nbsp;</td>
      <td colspan="2"><strong>NAME</strong>&nbsp;&nbsp;<?php echo $details1['title'].' '.$details1['first_name'].' '.$details1['last_name']; ?></td>
    </tr>
    <tr>
      <td colspan="4" rowspan="2"><p><strong>NAME</strong>&nbsp;&nbsp;<?php echo $details1['title'].' '.$details1['first_name'].' '.$details['last_name']; ?></td>
    </tr>
    <tr>
      <td height="22" colspan="2" ><strong>FROM</strong>&nbsp;&nbsp;<?php echo getflightlocationname($details1['source']); // $loc_name = getlocationname($departure_loc);echo $loc_name; ?></td>
    </tr>
    <tr>
      <td colspan="3"><strong>FROM</strong>&nbsp;&nbsp;
           <?php echo getflightlocationname($details1['source']); //$loc_name = getlocationname($departure_loc);echo $loc_name; ?>         </td>
      <td width="227"><strong>TO</strong>&nbsp;&nbsp;
          <?php  echo getflightlocationname($details1['destination']);  // $loc_name = getlocationname($arriaval_loc);echo $loc_name; ?>      </td>
      <td colspan="2">
         <strong>TO</strong>&nbsp;&nbsp; 
         <?php echo getflightlocationname($details1['destination']);  // $loc_name = getlocationname($arriaval_loc);echo $loc_name; ?>
      </td>
    </tr>
    <tr>
      <td colspan="3"><strong>TICKET NO</strong> &nbsp;&nbsp;<?php echo $details1['bp_ticketid']; ?></td>  
      <td><strong>PASSPORT NO.</strong>&nbsp;&nbsp;<?php echo $details1['passport_no']; ?></td>
      <td colspan="2" ><strong>TICKET NO</strong>&nbsp;&nbsp; <?php echo $details1['bp_ticketid']; ?></td>
	  </tr>
    <tr>
      <td colspan="3"><!--<strong>SEAT NO</strong>&nbsp;&nbsp;<?php // echo $bp1['seat_no']; ?>--></td>
      <td><strong>TIME</strong>&nbsp;&nbsp;<?php echo $details1['time1']; ?>
      
      
      </td>
      <td colspan="2"><strong>PASSPORT NO</strong>&nbsp;&nbsp; <?php echo $details1['passport_no']; ?></td>
      </tr>
    <tr>
      <td><strong>FLIGHT NO</strong>&nbsp;&nbsp;<?php echo $details1['flight_no']; ?></td>
      <td colspan="2">&nbsp;</td>
      <td><strong>DATE</strong>&nbsp;&nbsp;<?php echo $details1['date1']; ?></td>
      <td colspan="2"><strong>FLIGHT NO</strong>&nbsp;&nbsp;<?php echo $details1['flight_no']; ?></td>
      </tr>
    <tr>
      <td width="164"><strong>GATE NO.</strong>&nbsp;&nbsp;<?php echo $details1['gateno']; // echo $gate_no; ?> </td>
      <td colspan="2">&nbsp;</td>
      <td rowspan="2" align="left" valign="bottom"><img src="<?php echo BASEURL."common/"; ?>barcode.php?barcode=<?php echo $details1['bp_ticketid']; ?>&amp;height=50&amp;width=265" /></td>
      <td colspan="2"><strong>DATE</strong>&nbsp;&nbsp;<?php echo $details1['date1']; ?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td width="77"><strong>GATE NO.</strong>&nbsp;&nbsp;<?php echo $details1['gateno']; // echo $gate_no; ?> </td>
      <td width="81"><strong>TIME</strong>&nbsp;&nbsp;<?php echo $details1['time1']; ?></td>
      </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>

<br /><br /><br /><br />



<?php } ?>

<?php		} ?>
</div>


		<!-- end id-form  -->

	</td>
	<td>

	<!--  start related-activities -->
	<!-- end related-activities -->

</td>
</tr>
<tr>
<td><img src="../images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
<td></td>
</tr>
</table>
 
<div class="clear"></div>
 

</div>
<!--  end content-table-inner  -->
</td>
<td id="tbl-border-right"></td>
</tr>
<tr>
	<th class="sized bottomleft"></th>
	<td id="tbl-border-bottom">&nbsp;</td>
	<th class="sized bottomright"></th>
</tr>
</table>









 





<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer -->

 

<div class="clear">&nbsp;</div>

<?php include('../common/footer.php'); ?>