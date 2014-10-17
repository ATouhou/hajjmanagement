<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_carriers_reports.php');
if(isset($_REQUEST['id']))
{
	$db = new Database();
	$id = base64_decode($_REQUEST['id']);
	$flight_carrier_run = $db->query("SELECT * FROM flights LEFT JOIN carriers ON agency_id=carriers_id WHERE flights.flight_id='".$id."'");
	$flight_carrier_data = $db->fetch($flight_carrier_run);
//	$run = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM agency_seat_allocation LEFT JOIN eticket ON agency_seat_allocation.allocation_id = eticket.allocation_id1 LEFT JOIN flights USING(flight_id) WHERE flight_id='".$id."' AND agency_seat_allocation.agency_id='".$_SESSION['agency_id']."'");
//	$row = $db->fetch($run);
}


?>
 <script type="text/javascript">
 function pagination(id,val)
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
	xmlhttp.open("GET","../ajax/carrier_boarding_table.php?val="+val+"&id="+id,true);
xmlhttp.send();
}


 </script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Boarding Confirmation Reports</h1></div>


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
		<h3>Agency: <?php echo getcarriername($_SESSION['agency_id']); ?></h3>
        <?php  // print_r($flight_carrier_data); ?>
<table width="840" align="center" id="product-table">
  <tr>
    <td><?php echo $flight_carrier_data['carriers_name']; ?></td>
  </tr>
  <tr>
    <td>Boarding Confirmation Report;</td>
  </tr>
  <tr>
    <td>Flight No: <?php echo $flight_carrier_data['flight_no'].' '.getflightlocationname($flight_carrier_data['source']).' to '.getflightlocationname($flight_carrier_data['destination']).' '.$flight_carrier_data['date1']; ?> </td>
  </tr>
</table>
        
       
<div id="create_pilgrim_table">        
		<?php include('../ajax/carrier_boarding_table.php'); ?>
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