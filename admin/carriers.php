<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/commonadmin_menu.php');
?>
<script type="text/javascript">
 function pagination(val)
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
		    document.getElementById('create_carriers_table').innerHTML=xmlhttp.responseText;
    }
  }
	xmlhttp.open("GET","../ajax/carriers_table.php?val="+val,true);
xmlhttp.send();
}
/*******SCRIPT FOR CHAGNING THE STATUS OF CARRIERS********/
function changecarriersstatus(action,carriers_id,carriers_status)
{
	var xmlhttp;
	var res =true;

	if(action=='status')
	{
		if(carriers_status=='Active')
		{
			 res = window.confirm('Deactivate Carriers Status.\n    Are you sure?');
		}else
		{
			 res = window.confirm('Activate Carriers Status.\n    Are you sure?');
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
//		alert('final');
		document.getElementById(panel).innerHTML=xmlhttp.responseText;
    }
  }
//  alert('before finale');
   var panel = 'status_'+carriers_id;
//	document.getElementById(panel).innerHTML ='<div align="left"><center><img src="../images/loading.gif" /></center></div>';  
xmlhttp.open("GET","../ajax/changecarriersstatus.php?carriers_id="+carriers_id+"&action="+action,true);
xmlhttp.send();
}
	
}

function displayinfo(id)
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
		document.getElementById(panel).innerHTML=xmlhttp.responseText;
    }
  }
//  alert('before finale');
  var panel = 'display_carriersinfo';
//	document.getElementById(panel).innerHTML ='<div align="left"><center><img src="../images/loading.gif" /></center></div>';  
xmlhttp.open("GET","../common/carriers_latestactivity.php?latestid="+id+"&action=disp",true);
xmlhttp.send();
	

}

</script>
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
<div id="page-heading"><h3><a href="<?php echo ADMIN.'add_carriers.php'; ?>"> New</a></h3></div>
	
	<?php notification(); ?>
		<!-- start of table -->
<div id="create_carriers_table">
    <?php include('../ajax/carriers_table.php'); ?>
</div>	


		<!-- end of table  -->

	</td>
	<td>

<?php include('../common/carriers_latestactivity.php'); ?>

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