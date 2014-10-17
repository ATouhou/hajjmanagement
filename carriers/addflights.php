<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_carriers_flights.php');
if(!isset($_SESSION['aircraft']))
{
	$_SESSION['aircraft'] = array();
	$db = new Database();	
	$db_run = $db->query("SELECT aircraft_id,model FROM aircraft WHERE agency_id='".$_SESSION['agency_id']."' AND status='Active' AND seats!='NULL' ORDER BY model");
	while($db_row = $db->fetch($db_run))
	{
		$_SESSION['aircraft'][] = $db_row;
	}
	
}
if(!isset($_SESSION['location']))
{
	$_SESSION['location'] = array();
	$db = new Database();	
	$db_run = $db->query("SELECT location_id,location_name FROM carriers_location WHERE agency_id='".$_SESSION['agency_id']."' AND status='Active' ORDER BY location_name");
	while($db_row = $db->fetch($db_run))
	{
		$_SESSION['location'][] = $db_row;
	}
	
}
if(!isset($_SESSION['terminal']))
{
	$_SESSION['terminal'] = array();
	$db = new Database();	
	$db_run = $db->query("SELECT id,name FROM terminals WHERE agency_id='".$_SESSION['agency_id']."' AND status='Active' ORDER BY name");
	while($db_row = $db->fetch($db_run))
	{
		$_SESSION['terminal'][] = $db_row;
	}
	
}




?>

<!--************TO FETCH THE LGA VALUES***********-->
<script type="text/javascript">
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
xmlhttp.open("GET","../ajax/getdestination.php?value="+source_id,true);
xmlhttp.send();
	}
}

function getterminal(source_id)
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
		 document.getElementById("display_terminal").innerHTML=xmlhttp.responseText;
	 }
  }
xmlhttp.open("GET","../ajax/getterminal.php?value="+source_id,true);
xmlhttp.send();
	}
}

function checkfrm(f)
{
var flightid = document.getElementById('flightid').value;
var captainname = document.getElementById('captainname').value;
var model = document.getElementById('model').value;
var date1 = document.getElementById('date1').value;
var date2 = document.getElementById('date2').value;
var dterminal = document.getElementById('dterminal').value;
var source = document.getElementById('source').value;
//var cpassword = document.getElementById('cpassword').value;
		if(flightid=='')
		{
			document.getElementById('error_flightid').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.flightid.focus();
			return false;
		}else
		{
			document.getElementById('error_flightid').innerHTML='';		
		}
		if(captainname=='')
		{
			document.getElementById('error_captainname').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.captainname.focus();
			return false;
		}else
		{
			document.getElementById('error_captainname').innerHTML='';		
		}
		if(model=='')
		{
			document.getElementById('error_model').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.model.focus();
			return false;
		}else
		{
			document.getElementById('error_model').innerHTML='';		
		}
		if(dterminal=='')
		{
			document.getElementById('error_dterminal').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.dterminal.focus();
			return false;
		}else
		{
			document.getElementById('error_dterminal').innerHTML='';		
		}		
		if(source=='')
		{
			document.getElementById('error_source').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.source.focus();
			return false;
		}else
		{
			document.getElementById('error_source').innerHTML='';		
		}		
		if(date1=='')
		{
			document.getElementById('error_date1').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.date1.focus();
			return false;
		}else
		{
			document.getElementById('error_date1').innerHTML='';		
		}
		if(date2=='')
		{
			document.getElementById('error_date2').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.date2.focus();
			return false;
		}else
		{
			document.getElementById('error_date2').innerHTML='';		
		}
}

</script> 
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>New Flight</h1></div>

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
			<div class="step-dark-left"><a href="">Flight details</a></div>
			<div class="step-dark-right">&nbsp;</div>
			<div class="step-no-off">2</div>
			<div class="step-light-left">Preview Flight</div>
			<div class="step-light-round">&nbsp;</div>
			<div class="clear"></div>
		</div>
		<!--  end step-holder -->
	
		<!-- start id-form -->
        
