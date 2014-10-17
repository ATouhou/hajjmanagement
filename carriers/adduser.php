<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_carriers_users.php');
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
<form  name="regisfrm" method="post" enctype="multipart/form-data" action="../action/user_transact.php?action=<?php if(isset($_REQUEST['user_id'])){ echo "edit";}else { echo "add"; }?>" id="regisfrm" onSubmit="return checkfrm(this);" >

<?php if(isset($_REQUEST['user_id']))
{
	$db= new Database();
	$run = $db->query("SELECT * FROM users WHERE uid='".$_REQUEST['user_id']."'");
	if($db->total()>0)
	{
		$row = $db->fetch($run);
	}
	echo "<input type='hidden' name='user_id' value='".$_REQUEST['user_id']."'>";
	echo "<input type='hidden' name='eid' value='".$row['eid']."'>";
}

?>
<input type="hidden" name="category" id="category" value="<?php echo $_SESSION['cid']; ?>" />
<input type="hidden" name="agency_id" id="agency_id" value="<?php echo $_SESSION['agency_id']; ?>" />
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
  <tr>
    <th valign="top">Employee ID:</th>
    <td><?php if(isset($_REQUEST['user_id'])){ echo $row['eid'];}else{ ?><input type="hidden" name="eid" id="eid" value="<?php echo generateeid(); ?>" /><?php echo generateeid(); } ?> </td>
    <td></td>
  </tr>
	    <tr>
			<th valign="top">Full Name:</th>
			<td><input name="full_name" type="text" class="input-medium" id="full_name" <?php if(isset($_REQUEST['user_id'])){ echo "value='". $row['name']."'";} ?> /></td>
			<td><div id="error_full_name"></div></td>
		</tr> 
		<tr>
		  <th valign="top">User Name:</th>
		  <td><input name="username" type="text" class="input-medium" id="username" <?php if(isset($_REQUEST['user_id'])){ echo "value='". $row['username']."'";} ?> /></td>
		  <td><div id="error_username"></div></td>
		  </tr>	
	    <tr>
	      <th valign="top">Password:</th>
	      <td><input name="password" type="password" class="input-medium" id="password" <?php if(isset($_REQUEST['user_id'])){ echo "value='". $row['password']."'";} ?> /></td>
	      <td><div id="error_password"></div></td>
	      </tr>
	    <tr>
	      <th valign="top">Confirm Password:</th>
	      <td><input name="cpassword" type="password" class="input-medium" id="cpassword" <?php if(isset($_REQUEST['user_id'])){ echo "value='". $row['password']."'";} ?> /></td>
	      <td><div id="error_cpassword"></div></td>
	      </tr>
	    <tr>
	      <th>Image :</th>
	      <td><label>
	        <input type="file" name="users_image" id="users_image" />
	        </label></td>
	      <td><div class="bubble-left"></div>
	        <div class="bubble-inner">JPEG, GIF 5MB max per image</div>
	        <div class="bubble-right"></div></td>
	      <!--	</tr>
	    <tr>
			<th valign="top">Agency Name:</th>
			<td><select name="agency" class="input-medium" id="agency" />
            	      		<option value="">Select Agency</option>
<?php 
//		$agency_data = array();
//		foreach($_SESSION['agency'] as $val=>$key)
//		{
//			if(isset($_REQUEST['pilgrim_id']) && ($key['agency_id']==$row['agency']))
//			{
//				$val ='selected="selected"';			
//			}
//			
//			
//			
//			echo '<option value='.$key['agency_id'].' '.$val.'>'.$key['agency_name'].'</option>';
//		}
?>
            </td>
			<td></td>
		</tr> -->
	      <input type="hidden" name="agency" id="agency" value="0" />
	      <!--	<tr>
	  <th>State</th>
	  <td><input name="state" id="state" class="input-medium" /></td>
	  <td>&nbsp;</td>
    </tr>-->
	      </tr>
<!--	<tr>
	  <th>State</th>
	  <td><input name="state" id="state" class="input-medium" /></td>
	  <td>&nbsp;</td>
    </tr>-->
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