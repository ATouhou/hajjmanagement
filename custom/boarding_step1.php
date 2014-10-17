<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_agency_boarding.php');
$db = new Database();
if(!isset($_SESSION['passport_no'])){ $_SESSION['passport_no'] = $_POST['passport_no'];}
// CHECK THE EXISTANCE OF THE PILGRIM
$run = $db->query("SELECT * FROM eticket LEFT JOIN pilgrims USING(pilgrim_id) WHERE passport_no ='".$_SESSION['passport_no']."' AND pilgrims.status='Active' AND eticket.status='Active' AND state='".$_SESSION['agency_id']."' ORDER BY flight_order");
$rec= $db->total();
if($db->total()==0)
{

	$status ='fail';
	$message ='Passport No does not exists';
	$link = 'boardingpass.php';	
	notify($status,$message);
	header('Location:'.$_SESSION['basemodule'].$link);

}else
{
// GET THE LIST OF SEATS BASED ON THE  PATH VARIABLE
$row = $db->fetch($run);
$pilgrim_data[] = $row;

$run_pil =	$db->query("SELECT bno FROM `boardingpass` WHERE pilgrim_id='".$row['pilgrim_id']."' ");
if($db->total()>0)
{

	$status ='fail';
	$message ='Boarding Pass already generated';
	$link = 'boardingpass.php';	
	notify($status,$message);
	header('Location:'.$_SESSION['basemodule'].$link);
}





$seats1 = array();
$allocation_id1=$row['allocation_id'];
//print_r($row);
$run_seat = $db->query("SELECT seats,seats_no_alloted,flight_no, date1, date2, time1, time2, source, destination FROM agency_seat_allocation LEFT JOIN flights USING(flight_id) WHERE allocation_id='".$row['allocation_id']."'"); 
$row_seat = $db->fetch($run_seat);
$flight1_data[] = $row_seat;
$total_seats = explode(',',$row_seat['seats']);
$seats_no_alloted = explode(',',$row_seat['seats_no_alloted']);
$seats1 = array_diff($total_seats,$seats_no_alloted);
if($rec==2)
{
	unset($total_seats);
	unset($seats_no_alloted);
	$row = $db->fetch($run);
	$allocation_id2=$row['allocation_id'];
	
	$seats2 = array();
	$run_seat = $db->query("SELECT seats,seats_no_alloted,flight_no, date1, date2, time1, time2, source, destination FROM agency_seat_allocation LEFT JOIN flights USING(flight_id) WHERE allocation_id='".$row['allocation_id']."'"); 
	$row_seat = $db->fetch($run_seat);
	$flight2_data[] = $row_seat;	
	$total_seats = explode(',',$row_seat['seats']);
	$seats_no_alloted = explode(',',$row_seat['seats_no_alloted']);
	$seats2 = array_diff($total_seats,$seats_no_alloted);
}	
	
}

// COLLECT ALL THE FLIGHT IDS HAVING SEATS GREATOR THAN ZERO
// GET ALL THE FLIGHTS
$flight_data = array();
$run_flight =$db->query("SELECT allocation_id,seat_allocated, flight_no FROM agency_seat_allocation asa LEFT JOIN flights USING(flight_id) WHERE asa.agency_id='".$_SESSION['agency_id']."' AND date1 >='".date('Y-m-d')."' ");
$total = $db->total();

while($row_flight = $db->fetch($run_flight))
{
//	$db->query("SELECT id FROM eticket WHERE (allocation_id1 ='".$row_flight['allocation_id']."') OR (allocation_id2 ='".$row_flight['allocation_id']."')");
	$db->query("SELECT id FROM eticket WHERE allocation_id ='".$row_flight['allocation_id']."'");
	
	if(($row_flight['seat_allocated']-$db->total())>0)
	{	
		$flight_data[]	= $row_flight;
	}
}

//$total = $db->total();

?>
 <script type="text/javascript">
 function pagination(val)
{
	var xmlhttp;
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
		    document.getElementById('create_pilgrim_table').innerHTML=xmlhttp.responseText;
    }
  }
	xmlhttp.open("GET","../ajax/agency_flight_table.php?val="+val,true);
xmlhttp.send();
}
/*******SCRIPT FOR CHAGNING THE STATUS OF PILGRIM********/
function changeusertatus(action,user_id,user_status)
{
	var xmlhttp;
	var res =true;
//alert('hello');
//alert(user_id);
//alert(user_status);
//alert(action);
	if(action=='status')
	{
		if(user_status=='Active')
		{
			 res = window.confirm('Deactivate User Status.\n    Are you sure?');
		}else
		{
			 res = window.confirm('Activate User Status.\n    Are you sure?');
		}
	}
	if(res==true)
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
		document.getElementById(panel).innerHTML=xmlhttp.responseText;
    }
  }
   var panel = 'status_'+user_id;
	document.getElementById(panel).innerHTML ='<div align="left"><center><img src="../images/loading.gif" width="40" /></center></div>';  
xmlhttp.open("GET","../ajax/changeuserstatus.php?user_id="+user_id+"&action="+action,true);
xmlhttp.send();
}
	
}

function getdetails(id,val)
{
var xmlhttp;
   var panel = 'show_details_'+val;

if(id=='')
{
		document.getElementById('error_allocation'+val).innerHTML='';
		document.getElementById(panel).innerHTML ='';
		return false;
}else
{
	
}
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
		document.getElementById(panel).innerHTML=xmlhttp.responseText;
    }
  }
	document.getElementById(panel).innerHTML ='<div align="left"><center><img src="../images/loading.gif" width="40" /></center></div>';  