<form  name="regisfrm" method="post" enctype="multipart/form-data" action="../action/flight_transact.php?action=<?php if(isset($_REQUEST['flightid'])){ echo "edit";}else { echo "add"; }?>" id="regisfrm" onSubmit="return checkfrm(this);"  >
<?php if(isset($_REQUEST['flightid']))
{	
	$db= new Database();
	$run = $db->query("SELECT * FROM flights WHERE flight_id='".$_REQUEST['flightid']."' AND agency_id='".$_SESSION['agency_id']."'");
	if($db->total()>0)
	{ 
		$row = $db->fetch($run);
		$time1 = explode(':',$row['time1']);
		$time2 = explode(':',$row['time2']);
		
	}
	echo "<input type='hidden' name='flight_no' id='flight_no' value='".$_REQUEST['flightid']."'>";
}
?>
<input type="hidden" name="captainname" id="captainname" class="input-medium" <?php if(isset($_REQUEST['flightid'])){ echo "value='". $row['captainname']."'";}else{ echo "value='CAPTAIN'"; } ?>   />
<input type="hidden" name="crewnumber" id="crewnumber" <?php if(isset($_REQUEST['flightid'])){ echo "value='". $row['crewnumber']."'";}else{ echo "value='5'";} ?> class="input-medium" />
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
	    <tr>
	      <th valign="top">Flight Type</th>
	      <td><label>
			  <select name="flight_type" id="flight_type" class="input-medium">
              <option value="passenger" <?php if(isset($_REQUEST['flightid']) && ($row['flight_type']=='passenger')){ echo 'selected="selected"'; } ?>>Passenger</option>
              <option value="cargo" <?php if(isset($_REQUEST['flightid']) && ($row['flight_type']=='cargo')){ echo 'selected="selected"'; } ?>>Cargo</option>
			    </select>
			  </label></td>
	      <td><div id="error_flighttype"></div></td>
	      </tr>
	    <tr>
	      <th valign="top">Flight Id</th>
	      <td><label>
	        <input type="text" name="flightid" id="flightid" class="input-medium" <?php if(isset($_REQUEST['flightid'])){ echo "value='". $row['flight_no']."'";} ?> />
	        </label></td>
	      <td><div id="error_flightid"></div></td>
	      </tr>
<!--	    <tr>
	      <th valign="top">Captain Name</th>
	      <td><label>
	        <input type="text" name="captainname" id="captainname" class="input-medium" <?php // if(isset($_REQUEST['flightid'])){ echo "value='". $row['captainname']."'";} ?> />
	        </label></td>
	      <td><div id="error_captainname"></div></td>
	      </tr>
-->	    <tr>
			<th valign="top">Aircraft Model:</th>
			<td><label>
			  <select name="model" id="model" class="input-medium">
              <option value="" selected="selected">Select</option>
<?php 
		$aircraft_data = array();
		foreach($_SESSION['aircraft'] as $val=>$key)
		{	
			$val = '';
			if(isset($_REQUEST['flightid']) && ($key['aircraft_id']==$row['aircraft_id']))
			{
				$val ='selected="selected"';			
			}
			
			echo '<option value='.$key['aircraft_id'].' '.$val.'>'.$key['model'].'</option>';
		}
?>
			    </select>
			  </label></td>
			<td><div id="error_model"></div></td>
		</tr> 
		<tr>
		  <th valign="top">Departure Terminal</th>
		  <td><label>
		    <select name="dterminal" id="dterminal" class="input-medium" onchange="getterminal(this.value); return false;">
              <option value="" selected="selected">Select</option>
<?php 
		$aircraft_data = array();
		foreach($_SESSION['terminal'] as $val=>$key)
		{	
			$val = '';
			if(isset($_REQUEST['flightid']) && ($key['id']==$row['dterminal']))
			{
				$val ='selected="selected"';			
			}
			
			echo '<option value='.$key['id'].' '.$val.'>'.$key['name'].'</option>';
		}
?>
		      </select>
		    </label></td>
		  <td><div id="error_dterminal"></div></td>
		  </tr>
		<tr>
		  <th valign="top">Arrival Terminal</th>
	  <td valign="top">
      <div id="display_terminal">

      <select name="aterminal" id="aterminal" class="input-medium" >
     	 <option value="" selected="selected">Select</option>
<?php	
		foreach($_SESSION['terminal'] as $val=>$key)
		{	
			$val = '';

			if(isset($_REQUEST['flightid']) && ($key['id']==$row['aterminal']))
			{
				$val ='selected="selected"';						
			}
			if($key['id']!=$row['dterminal'])
			{
						echo '<option value='.$key['id'].' '.$val.'>'.$key['name'].'</option>';
	
			}
 } ?>              
	    </select>
      </div>  
       </td>
	  <td>&nbsp;</td>
		  </tr>
		<tr>
		  <th valign="top">Departure:</th>
		  <td><select name="source" id="source" class="input-medium" onchange="getdestination(this.value); return false;">
              <option value="" selected="selected">Select</option>
<?php 
		$aircraft_data = array();
		foreach($_SESSION['location'] as $val=>$key)
		{	
			$val = '';
			if(isset($_REQUEST['flightid']) && ($key['location_id']==$row['source']))
			{
				$val ='selected="selected"';			
			}
			
			echo '<option value='.$key['location_id'].' '.$val.'>'.$key['location_name'].'</option>';
		}
