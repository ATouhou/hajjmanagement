<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_carriers_reports.php');
if(isset($_REQUEST['id']))
{
	$db = new Database();
	$id = base64_decode($_REQUEST['id']);
}

$data = array();
$flight_id = $id;
//echo $flight_id;



?>
 <script type="text/javascript">
 function pagination(id,val)
{
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
		    document.getElementById('create_pilgrim_table').innerHTML=xmlhttp.responseText;
    }
  }
	xmlhttp.open("GET","../ajax/carrier_manifest_table.php?val="+val+"&id="+id,true);
xmlhttp.send();
}
/*******SCRIPT FOR CHAGNING THE STATUS OF PILGRIM********/
function getManifestTable(agency_id)
{
	var xmlhttp;
	var res =true;
	
	alert(agency_id);
//alert('hello');
//alert(user_id);
//alert(user_status);
//alert(action);
	if(action=='status')
	{
		if(user_status=='Active')
		{
			 res = window.confirm('Deactivate User Status.\n    Are you sure?');
		}else
		{
			 res = window.confirm('Activate User Status.\n    Are you sure?');
		}
	}
	if(res==true)
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
		document.getElementById(panel).innerHTML=xmlhttp.responseText;
    }
  }
   var panel = 'status_'+user_id;
	document.getElementById(panel).innerHTML ='<div align="left"><center><img src="../images/loading.gif" width="40" /></center></div>';  
xmlhttp.open("GET","../ajax/changeuserstatus.php?user_id="+user_id+"&action="+action,true);
xmlhttp.send();
}
	
}



 </script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Manifest Reports</h1></div>


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
		<h3>Flight No is : <?php echo getflightno(base64_decode($_REQUEST['id'])); ?></h3>
        
<table border="0" cellpadding="2" cellspacing="2"  id="product-table">        
  	<tr>
          <th class="table-header-repeat line-left" width="220px;" align="center"><a href="#">Agency Name</a></th>
    </tr>      
  	  <td>
        <?php
		
		$run = $db->query("SELECT DISTINCT(`agency_id`) agency_id FROM `agency_seat_allocation` LEFT JOIN boardingpass USING(allocation_id) WHERE flight_id= $flight_id");
echo '<select name="agency_id" id="agency_id" class="input-medium" onchange="getManifestTable(this.value);">';
      	echo '<option value="all">ALL</option>';
while($row = $db->fetch($run))
{
      	echo '<option value="'.$row['agency_id'].'">'.getstatename($row['agency_id']).'</option>';
}
echo '</select>';

		 ?>

        </td>
	  </tr>
</table>        
        


<h3><a href="../common/generatemanifestpdf.php?id=<?php echo $_REQUEST['id']; ?>" target="_blank"><img src="../images/pdf.png" width="32" /></a></h3>    


<div id="create_pilgrim_table">        
		<?php include('../ajax/carrier_manifest_table.php'); ?>
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