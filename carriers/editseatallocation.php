<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_carriers_agency.php');
$db= new Database();
$run = $db->query("SELECT * FROM `agency_seat_allocation` WHERE allocation_id='".$_REQUEST['id']."'");
$row = $db->fetch($run);
$seat_booked = count(explode(',',$row['seats_no_alloted']))-1;


?>
<script type="text/javascript">
function checkfrm(f1)
{
	var total_seats = document.getElementById('total_seats').value;
	var seats = document.getElementById('seats').value;	
	var booked_seats = document.getElementById('booked_seats').value;	
	var diff = parseInt(parseInt(total_seats) - parseInt(booked_seats));
	if(seats=='' || seats==0 || seats> diff)
	{
			document.getElementById('error_seats').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">Correct Entry required.</div>';
			document.getElementById('seats').focus();
			return false;
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
<div id="page-heading"><h3>Flight Management</h3></div>
<?php notification(); ?>	

		<!-- start id-form -->

<form  name="regisfrm"  method="post" action="../action/agency_carriers_transact.php?action=<?php if(isset($_REQUEST['id'])){ echo "remove";}else { echo "add"; }?>" id="regisfrm" onsubmit="return checkfrm(this.value);" >
<?php if(isset($_REQUEST['id'])){ echo '<input type="hidden" name="allocation_id" id="allocation_id" value="'.$_REQUEST['id'].'">'; } ?><?php if(isset($_REQUEST['id'])){ echo '<input type="hidden" name="flightid" id="flightid" value="'.$_REQUEST['flightid'].'">'; } ?>        
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
  	<tr>
		<th valign="top">Agency Name:</th>
		<td><input type="text" value="<?php echo getstatename($row['agency_id']); ?>" disabled="disabled" class="input-medium"  /></td>
		<td></td>
	</tr>
  	<tr>
  	  <th valign="top">Total Seats Allocated</th>
  	  <td><input type="text" value="<?php echo $row['seat_allocated']; ?>" disabled="disabled" class="input-medium"  /><input type="hidden" name="total_seats" id="total_seats" value="<?php echo $row['seat_allocated']; ?>" /></td>
  	  <td></td>
	</tr>
  	<tr>
  	  <th valign="top">Total Seats Booked</th>
  	  <td><input type="text" value="<?php echo $seat_booked; ?>" disabled="disabled" class="input-medium"  /><input type="hidden" name="booked_seats" id="booked_seats" value="<?php echo $seat_booked; ?>" /></td>
  	  <td></td>
	  </tr>
  	<tr>
  	  <th valign="top">Seats removed</th>
  	  <td>
      <label>
  	    <input type="text" name="seats" id="seats" class="input-medium" />
  	  </label> Maximum (<strong><?php echo  $row['seat_allocated']-$seat_booked; ?></strong>)</td>
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