?>
		    </select></td>
		  <td><div id="error_source"></div></td>
		  </tr>
	<tr>
	  <th>Arrival</th>
	  <td valign="top">
      <div id="display_destination">

      <select name="destination" id="destination" class="input-medium" >
     	 <option value="" selected="selected">Select</option>
<?php	
		foreach($_SESSION['location'] as $val=>$key)
		{	
			$val = '';

			if(isset($_REQUEST['flightid']) && ($key['location_id']==$row['destination']))
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
		  <th valign="top">Departure Date</th>
		  <td><label>
		    <input type="text" name="date1" id="date1" class="input-medium" <?php if(isset($_REQUEST['flightid'])){ echo "value='". $row['date1']."'";} ?>>
		    </label></td>
		  <td><div id="error_date1"></div></td>
		  </tr>
		<tr>
		  <th valign="top">Time</th>
		  <td><label>
		    <select name="h1" id="h1" class="input-medium1">
<?php for($h1=0; $h1<=23; $h1++){
	
			$t1 = str_pad($h1,2,'0',STR_PAD_LEFT);
			if(isset($_REQUEST['flightid']) && ($t1==$time1[0])){	$val ='selected="selected"';	}else{	$val ='';	}
?>
				<option value="<?php echo $t1; ?>" <?php echo $val; ?>><?php echo $t1; ?></option>            
<?php } ?>                
		      </select>
		    </label>
		    <label>
		      <select name="m1" id="m1" class="input-medium1">
<?php for($m1=0; $m1<=59; $m1++){
			$min1 = str_pad($m1,2,'0',STR_PAD_LEFT);
			if(isset($_REQUEST['flightid']) && ($min1==$time1[1])){	$val ='selected="selected"';	}else{	$val ='';	}
?>
				<option value="<?php echo $min1; ?>" <?php echo $val; ?> ><?php echo $min1; ?></option>            
<?php } ?>                
		        </select>
		      </label></td>
		  <td>&nbsp;</td>
		  </tr>
		<tr>
		  <th valign="top">Arrival Date</th>
		  <td><input name="date2" type="text" class="input-medium" id="date2" <?php if(isset($_REQUEST['flightid'])){ echo "value='". $row['date2']."'";} ?> /></td>
		  <td><div id="error_date2"></div></td>
		  </tr>
		<tr>
		  <th valign="top">Time</th>
		  <td><label>
		    <select name="h2" id="h2" class="input-medium1">
<?php for($h2=0; $h2<=23; $h2++){
			$t2 = str_pad($h2,2,'0',STR_PAD_LEFT);
			if(isset($_REQUEST['flightid']) && ($t2==$time2[0])){	$val ='selected="selected"';	}else{	$val ='';	}
?>
	
				<option value="<?php echo $t2; ?>" <?php echo $val; ?>><?php echo $t2; ?></option>            
<?php } ?>                
		      </select>
		    </label>
		    <label>
		      <select name="m2" id="m2" class="input-medium1">
<?php for($m2=0; $m2<=59; $m2++){
			$min2 = str_pad($m2,2,'0',STR_PAD_LEFT);
			if(isset($_REQUEST['flightid']) && ($min2==$time2[1])){	$val ='selected="selected"';	}else{	$val ='';	}
?>
				<option value="<?php echo $min2; ?>" <?php echo $val; ?>><?php echo $min2; ?></option>            
<?php } ?>                
		        </select>
		      </label></td>
		  <td>&nbsp;</td>
		  </tr>
		<tr>
		  <th valign="top">Price</th>
		  <td><label>
		    <input type="text" name="price" id="price" <?php if(isset($_REQUEST['flightid'])){ echo "value='". $row['price']."'";} ?> class="input-medium" />
		    Naira
		    </label></td>
		  <td>&nbsp;</td>
		  </tr>
<!--		<tr>
		  <th valign="top">Crew Number</th>
		  <td><label>
		    <input type="text" name="crewnumber" id="crewnumber" <?php // if(isset($_REQUEST['flightid'])){ echo "value='". $row['crewnumber']."'";} ?> class="input-medium" />
		    </label></td>
		  <td>&nbsp;</td>
		  </tr>
-->		<tr>
		  <th valign="top">Gate No.</th>
		  <td><label>
		    <input type="text" name="gateno" id="gateno" <?php if(isset($_REQUEST['flightid'])){ echo "value='". $row['gateno']."'";} ?> class="input-medium" />
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