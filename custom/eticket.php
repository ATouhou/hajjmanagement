<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_custom_eticket.php');
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


<div id="page-heading"><h1>CSV Upload </h1></div>


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
		 
          echo '<a href='.$_SERVER['PHP_SELF'].'?val='.($current_val-1).'  ><img src="../images/forms/prev.gif" /></a>';
         
		  }
		  ?>
          </th>
          <th  colspan="2" align="left" width="300">Total No of Records : <?php echo $total_val; ?>(<?php echo $current_val+1; ?>/<?php echo $nop; ?> )</th>
		  <th align="left"></th>
          <td><?php for($i=1;$i<=$nop; $i++){ echo '<a href='.$_SERVER['PHP_SELF'].'?val='.($i-1).'  >&nbsp;&nbsp;'.$i.'&nbsp;&nbsp;</a>'; }?></td>	
          <th width="200">
          <?php
          if($limit<$total_val)
		  {
	          echo '<a href='.$_SERVER['PHP_SELF'].'?val='.($current_val+1).'  ><img src="../images/forms/next.gif" /></a>';
		  }
          ?>
          </th>
        </tr> 
</table>
<br /><br /><br />

<?php
	$checkdate1 = strtotime(date('Y-m-d'));
	$checkdate2 = strtotime('2015-12-07');
	if(($checkdate1-$checkdate2)<0){ 

		for($i=1; $i<=$nop; $i++){
			$no = $i-1;
			echo '<div style=" vertical-align:center;display:block;position:relative; float:left; width:80px; height:20px;  padding-top:8px; margin:2px; background-color:#333;text-align:center;">';
			echo '<a style="text-decoration:none;color:#FFF;" target="_blank" href="eticket_pdf.php?val='.$no.'" >Print '.$i.'</a>';
			echo '</div>';
		}
	}
?>
<div style="clear:both"></div>

