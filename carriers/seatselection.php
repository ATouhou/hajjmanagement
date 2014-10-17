<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_carriers_agency.php');
$db= new Database();
$run = $db->query("SELECT state_id,state_name FROM state WHERE status='Active'");
while($row = $db->fetch($run))
{
 		$agency_data[]=$row;
}
$seat_count =1;
if(!isset($_SESSION['flight_id'])){ $_SESSION['flight_id']=$_POST['flight_id'];}
if(!isset($_SESSION['agency'])){ $_SESSION['agency']=$_POST['agency'];}
if(!isset($_SESSION['seats'])){ $_SESSION['seats']=$_POST['seats'];}

$db = new Database();
$run = $db->query("SELECT * FROM flights WHERE flight_id='".$_SESSION['flight_id']."'");
$flight_details = $db->fetch($run);
$query= $db->query("SELECT * FROM aircraft WHERE aircraft_id='".$flight_details['aircraft_id']."' AND agency_id='".$_SESSION['agency_id']."'");
$aircraft_details = $db->fetch($query);
$seats = $aircraft_details['seats'];
// GET ALL THE BOOKED SEAT IN AN ARRAY
$db = new Database();
$query = $db->query("SELECT seats FROM `agency_seat_allocation` WHERE flight_id='".$_SESSION['flight_id']."'");
$seats_booked = array();
if($db->total()>0)
{
while($row = $db->fetch($query))
{
	$seats_booked_data[] = $row['seats'];
}

//print_r($seats_booked_data);
$seats_booked = implode(',',$seats_booked_data);
}
//echo 'the big array is'. $big_array;
/*for($i=0; $i<count($seat_booked_data); $i++);
{*/
//print_r(explode(',',$big_array));

//	$seats_booked[] = explode(',',$big_array);	
//}

//print_r($seats_booked);
$noc = $aircraft_details['noc'];
$nor = $aircraft_details['nor'];

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
	var seats_count = document.getElementById('seats_count').value;
//	alert(seats_count);
	var seats = document.getElementById('seats[]').length;
	
//	alert(seats);
//	return false;	
	
/*	if(seats =='')
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
	
*/	
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
<?php 
//print_r($flight_details);
//print_r($aircraft_details);
//echo 'the seats booked are';
//print_r($seats_booked);
?>
		<!-- start id-form -->

<!--<form  name="regisfrm"  method="post" action="../action/agency_carriers_transact.php?action=<?php if(isset($_REQUEST['location_id'])){ echo "edit";}else { echo "add"; }?>" id="regisfrm" onsubmit="return checkfrm(this.value);" >
--><form  name="regisfrm"  method="post" action="../action/agency_carriers_transact.php?action=<?php if(isset($_REQUEST['location_id'])){ echo "edit";}else { echo "add"; }?>" id="regisfrm" onsubmit="return checkfrm(this.value);" >
<?php if(isset($_REQUEST['location_id'])){ echo '<input type="hidden" name="location_id" id="location_id" value="'.$_REQUEST['location_id'].'">'; } ?>        
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
  	<tr>
		<th valign="top">Total Seats:</th>
		<td><?php echo getflightseats($_SESSION['flight_id']); ?><input type="hidden" name="flight_id" id="flight_id" value="<?php echo $_SESSION['flight_id']; ?>" readonly="readonly" /></td>
		<td></td>
	</tr>
  	<tr>
  	  <th valign="top">Remaining Seats</th>
  	  <td><?php echo getremaningseats($_SESSION['flight_id']); ?><input type="hidden" name="rseats" id="rseats" value="<?php echo getremaningseats($_SESSION['flight_id']); ?>" /></td>
  	  <td></td>
	  </tr>
  	<tr>
  	  <th valign="top">Agency</th>
  	  <td><label><?php echo $_SESSION['agency']; ?>
	    </label></td>
  	  <td></td>
	  </tr>
  	<tr>
  	  <th valign="top">Seats</th>
  	  <td>
      <label>
  	    <input type="text" name="seats_count" id="seats_count" value="<?php echo $_SESSION['seats']; ?>"  class="input-medium" />
  	  </label></td>
  	  <td><div id="error_seats"></div></td>
    </tr> 
    <tr>
    	<td colspan="3">
     
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
	  <tr>
      	<th>&nbsp;</th>
<?php for($c=0;$c<$noc; $c++){ ?>     
      	<th><?php echo $albhates[$c+1]; ?></th>
<?php } ?>        
      </tr>	
<?php for($r=0;$r<$nor; $r++){ ?>        
	  <tr>
 		<th><?php echo $r+1; ?></th>     
<?php for($c=0;$c<$noc; $c++){ ?>  
		<td>
        <?php if($seats !=NULL){ $seats1=explode(',',$seats); $var =($r+1).'-'.($albhates[$c+1]);  
		if(in_array($var,$seats1)){
			
		$sel1 ='';
		$sel='';
		
		if(count($seats_booked)>0)
		{
// SEATS ARE BOOKED			
		if(in_array($var,explode(',',$seats_booked))){ 
			$sel1 = 'disabled="disabled"';
		//	echo 'iam desi';
		}else{
			if($seat_count<= $_SESSION['seats'])
			{
			
				$seat_count++;
			$sel=	'checked="checked"';
			}else{
				$sel ='';
			}
		}
		
		}else{
// SEATS ARE NOT BOOKED			
			
			$sel1='';
// CHECK WITH THE TOTAL SSEATS ALLOCATED
			if($seat_count<= $_SESSION['seats'])
			{
				$seat_count++;
				$sel=	'checked="checked"';
				
			}else{
				$sel='';	
			}
		}
		?>
			<input type="checkbox"   name="seats[]" value="<?php echo ($r+1).'-'.($albhates[$c+1]); ?>" id="seats[]" <?php  echo $sel1; echo $sel; ?> />		
		<?php    echo $r+1; echo $albhates[$c+1];             }else{ echo '&nbsp;'; } 
		?><?php
		}
			?>            
        </td>	
<?php } 	?>        
	  </tr>
<?php } ?>        
	</table>
     
        
        
    	</td>
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