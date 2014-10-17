<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_agency_book.php');
$db = new Database();

$run = $db->query("SELECT * FROM agency_seat_allocation LEFT JOIN eticket1 USING (allocation_id) WHERE eno='".base64_decode($_REQUEST['id'])."' ORDER BY eticket1.flight_order");
$rec = $db->total();
$row = $db->fetch($run);
$data1[] = $row;	
$flight_info = $db->query("SELECT * FROM flights LEFT JOIN carriers ON flights.agency_id=carriers.carriers_id WHERE flight_id='".$row['flight_id']."'");
$fdata1 = $db->fetch($flight_info);



if($rec==2)
{
// MEANS RETURN TICKET IS THERE
$row = $db->fetch($run);
$data2[] = $row;
	
}


//OLD DATA

/*$run = $db->query("SELECT * FROM eticket LEFT JOIN pilgrims USING(pilgrim_id) WHERE id='".base64_decode($_REQUEST['id'])."'");
$row = $db->fetch($run);
$data1 = array();
$data2 = array();
	$run = $db->query("SELECT * FROM agency_seat_allocation LEFT JOIN flights USING(flight_id) LEFT JOIN state ON agency_seat_allocation.agency_id=state.state_id LEFT JOIN carriers ON agency_seat_allocation.carrier_id= carriers.carriers_id WHERE allocation_id='".$row['allocation_id1']."'");
//	$run = $db->query("SELECT * FROM agency_seat_allocation LEFT JOIN flights USING(flight_id) LEFT JOIN agency ON agency_seat_allocation.agency_id=agency.agency_id LEFT JOIN carriers ON agency_seat_allocation.carrier_id= carriers.carriers_id WHERE allocation_id='".$row['allocation_id1']."'");
	$data1 = $db->fetch($run);
	if($row['allocation_id2']!=0)
	{
		$run = $db->query("SELECT * FROM agency_seat_allocation LEFT JOIN flights USING(flight_id) WHERE allocation_id='".$row['allocation_id']."' ");
		$data2 = $db->fetch($run);		
	}
*/
$path = BASEURL.'image_content/carriers/carriers_images_th/';

//if(isset($_SESSION['passport_no'])){ unset($_SESSION['passport_no']);}
//if(isset($_SESSION['path'])){ unset($_SESSION['path']);}

?>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Eticket</h1></div>


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
        <?php notification(); ?>
        <?php print_r($data1); ?>
        <hr />
        <?php print_r($data2); ?>
        <hr />
        <?php print_r($fdata1); ?>
        
        
            <input type="button" value="PRINT" onclick="printContent('print_area')"  />	 
<br />
<br />
				<div class="clear"></div>

<div id="print_area">        
<table width="650" border="0" id="eticket">
<tr>
  <td width="281" rowspan="4"><img src="<?php  echo $path.$data1['carriers_id'].'.'.$data1['carriers_logo']; ?>" width="60" height="60"/></td>
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
    <td colspan="2"><strong><font color="#009966">CARRIER NAME</font>&nbsp;&nbsp;&nbsp;&nbsp;</strong><?php echo $data1['carriers_name']; ?></td>
    <td>&nbsp;</td>
    <td><strong><font color="#009966">CARRIER IATA CODE:</font>&nbsp;&nbsp;&nbsp;&nbsp;</strong><?php  echo $data1['iata_code']; ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td colspan="2"><strong><font color="#009966">CARRIER ADDRESS</font>&nbsp;&nbsp;&nbsp;&nbsp; </strong><br />
    &nbsp;<?php echo $data1['carriers_address']; ?></td>
    <td>&nbsp;</td>
    <td><strong><font color="#009966">PHONE NO.</font>&nbsp;&nbsp;&nbsp;&nbsp;</strong>+234 - <?php echo $data1['carriers_phoneno']; ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
<!--    <td><b>Agency Name:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php echo $data1['agency_name']; ?></td>
-->    
    <td><b>Agency Name:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php echo $data1['state_name']; ?></td>
	<td>&nbsp;</td>
<!--    <td colspan="2"><strong>Email:&nbsp;&nbsp;</strong><?php echo $data1['agency_url']; ?></td>
-->
    <td colspan="2"><strong>Email:&nbsp;&nbsp;</strong><?php echo $data1['email']; ?></td>
 	<td>&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td rowspan="3"><img src="<?php echo BASEURL."common/"; ?>barcode.php?barcode=<?php echo $row['eno']; ?>&height=60&width=300"/>
    <td>&nbsp;</td>
 </tr>

<tr>
    <td colspan="3"><strong>Passenger E-ticket No.</strong> <?php echo $row['eno'];?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><strong>Date of Issue:</strong> <?php echo $row['createdon']; ?></td>
    <td colspan="2"><strong>Validity</strong>&nbsp;<?php echo $data1['validity']; ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td colspan="2"><strong>Passenger Information</strong></td>
	<td>&nbsp;</td>
    <td><strong>Passenger Status:</strong><?php  echo $row['pilgrim_status']; ?></td>   
    <td>&nbsp;</td>