<br /><br />
<div id="print_area">

		<?php foreach($show_disp as $val=>$key ) {
			
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
	//	echo "SELECT * FROM flights LEFT JOIN carriers ON carriers.carriers_id=flights.agency_id WHERE flight_no='".$flightnodetails[0]."' AND date1='".$flightdatedetails[0]."'";
		$get_flightinfo1 = $db->fetch($run_flightinfo1);		
		
		
			?>

<table width="650" border="0" id="eticket">
<tr>
  <td width="281" rowspan="4"><img src="<?php   echo $path.$get_flightinfo1['carriers_id'].'.'.$get_flightinfo1['carriers_logo']; ?>" width="60" height="60"/></td>
  <td width="51">&nbsp;</td>
  <td width="135">&nbsp;</td>
  <td width="142">&nbsp;</td>
  <td width="19">&nbsp;</td>
  </tr>
<tr>
  <td colspan="3" align="center"><strong><font color="#CC6600">ELECTRONIC TICKET</font></strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
    <td colspan="3" align="center"><strong><font color="#CC6600">PASSENGER ITINERARY RECEIPT</font></strong></td>
    <td>&nbsp;</td>
 	<td>&nbsp;</td>
  </tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td colspan="2"><strong><font color="#009966">CARRIER NAME</font>&nbsp;&nbsp;&nbsp;&nbsp;</strong><?php   echo $get_flightinfo1['carriers_name']; ?></td>
    <td>&nbsp;</td>
    <td><strong><font color="#009966">CARRIER IATA CODE:</font>&nbsp;&nbsp;&nbsp;&nbsp;</strong><?php    echo $get_flightinfo1['iata_code']; ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td colspan="2"><strong><font color="#009966">CARRIER ADDRESS</font>&nbsp;&nbsp;&nbsp;&nbsp; </strong><br />
    &nbsp;<?php   echo $get_flightinfo1['carriers_address']; ?></td>
    <td><?php 
	$checkdate1 = strtotime(date('Y-m-d'));
	$checkdate2 = strtotime('2015-02-07');
	if(($checkdate1-$checkdate2)>0){ ?><font color="#FF0000">Dummy E-Ticket</font><?php } ?></td>
    <td><strong><font color="#009966">PHONE NO.</font>&nbsp;&nbsp;&nbsp;&nbsp;</strong>+234 - <?php   echo $get_flightinfo1['carriers_phoneno']; ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
<!--    <td><b>Agency Name:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php //  echo $data1['agency_name']; ?></td>
-->    
    <td><b>Agency Name:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php  echo $data[0]['agency_code']; ///  echo getstatename($details['agency_id']); ?></td>
	<td>&nbsp;</td>
<!--    <td colspan="2"><strong>Email:&nbsp;&nbsp;</strong><?php  // echo $details['agency_url']; ?></td>
-->
    <td colspan="2"><strong>Email:&nbsp;&nbsp;</strong><?php   echo $get_flightinfo1['email']; ?></td>
 	<td>&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td rowspan="3"><img src="<?php   echo BASEURL."common/"; ?>barcode.php?barcode=<?php   echo $data[0]['ticket_id']; ?>&height=60&width=300"/>
    <td>&nbsp;</td>
 </tr>

<tr>
    <td colspan="3"><strong>Passenger E-ticket No.</strong> <?php   echo $data[0]['ticket_id'];?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><strong>Date of Issue:</strong> <?php  echo $data[0]['issue_date']; ?></td>
    <td colspan="2"><strong>Validity</strong>&nbsp;<?php   echo $data[0]['exp_date']; ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td colspan="2"><strong>Passenger Information</strong></td>
	<td>&nbsp;</td>
    <td><strong>Passenger Status:</strong><?php echo 'Adult'; //  echo $pdata['pilgrim_status']; ?></td>   
    <td>&nbsp;</td>
</tr>
<tr>
    <td height="20"><strong>Full Name Title : </strong></td>    
    <td colspan="2"><?php echo $data[0]['title'].'. '; ?><?php   echo $data[0]['first_name'].' '.$data[0]['last_name']; ?></td>
    <td rowspan="2"><img src="<?php   echo BASEURL."common/"; ?>barcode.php?barcode=<?php    echo $data[0]['passport_no']; ?>&amp;height=60&amp;width=300" /></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><strong>Passport</strong>: <?php   echo $data[0]['passport_no']; ?></td>
    <td colspan="2"><strong>Nationality</strong>: <?php  echo $data[0]['country']; ?> </td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td style="background-color:#333;"><font color="#FFF"><strong>DEPARTURE DATE:&nbsp;</strong><?php  echo $get_flightinfo1['date1']; ?></font></td>
    <td colspan="2"><strong>FLIGHT NO:</strong> &nbsp;<?php   echo $get_flightinfo1['flight_no']; ?> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong><font color="#009966">FROM</font>&nbsp;&nbsp;&nbsp;&nbsp; </strong>
      <?php    echo getflightlocationname($get_flightinfo1['source']); //   echo $details['departure']; ?></td>
    <td><strong><font color="#009966">TO</font>&nbsp;&nbsp;&nbsp;&nbsp;</strong>
      <?php  echo getflightlocationname($get_flightinfo1['destination']); // echo $details['destination'];  ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><strong>Departing At :</strong> <?php   echo $get_flightinfo1['time1'];  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Arriving At </strong> &nbsp;<?php  echo $get_flightinfo1['time2'];  ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><strong>Terminal</strong> &nbsp; <?php  echo getterminalname($get_flightinfo1['dterminal']);  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Terminal</strong> &nbsp; <?php  echo getterminalname($get_flightinfo1['aterminal']); ?></td>
    <td>&nbsp;</td>
</tr>	 
<tr>
    <td><strong>Class :</strong> &nbsp;<?php   echo $data[0]['class']; ?> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>BAG :</strong> <?php //  echo $fdata1['weight']; ?> 30 KG </td>
    <td>&nbsp;</td>
</tr>	
<tr>
    <td><strong><font color="#009966">BOOKING STATUS:</font>&nbsp;&nbsp;&nbsp;<span class="small">&nbsp;</span></strong><span class="small"><?php //  echo $data1['bstatus']; ?></span></td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<?php if($way ==2){
		$run_flightinfo2 = $db->query("SELECT * FROM flights LEFT JOIN carriers ON carriers.carriers_id=flights.agency_id WHERE flight_no='".$flightnodetails[1]."' AND date1='".$flightdatedetails[1]."'");
		$get_flightinfo2 = $db->fetch($run_flightinfo2);
	
//	$details1 = $db->fetch($run_details);	
	
?>
<tr>
	<td style="background-color:#333;"><font color="#FFF"><strong>DEPARTURE DATE:&nbsp;</strong><?php   echo $get_flightinfo2['date1']; ?></font></td>
	<td colspan="2"><strong>FLIGHT NO:</strong>&nbsp;<?php   echo $get_flightinfo2['flight_no'];  ?> </td>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong><font color="#009966">FROM</font>&nbsp;&nbsp;&nbsp;&nbsp; </strong>
    <?php    echo getflightlocationname($get_flightinfo2['source']);  ?></td>
    <td><strong><font color="#009966">TO</font>&nbsp;&nbsp;&nbsp;</strong>
    <?php   echo getflightlocationname($get_flightinfo2['destination']); ?></td>
    <td>&nbsp;</td>
</tr>	
<tr>
    <td><strong>Departing At :</strong> <?php   echo $get_flightinfo2['time1'];  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Arriving At </strong> <?php  echo $get_flightinfo2['time2']; ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><strong>Terminal</strong> &nbsp;<?php   echo getterminalname($get_flightinfo2['dterminal']);  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Terminal</strong> &nbsp; <?php  echo getterminalname($get_flightinfo2['aterminal']); ?></td>
    <td>&nbsp;</td>
</tr>	 
<tr>
    <td><strong>Class :</strong> &nbsp;<?php   echo $data[1]['class']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>BAG :</strong> <?php //  echo $fdata2['weight']; ?> 30 KG </td>
    <td>&nbsp;</td>
</tr>	
<?php } ?>
<tr>
    <td height="35"><?php if($way==2){ ?><strong><font color="#009966">BOOKING STATUS:</font>&nbsp;&nbsp;&nbsp;&nbsp;</strong><?php echo 'CONFIRM'; //  echo $data2['bstatus']; ?><?php } ?></td>
    <td colspan="2"><strong>AIR FARE&nbsp;&nbsp;&nbsp;&nbsp;</strong><?php echo 'CHARTER'; //  echo $fdata1['price'];  ?></td>
    <td><strong>MODE OF PAYMENT&nbsp;&nbsp;&nbsp;&nbsp; </strong><?php echo 'CONFIRM';  //  echo $data1['mop']; ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td colspan="5" align="justify"><span class="small">&nbsp;AT CHECK-IN, PLEASE SHOW A PICTURE IDENTIFICATION AND THE DOCUMENT YOU GAVE FOR REFERENCE AT THE RESERVATION TIME. NOTE:RETURN DATE IS SUBJECT TO CONFIRMATION AND AVAILABILITY OF SCREENING BAY. </span></tr>
<tr>
	<td colspan="5"><span class="small">ENDORESEMENT: <strong>NONE ENDORESABLE</strong></span>  </tr>
<tr>
	<td colspan="5"><hr /></td>
</tr>
<tr>
	<td colspan="5" align="center"><strong><font color="#FF0000" size="0.6em" >CONDITIONS OF CARRIAGE</font></strong></td>
</tr>
<tr>
	<td colspan="5"><font size="0.6em">&nbsp;</font>
	<p align="justify"><font size="0.6em"><strong>GENERAL</strong></font><font size="0.6em"><br />
  
  Except as provided in Articles 2.2, 2.4 and 2.5 our  conditions of carriage apply only on those flights, or flight segments, where  our name or Airline Designator Code of the airline operating this charter  flight on our behalf (i.e IY, E3, PGT JAV etc.) is indicated in the carrier box  of the Ticket for that flight or flight segment. The Terms and Conditions  contained within the Ticket, your itinerary or receipt or any ticket wallet  shall form part of these Conditions of Carriage.<br />
  
  <strong>CHARE TER OPERATIONS</strong><br />
  
  If Carriage is performed pursuant to a charter agreement,  these Conditions of Carriage apply only to the extent they are incorporated by  reference or otherwise, in the charter agreement or the Ticket.<br />
  
  <strong>CARRIERS</strong><br />
  
  Our Charter Flights are operated by sufficiently Airline  Operators including but not limited to Yemen Airways, Eritrean Airlines, Pegasus  Airlines, Jordan Aviation among others.<br />
  
  <strong>OVERRIDING LAW</strong><br />
  
  These conditions of Carriage are applicable unless they are  inconsistent with our Tariffs or applicable law in which event such Tariffs or  laws shall prevail. If any provision of these Conditions of Carriage is invalid  under any applicable law, the other provisions shall nevertheless remain valid.</font></p>      </td>
</tr>
<tr>
	<td colspan="5" align="right"><font size="0.6em"><strong>Detailed Conditions of Carriage are available from our offices upon request</strong></font></td>
</tr>
</table>

<br /><Br /><Br /><Br />
<?php if(($checkdate1-$checkdate2)>0){ ?>
<div style="page-break-after:always"></div>
<?php } ?>

<?php unset($data);	 unset($flightdatedetailscopy); unset($flightdatedetails); unset($flightnodetails); unset($flightnodetailscopy);	} ?>
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