<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/movement_vehicle.php');
if(!isset($_SESSION['location']))
{
	$_SESSION['location'] = array();
	$db = new Database();	
	$db_run = $db->query("SELECT location_id,location_name FROM movement_location WHERE agency_id='".$_SESSION['agency_id']."' AND status='Active' ORDER BY location_name");
	while($db_row = $db->fetch($db_run))
	{
		$_SESSION['location'][] = $db_row;
	}
	
}
if(!isset($_SESSION['center']))
{
	$_SESSION['center'] = array();
	$db = new Database();	
	$db_run = $db->query("SELECT center_id,center_name FROM movement_center WHERE agency_id='".$_SESSION['agency_id']."' AND status='Active' ORDER BY center_name");
	while($db_row = $db->fetch($db_run))
	{
		$_SESSION['center'][] = $db_row;
	}
	

}
?>

<!--************TO FETCH THE LGA VALUES***********-->
<script type="text/javascript">
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
function getdestination(source_id)
{
	if(source_id=='')
	{
		document.getElementById('error_source').innerHTML='';		
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
		 document.getElementById("display_destination").innerHTML=xmlhttp.responseText;
	 }
  }
xmlhttp.open("GET","../ajax/getmovementdestination.php?value="+source_id,true);
xmlhttp.send();
	}
}

function checkfrm(f)
{
var fname = document.getElementById('full_name').value;
var username = document.getElementById('username').value;
var category = document.getElementById('category').value;
var password = document.getElementById('password').value;
var cpassword = document.getElementById('cpassword').value;
		if(fname=='')
		{
			document.getElementById('error_full_name').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.full_name.focus();
			return false;
		}else
		{
			document.getElementById('error_full_name').innerHTML='';		
		}
		if(username=='')
		{
			document.getElementById('error_username').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.username.focus();
			return false;
		}else
		{
			document.getElementById('error_username').innerHTML='';		
		}
		if(category=='')
		{
			document.getElementById('error_category').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.category.focus();
			return false;
		}else
		{
			document.getElementById('error_category').innerHTML='';		
		}
		if(password=='')
		{
			document.getElementById('error_password').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.password.focus();
			return false;
		}else
		{
			document.getElementById('error_password').innerHTML='';		
		}
		if(cpassword=='')
		{
			document.getElementById('error_cpassword').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.cpassword.focus();
			return false;
		}else
		{
			document.getElementById('error_cpassword').innerHTML='';		
		}
		if(cpassword!=password)
		{
			document.getElementById('error_cpassword').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">Password does not match.</div>';
			f.cpassword.focus();
			return false;
		}else
		{
			document.getElementById('error_cpassword').innerHTML='';		
		}		
}


function checkcategory(category_id)
{
	if(category_id!='2')
	{
	document.getElementById("getlist").innerHTML='';
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
		 document.getElementById("getlist").innerHTML=xmlhttp.responseText;
	 }
  }
xmlhttp.open("GET","../ajax/getcarriers.php?value="+category_id,true);
xmlhttp.send();
	}	
	
}


</script> 
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">

<div id="page-heading"><h1>Vehicle Management</h1></div>


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
		<div id="step-holder">
			<div class="step-no">1</div>
			<div class="step-dark-left"><a href="">Vehicle details</a></div>
			<div class="step-dark-round">&nbsp;</div>
			<div class="clear"></div>
		</div>
		<!--  end step-holder -->
	
		<!-- start id-form -->
<form  name="regisfrm" method="post" enctype="multipart/form-data" action="../action/vehicle_transact.php?action=<?php if(isset($_REQUEST['id'])){ echo "edit";}else { echo "add"; }?>" id="regisfrm" onSubmit="return checkfrm(this);" >

<?php if(isset($_REQUEST['id']))
{
	$db= new Database();
	$run = $db->query("SELECT * FROM vehicle WHERE vehicle_id='".base64_decode($_REQUEST['id'])."'");
	if($db->total()>0)
	{
		$row = $db->fetch($run);
	}
	echo "<input type='hidden' name='vehicle_id' value='".base64_decode($_REQUEST['id'])."'>";

}

?>
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
	    <tr>
			<th valign="top">Agency:</th>
			<td><input type="text" readonly="readonly" class="input-medium" disabled="disabled" name="agency_id" id="agency_id" value="<?php echo getstatename($_SESSION['agency_id']); ?>" /></td>
			<td><div id="error_full_name"></div></td>
		</tr> 
	    <tr>
			<th valign="top">Vehicle No:</th>
			<td><input name="vehicle_no" type="text" class="input-medium" id="vehicle_no" <?php if(isset($_REQUEST['id'])){ echo "value='". $row['vehicle_no']."'";} ?> /></td>
			<td><div id="error_vehicle_no"></div></td>
		</tr> 
		<tr>
		  <th valign="top">Receiver Name:</th>
		  <td><select name="center" id="center" class="input-medium" >
              <option value="" selected="selected">Select</option>
<?php 
		foreach($_SESSION['center'] as $val=>$key)
		{	
			$val = '';
			if(isset($_REQUEST['id']) && ($key['center_id']==$row['center_id']))
			{
				$val ='selected="selected"';			
			}
			
			echo '<option value='.$key['center_id'].' '.$val.'>'.$key['center_name'].'</option>';
		}
