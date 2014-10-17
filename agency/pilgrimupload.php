<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_agency_pilgrim.php');
if(!isset($_SESSION['state']))
{
	$db = new Database();
	$_SESSION['state'] = array();
	$db_run = $db->query("SELECT * FROM state ORDER BY state_name");
	while($db_row = $db->fetch($db_run))
	{
		$_SESSION['state'][] = $db_row;
	}
}
if(!isset($_SESSION['agency']))
{
	$db = new Database();
	$_SESSION['agency'] = array();
	$db_run = $db->query("SELECT agency_id,agency_name FROM agency ORDER BY agency_name");
	while($db_row = $db->fetch($db_run))
	{
		$_SESSION['agency'][] = $db_row;
	}
}
if(!isset($_SESSION['lga']))
{
	$db = new Database();
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


<div id="page-heading"><h1>CSV Upload </h1></div>


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
<!--		<div id="step-holder">
			<div class="step-no">1</div>
			<div class="step-dark-left"><a href="">Pilgrim details</a></div>
			<div class="step-dark-right">&nbsp;</div>
			<div class="step-no-off">2</div>
			<div class="step-light-left">Preview</div>
			<div class="step-light-round">&nbsp;</div>
			<div class="clear"></div>
		</div>
-->		<!--  end step-holder -->
	
		<!-- start id-form -->
        <?php notification(); ?>
<form  name="regisfrm" method="post" enctype="multipart/form-data" action="../action/uploadpilgrim_transact.php?action=<?php if(isset($_REQUEST['pilgrim_id'])){ echo "edit";}else { echo "add"; }?>" id="regisfrm"  >
<table>
  <tr>
    <th scope="row" colspan="3">Download Link</th>
  </tr>
  <tr>
    <th colspan="2" scope="row"><div id="icon" style="padding:4px;"><a href="../common/download.php?file=../excelsheet/pilgrim.csv" target="_blank"><img src="<?php echo BASEURL; ?>images/excel.png" width="64" /></a>csv link ( Click here )</a></div></th>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row">Upload File :</th>
    <td><label>
      <input type="file" name="pilgrimfile" id="pilgrimfile" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td><label>
      <input type="submit" name="submit" id="submit" value="Submit" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>

<?php // echo $_REQUEST['error_data']; $error_data[] = unserialize($_REQUEST['error_data']); print_r(unserialize($_REQUEST['error_data'])); ?>


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