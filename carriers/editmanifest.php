<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_carriers_reports.php');
if(isset($_REQUEST['id']))
{
	$db = new Database();
	$id = base64_decode($_REQUEST['id']);
}


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
	xmlhttp.open("GET","../ajax/editcarrier_manifest_table.php?val="+val+"&id="+id,true);
xmlhttp.send();
}
/********SCRIPT TO DELETE THE ETICKET ****************/

function deleteRow(eno) {
			var res = window.confirm('Eticket from both the flights will be deleted'); 
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
							var row = document.getElementById(eno);
						    row.parentNode.removeChild(row);

					}
				  }
				xmlhttp.open("GET","../ajax/deleteeticketrecord.php?eno="+eno,true);
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
<h3><a href="../common/generatemanifestpdf.php?id=<?php echo $_REQUEST['id']; ?>" target="_blank"><img src="../images/pdf.png" width="32" /></a></h3>    
        <?php notification(); ?>
		<h3>Flight No is : <?php echo getflightno(base64_decode($_REQUEST['id'])); ?></h3>
        <?php // print_r($row); ?>
<div id="create_pilgrim_table">        
		<?php include('../ajax/editcarrier_manifest_table.php'); ?>
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