?>
		    </select>
            </td>
		  <td><div id="error_source"></div></td>
		  </tr>	
	    <tr>
			<th valign="top">Vehicle Type:</th>
			<td><select name="vehicle_type" class="input-medium" id="vehicle_type">
            <option value="Passenger" <?php if(isset($_REQUEST['id'])){ echo "value='". $row['vehicle_type']."'";} ?> />Passenger</option>
            <option value="Luggage" <?php if(isset($_REQUEST['id'])){ echo "value='". $row['vehicle_type']."'";} ?> />Luggage</option>
            </td>
			<td><div id="error_vehicle_type"></div></td>
		</tr> 
	    <tr>
			<th valign="top">Capacity:</th>
			<td><input name="capacity" type="text" class="input-medium" id="capacity" <?php if(isset($_REQUEST['id'])){ echo "value='". $row['capacity']."'";} ?> /></td>
			<td><div id="error_vehicle_type"></div></td>
		</tr> 
		<tr>
		  <th valign="top">Source:</th>
		  <td><select name="source" id="source" class="input-medium" onchange="getdestination(this.value); return false;">
              <option value="" selected="selected">Select</option>
<?php 
		foreach($_SESSION['location'] as $val=>$key)
		{	
			$val = '';
			if(isset($_REQUEST['id']) && ($key['location_id']==$row['source']))
			{
				$val ='selected="selected"';			
			}
			
			echo '<option value='.$key['location_id'].' '.$val.'>'.$key['location_name'].'</option>';
		}
?>
		    </select>
            </td>
		  <td><div id="error_source"></div></td>
		  </tr>	
	    <tr>
			<th valign="top">Departure Date:</th>
			<td><input name="departure_date" type="text" class="input-medium" readonly="readonly"  id="date2" <?php if(isset($_REQUEST['id'])){ echo "value='". $row['departure_date']."'";} ?> /></td>
			<td><div id="error_departure_date"></div></td>
		</tr> 
		<tr>
		  <th valign="top">Time</th>
		  <td><label>
		    <select name="h1" id="h1" class="input-medium1">
<?php 

if(isset($_REQUEST['id'])){
		$time1 = explode(':',$row['dtime']);	
}

for($h1=0; $h1<=23; $h1++){
	
			$t1 = str_pad($h1,2,'0',STR_PAD_LEFT);
			if(isset($_REQUEST['id']) && ($t1==$time1[0])){	$val ='selected="selected"';	}else{	$val ='';	}
?>
				<option value="<?php echo $t1; ?>" <?php echo $val; ?>><?php echo $t1; ?></option>            
<?php } ?>                
		      </select>
		    </label>
		    <label>
		      <select name="m1" id="m1" class="input-medium1">
<?php for($m1=0; $m1<=59; $m1++){
			$min1 = str_pad($m1,2,'0',STR_PAD_LEFT);
			if(isset($_REQUEST['id']) && ($min1==$time1[1])){	$val ='selected="selected"';	}else{	$val ='';	}
?>
				<option value="<?php echo $min1; ?>" <?php echo $val; ?> ><?php echo $min1; ?></option>            
<?php } ?>                
		        </select>
		      </label></td>
		  <td>&nbsp;</td>
		  </tr>
   	    <tr>
			<th valign="top">Destination:</th>
			<td>
            <div id="display_destination">

      <select name="destination" id="destination" class="input-medium" >
     	 <option value="" selected="selected">Select</option>
<?php	
		foreach($_SESSION['location'] as $val=>$key)
		{	
			$val = '';

			if(isset($_REQUEST['id']) && ($key['location_id']==$row['destination']))
			{
				$val ='selected="selected"';						
			}
			if($key['location_id']!=$row['source'])
			{
						echo '<option value='.$key['location_id'].' '.$val.'>'.$key['location_name'].'</option>';
	
			}
 } ?>              
	    </select>
      </div>  
			</td>
			<td><div id="error_destination"></div></td>
		</tr> 
	    <tr>
			<th valign="top">Arrival Date:</th>
			<td><input name="arrival_date" type="text" class="input-medium" readonly="readonly" id="date1" <?php if(isset($_REQUEST['id'])){ echo "value='". $row['arrival_date']."'";} ?> /></td>
			<td><div id="error_arrival_date"></div></td>
		</tr> 
		<tr>
		  <th valign="top">Time</th>
		  <td><label>
		    <select name="h2" id="h2" class="input-medium1">
<?php 
if(isset($_REQUEST['id'])){
		$time2 = explode(':',$row['atime']);	
}
for($h2=0; $h2<=23; $h2++){
			$t2 = str_pad($h2,2,'0',STR_PAD_LEFT);
			if(isset($_REQUEST['id']) && ($t2==$time2[0])){	$val ='selected="selected"';	}else{	$val ='';	}
?>
	
				<option value="<?php echo $t2; ?>" <?php echo $val; ?>><?php echo $t2; ?></option>            
<?php } ?>                
		      </select>
		    </label>
		    <label>
		      <select name="m2" id="m2" class="input-medium1">
<?php for($m2=0; $m2<=59; $m2++){
			$min2 = str_pad($m2,2,'0',STR_PAD_LEFT);
			if(isset($_REQUEST['id']) && ($min2==$time2[1])){	$val ='selected="selected"';	}else{	$val ='';	}
?>
				<option value="<?php echo $min2; ?>" <?php echo $val; ?>><?php echo $min2; ?></option>            
<?php } ?>                
		        </select>
		      </label></td>
		  <td>&nbsp;</td>
		  </tr>
	<tr>
	  <th>&nbsp;</th>
	  <td valign="top">
	    <input type="submit" value="Submit" class="form-submit" />
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