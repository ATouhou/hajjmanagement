<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_agency_boarding.php');
$db = new Database();
$disp1=0;
$disp2=0;
if(isset($_REQUEST['id1'])){
$run = $db->query("SELECT full_name,bno,passport_no, seat_no, flight_id  FROM boardingpass LEFT JOIN pilgrims USING(pilgrim_id) LEFT JOIN agency_seat_allocation USING(allocation_id) WHERE bno='".$_REQUEST['id1']."'");
if($db->total()>0){	$bp1 = $db->fetch($run); $disp1=1; 
$run = $db->query("SELECT source, destination,date1, date2,time1,time2,flight_no,gateno FROM flights WHERE flight_id='".$bp1['flight_id']."'");
$flight1 = $db->fetch($run);
}
}
if(isset($_REQUEST['id2'])){
$run = $db->query("SELECT full_name,bno,passport_no, flight_id, seat_no  FROM boardingpass LEFT JOIN pilgrims USING(pilgrim_id) LEFT JOIN agency_seat_allocation USING(allocation_id) WHERE bno='".$_REQUEST['id2']."'");
if($db->total()>0){	$bp2 = $db->fetch($run); $disp2=1; 
$run = $db->query("SELECT source, destination,date1, date2,time1,time2,flight_no,gateno FROM flights WHERE flight_id='".$bp2['flight_id']."'");
$flight2 = $db->fetch($run);
}
}



?>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Boarding Pass</h1></div>

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


<?php if($disp1==1){  ?>
<div id="boardingpass">
<table width="700" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td height="25" colspan="4" align="center">&nbsp;</td>
      <td colspan="2"><strong>NAME</strong>&nbsp;&nbsp;<?php echo $bp1['full_name']; ?></td>
    </tr>
    <tr>
      <td colspan="4" rowspan="2"><p><strong>NAME</strong>&nbsp;&nbsp;<?php echo $bp1['full_name']; ?></td>
    </tr>
    <tr>
      <td height="22" colspan="2" ><strong>FROM</strong>&nbsp;&nbsp;<?php echo getflightlocationname($flight1['source']); // $loc_name = getlocationname($departure_loc);echo $loc_name; ?></td>
    </tr>
    <tr>
      <td colspan="3"><strong>FROM</strong>&nbsp;&nbsp;
           <?php echo getflightlocationname($flight1['source']); //$loc_name = getlocationname($departure_loc);echo $loc_name; ?>         </td>
      <td width="227"><strong>TO</strong>&nbsp;&nbsp;
          <?php  echo getflightlocationname($flight1['destination']);  // $loc_name = getlocationname($arriaval_loc);echo $loc_name; ?>      </td>
      <td colspan="2">
         <strong>TO</strong>&nbsp;&nbsp; 
         <?php echo getflightlocationname($flight1['destination']);  // $loc_name = getlocationname($arriaval_loc);echo $loc_name; ?>
      </td>
    </tr>
    <tr>
      <td colspan="3"><strong>TICKET NO</strong> &nbsp;&nbsp;<?php echo $bp1['bno']; ?></td>  
      <td><strong>PASSPORT NO.</strong>&nbsp;&nbsp;<?php echo $bp1['passport_no']; ?></td>
      <td colspan="2" ><strong>TICKET NO</strong>&nbsp;&nbsp; <?php echo $bp1['bno']; ?></td>
	  </tr>
    <tr>
      <td colspan="3"><strong>SEAT NO</strong>&nbsp;&nbsp;<?php echo $bp1['seat_no']; ?></td>
      <td><strong>TIME</strong>&nbsp;&nbsp;<?php echo $flight1['time1']; ?>
      
      
      </td>
      <td colspan="2"><strong>PASSPORT NO</strong>&nbsp;&nbsp; <?php echo $bp1['passport_no']; ?></td>
      </tr>
    <tr>
      <td><strong>FLIGHT NO</strong>&nbsp;&nbsp;<?php echo $flight1['flight_no']; ?></td>
      <td colspan="2">&nbsp;</td>
      <td><strong>DATE</strong>&nbsp;&nbsp;<?php echo $flight1['date1']; ?></td>
      <td colspan="2"><strong>FLIGHT NO</strong>&nbsp;&nbsp;<?php echo $flight1['flight_no']; ?></td>
      </tr>
    <tr>
      <td width="164"><strong>GATE NO.</strong>&nbsp;&nbsp;<?php echo $flight1['gateno']; // echo $gate_no; ?> </td>
      <td colspan="2">&nbsp;</td>
      <td rowspan="2" align="left" valign="bottom"><img src="<?php echo BASEURL."common/"; ?>barcode.php?barcode=<?php echo $bp1['bno']; ?>&amp;height=50&amp;width=265" /></td>
      <td colspan="2"><strong>DATE</strong>&nbsp;&nbsp;<?php echo $flight1['date1']; ?></td>
      </tr>
    <tr>
      <td colspan="3" style="font-size:14px;">Agnecy Name:<?php echo getstatename($_SESSION['agency_id']); ?></td>
      <td width="77"><strong>GATE NO.</strong>&nbsp;&nbsp;<?php echo $flight1['gateno']; // echo $gate_no; ?> </td>
      <td width="81"><strong>TIME</strong>&nbsp;&nbsp;<?php echo $flight1['time1']; ?></td>
      </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <td ></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
            <input type="button" value="PRINT" onclick="printContent('boardingpass')"  />	 

<?php }else{?>
<table width="840">
  <tr>
    <td>Sorry Boarding Pass Does not exists</td>
  </tr>
</table>
<?php } ?>
<br /><br />
<br /><br />
<br /><br />

