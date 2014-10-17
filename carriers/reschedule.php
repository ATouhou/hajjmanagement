<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/carriers_menu.php');
$db = new Database();
$sql = "SELECT * FROM eticket LEFT JOIN agency_seat_allocation USING(allocation_id) WHERE eticket.id='".base64_decode($_REQUEST['id'])."'";
$run_info = $db->query($sql);
if($db->total()==0)
{
	$link = $_SESSION['basemodule'].'edit_eticket.php';
	notify('fail','E-ticket Number does not exists, Kindly contant administrator');	
	header('Location:'.$link);
}
$previous_data = $db->fetch($run_info);

// GET PILGRIM INFORMATION
$run_pilgrim = $db->query("SELECT pilgrim_id, full_name, passport_no FROM pilgrims WHERE pilgrim_id='".$previous_data['pilgrim_id']."'  AND  status='Active'");
$pilgrim_data = $db->fetch($run_pilgrim);

//GET FLIGHT IFORMATION
$run_flight = $db->query("SELECT * FROM flights WHERE flight_id='".$previous_data['flight_id']."' AND  status='Active'");
$prev_flight_data = $db->fetch($run_flight);
// GET ALL THE AGENCY INFROMATION OF THIS CARRIER
$run = $db->query("SELECT DISTINCT(agency_seat_allocation.agency_id) FROM  `agency_seat_allocation` LEFT JOIN flights USING(flight_id)  WHERE flights.agency_id='".$_SESSION['agency_id']."' AND flights.date1>='".date('Y-m-d')."' AND flights.status='Active'");
while($agency_info = $db->fetch($run))
{
	$agency_data[] =$agency_info;
}

?>
<script type="text/javascript">
function getflightno(agency_id){

var xmlhttp;
var panel = "display_flightno";

if(agency_id=='')
{
		document.getElementById('error_agency').innerHTML='<div style="color:#F00;">Please choose Agency</div>';

		return false;
}else
{
	document.getElementById('error_agency').innerHTML='';
	document.getElementById('show_details').innerHTML ='';
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
//		document.getElementById(panel).innerHTML ='<div align="left"><center><img src="../images/loading.gif" width="40" /></center></div>';  
	xmlhttp.open("GET","../ajax/getflightno.php?id="+agency_id,true);
	xmlhttp.send();
	}
}
function getdetails(id)
{
var xmlhttp;
var panel = 'show_details';

if(id=='')
{
		document.getElementById('error_allocation').innerHTML='<div style="color:#F00;">This field cannot be blank</div>';
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
		document.getElementById('error_allocation1').innerHTML='<div style="color:#F00;">This field cannot be blank</div>';
		return false;
	}
}
</script>

<!-- start content-outer -->
<div id="content-outer" >
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Reschedule Eticket</h1></div>


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
<br />
<br />
				<div class="clear"></div>
<table width="850" id="product-table">
  <tr>
    <td>Eticket No</td>
    <td><?php echo $previous_data['eno']; ?></td>
    <td>Carrier Name</td>
    <td><?php echo getcarriername($previous_data['carrier_id']); ?></td>
  </tr>
  <tr>
    <td>Flight No</td>
    <td><?php echo $prev_flight_data['flight_no']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Source</td>
    <td><?php echo getflightlocationname($prev_flight_data['source']); ?></td>
    <td>Destination</td>
    <td><?php echo getflightlocationname($prev_flight_data['destination']); ?></td>
  </tr>
  <tr>
    <td>Pilgrim Name</td>
    <td><?php echo $pilgrim_data['full_name']; ?></td>
    <td>Passport No</td>
    <td><?php echo $pilgrim_data['passport_no']; ?></td>
  </tr>
</table>   
<?php // echo base64_decode($_REQUEST['id']); ?>


<form action="../action/eticket_transact.php?action=edit" method="post" onsubmit="return checkfrm(this);">
<input type="hidden" name="pilgrim_id" id="pilgrim_id" value="<?php echo $pilgrim_data['pilgrim_id']; ?>" />
<input type="hidden" name="eticket_id" id="eticket_id" value="<?php echo base64_decode($_REQUEST['id']); ?>" />
<input type="hidden" name="eno" id="eno" value="<?php echo $previous_data['eno']; ?>" />


<table width="850" id="product-table">
  <tr>
    <td width="180">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="250">&nbsp;</td>
  </tr>
  <tr>
    <td>Mode of Payment <font color="#FF0000">*</font></td>
    <td><label>
      <select name="mop" id="mop" class="input-medium" >
        <option value="CASH" selected="selected">CASH</option>
        <option value="CHEQUE">CHEQUE</option>
      </select>
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Pilgrim Name</td>
    <td><?php echo $pilgrim_data['full_name']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Passport No</td>
    <td><?php echo $pilgrim_data['passport_no']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Agency Name</td>
    <td>
    <label>
        <select name="agency_id" id="agency_id" onchange="getflightno(this.value); return false;" class="input-medium" >
        <option value="">Choose Agency</option>
        <?php foreach($agency_data as $val){ ?>
        <option value="<?php echo $val['agency_id']; ?>"><?php echo getstatename($val['agency_id']); ?></option>
        <?php } ?>
        </select>
      </label>
   	</td>
    <td><div id="error_agency"></div></td>
  </tr>
  <tr>
    <td>Flight ID <font color="#FF0000">*</font></td>
    <td><div id="display_flightno">
      <label>
        <select name="allocation1" id="allocation1" onchange="getdetails(this.value,1); return false;" class="input-medium" >
        <option value="">Choose Flight</option>
        <?php foreach($flight_data as $val){ ?>
        <option value="<?php echo $val['allocation_id']; ?>"><?php echo $val['flight_no']; ?></option>
        <?php } ?>
        </select>
      </label>
      </div>
      </td>
    <td><div id="error_allocation"></div></td>
  </tr>
  <tr>
    <td>Booking Status</td>
    <td><label>
      <select name="bstatus1" size="1" id="bstatus1" class="input-medium">
<option value="CONFIRMED">CONFIRMED</option>
        <option value="WAITING">WAITING</option>
        <option value="OK">OK</option>
      </select>
    </label></td>
    <td>&nbsp;</td>
  </tr>
<!--  <tr>
    <td>Bag</td>
    <td><select name="weight1" size="1" id="weight1" class="input-medium">
      <option value="30">30</option>
      <option value="40">40</option>
      <option value="50">50</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
-->  <tr>
    <td>Class</td>
    <td><select name="class1" size="1" id="class1" class="input-medium">
      <option value="ECONOMY">ECONOMY</option>
      <option value="FIRST">FIRST</option>
      <option value="BUSINESS">BUSINESS</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><div id="show_details"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><label>
      <input type="submit" name="button" id="button" value="Reschedule Eticket" style="padding:5px;" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>
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