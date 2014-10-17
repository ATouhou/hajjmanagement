<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_carriers_bconfirmation.php');
$db= new Database();
$run_flight = $db->query("SELECT flight_id,flight_no FROM flights WHERE agency_id='".$_SESSION['agency_id']."' ORDER BY createdon DESC");
$show_disp = array();
while($row_disp_flight = $db->fetch($run_flight))
{
	$show_flight[] = $row_disp_flight;
}



?>
 <script type="text/javascript">
 function pagination(val)
{
	var xmlhttp;	
	var agency_id = document.getElementById('agency_id').value;
	var flight_id = document.getElementById('flight_id').value;
	
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
		    document.getElementById('agency_report').innerHTML=xmlhttp.responseText;
    }
  }
	xmlhttp.open("GET","../ajax/carrier_agency_boarding_confirmation_table.php?val="+val+"&flight_id="+flight_id+"&agency_id="+agency_id,true);
	xmlhttp.send();
}
/*****FETCHING THE AGENCY LIST ***********/
function getagencylist(flight_id)
{
	if(flight_id=='')
	{
		document.getElementById('agencylist').innerHTML='';
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
			document.getElementById('agencylist').innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","../ajax/getagencyconfirmationlist.php?flight_id="+flight_id,true);
	xmlhttp.send();
	
}

function getagencyreport()
{
	var xmlhttp;	
	var agency_id = document.getElementById('agency_id').value;
	var flight_id = document.getElementById('flight_id').value;
	
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
		    document.getElementById('agency_report').innerHTML=xmlhttp.responseText;
    }
  }
	xmlhttp.open("GET","../ajax/carrier_agency_boarding_confirmation_table.php?val=0&flight_id="+flight_id+"&agency_id="+agency_id,true);
	xmlhttp.send();
}

 </script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Boarding Confirmation Reports</h1></div>


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

<table border="0" cellpadding="2" cellspacing="2"  id="product-table">        
  	<tr>
          <th class="table-header-repeat line-left"  ><a href="#">Flight ID</a></th>
          <th class="table-header-repeat line-left" width="220px;" align="center"><a href="#">Agency Name</a></th>
    </tr>      
  	  <td>
  	    <select name="flight_id" id="flight_id" class="input-medium" onchange="getagencylist(this.value);">
        	<option value="">Choose Flight</option>
    	<?php foreach($show_flight as $val=>$key){ ?>
        	<option value="<?php echo $key['flight_id']; ?>"><?php echo $key['flight_no']; ?></option>    
        <?php } ?>
	      </select>

        </td>
  	  <td><div id="agencylist"></div></td>
	  </tr>
</table>  
        <br />
<div id="agency_report">        
		<?php  include('../ajax/carrier_agency_boarding_confirmation_table.php'); ?>
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