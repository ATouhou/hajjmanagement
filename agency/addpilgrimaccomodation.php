<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/agency_accomodation_menu.php');
$db= new Database();
$run = $db->query("SELECT id FROM accomodation WHERE id='".base64_decode($_REQUEST['id'])."'");
$total = $db->total();


$run = $db->query("SELECT * FROM accomodation WHERE id='".base64_decode($_REQUEST['id'])."'");
$row = $db->fetch($run);

?>
 <script type="text/javascript">

function getpassportrecord()
{
	var passportno = document.getElementById('passportno').value;
	if(passportno==''){
		return false;	
	}

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
		 document.getElementById("displaypassport").innerHTML=xmlhttp.responseText;
	 }
  }
  	xmlhttp.open("GET","../ajax/getaccomodationpassportrecord.php?passportno="+passportno,true);
	xmlhttp.send();
}

function checkfrm(){
	var bed_no = document.getElementById('bed_no').value;
	if(bed_no==''){
		document.getElementById("bed_no_error").innerHTML='<table border="0" width= "850 " cellpadding= "0 " cellspacing= "0"><tr><td class="red-left">Please Enter Bed No</td><td class="red-right"><a class="close-red"><img src="../images/table/icon_close_red.gif"   alt="" /></a></td></tr></table><br>';		
		return false;
		
	}
	
	
}

 </script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Create Accomodation Manifest</h1></div>


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
        <?php notification(); ?>
			<h3>Accomodation Details</h3>
        
<table width="800" id="product-table">
		<thead>
        <tr>
          <th class="table-header-repeat line-left" ><a href="#">Name</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Accomodation Duration</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Phone No</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Address</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Capacity</a></th>
	    </tr>
        </thead>
        <tbody>
		  <tr>
    		<td><?php echo $row['name']; ?></td>
    		<td><?php echo $row['email_id']; ?></td>
    		<td><?php echo $row['phone_no']; ?></td>
    		<td><?php echo $row['address']; ?></td>
    		<td><?php echo $row['capacity']; ?></td>
		  </tr>
        </tbody>  
</table>
        
<form  name="regisfrm" method="post" enctype="multipart/form-data" action="#" id="regisfrm" onSubmit="return checkfrm(this);" >

<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
  <tr>
    <th valign="top">Passport No:</th>
    <td><input type="text" name="passportno" id="passportno" value="" class="input-medium"  /></td>
    <td><div id="error_eticket"></div></td>
  </tr>
  <tr>
    <th valign="top">&nbsp;</th>
    <td><input type="button" name="search" id="search" value="Search" style="padding:5px;"  onclick="getpassportrecord();"/></td>
    <td><div id="error_eticket"></div></td>
  </tr>
</table>
</form>            

<form  name="regisfrm" method="post" enctype="multipart/form-data" action="../action/accomodation_manifest.php?action=add" id="regisfrm" onSubmit="return checkfrm(this);" >
<input type="hidden" name="id" id="id" value="<?php echo base64_decode($_REQUEST['id']); ?>" />
<input type="hidden" name="capacity" id="capacity" value="<?php echo $row['capacity']; ?>" />
			
<div id="displaypassport"></div>            
</form>
	</td>
	<td>
       <?php  include('../common/accomodation_latestactivity.php'); ?>
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