xmlhttp.open("GET","../ajax/getflightdetails.php?id="+id,true);
xmlhttp.send();
}
function checkfrm(f1)
{
	var allocation1 = document.getElementById('allocation1').value;
	if(allocation1=='')
	{
		document.getElementById('error_allocation1').innerHTML='This cannot be blank';
		return false;
	}
	if(document.getElementById('path').value==2)
	{
		var allocation2 = document.getElementById('allocation2').value;
		if(allocation2=='')
		{
//			alert('iaminside');
			document.getElementById('error_allocation2').innerHTML='This cannot be blank';
			return false;
		}
	}
}


 </script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Seat Allocation Management</h1></div>


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
        <?php // notification(); ?>
<form action="../action/boardingpass_transact.php" method="post" onsubmit="return checkfrm(this);">
<input type="hidden" name="path" id="path" value="<?php echo $rec; ?>" />
<?php // print_r($seats1); $_SESSION['agency_id']; ?>
<input type="hidden" name="pilgrim_id" id="pilgrim_id" value="<?php echo $row['pilgrim_id']; ?>" />
<input type="hidden" name="allocation_id1" id="allocation_id1" value="<?php echo $allocation_id1; ?>" />
<table width="850" id="boarding-table">
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td>E-ticket No:<?php echo $row['eno']; ?> <input type="hidden" name="eno" id="eno" value="<?php echo $row['eno']; ?>" /></td>
  </tr>
  <tr>
    <th>Pilgrim Information</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">
    <table width="840">
      <tr>
        <td width="180">Pilgrim Name</td>
        <td width="220"><?php echo $pilgrim_data[0]['full_name']; ?></td>
        <td width="180">Birth Date</td>
        <td><?php echo $pilgrim_data[0]['dob']; ?></td>
      </tr>
      <tr>
        <td>Passport No</td>
        <td><?php echo $pilgrim_data[0]['passport_no']; ?></td>
        <td>Cell No:</td>
        <td><?php echo $pilgrim_data[0]['mno']; ?></td>
      </tr>
      <tr>
        <td>Passenger Status</td>
        <td><?php echo $pilgrim_data[0]['pilgrim_status']; ?></td>
        <td>Nationality</td>
        <td><?php echo $pilgrim_data[0]['nationality']; ?></td>
      </tr>
      <tr>
        <td>Gender</td>
        <td><?php echo $pilgrim_data[0]['sex']; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <th width="180">Flight Information ( <?php echo $flight1_data[0]['flight_no']; ?> )</th>
    <td>&nbsp;</td>
    <td width="250">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">
    <table width="840">
      <tr>
        <td width="180">Departure</td>
        <td width="220"><?php echo getflightlocationname($flight1_data[0]['source']); ?></td>
        <td width="180">Arrival</td>
        <td><?php echo getflightlocationname($flight1_data[0]['destination']); ?></td>
      </tr>
      <tr>
        <td>Date &amp; time</td>
        <td><?php echo $flight1_data[0]['date1'].' '.$flight1_data[0]['time1']; ?></td>
        <td>Date &amp; time</td>
        <td><?php echo $flight1_data[0]['date2'].' '.$flight1_data[0]['time2']; ?></td>
      </tr>
    </table>
    </td>
    </tr>
  <tr>
    <td colspan="3">
    <table width="840">
<?php $s=0; foreach($seats1 as $val){ ?>
<?php if(($s%6)==0){ ?>    
      <tr>
<?php } ?>      
        <td><input type="radio" name="seats1" id="seats1" value="<?php echo $val; ?>" checked="checked" /></td>
        <td><?php echo $val; $s++; ?></td>
<?php if(($s%6)==0){ ?>    
      </tr>
<?php } ?> 
<?php } ?>      
    </table>
    </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php if($rec==2) { ?>
  <tr>
    <th width="180"><input type="hidden" name="allocation_id2" id="allocation_id2" value="<?php echo $allocation_id2; ?>" />Flight Information ( <?php echo $flight2_data[0]['flight_no']; ?> )</th>
    <td>&nbsp;</td>
    <td width="250">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">
    <table width="840">
      <tr>
        <td width="180">Departure</td>
        <td width="220"><?php echo getflightlocationname($flight2_data[0]['source']); ?></td>
        <td width="180">Arrival</td>
        <td><?php echo getflightlocationname($flight2_data[0]['destination']); ?></td>
      </tr>
      <tr>
        <td>Date &amp; time</td>
        <td><?php echo $flight2_data[0]['date1'].' '.$flight2_data[0]['time1']; ?></td>
        <td>Date &amp; time</td>
        <td><?php echo $flight2_data[0]['date2'].' '.$flight2_data[0]['time2']; ?></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
  <td colspan="3">
    <table width="840">
<?php print_r($seats2); $s=0; foreach($seats2 as $val){ ?>
<?php if(($s%6)==0){ ?>    
      <tr>
<?php } ?>      
        <td><input type="radio" name="seats2" id="seats2" value="<?php echo $val; ?>" checked="checked" /></td>
        <td><?php echo $val; $s++; ?></td>
<?php if(($s%6)==0){ ?>    
      </tr>
<?php } ?> 
<?php } ?>      
    </table>
    </td>
  </tr>
<?php } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><label>
      <input type="submit" name="button" id="button" value="Generate Boarding Pass" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
</table>





</form>        
        
        
        
        
<div id="create_pilgrim_table">        
		<?php // include('../ajax/agency_flight_table.php'); ?>
</div>        
	</td>
	<td>
       <?php include('../common/user_latestactivity.php'); ?>
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