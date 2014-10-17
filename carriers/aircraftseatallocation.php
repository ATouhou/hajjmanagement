<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_carriers_common.php');

if(isset($_REQUEST['latestid']))
{
	$db = new Database();	
	$run = $db->query("SELECT nor,noc,seats FROM aircraft WHERE agency_id='".$_SESSION['agency_id']."' AND aircraft_id='".$_REQUEST['latestid']."'");
	$row = $db->fetch($run);
	$nor = $row['nor'];
	$noc = $row['noc'];
	$seats = $row['seats'];
}



?>

<!--************TO FETCH THE LGA VALUES***********-->
<script type="text/javascript">
function getlga(state_id)
{
	if(state_id=='')
	{
		document.getElementById('error_state').innerHTML='';		
	}else
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
		 document.getElementById("display_lga").innerHTML=xmlhttp.responseText;
	 }
  }
xmlhttp.open("GET","../ajax/getlga.php?value="+state_id,true);
xmlhttp.send();
	}
}


</script> 
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Aircraft Seat Allocation</h1></div>


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
	
<a href="<?php echo $_SESSION['basemodule'].'aircraft.php'; ?>"><h3>Back</h3></a>	
		<!--  start step-holder -->
		<div id="step-holder">
			<div class="step-no-off">1</div>
			<div class="step-light-left"><a href="">Aircraft details</a></div>
			<div class="step-light-right">&nbsp;</div>
			<div class="step-no">2</div>
			<div class="step-dark-left">Choose Seat</div>
			<div class="step-dark-round">&nbsp;</div>
			<div class="clear"></div>
		</div>
		<!--  end step-holder -->
	
		<!-- start id-form -->
    
<?php notification(); ?>
        
<form  name="regisfrm" method="post"  action="../action/seats_transact.php?action=<?php if(isset($_REQUEST['pilgrim_id'])){ echo "edit";}else { echo "add"; }?>" id="regisfrm" >
<input type="hidden" name="aircraft_id" id="aircraft_id" value="<?php echo $_REQUEST['latestid']; ?>"  />
<?php if($seats !=NULL){} ?>


<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
	  <tr>
      	<th>&nbsp;</th>
<?php for($c=0;$c<$noc; $c++){ ?>     
      	<th><?php echo $albhates[$c+1]; ?></th>
<?php } ?>        
      </tr>	
<?php for($r=0;$r<$nor; $r++){ ?>        
	  <tr>
 		<th><?php echo $r+1; ?></th>     
<?php for($c=0;$c<$noc; $c++){ ?>  
		<td>
        <?php if($seats !=NULL){ $seats1=explode(',',$seats); $var =($r+1).'-'.($albhates[$c+1]);  if(in_array($var,$seats1)){ $sel = 'checked="checked"'; }else{ $sel ='';} }else{ $sel = 'checked="checked"';} ?>
			<input type="checkbox" name="seats[]" value="<?php echo ($r+1).'-'.($albhates[$c+1]); ?>" id="seats[]" <?php echo $sel; ?> /><?php echo $r+1; ?>&nbsp;<?php echo $albhates[$c+1]; ?>            
        </td>	
<?php } 	?>        
	  </tr>
<?php } ?>        
	</table>
    
	    <input type="submit" value="" class="form-submit" />
	    <input type="reset" value="" class="form-reset"  />
    
        </form>

		<!-- end id-form  -->

	</td>
	<td>

	<!--  start related-activities -->
	<!-- end related-activities -->

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