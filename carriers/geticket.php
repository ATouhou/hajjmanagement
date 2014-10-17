<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/carriers_menu.php');
if(isset($_SESSION['passport_no'])){ unset($_SESSION['passport_no']);}

?>
 <script type="text/javascript">
function checkfrm(f)
{
	var passport_no = document.getElementById('passport_no').value;
	if(passport_no=='')
	{
			document.getElementById('error_passport').innerHTML= '<div class=\"error-left\"></div><div class=\"error-inner\">This field is required.</div>';
			f.passport_no.focus();
		return false;
	}
	
}
 </script>
<!-- start content-outer -->

<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Generate Duplicate Eticket</h1></div>


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
	<td valign="top">
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td valign="top">
        <?php notification(); ?>   
<form action="../action/eticket_check.php" method="post" onsubmit="return checkfrm(this);">
<table width="850" id="id-form">
  <tr>
    <td width="220"><strong>Enter Passport Number</strong></td>
    <td><label>
      <input name="passport_no" type="text" class="input-medium" id="passport_no" maxlength="20" />
    </label></td>
    <td><div id="error_passport"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Submit" class="form-submit" /></td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>        
        
        
        
        
<div id="create_pilgrim_table">        
		<?php // include('../ajax/agency_flight_table.php'); ?>
</div>        
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