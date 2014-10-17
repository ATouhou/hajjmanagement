<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_luggage_flights.php');
$db = new Database();
if(!isset($_SESSION['flights']))
{
	$_SESSION['flights'] = array();
	$db = new Database();	
	$db_run = $db->query("SELECT DISTINCT(flight_id),flight_no FROM flights WHERE agency_id='".$_SESSION['agency_id']."' AND status='Active' ORDER BY flight_no");
	while($db_row = $db->fetch($db_run))
	{
		$_SESSION['flights'][] = $db_row;
	}
}

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
		    document.getElementById('create_state_table').innerHTML=xmlhttp.responseText;
    }
  }
	xmlhttp.open("GET","../ajax/flights_table.php?val="+val,true);
xmlhttp.send();
}

/*******SCRIPT FOR CHAGNING THE STATUS OF PILGRIM********/
function changeflightstatus(action,flight_id,flight_status)
{
	var xmlhttp;
	var res =true;
	if(action=='status')
	{
		if(flight_status=='Active')
		{
			 res = window.confirm('Deactivate Flight Status.\n    Are you sure?');
		}else
		{
			 res = window.confirm('Activate Flight Status.\n    Are you sure?');
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
   var panel = 'status_'+flight_id;
xmlhttp.open("GET","../ajax/changeflightstatus.php?flight_id="+flight_id+"&action="+action,true);
xmlhttp.send();
}
	
}

function getpassangerlist(flightid)
{
	if(flightid!='')
	{
		var val = 0;
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
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		 {
			document.getElementById('create_passenger_luugage_table').innerHTML=xmlhttp.responseText;
		 }
		}
		  xmlhttp.open("GET","../ajax/passengerluggage_table.php?val="+val+"&flightid="+flightid,true);
	  xmlhttp.send();
	}
}

function printLabel(luggageid)
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
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		 {
			document.getElementById('luggage_latestactivity').innerHTML=xmlhttp.responseText;
		 }
		}
		  xmlhttp.open("GET","../common/luggage_latestactivity.php?id="+luggageid+"&ajax=1",true);
	  xmlhttp.send();
	
}

 </script> 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Luggage Management</h1></div>

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
<div id="page-heading"><h3>Passenger List </h3></div>

<?php notification(); ?>	
<p> <b>Select Flight Id  </b>
<select name="flightid" id="flightid" class="input-medium" onchange="getpassangerlist(this.value)">
 <option value="" selected="selected">Select</option>
<?php
		foreach($_SESSION['flights'] as $val=>$key)
		{	
			$val = '';
			if(isset($_REQUEST['flight_id']) && ($key['flight_id']==$row['flight_id']))
			{
				$val ='selected="selected"';			
			}			
			echo '<option value='.$key['flight_id'].' '.$val.'>'.$key['flight_no'].'</option>';
		}
?>
</select>
</p>
<p>&nbsp;</p>

		<!-- start id-form -->
<div id="create_passenger_luugage_table">
</div>
		<!-- end id-form  -->

	</td>
	<td>

	<!--  start related-activities -->
	<div id="luggage_latestactivity">
	</div>
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