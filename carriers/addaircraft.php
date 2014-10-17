<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_carriers_common.php');


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


<div id="page-heading"><h1>New Aircraft</h1></div>


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
<a href="<?php echo $_SESSION['basemodule'].'aircraft.php'; ?>"><h3>Back</h3></a>
	
		<!--  start step-holder -->
		<div id="step-holder">
			<div class="step-no">1</div>
			<div class="step-dark-left"><a href="">Aircraft details</a></div>
			<div class="step-dark-right">&nbsp;</div>
			<div class="step-no-off">2</div>
			<div class="step-light-left">Choose Seat</div>
			<div class="step-light-round">&nbsp;</div>
			<div class="clear"></div>
		</div>
		<!--  end step-holder -->
	
		<!-- start id-form -->
        
<form  name="regisfrm" method="post" enctype="multipart/form-data" action="../action/aircraft_transact.php?action=<?php if(isset($_REQUEST['aircraft_id'])){ echo "edit";}else { echo "add"; }?>" id="regisfrm" >
<?php if(isset($_REQUEST['aircraft_id']))
{	
	$db= new Database();
	$run = $db->query("SELECT * FROM aircraft WHERE aircraft_id='".$_REQUEST['aircraft_id']."' AND agency_id='".$_SESSION['agency_id']."'");
	if($db->total()>0)
	{ 
		$row = $db->fetch($run);
	}
	echo "<input type='hidden' name='aircraft_id' value='".$_REQUEST['aircraft_id']."'>";
}
?>
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
	    <tr>
			<th valign="top">Aircraft Model:</th>
			<td><input name="model" type="text" class="input-medium" id="model" <?php if(isset($_REQUEST['aircraft_id'])){ echo "value='". $row['model']."'";} ?> /></td>
			<td></td>
		</tr> 
		<tr>
		  <th valign="top">Aircraft Manufacturer:</th>
		  <td><input name="manufacturer" type="text" class="input-medium" id="manufacturer" <?php if(isset($_REQUEST['aircraft_id'])){ echo "value='". $row['manufacturer']."'";} ?> /></td>
		  <td></td>
		  </tr>
		<tr>
	  <th>Number of Rows</th>
	  <td><label>
	    <input type="text" name="nor" id="nor" class="input-medium" <?php if(isset($_REQUEST['aircraft_id'])){ echo "value='". $row['nor']."'";} ?>  />
	    </label></td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <th>Number of Colums</th>
	  <td>
      <div id="display_lga">
        <label>
          <input type="text" name="noc" id="noc" class="input-medium" <?php if(isset($_REQUEST['aircraft_id'])){ echo "value='". $row['noc']."'";} ?>  />
        </label>
      </div>
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