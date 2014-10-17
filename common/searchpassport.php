<script type="text/javascript">
function getpassportrecord()
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
  	xmlhttp.open("GET","../ajax/getpassportrecord.php?passportno="+passportno,true);
	xmlhttp.send();
}
function eticketdelete(eno)
{
	var res = window.confirm('Are you sure?');
//	alert(res);
	if(res==true)
	{
		//alert('hello');
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
//			 document.getElementById("dispetickettable").innerHTML='Coming Soon';
//				alert('get deleted');
				var row = document.getElementById(eno);
			    row.parentNode.removeChild(row);
		 }
	  }
		xmlhttp.open("GET","../ajax/deleteeticketrecord.php?eno="+eno,true);
		xmlhttp.send();			 
		
	}
	
}
</script>
<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Passport Management</h1>
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
			<h3>Search Passport</h3>
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
			
<div id="displaypassport"></div>            
            
			
			
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
