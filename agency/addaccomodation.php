<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/agency_menu.php');

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
xmlhttp.open("GET","../ajax/getmovementdestination.php?value="+source_id,true);
xmlhttp.send();
	}
}

function isNumericKey(e)
{
    if (window.event) { var charCode = window.event.keyCode; }
    else if (e) { var charCode = e.which; }
    else { return true; }
    if (charCode > 31 && (charCode < 48 || charCode > 57)) { return false; }
    return true;
}
function checkfrm(f)
{
//var reg_email =new RegExp("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})/");
var name = document.getElementById('name').value;
var capacity = document.getElementById('capacity').value;
var address = document.getElementById('address').value;
var phone_no = document.getElementById('phone_no').value;
var email_id = document.getElementById('email_id').value;
		if(name=='')
		{
			document.getElementById('error_name').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.name.focus();
			return false;
		}else
		{
			document.getElementById('error_name').innerHTML='';		
		}
		if(capacity=='')
		{
			document.getElementById('error_capacity').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.capacity.focus();
			return false;
		}else
		{
			document.getElementById('error_capacity').innerHTML='';		
		}
		if(address=='')
		{
			document.getElementById('error_address').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.address.focus();
			return false;
		}else
		{
			document.getElementById('error_address').innerHTML='';		
		}
		if(phone_no=='')
		{
			document.getElementById('error_phone_no').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.phone_no.focus();
			return false;
		}else
		{
			document.getElementById('error_phone_no').innerHTML='';		
		}
		if(email_id=='')
		{
			document.getElementById('error_email_id').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.email_id.focus();
			return false;
		}else
		{
			document.getElementById('error_email_id').innerHTML='';		
		}
}

</script> 
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">

<div id="page-heading"><h1>Accomodation Management</h1></div>


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
	<a href="accomodation.php"><h3>Back</h3></a>
	
		<!--  start step-holder -->
		<div id="step-holder">
			<div class="step-no">1</div>
			<div class="step-dark-left"><a href="">Accomodation Detail</a></div>
			<div class="step-dark-round">&nbsp;</div>
			<div class="clear"></div>
		</div>
		<!--  end step-holder -->
	
		<!-- start id-form -->
<form  name="regisfrm" method="post" enctype="multipart/form-data" action="../action/accomodation_transact.php?action=<?php if(isset($_REQUEST['id'])){ echo "edit";}else { echo "add"; }?>" id="regisfrm" onSubmit="return checkfrm(this);" >

<?php if(isset($_REQUEST['id']))
{
	$db= new Database();
	$run = $db->query("SELECT * FROM accomodation WHERE id='".base64_decode($_REQUEST['id'])."'");
	if($db->total()>0)
	{
		$row = $db->fetch($run);
	}
	echo "<input type='hidden' name='id'  value='".base64_decode($_REQUEST['id'])."'>";

}

?>
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
	    <tr>
			<th valign="top">Agency:</th>
			<td><input type="text" readonly="readonly" class="input-medium" disabled="disabled" name="agency_id" id="agency_id" value="<?php echo getstatename($_SESSION['agency_id']); ?>" /></td>
			<td><div id="error_full_name"></div></td>
		</tr> 
	    <tr>
			<th valign="top">Name:</th>
			<td><input name="name" type="text" class="input-medium" id="name" <?php if(isset($_REQUEST['id'])){ echo "value='". $row['name']."'";} ?> /></td>
			<td><div id="error_name"></div></td>
		</tr> 
		<tr>
		  <th valign="top">Capaity:</th>
		  <td><input name="capacity" type="text" class="input-medium" id="capacity" <?php if(isset($_REQUEST['id'])){ echo "value='". $row['capacity']."'";} ?>  onkeypress="return isNumericKey(event);" />
            </td>
		  <td><div id="error_capacity"></div></td>
		  </tr>	
	    <tr>
			<th valign="top">Address:</th>
			<td><textarea name="address" id="address" class="form-textarea" ><?php if(isset($_REQUEST['id'])){ echo $row['address'];} ?></textarea>
            </td>
			<td><div id="error_address"></div></td>
		</tr> 
	    <tr>
			<th valign="top">Phone No:</th>
			<td><input name="phone_no" type="text" class="input-medium" id="phone_no" <?php if(isset($_REQUEST['id'])){ echo "value='". $row['phone_no']."'";} ?> onkeypress="return isNumericKey(event);" /></td>
			<td><div id="error_phone_no"></div></td>
		</tr> 
   	    <tr>
			<th valign="top">Accomodation Duration:</th>
			<td><input name="email_id" type="text" class="input-medium" id="email_id" <?php if(isset($_REQUEST['id'])){ echo "value='". $row['email_id']."'";} ?> /> Days
			</td>
			<td><div id="error_email_id"></div></td>
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