</tr>
<tr>
    <td height="20"><strong>Full Name Title : </strong></td>    
    <td colspan="2"><?php  if($row['sex']= "Male"){ echo "Mr.";} else{ echo "Mrs.";} ?><?php echo $row['full_name']; ?></td>
    <td rowspan="2"><img src="<?php echo BASEURL."common/"; ?>barcode.php?barcode=<?php  echo $row['passport_no']; ?>&amp;height=60&amp;width=300" /></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><strong>Passport</strong>: <?php  echo $row['passport_no']; ?></td>
    <td colspan="2"><strong>Nationality</strong>: <?php echo $row['nationality']; ?> </td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td style="background-color:#333;"><strong><font color="#FFF">DEPARTURE DATE</font>&nbsp;&nbsp;&nbsp;</strong><?php echo $data1['date2']; ?></td>
    <td colspan="2"><strong>FLIGHT NO:</strong> &nbsp;<?php  echo $data1['flight_no']; ?> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong><font color="#009966">FROM</font>&nbsp;&nbsp;&nbsp;&nbsp; </strong>
      <?php  echo getflightlocationname($data1['source']);    ?></td>
    <td><strong><font color="#009966">TO</font>&nbsp;&nbsp;&nbsp;&nbsp;</strong>
      <?php echo getflightlocationname($data1['destination']);  ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><strong>Departing At :</strong> <?php echo $data1['time1'];  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Arriving At </strong> &nbsp;<?php echo $data1['time2'];  ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><strong>Terminal</strong> &nbsp; <?php echo getterminalname($data1['dterminal']);  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Terminal</strong> &nbsp; <?php  echo getterminalname($data1['aterminal']); ?></td>
    <td>&nbsp;</td>
</tr>	 
<tr>
    <td><strong>Class :</strong> &nbsp;<?php  echo $row['class1']; ?> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>BAG :</strong> <?php echo $row['weight1']; ?> KG </td>
    <td>&nbsp;</td>
</tr>	
<tr>
    <td><strong><font color="#009966">BOOKING STATUS:</font>&nbsp;&nbsp;&nbsp;<span class="small">&nbsp;</span></strong><span class="small"><?php echo $row['bstatus1']; ?></span></td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<?php if($row['path'] ==2){ ?>
<tr>
	<td style="background-color:#333;"><strong><font color="#FFF">DEPARTURE DATE</font>&nbsp;&nbsp;&nbsp;</strong>
	<?php echo $data2['date2']; ?></td>
	<td colspan="2"><strong>FLIGHT NO:</strong>&nbsp;<?php echo $data2['flight_no'];  ?> </td>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong><font color="#009966">FROM</font>&nbsp;&nbsp;&nbsp;&nbsp; </strong>
    <?php  echo getflightlocationname($data2['source']);  ?></td>
    <td><strong><font color="#009966">TO</font>&nbsp;&nbsp;&nbsp;</strong>
    <?php echo getflightlocationname($data2['destination']); ?></td>
    <td>&nbsp;</td>
</tr>	
<tr>
    <td><strong>Departing At :</strong> <?php echo $data2['time1'];  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Arriving At </strong> <?php echo $data2['time2']; ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><strong>Terminal</strong> &nbsp; <?php echo getterminalname($data2['dterminal']);  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Terminal</strong> &nbsp; <?php echo getterminalname($data2['aterminal']); ?></td>
    <td>&nbsp;</td>
</tr>	 
<tr>
    <td><strong>Class :</strong> &nbsp;<?php echo $row['class2']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>BAG :</strong> <?php echo $row['weight2']; ?> KG </td>
    <td>&nbsp;</td>
</tr>	
<?php } ?>
<tr>
    <td height="35"><?php if($row['path']==2){ ?><strong><font color="#009966">BOOKING STATUS:</font>&nbsp;&nbsp;&nbsp;&nbsp;</strong><?php echo $row['bstatus2']; ?><?php } ?></td>
    <td colspan="2"><strong>AIR FARE&nbsp;&nbsp;&nbsp;&nbsp;</strong><?php echo $data1['price'];  ?></td>
    <td><strong>MODE OF PAYMENT&nbsp;&nbsp;&nbsp;&nbsp; </strong><?php  echo $row['mop']; ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td colspan="5"><span class="small">&nbsp;AT CHECK-IN, PLEASE SHOW A PICTURE IDENTIFICATION AND THE DOCUMENT YOU GAVE FOR REFERENCE AT THE RESERVATION TIME. NOTE:RETURN DATE IS SUBJECT TO CONFIRMATION AND AVAILABILITY OF SCREENING BAY. </span></tr>
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


</div>
<br />
				<div class="clear"></div>
            <input type="button" value="PRINT" onclick="printContent('print_area')"  />	 


        
	</td>
	<td>
       <?php // include('../common/user_latestactivity.php'); ?>
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