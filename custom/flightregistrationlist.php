<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_custom_reports.php');
$id = base64_decode($_REQUEST['id']);
$db = new Database();

$run_flight = $db->query("SELECT * FROM flights WHERE flight_no ='".$id."'");
$row_flight = $db->fetch($run_flight);

?>

<!--************TO FETCH THE LGA VALUES***********-->
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
	xmlhttp.open("GET","../ajax/custom_flightuser_table.php?val="+val+"&id="+id,true);
xmlhttp.send();
}
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


<div id="page-heading"><h1>Flight Wise Report </h1></div>


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
        <h3> Flight Information </h3>
        
        <?php notification(); ?>

<?php // print_r($row_user); ?>
<table width="850" id="product-table">
  <tr>
    <th class="table-header-repeat line-left"><a href="#">Flight No</a></th>
    <th class="table-header-repeat line-left"><a href="#">Departure</a></th>
    <th class="table-header-repeat line-left"><a href="#">Destination</a></th>
  </tr>
  <tr>
    <td><?php echo $row_flight['flight_no']; ?></td>
    <td><?php echo getflightlocationname($row_flight['source']); ?></td>
    <td><?php echo getflightlocationname($row_flight['destination']); ?></td>
  </tr>
</table>


           <input type="button" value="PRINT" onclick="printContent('print_area')"  />	 
<br />
<br />


<div id="create_pilgrim_table">        
		<?php  include('../ajax/custom_flightuser_table.php'); ?>
</div>        

<?php // echo $_REQUEST['error_data']; $error_data[] = unserialize($_REQUEST['error_data']); print_r(unserialize($_REQUEST['error_data'])); ?>


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