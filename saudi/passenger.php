<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/saudi_passenger_menu.php');
$db = new Database();
$olddate = date('Y-m-d',strtotime("-600 days"));
$currentdate = date('Y-m-d',strtotime("1 days"));
//$sql = "SELECT flight_id,flight_no FROM flights  WHERE date2 > '".$olddate."' and date2< '".$currentdate."' ORDER BY createdon DESC";
$run_flight = $db->query("SELECT flight_id,flight_no,date1,date2,time2 FROM flights  WHERE date2 BETWEEN '".$olddate."' AND '".$currentdate."'ORDER BY date2 DESC");

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
		    document.getElementById('saudi_manifest').innerHTML=xmlhttp.responseText;
    }
  }
	xmlhttp.open("GET","../ajax/getsaudimanifest.php?flight_id="+flight_id+"&val="+val,true);
	xmlhttp.send();

}
/*******SCRIPT FOR CHAGNING THE STATUS OF PILGRIM********/
function getconfirmationlist(flight_id)
{
	var xmlhttp;
if(flight_id!='')
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
	   var panel = 'saudi_manifest';
		document.getElementById(panel).innerHTML ='<div align="left"><center><img src="../images/loading.gif" width="40" /></center></div>';  
	xmlhttp.open("GET","../ajax/getsaudimanifest.php?flight_id="+flight_id,true);
	xmlhttp.send();
	}
	
//	return false;
}



 </script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Passenger Manifest</h1></div>


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

<table width="500" border="0" cellpadding="2" cellspacing="2" style="vertical-align:top" >        
  	<tr>
    	  <th><b>Flight ID</th>
      	  <td>
  	    <select name="flight_id" id="flight_id" class="input-medium" onchange="getconfirmationlist(this.value);">
        	<option value="">Choose Flight</option>
    	<?php foreach($show_flight as $val=>$key){ ?>
        	<option value="<?php echo $key['flight_id']; ?>"><?php echo '<b>'.$key['flight_no'].'</b> '.$key['date2'].'::'.$key['time2']; ?></option>    
        <?php } ?>
	      </select>

        </td>
	  </tr>
</table>  
<br />
<div class="clear"></div>
<div id="saudi_manifest">        

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
<?php
include('../common/footer.php');

?>