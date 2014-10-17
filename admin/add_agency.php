<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/commonadmin_menu.php');
?>
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Agency Management</h1></div>

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
        <form action="../action/agency_transact.php?action=<?php if(isset($_REQUEST['agency_id'])){ echo "edit";}else { echo "add"; }?>" method="post" enctype="multipart/form-data" name="form1">
<?php if(isset($_REQUEST['agency_id']))
{	
	$db= new Database();
	$run = $db->query("SELECT * FROM agency WHERE agency_id='".$_REQUEST['agency_id']."'");
	if($db->total()>0)
	{
		$row = $db->fetch($run);
	}
	echo "<input type='hidden' name='agency_id' value='".$_REQUEST['agency_id']."'>";
}
?>
        
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
  	<tr>
		<th valign="top">Agency Name:</th>
		<td><input name="agency_name" type="text" class="input-medium" id="agency_name" <?php if(isset($_REQUEST['agency_id'])){ echo "value='". $row['agency_name']."'";} ?> /></td>
		<td></td>
	</tr> 
	<tr>
		<th valign="top">Admin Name:</th>
		<td><input name="admin_name" type="text" class="input-medium" id="admin_name" <?php if(isset($_REQUEST['agency_id'])){ echo "value='". $row['agency_adminname']."'";} ?> /></td>
		<td></td>
	</tr>
	<tr>
		<th valign="top">Address:</th>
		<td><textarea name="address" cols="" rows="" class="form-textarea" id="address"><?php if(isset($_REQUEST['agency_id'])){ echo $row['agency_address'];} ?></textarea></td>
		<td></td>
	</tr>
	<tr>
	    <th valign="top">Phone No:</th>
		<td><input name="mno" type="text" class="input-medium" id="mno" <?php if(isset($_REQUEST['agency_id'])){ echo "value='". $row['agency_phoneno']."'";} ?> /></td>
		<td></td>
	</tr>
	<tr>
	    <th valign="top">Website Url:</th>
		<td><input name="url" type="text" class="input-medium" id="url"  <?php if(isset($_REQUEST['agency_id'])){ echo "value='". $row['agency_url']."'";} ?>  /></td>
		<td></td>
	</tr>
	<tr>
      <th>Logo:</th>
      <td><label>
        <input type="file" name="agencys_image" id="agencys_image" >
        </label></td>
  
      <td>
      <div class="bubble-left"></div>
      <div class="bubble-inner">JPEG, GIF 5MB max per image</div>
      <div class="bubble-right"></div>
      </td>
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
	<div id="related-activities">
		
		<!--  start related-act-top -->
		<div id="related-act-top">
		<img src="../images/forms/header_related_act.gif" width="271" height="43" alt="" />
		</div>
		<!-- end related-act-top -->
		
		<!--  start related-act-bottom -->
		<div id="related-act-bottom">
		
			<!--  start related-act-inner -->
			<div id="related-act-inner">
			
				<div class="left"><a href=""><img src="../images/forms/icon_plus.gif" width="21" height="21" alt="" /></a></div>
				<div class="right">
					<h5>Add another product</h5>
					Lorem ipsum dolor sit amet consectetur
					adipisicing elitsed do eiusmod tempor.
					<ul class="greyarrow">
						<li><a href="">Click here to visit</a></li> 
						<li><a href="">Click here to visit</a> </li>
					</ul>
				</div>
				
				<div class="clear"></div>
				<div class="lines-dotted-short"></div>
				
				<div class="left"><a href=""><img src="../images/forms/icon_minus.gif" width="21" height="21" alt="" /></a></div>
				<div class="right">
					<h5>Delete products</h5>
					Lorem ipsum dolor sit amet consectetur
					adipisicing elitsed do eiusmod tempor.
					<ul class="greyarrow">
						<li><a href="">Click here to visit</a></li> 
						<li><a href="">Click here to visit</a> </li>
					</ul>
				</div>
				
				<div class="clear"></div>
				<div class="lines-dotted-short"></div>
				
				<div class="left"><a href=""><img src="../images/forms/icon_edit.gif" width="21" height="21" alt="" /></a></div>
				<div class="right">
					<h5>Edit categories</h5>
					Lorem ipsum dolor sit amet consectetur
					adipisicing elitsed do eiusmod tempor.
					<ul class="greyarrow">
						<li><a href="">Click here to visit</a></li> 
						<li><a href="">Click here to visit</a> </li>
					</ul>
				</div>
				<div class="clear"></div>
				
			</div>
			<!-- end related-act-inner -->
			<div class="clear"></div>
		
		</div>
		<!-- end related-act-bottom -->
	
	</div>
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