<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_agency_pilgrim.php');
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
		    document.getElementById('create_pilgrim_table').innerHTML=xmlhttp.responseText;
    }
  }
	xmlhttp.open("GET","../ajax/pilgrim_table.php?val="+val,true);
xmlhttp.send();
}
/*******SCRIPT FOR CHAGNING THE STATUS OF PILGRIM********/
function changepilgrimstatus(action,pilgrim_id,pilgrim_status)
{
	var xmlhttp;
	var res =true;

	if(action=='status')
	{
		if(pilgrim_status=='Active')
		{
			 res = window.confirm('Deactivate Pilgrim Status.\n    Are you sure?');
		}else
		{
			 res = window.confirm('Activate Pilgrim Status.\n    Are you sure?');
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
   var panel = 'status_'+pilgrim_id;
//	document.getElementById(panel).innerHTML ='<div align="left"><center><img src="../images/loading.gif" /></center></div>';  
xmlhttp.open("GET","../ajax/changepilgrimstatus.php?pilgrim_id="+pilgrim_id+"&action="+action,true);
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
xmlhttp.open("GET","../common/pilgrim_latestactivity.php?latestid="+id+"&action=disp",true);
xmlhttp.send();
	

}
 </script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Pilgrim List</h1></div>


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
   <!--     <h3><a href="../common/generatepilgrimlistpdf.php" target="_blank"><img src="../images/pdf.png" width="32" /></a></h3> -->
<?php
$db = new Database();

if($_SESSION['cid']==1){ $cond =''; }else { $cond = 'WHERE state="'.$_SESSION['agency_id'].'"'; }
//if($_SESSION['cid']==1){ $cond =''; }else { $cond = 'WHERE agency="'.$_SESSION['agency_id'].'"'; }
$total = $db->query("SELECT * FROM pilgrims ".$cond."");
$total = $db->total();
$nopilgrims = 160;
$nob = ceil($total/$nopilgrims);
for($i=0; $i<$nob;$i++){
$start = $i*$nopilgrims+1;
$end = $start + $nopilgrims-1;

if($i==($nob-1)){
$end = $total;
}
$bno = $i+1;
echo '<a href="../common/generatepilgrimlistpdf.php?s='.$start.'&l='.$end.'&totalrecord='.$total.'&bno='.$bno.'" style="width:100px; height:26px; background-color:#000; color:#fff; display:block;padding-top:8px;margin:4px; float:left;" target="_blank"><img src="../images/pdf.png" width="24" />('.$start.' - '.$end.')</a>';
}
echo '<div class="clear">&nbsp;</div>';
echo '<br>';
?>        
        
<div id="create_pilgrim_table">        
		<?php include('../ajax/pilgrim_table.php'); ?>
</div>        
	</td>
	<td>
    <div id="display_pilgriminfo">
       <?php include('../common/pilgrim_latestactivity.php'); ?>
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