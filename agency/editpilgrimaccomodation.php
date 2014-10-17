<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/agency_accomodation_menu.php');
$db= new Database();
$run = $db->query("SELECT manifest_id FROM accomodation_manifest WHERE accomodation_id='".base64_decode($_REQUEST['id'])."'");
$total = $db->total();
$run = $db->query("SELECT * FROM accomodation WHERE id='".base64_decode($_REQUEST['id'])."'");
$row = $db->fetch($run);

?>
 <script type="text/javascript">

function deleteRow(manifestId) {
			var res = window.confirm('Passenger will be deleted from the Vehicle'); 
			if(res==true){
			
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
							var row = document.getElementById(manifestId);
						    row.parentNode.removeChild(row);
					}
				  }
				xmlhttp.open("GET","../ajax/deletepilgrimaccomodationmanifest.php?manifestId="+manifestId,true);
				xmlhttp.send();		
			}
}


 </script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Edit Accomodation Manifest</h1></div>


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
          <th class="table-header-repeat line-left" ><a href="#">Accomodation Durtaion</a></th>
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
    		<td><?php echo $row['capacity']-$total==0?'Full':$row['capacity']-$total; ?></td>
		  </tr>
        </tbody>  
</table>
<input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo base64_decode($_REQUEST['id']); ?>" />        

<div id="create_pilgrim_table">        
		<?php include('../ajax/agency_edit_accomodation_manifest_table.php'); ?>
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