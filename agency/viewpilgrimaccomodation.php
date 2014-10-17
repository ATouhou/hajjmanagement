<?php 
include("../common/functions.php");
$title='Movement - Manifest';
include('../common/header.php');
include('../menu/agency_accomodation_menu.php');
$db= new Database();
$run = $db->query("SELECT manifest_id FROM accomodation_manifest WHERE accomodation_id='".base64_decode($_REQUEST['id'])."'");
$total = $db->total();
$run = $db->query("SELECT * FROM accomodation WHERE id='".base64_decode($_REQUEST['id'])."'");
$row = $db->fetch($run);

?>
 <script type="text/javascript">

function pagination(val)
{
	var xmlhttp;
	var id = document.getElementById('vehicle_id').value;
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
	xmlhttp.open("GET","../ajax/agency_accomodation_manifest_table.php?val="+val+"&id="+id,true);
xmlhttp.send();
}
/*******SCRIPT FOR CHAGNING THE STATUS OF PILGRIM********/
function changeusertatus(action,user_id,user_status)
{
	var xmlhttp;
	var res =true;
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
  var panel = 'display_pilgriminfo';
//	document.getElementById(panel).innerHTML ='<div align="left"><center><img src="../images/loading.gif" /></center></div>';  
xmlhttp.open("GET","../common/accomodation_latestactivity.php?mid="+id+"&action=disp",true);
xmlhttp.send();
	

}

 </script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>View Manifest</h1></div>


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
        <h3><a href="../common/generateaccomodationmanifestpdf.php?id=<?php echo $_REQUEST['id']; ?>" target="_blank"><img src="../images/pdf.png" width="32" /></a></h3>
        
        
<table width="850" id="product-table">
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
<input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo base64_decode($_REQUEST['id']); ?>" />        

<div id="create_pilgrim_table">        
		<?php include('../ajax/agency_accomodation_manifest_table.php'); ?>
</div>        


	</td>
	<td>
            <div id="display_pilgriminfo">
               <?php include('../common/accomodation_latestactivity.php'); ?>
            </div>    
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