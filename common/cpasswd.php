<?php
include("functions.php");
include("header.php");

switch($_SESSION['cid'])
{
	case '1' :	
		$menu_link = '../menu/commonadmin_menu.php';
	break;
	case '2' :	
		$menu_link = '../menu/menu_carriers_common.php';
	break;
	case '3' :	
		$menu_link = '../menu/menu_agency_common.php';
	break;
	case '4' :	
		$menu_link = '../menu/menu_custom_common.php';
	break;
}
include($menu_link);
?>
<script type="application/javascript">
function checkfrm(f)
{
var email1 = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

//var email = document.getElementById('email').value;
var password = document.getElementById('password').value;
var npassword = document.getElementById('npassword').value;
var cnpassword = document.getElementById('cnpassword').value;



	if(f.password.value=='')
	{
			document.getElementById('error_password').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.password.focus();
			return false;
	
		
	}else
	{
		document.getElementById('error_password').innerHTML='';
	}
	if(npassword.length <6)
	{
			document.getElementById('error_npassword').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">Password should be minimum 6 characters long.</div>';
			f.npassword.focus();
			return false;
	
		
	}else
	{
		document.getElementById('error_npassword').innerHTML='';
	}	
	if(f.npassword.value!=f.cnpassword.value)
	{
			document.getElementById('error_cnpassword').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.cnpassword.focus();
			return false;
	
		
	}else
	{
		document.getElementById('error_cnpassword').innerHTML='';
	}

}
</script>
<script type="application/javascript">
function checkpasswd(val)
{
//alert('hello');
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
		//alert('final hello');

		if(xmlhttp.responseText=='0')
		{
    		document.getElementById("error_password").innerHTML='<div class=\"error-left\"></div><div class=\"error-inner\">Password does not match.</div>';
			document.getElementById('password').value='';
		}else
		{
    		document.getElementById("error_password").innerHTML='<font color="green">Matched</font>';
		}
    }
  }
xmlhttp.open("GET","../ajax/checkpassword.php?value="+val+"&t="+Math.random(),true);
xmlhttp.send();
}

</script>
<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Change Password</h1>
	</div>
	<!-- end page-heading -->

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
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">
            
            <?php notification(); ?>

           <?php // echo "The use is ".$_SESSION['name']; ?> 
          <form action="<?php echo BASEURL."action/cpasswd.php"; ?>" name="frm"  method="post" id="user-register"  onSubmit="return checkfrm(this);">

               <table width="0" border="0" id="id-form">
                <tr>
                  <th width="150">Old Password</th>
                  <td><input name="password" type="password" class="inp-form" id="password" onBlur="checkpasswd(this.value)" maxlength="32" /></td>
                  <td><div id="error_password"></div></td>
                </tr>
                <tr>
                  <th>New Password</th>
                  <td><input name="npassword" type="password" class="inp-form" id="npassword" maxlength="32" /></td>
                  <td><div id="error_npassword"></div></td>
                </tr>
                <tr>
                  <th>Confirm Password</th>
                  <td><input name="cnpassword" type="password" class="inp-form" id="cnpassword" maxlength="32" /></td>
                  <td><div id="error_cnpassword"></div></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input name="submit" type="submit" value="" class="form-submit" /></td>
                  <td>&nbsp;</td>
                </tr>
              </table>
              
		</form>                 







			
			</div>
			<!--  end table-content  -->
	
			<div class="clear"></div>
		 
		</div>
		<!--  end content-table-inner ............................................END  -->
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
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>






<?php include("footer.php"); ?>