<?php if($disp2==1){ ?>
<div id="boardingpass1">
<table width="700" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td height="25" colspan="4" align="center">&nbsp;</td>
      <td colspan="2"><strong>NAME</strong>&nbsp;&nbsp;<?php echo $bp1['full_name']; ?></td>
    </tr>
    <tr>
      <td colspan="4" rowspan="2"><p><strong>NAME</strong>&nbsp;&nbsp;<?php echo $bp1['full_name']; ?></td>
    </tr>
    <tr>
      <td height="22" colspan="2" ><strong>FROM</strong>&nbsp;&nbsp;<?php echo getflightlocationname($flight2['source']);  ?></td>
    </tr>
    <tr>
      <td colspan="3"><strong>FROM</strong>&nbsp;&nbsp;
           <?php echo getflightlocationname($flight2['source']);  ?>         </td>
      <td width="227"><strong>TO</strong>&nbsp;&nbsp;
          <?php  echo getflightlocationname($flight2['destination']);  ?>      </td>
      <td colspan="2">
         <strong>TO</strong>&nbsp;&nbsp; 
         <?php echo getflightlocationname($flight2['destination']);  ?>
      </td>
    </tr>
    <tr>
      <td colspan="3"><strong>TICKET NO</strong> &nbsp;&nbsp;<?php echo $bp2['bno']; ?></td>  
      <td><strong>PASSPORT NO.</strong>&nbsp;&nbsp;<?php echo $bp1['passport_no']; ?></td>
      <td colspan="2" ><strong>TICKET NO</strong>&nbsp;&nbsp; <?php echo $bp2['bno']; ?></td>
	  </tr>
    <tr>
      <td colspan="3"><strong>SEAT NO</strong>&nbsp;&nbsp;<?php echo $bp2['seat_no']; ?></td>
      <td><strong>TIME</strong>&nbsp;&nbsp;<?php echo $flight2['time1']; ?>
      </td>
      <td colspan="2"><strong>PASSPORT NO</strong>&nbsp;&nbsp; <?php echo $bp1['passport_no']; ?></td>
      </tr>
    <tr>
      <td><strong>FLIGHT NO</strong>&nbsp;&nbsp;<?php echo $flight2['flight_no']; ?></td>
      <td colspan="2">&nbsp;</td>
      <td><strong>DATE</strong>&nbsp;&nbsp;<?php echo $flight2['date1']; ?></td>
      <td colspan="2"><strong>FLIGHT NO</strong>&nbsp;&nbsp;<?php echo $flight2['flight_no']; ?></td>
      </tr>
    <tr>
      <td width="164"><strong>GATE NO.</strong>&nbsp;&nbsp;<?php echo $flight2['gateno']; // echo $gate_no; ?> </td>
      <td colspan="2">&nbsp;</td>
      <td rowspan="2"><img src="<?php echo BASEURL."common/"; ?>barcode.php?barcode=<?php echo $bp2['bno']; ?>&amp;height=40&amp;width=265" /></td>
      <td colspan="2"><strong>DATE</strong>&nbsp;&nbsp;<?php echo $flight2['date1']; ?></td>
      </tr>
    <tr>
      <td colspan="3" style="font-size:14px;">Agnecy Name:<?php echo getstatename($_SESSION['agency_id']); ?></td>
      <td width="77"><strong>GATE NO.</strong>&nbsp;&nbsp;<?php echo $flight2['gateno'];// echo $gate_no; ?> </td>
      <td width="81"><strong>TIME</strong>&nbsp;&nbsp;<?php echo $flight2['time1']; ?></td>
      </tr>
    <tr>
      <td colspan="3" >&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>

            <input type="button" value="PRINT" onclick="printContent('boardingpass1')"  />	 

<?php }else{?>
<table width="840">
  <tr>
    <td>Sorry Boarding Pass Does not exists</td>
  </tr>
</table>
<?php } ?>


        
<div id="create_pilgrim_table">        
		<?php // include('../ajax/agency_flight_table.php'); ?>
</div>        
	</td>
	<td>
       <?php  // include('../common/user_latestactivity.php'); ?>
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