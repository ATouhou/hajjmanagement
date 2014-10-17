<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_agency_book.php');
?>
 <script type="text/javascript">
function getagencyeticketrecord()
{
	var passportno = document.getElementById('passportno').value;
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
  	xmlhttp.open("GET","../ajax/getagencyeticketrecord.php?passportno="+passportno,true);
	xmlhttp.send();
}


 </script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Edit E-ticket</h1></div>


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
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">
			<h3>Enter Passport No</h3>
<form  name="regisfrm" method="post" enctype="multipart/form-data" action="#" id="regisfrm" onSubmit="return checkfrm(this);" >

<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
  <tr>
    <th valign="top">Passport No:</th>
    <td><input type="text" name="passportno" id="passportno" value="" class="input-medium"  /></td>
    <td><div id="error_eticket"></div></td>
  </tr>
  <tr>
    <th valign="top">&nbsp;</th>
    <td><input type="button" name="search" id="search" value="Search" style="padding:5px;"  onclick="getagencyeticketrecord();"/></td>
    <td><div id="error_eticket"></div></td>
  </tr>
</table>
</form>            
			
<div id="displaypassport"></div>            
            
			
			
			</div>
			<!--  end table-content  -->
	
			<div class="clear"></div>
		 
		</div>
		<!--  end content-table-inner ............................................END  -->
      


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