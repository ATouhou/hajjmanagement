<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_carriers_common.php');
if(!isset($_SESSION['category']))
{
	$db = new Database();
	$_SESSION['category'] = array();
	$db_run = $db->query("SELECT * FROM category ORDER BY cname");
	while($db_row = $db->fetch($db_run))
	{
		$_SESSION['category'][] = $db_row;
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

function enableButton()
{
	document.getElementById('amount').disabled = false;	
	document.getElementById('luggage').disabled = false;
	document.getElementById('save').disabled = false;
	document.getElementById('edit').disabled = true;
}

function saveValue()
{
	var amount = document.getElementById('amount').value;	
	var luggage = document.getElementById('luggage').value;
	if(amount=='')
	{
		document.getElementById('error_amount').innerHTML='<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
		document.getElementById('amount').focus();
	}else{
	  if(luggage=='')
	  {
		  document.getElementById('error_amount').innerHTML='';
		  document.getElementById('error_luggage').innerHTML='<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
		  document.getElementById('luggage').focus();
	  }
	}
// CALL THE AJAX AND SAVE THE VALUE	
	
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
		  document.getElementById("message").innerHTML=xmlhttp.responseText;
		  document.getElementById('amount').disabled = true;	
		  document.getElementById('luggage').disabled = true;
		  document.getElementById('save').disabled = true;
		  document.getElementById('edit').disabled = false;		   
	   }
   }
	xmlhttp.open("GET","../ajax/savecarriersettings.php?amount="+amount+"&luggage="+luggage,true);
	xmlhttp.send();


	
	
}


</script> 
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">

<div id="page-heading"><h1>User Management</h1></div>


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
			<div class="step-dark-left"><a href="">User details</a></div>
			<div class="step-dark-right">&nbsp;</div>
			<div class="step-no-off">2</div>
			<div class="step-light-left">Preview</div>
			<div class="step-light-round">&nbsp;</div>
			<div class="clear"></div>
		</div>
		<!--  end step-holder -->
	
		<!-- start id-form -->
        
        
<div id="message"></div>        
<?php 
	$db= new Database();
	$run = $db->query("SELECT * FROM carriers WHERE carriers_id='".$_SESSION['agency_id']."'");
	if($db->total()>0)
	{
		$row = $db->fetch($run);
		$amount = $row['amount'];
		$luggage = $row['weight'];
	}else{
		$amount =0;
		$luggage =0;
	}

?>
<input type="hidden" name="category" id="category" value="<?php echo $_SESSION['cid']; ?>" />
<input type="hidden" name="agency_id" id="agency_id" value="<?php echo $_SESSION['agency_id']; ?>" />
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
	    <tr>
			<th valign="top">Amount Charge:</th>
			<td><input name="amount" type="text" class="input-medium" id="amount" disabled="disabled" value="<?php echo $amount; ?>" /> Naira/ Kg</td>
			<td><div id="error_amount"></div></td>
		</tr> 
		<tr>
		  <th valign="top">Maximum Luggage:</th>
		  <td><input name="luggage" type="text" class="input-medium" id="luggage"  disabled="disabled" value="<?php echo $luggage; ?>"  /> Kg</td>
		  <td><div id="error_luggage"></div></td>
		  </tr>	
	<tr>
	  <th>&nbsp;</th>
	  <td valign="top">
	    <input type="button" value="Save" name="save" id="save" disabled="disabled" style="padding:5px; width:80px;" onclick="saveValue();" />
	    <input type="button" value="Edit" name="edit" id="edit" style="padding:5px; width:80px;" onclick="enableButton();" />
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