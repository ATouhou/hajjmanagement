<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_agency_flight.php');
$db = new Database();

$run = $db->query("SELECT * FROM flights LEFT JOIN agency_seat_allocation USING(flight_id) LEFT JOIN aircraft USING (aircraft_id)  WHERE agency_seat_allocation.allocation_id='".base64_decode($_REQUEST['id'])."'");
$row = $db->fetch($run);





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
        <?php notification(); ?>



<table width="850" id="product-table">
  <tr>
    <td width="100">Flight No</td>
    <td width="140"><?php echo $row['flight_no']; ?></td>
    <td width="100">Source</td>
    <td width="220"><?php echo getflightlocationname($row['source']); ?></td>
    <td width="100" >Time</td>
    <td><?php echo $row['date1'].' '.$row['time1'];?></td>
  </tr>
  <tr>
    <td>Model</td>
    <td><?php echo $row['manufacturer'].' - '.$row['model']; ?></td>
    <td>Destination</td>
    <td><?php echo getflightlocationname($row['destination']); ?></td>
    <td>Time</td>
    <td><?php echo $row['date2'].' '.$row['time2'];?></td>
  </tr>
  <tr>
    <td>Total Seats</td>
    <td><?php echo $row['seat_allocated']; ?></td>
    <td>Seat Left</td>
    <td>&nbsp;</td>
    <td>Captian Name</td>
    <td><?php echo $row['captainname']; ?></td>
  </tr>
</table>



<form action="../action/generateeticket.php" method="post">
<input type="hidden" name="allocation_id" id="allocation_id" value="<?php echo base64_decode($_REQUEST['id']);?>" />
<table width="850" id="product-table">
  <tr>
    <td width="220">Enter Passport Number</td>
    <td><label>
      <input name="passport_no" type="text" class="input-medium" id="passport_no" maxlength="20" />
    </label></td>
    <td><div id="error_passport"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Generate E-ticket" /></td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>





<div id="create_pilgrim_table">        




		<?php // include('../ajax/agency_flight_table.php'); ?>
</div>        
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