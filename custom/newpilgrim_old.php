<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_agency_pilgrim.php');
	$db = new Database();

if(!isset($_SESSION['state']))
{
	$_SESSION['state'] = array();
	$db_run = $db->query("SELECT * FROM state ORDER BY state_name");
	while($db_row = $db->fetch($db_run))
	{
		$_SESSION['state'][] = $db_row;
	}
}
	$db_run = $db->query("SELECT agency_name FROM agency WHERE agency_id='".$_SESSION['agency_id']."' ");
	$db_row = $db->fetch($db_run);
	$agency_name = $db_row['agency_name'];

if(!isset($_SESSION['lga']))
{
	$_SESSION['lga'] = array();
	$db_run = $db->query("SELECT * FROM lga ORDER BY lga_name");
	while($db_row = $db->fetch($db_run))
	{
		$_SESSION['lga'][] = $db_row;
	//	$_SESSION['state']['state_name'][]= $db_row['state_name'];
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


</script> 
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>New Pilgrim</h1></div>


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
			<div class="step-dark-left"><a href="">Pilgrim details</a></div>
			<div class="step-dark-right">&nbsp;</div>
			<div class="step-no-off">2</div>
			<div class="step-light-left">Preview</div>
			<div class="step-light-round">&nbsp;</div>
			<div class="clear"></div>
		</div>
		<!--  end step-holder -->
	
		<!-- start id-form -->
<form  name="regisfrm" method="post" enctype="multipart/form-data" action="../action/pilgrim_transact.php?action=<?php if(isset($_REQUEST['pilgrim_id'])){ echo "edit";}else { echo "add"; }?>" id="regisfrm"  >

<?php if(isset($_REQUEST['pilgrim_id']))
{	
	$db= new Database();
	$run = $db->query("SELECT * FROM pilgrims WHERE pilgrim_id='".$_REQUEST['pilgrim_id']."'");
	if($db->total()>0)
	{
		$row = $db->fetch($run);
	}
	echo "<input type='hidden' name='pilgrim_id' value='".$_REQUEST['pilgrim_id']."'>";
}
?>
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
	    <tr>
			<th valign="top">Agency:</th>
			<td><?php echo $agency_name; ?>       <input type="hidden" name="agency" id="agency" value="<?php echo $_SESSION['agency_id']; ?>" />    </td>
			<td></td>
		</tr> 
	    <tr>
			<th valign="top">Full Name:</th>
			<td><input name="full_name" type="text" class="input-medium" id="full_name" <?php if(isset($_REQUEST['pilgrim_id'])){ echo "value='". $row['full_name']."'";} ?> /></td>
			<td></td>
		</tr> 
		<tr>
		  <th valign="top">Passport No:</th>
		  <td><input name="passport_no" type="text" class="input-medium" id="passport_no" <?php if(isset($_REQUEST['pilgrim_id'])){ echo "value='". $row['passport_no']."'";} ?> /></td>
		  <td></td>
		  </tr>
	<tr>
	<th>Image :</th>
	<td><label>
	  <input type="file" name="pilgrims_image" id="pilgrims_image" >
	  </label></td>

	<td>
	<div class="bubble-left"></div>
	<div class="bubble-inner">JPEG, GIF 5MB max per image</div>
	<div class="bubble-right"></div>
	</td>
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
 	<tr>
	  <th>State</th>
	  <td><select name="state" id="state" class="input-medium" onchange="getlga(this.value);" >
      		<option value="">Select State</option>
<?php 
		$state_data = array();
		foreach($_SESSION['state'] as $val=>$key)
		{	
			$val = '';
			if(isset($_REQUEST['pilgrim_id']) && ($key['state_id']==$row['state']))
			{
				$val ='selected="selected"';			
			}
			
			echo '<option value='.$key['state_id'].' '.$val.'>'.$key['state_name'].'</option>';
		}
?>
	</select>      
      </td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <th>Lga</th>
	  <td>
      <div id="display_lga">
      <select name="lga" id="lga" class="input-medium">
      <?php if(isset($_REQUEST['pilgrim_id'])){
		foreach($_SESSION['lga'] as $val=>$key)
		{
			if($key['state_id']==$row['state'])
			{	
				$val = '';	
				if($key['lga_id']==$row['lga'])
				{
				$val ='selected="selected"';			
			}
				echo '<option value='.$key['lga_id'].' '.$val.'>'.$key['lga_name'].'</option>';
			}
		}
		}else{ ?>
      		<option value="">Select Lga</option>
      <?php } ?>     
      </select>      
      </div>
      </td>
	  <td>&nbsp;</td>
	  </tr>
    <tr>
    </tr>
	<tr>
	  <th>Nationaility</th>
	  <td><select name="nationality" id="nationality" class="input-medium">
<?php  for($n=0; $n<count($_SESSION['nationality']);$n++){ if($_SESSION['nationality'][$n]=='Nigerian'){ $sel = 'selected="selected"';}else{ $sel='';} ?>
			<option value="<?php echo $_SESSION['nationality'][$n]; ?>" <?php echo $sel; ?> ><?php echo $_SESSION['nationality'][$n]; ?></option>
<?php } ?>
	    </select>
	  </label></td>
	  <td>&nbsp;</td>
	  </tr>
	<tr>
	  <th>Passenger Status</th>
	  <td><select name="pilgrim_status" id="pilgrim_status" class="input-medium">
      		<option value="Adult" <?php if(isset($_REQUEST['pilgrim_id'])){ if($row['pilgrim_status']=='Adult'){   echo 'selected="selected"';}} ?>>Adult</option>
      		<option value="Child" <?php if(isset($_REQUEST['pilgrim_id'])){ if($row['pilgrim_status']=='Child'){   echo 'selected="selected"';}} ?>>Child</option>
      		<option value="Infant" <?php if(isset($_REQUEST['pilgrim_id'])){ if($row['pilgrim_status']=='Infant'){   echo 'selected="selected"';}} ?>>Infant</option>
          </select>
      </td>
	  <td>&nbsp;</td>
	</tr>
    <tr>
		<th valign="top">Birth Date:</th>
		<td class="noheight">
		<input name="dob" type="text" class="input-medium" id="datepicker" readonly="readonly" <?php if(isset($_REQUEST['pilgrim_id'])){ echo "value='". $row['dob']."'";} ?>>
		</td>
		<td>&nbsp;</td>
	</tr>
	    <tr>
			<th valign="top">Mobile No:</th>
			<td><input name="mno" type="text" class="input-medium" id="mno" <?php if(isset($_REQUEST['pilgrim_id'])){ echo "value='". $row['mno']."'";} ?> /></td>
			<td></td>
		</tr>     
	<tr>
	  <th>Gender</th>
	  <td>
		<select name="sex"  class="styledselect-medium">
			<option value="Male" <?php if(isset($_REQUEST['pilgrim_id'])){ if($row['sex']=='Male'){   echo 'selected="selected"';}} ?>>Male</option>
			<option value="Female" <?php if(isset($_REQUEST['pilgrim_id'])){ if($row['sex']=='Female'){   echo 'selected="selected"';}} ?>>Female</option>
		</select>
	  </td>
	  <td>&nbsp;</td>
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