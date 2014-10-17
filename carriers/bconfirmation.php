<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_carriers_bconfirmation.php');
?>
 <script type="text/javascript">
 function confirmboarding()
{
	val = document.getElementById('bno').value;
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
		    document.getElementById('create_confirmation_table').innerHTML=xmlhttp.responseText;
    }
  }
	xmlhttp.open("GET","../ajax/checkconfirmation.php?val="+val,true);
xmlhttp.send();
}
 </script>
<!-- start content-outer -->
<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Add product</h1>
	</div>
	<!-- end page-heading -->

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
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">

<?php notification(); ?>	
			
			<h3>Boarding Confirmation</h3>
			
<p>&nbsp;</p>
<table id="id-form" >
  <tr>
    <td width="180px;"><strong>Boarding Pass Number</strong></td>
    <td><label>
      <input type="text" name="bno" id="bno" class="input-medium" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>
      <input type="button" name="button" id="button" value="Check" style="padding:5px;" onclick="confirmboarding(); return false;" />
    </label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


</p>
<p>&nbsp;</p>
<div id="create_confirmation_table"></div>




			
			</div>
			<!--  end table-content  -->
	
			<div class="clear"></div>
		 
		</div>
		<!--  end content-table-inner ............................................END  -->
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
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>

<!--  end content-outer -->

 

<div class="clear">&nbsp;</div>

<?php include('../common/footer.php'); ?>