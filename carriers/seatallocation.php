<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_carriers_agency.php');
$db= new Database();
//$run = $db->query("SELECT agency_id,agency_name FROM agency WHERE agency_status='Active'");
$run = $db->query("SELECT state_id,state_name FROM state WHERE status='Active'");
while($row = $db->fetch($run))
{
 		$agency_data[]=$row;
}

if(isset($_SESSION['flight_id'])){ unset($_SESSION['flight_id']);}
if(isset($_SESSION['agency'])){ unset($_SESSION['agency']);}
if(isset($_SESSION['seats'])){ unset($_SESSION['seats']);}

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
	xmlhttp.open("GET","../ajax/flights_agency_table.php?val="+val,true);
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

function checkfrm(f1)
{
//	alert('hello');
	var seats = document.getElementById('seats').value;
	var rseats = document.getElementById('rseats').value;
	if(seats =='')
	{
			document.getElementById('error_seats').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			document.getElementById('seats').focus();
			return false;
	}
	if((rseats-seats)<0)
	{
			document.getElementById('error_seats').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">Seats exceeds the total number of seats required.</div>';
			document.getElementById('seats').focus();
			return false;
	}
	
	
//	alert('hello');
	
//	return false;
		
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
<div id="page-heading"><h3>Flight Management</h3></div>
<?php notification(); ?>	

		<!-- start id-form -->


<form  name="regisfrm"  method="post" action="seatselection.php?action=<?php if(isset($_REQUEST['location_id'])){ echo "edit";}else { echo "add"; }?>" id="regisfrm" onsubmit="return checkfrm(this.value);" >
<?php if(isset($_REQUEST['location_id'])){ echo '<input type="hidden" name="location_id" id="location_id" value="'.$_REQUEST['location_id'].'">'; } ?>        
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
  	<tr>
		<th valign="top">Total Seats:</th>
		<td><?php echo getflightseats($_REQUEST['flight_id']); ?><input type="hidden" name="flight_id" id="flight_id" value="<?php echo $_REQUEST['flight_id']; ?>" /></td>
		<td></td>
	</tr>
  	<tr>
  	  <th valign="top">Remaining Seats</th>
  	  <td><?php echo getremaningseats($_REQUEST['flight_id']); ?><input type="hidden" name="rseats" id="rseats" value="<?php echo getremaningseats($_REQUEST['flight_id']); ?>" /></td>
  	  <td></td>
	  </tr>
  	<tr>
  	  <th valign="top">Agency</th>
  	  <td><label>
  	    <select name="agency" id="agency" class="input-medium">
    	<?php foreach($agency_data as $val=>$key){ ?>
<!--        	<option value="<?php // echo $key['agency_id']; ?>"><?php // echo $key['agency_name']; ?></option>    
-->        	<option value="<?php echo $key['state_id']; ?>"><?php echo $key['state_name']; ?></option>    
        <?php } ?>
	      </select>
	    </label></td>
  	  <td></td>
	  </tr>
  	<tr>
  	  <th valign="top">Seats</th>
  	  <td>
      <label>
  	    <input type="text" name="seats" id="seats" class="input-medium" />
  	  </label></td>
  	  <td><div id="error_seats"></div></td>
	  </tr> 
	<tr>
	  <th>&nbsp;</th>
	  <td valign="top">
	    <input type="submit" value="" class="form-submit" />
	    <input type="reset" value="" class="form-reset"  />
	    </td>
	  <td></td>
	  </tr>
	</table>
        </form>
<div class="clear"></div>
<div class="lines-dotted-short"></div>
<h3>Agencies  List </h3>
<div class="lines-dotted-short"></div>
<div id="bookedagencylist"></div>

<?php include('../ajax/agency_seats_booked_table.php'); ?>




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