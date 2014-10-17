<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_agency_book.php');
$db = new Database();
if(!isset($_SESSION['passport_no'])){ $_SESSION['passport_no'] = $_POST['passport_no'];}
if(!isset($_SESSION['path'])){ $_SESSION['path'] = $_POST['path'];}

// CHECK THE EXISTANCE OF THE PILGRIM
//$run = $db->query("SELECT pilgrim_id, full_name, passport_no FROM pilgrims WHERE passport_no='".$_SESSION['passport_no']."' AND agency ='".$_SESSION['agency_id']."' AND  status='Active'");
$run = $db->query("SELECT pilgrim_id, full_name, passport_no FROM pilgrims WHERE passport_no='".$_SESSION['passport_no']."' AND state ='".$_SESSION['agency_id']."' AND  status='Active'");
if($db->total()>0)
{
	$row = $db->fetch($run);
	$pilgrim_id = $row['pilgrim_id'];
	$db->query("SELECT * FROM eticket WHERE pilgrim_id='".$pilgrim_id."' AND eticket.status='Active'");
//	echo $pilgrim_id;
	if($db->total()==0)
	{
		$status='success';
		$message = 'Passport Verified';
		$link = 'book_step1.php';
		notify($status,$message);
	}else
	{
		$status ='fail';
		$message ='Eticket already exists';
		$link = 'book.php';	
		notify($status,$message);
		header('Location:'.$_SESSION['basemodule'].$link);		
	}
	$status ='success';
	$message ='E-ticket Generated';
	

}else
{
	$status ='fail';
	$message ='Passport No does not exists';
	$link = 'book.php';	
	notify($status,$message);
	header('Location:'.$_SESSION['basemodule'].$link);

}

// COLLECT ALL THE FLIGHT IDS HAVING SEATS GREATOR THAN ZERO
// GET ALL THE FLIGHTS
$flight_data = array();
$run_flight =$db->query("SELECT allocation_id,seat_allocated, flight_no FROM agency_seat_allocation asa LEFT JOIN flights USING(flight_id) WHERE asa.agency_id='".$_SESSION['agency_id']."' AND date1 >='".date('Y-m-d')."' ");
$total = $db->total();

while($row_flight = $db->fetch($run_flight))
{
//	$db->query("SELECT id FROM eticket WHERE (allocation_id1 ='".$row_flight['allocation_id']."') OR (allocation_id2 ='".$row_flight['allocation_id']."')");
	$db->query("SELECT id FROM eticket WHERE allocation_id ='".$row_flight['allocation_id']."'");
	
	if(($row_flight['seat_allocated']-$db->total())>0)
	{	
		$flight_data[]	= $row_flight;
	}
}

//$total = $db->total();

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

function getdetails(id,val)
{
var xmlhttp;
   var panel = 'show_details_'+val;

if(id=='')
{
		document.getElementById('error_allocation'+val).innerHTML='';
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
		document.getElementById('error_allocation1').innerHTML='This cannot be blank';
		return false;
	}
	if(document.getElementById('path').value==2)
	{
		var allocation2 = document.getElementById('allocation2').value;
		if(allocation2=='')
		{
//			alert('iaminside');
			document.getElementById('error_allocation2').innerHTML='This cannot be blank';
			return false;
		}
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
        <?php // echo $_SESSION['path']; // echo $total; print_r($flight_data); // notification(); ?>
<form action="../action/eticket_transact.php" method="post" onsubmit="return checkfrm(this);">
<input type="hidden" name="path" id="path" value="<?php echo $_SESSION['path']; ?>" />
<input type="hidden" name="pilgrim_id" id="pilgrim_id" value="<?php echo $pilgrim_id; ?>" />
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
    <td><?php echo $row['full_name']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Passport No</td>
    <td><?php echo $row['passport_no']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Flight ID <font color="#FF0000">*</font></td>
    <td>
      <label>
        <select name="allocation1" id="allocation1" onchange="getdetails(this.value,1); return false;" class="input-medium" >
        <option value="">Select</option>
        <?php foreach($flight_data as $val){ ?>
        <option value="<?php echo $val['allocation_id']; ?>"><?php echo $val['flight_no']; ?></option>
        <?php } ?>
        </select>
      </label></td>
    <td><div id="error_allocation1"></div></td>
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
    <td colspan="3"><div id="show_details_1"></div></td>
  </tr>
<?php if($_SESSION['path']==2){ ?>  
  <tr>
    <td>Flight ID ( Return)<font color="#FF0000">*</font></td>
    <td><label>
      <select name="allocation2" id="allocation2" onchange="getdetails(this.value,2); return false;" class="input-medium" >
          <option value="">Select</option>
       <?php foreach($flight_data as $val){ ?>
        <option value="<?php echo $val['allocation_id']; ?>"><?php echo $val['flight_no']; ?></option>
        <?php } ?>
     </select>
    </label></td>
    <td><div id="error_allocation2"></div></td>
  </tr>
  <tr>
    <td>Booking Status</td>
    <td><select name="bstatus2" size="1" id="bstatus2" class="input-medium">
      <option value="CONFIRMED">CONFIRMED</option>
      <option value="WAITING">WAITING</option>
      <option value="OK">OK</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
<!--  <tr>
    <td>Bag</td>
    <td><select name="weight2" size="1" id="weight2" class="input-medium">
      <option value="30">30</option>
      <option value="40">40</option>
      <option value="50">50</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
-->  <tr>
    <td>Class</td>
    <td><select name="class2" size="1" id="class2" class="input-medium">
      <option value="ECONOMY">ECONOMY</option>
      <option value="FIRST">FIRST</option>
      <option value="BUSINESS">BUSINESS</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><div id="show_details_2"></div></td>
  </tr>
<?php  } ?>  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><label>
      <input type="submit" name="button" id="button" value="Generate Eticket" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
</table>





</form>        
        
        
        
        
<div id="create_pilgrim_table">        
		<?php // include('../ajax/agency_flight_table.php'); ?>
</div>        
	</td>
	<td>
       <?php include('../common/user_latestactivity.php'); ?>
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