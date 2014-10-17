<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/commonadmin_menu.php');
?>
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Carriers Management</h1></div>

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
	
		<!-- start id-form -->
        <form action="../action/carriers_transact.php?action=<?php if(isset($_REQUEST['carriers_id'])){ echo "edit";}else { echo "add"; }?>" method="post" enctype="multipart/form-data" name="form1">
<?php if(isset($_REQUEST['carriers_id']))
{	
	$db= new Database();
	$run = $db->query("SELECT * FROM carriers WHERE carriers_id='".$_REQUEST['carriers_id']."'");
	if($db->total()>0)
	{
		$row = $db->fetch($run);
	}
	echo "<input type='hidden' name='carriers_id' value='".$_REQUEST['carriers_id']."'>";
}
?>
        
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
  	<tr>
		<th valign="top">Carriers Name:</th>
		<td><input name="carriers_name" type="text" class="input-medium" id="carriers_name" <?php if(isset($_REQUEST['carriers_id'])){ echo "value='". $row['carriers_name']."'";} ?> /></td>
		<td></td>
	</tr> 
	<tr>
		<th valign="top">Admin Name:</th>
		<td><input name="admin_name" type="text" class="input-medium" id="admin_name" <?php if(isset($_REQUEST['carriers_id'])){ echo "value='". $row['carriers_adminname']."'";} ?> /></td>
		<td></td>
	</tr>
	<tr>
	  <th valign="top">IATA Code</th>
	  <td><label>
	    <input type="text" name="iata_code" class="input-medium" id="iata_code" <?php if(isset($_REQUEST['carriers_id'])){ echo "value='". $row['iata_code']."'";} ?> />
	  </label></td>
	  <td></td>
	  </tr>
	<tr>
		<th valign="top">Address:</th>
		<td><textarea name="address" cols="" rows="" class="form-textarea" id="address"><?php if(isset($_REQUEST['carriers_id'])){ echo $row['carriers_address'];} ?></textarea></td>
		<td></td>
	</tr>
	<tr>
	    <th valign="top">Phone No:</th>
		<td><input name="mno" type="text" class="input-medium" id="mno" <?php if(isset($_REQUEST['carriers_id'])){ echo "value='". $row['carriers_phoneno']."'";} ?> /></td>
		<td></td>
	</tr>
	<tr>
	    <th valign="top">Website Url:</th>
		<td><input name="url" type="text" class="input-medium" id="url" <?php if(isset($_REQUEST['carriers_id'])){ echo "value='". $row['carriers_url']."'";} ?> /></td>
		<td></td>
	</tr>
	<tr>
      <th>Logo:</th>
      <td><label>
        <input type="file" name="carriers_image" id="carrierss_image" >
        </label></td>
  
      <td>
      <div class="bubble-left"></div>
      <div class="bubble-inner">JPEG, GIF 5MB max per image</div>
      <div class="bubble-right"></div>
      </td>
	</tr>
	<tr>
	  <th>Terms &amp; Conditions</th>
	  <td><label>
	    <textarea name="tc" id="tc" cols="45" rows="5"><?php if(isset($_REQUEST['carriers_id'])){ echo $row['terms_conditions']; } ?></textarea>
	    </label></td>
	  <td>&nbsp;</td>
	  </tr>
	<tr>
	  <th>Validity</th>
	  <td valign="top"><label>
	    <input type="text" name="validity" id="validity" class="input-medium" <?php if(isset($_REQUEST['carriers_id'])){ echo "value='". $row['validity']."'";} ?> />
	    </label></td>
	  <td></td>
	  </tr>
	<tr>
	  <th>Email</th>
	  <td valign="top"><label>
	    <input type="text" name="email" id="email" class="input-medium" <?php if(isset($_REQUEST['carriers_id'])){ echo "value='". $row['email']."'";} ?> />
	    </label></td>
	  <td></td>
	  </tr>
	<tr>
	  <th>Weight</th>
	  <td valign="top"><label>
	    <input type="text" name="weight" id="weight" class="input-medium" <?php if(isset($_REQUEST['carriers_id'])){ echo "value='". $row['weight']."'";} ?> />in KG
	  </label></td>
	  <td></td>
	  </tr>
	<tr>
	  <th>&nbsp;</th>
	  <td valign="top">&nbsp;</td>
	  <td></td>
	  </tr>
	<tr>
	  <th>&nbsp;</th>
	  <td valign="top">
	    <input type="submit" value="submit" class="form-submit" />
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