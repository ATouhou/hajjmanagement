<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_custom_reports.php');
$path = BASEURL.'image_content/carriers/carriers_images_th/';
$db = new Database();
$current_val=0;
$start =0;
$nor = 35;
$limit = $nor;
$flight_no = base64_decode($_REQUEST['id']);

if(isset($_GET['val']))
{
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}
$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT(passport_no) FROM custom_eticket WHERE createdby='".$_SESSION['uid']."' AND flight_no='".$flight_no."' ORDER BY id DESC LIMIT $start, $nor");
$num_disp = $db->total();
$run_total = $db->query("SELECT FOUND_ROWS() num;");
$row_total = $db->fetch($run_total);
$total_val = $row_total['num'];

$nop = ceil($total_val/$nor);
if(isset($_GET['val']))
{
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}

$show_disp = array();
while($row_disp = $db->fetch($run_disp))
{
	$show_disp[] = $row_disp;
}






?>

<!--************TO FETCH THE LGA VALUES***********-->
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
	xmlhttp.open("GET","../ajax/custom_manifest_table.php?val="+val+"&id="+id,true);
xmlhttp.send();
}
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


<div id="page-heading"><h1>Manifest Report </h1></div>


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

	
		<!-- start id-form -->
        <h3> Manifest List of Passenger </h3>
        
        <?php notification(); ?>


           <input type="button" value="PRINT" onclick="printContent('print_area')"  />	 
<br />
<br />

<table width="850">
        <tr>
          <th width="200">
          <?php 
		  if(($current_val-1)>=0)
		  {
		 
          echo '<a href='.$_SERVER['PHP_SELF'].'?val='.($current_val-1).'&id='.$_REQUEST['id'].'  ><img src="../images/forms/prev.gif" /></a>';
         
		  }
		  ?>
          </th>
          <th  colspan="2" align="left" width="300">Total No of Records : <?php echo $total_val; ?>(<?php echo $current_val+1; ?>/<?php echo $nop; ?> )</th>
		  <th align="left"></th>
          <td><?php for($i=1;$i<=$nop; $i++){ echo '<a href='.$_SERVER['PHP_SELF'].'?val='.($i-1).'&id='.$_REQUEST['id'].'  >&nbsp;&nbsp;'.$i.'&nbsp;&nbsp;</a>'; }?></td>	
          <th width="200">
          <?php
          if($limit<$total_val)
		  {
	          echo '<a href='.$_SERVER['PHP_SELF'].'?val='.($current_val+1).'&id='.$_REQUEST['id'].'  ><img src="../images/forms/next.gif" /></a>';
		  }
          ?>
          </th>
        </tr> 
</table>
<br /><br /><br />
<h3><a href="manifest_pdf.php?id=<?php echo $_REQUEST['id']; ?>" target="_blank"><img src="../images/pdf.png" width="32" /></a></h3>
<?php
/*
	$checkdate1 = strtotime(date('Y-m-d'));
	$checkdate2 = strtotime('2015-09-07');
	if(($checkdate1-$checkdate2)<0){ 
	  for($i=1; $i<=$nop; $i++){
		  $no = $i-1;
		  echo '<div style=" vertical-align:center;display:block;position:relative; float:left; width:80px; height:20px;  padding-top:8px; margin:2px; background-color:#333;text-align:center;">';
		  echo '<a style="text-decoration:none;color:#FFF;" target="_blank" href="manifest_pdf.php?val='.$no.'&id='.$_REQUEST['id'].'" >Print '.$i.'</a>';
		  echo '</div>';
	  }
 	} 

*/
?>

<div style="clear:both"></div>
<br /><br />
<br />
<br />
<div id="print_area">


<table id="product-table" width="800">
<?php

	$start =0;
if(isset($_GET['val']))
{
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}


?>
		<?php foreach($show_disp as $val=>$key ) { ?>
		<?php

				$run_details = $db->query("SELECT * FROM custom_eticket LEFT JOIN flights USING(flight_no) LEFT JOIN carriers ON carriers.carriers_id=flights.agency_id WHERE passport_no='".$key['passport_no']."' AND flight_no='".base64_decode($_REQUEST['id'])."'");			
		$details = $db->fetch($run_details);	
		?>
                
<?php        if(($start%35)==0){ ?>

<tr>
	<td colspan="7" style="border:none; ">
    
<table width="800">
  <tr>
    <td rowspan="5"><img src="<?php   echo $path.$details['carriers_id'].'.'.$details['carriers_logo']; ?>" width="125" height="125"/></td>
    <td colspan="2" align="center">PASSENGER MANIFEST</td>
    </tr>
  <tr>
    <td colspan="2" align="left"><?php   echo $details['carriers_name']; ?></td>
    </tr>
  <tr>
    <td>POINT OF EMBARKATION <?php    echo getflightlocationname($details['source']);  ?></td>
    <td>POINT OF DISEMBARKATION  <?php  echo getflightlocationname($details['destination']); ?></td>
    </tr>
  <tr>
    <td>FLIGHT NO: <?php  echo $details['flight_no']; ?></td>
    <td>DATE :<?php   echo $details['date1'];  ?> TIME: <?php   echo $details['time1'];  ?></td>
    </tr>
  <tr>
    <td>Owner of Operator <?php  echo $details['agency_code']; ?></td>
    <td>Marks of Nationality Registration</td>
    </tr>
</table>
    
	</td>
</tr>
  <tr>
    <td><strong>S.No</strong></td>
    <td><strong>Passenger Name</strong></td>
    <td><strong>Passport No</strong></td>
    <td><strong>Nationality</strong></td>
    <td><strong>Sex </strong></td>
    <td><strong>Status</strong></td>
    <td><strong>TicketNo</strong></td>
  </tr>        
        
<?php } ?>        
  <tr>
    <td><?php echo ++$start; ?>&nbsp;</td>
    <td><?php echo $details['title'].'. '; ?><?php   echo $details['first_name'].' '.$details['last_name']; ?></td>
    <td><?php   echo $details['passport_no']; ?></td>
    <td><?php   echo $details['country']; ?></td>
    <td><?php   echo $details['gender']; ?></td>
    <td><?php echo 'Adult'; ?></td>
    <td><?php echo $details['ticket_id']; ?></td>
  </tr>
		<?php } ?>
        </table>
</div>

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