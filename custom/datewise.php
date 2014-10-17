<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_custom_reports.php');
$disp=0;
$db = new Database();


if(isset($_POST['submit']))
{
	echo $_POST['date1'];	
	echo $_POST['date2'];	



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


<div id="page-heading"><h1>Date Wise</h1></div>


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
	
	
		<!--  start step-holder -->
<!--		<div id="step-holder">
			<div class="step-no">1</div>
			<div class="step-dark-left"><a href="">Pilgrim details</a></div>
			<div class="step-dark-right">&nbsp;</div>
			<div class="step-no-off">2</div>
			<div class="step-light-left">Preview</div>
			<div class="step-light-round">&nbsp;</div>
			<div class="clear"></div>
		</div>
-->		<!--  end step-holder -->
	
		<!-- start id-form -->
        <?php notification(); ?>
        
<form  name="regisfrm" method="post" enctype="multipart/form-data" action="#" id="inp-frm"  >
<table id="id-form">
  <tr>
    <th scope="row">From:</th>
    <td><label>
      <input type="text" name="date1"  class="input-medium" id="date1" readonly="readonly" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row">To:</th>
    <td><label>
      <input type="text" name="date2" class="input-medium" id="date2" readonly="readonly" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td><label>
      <input type="submit" name="submit" id="submit" value="Submit" class="form-submit" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>

<br />
<br />


           <input type="button" value="PRINT" onclick="printContent('print_area')"  />	 
<br />
<br />

<div id="print_area">
<?php 
if($disp==1){
	
//	print_r($details);
$i=0;
$path = BASEURL.'image_content/carriers/carriers_images_th/';

foreach($details as $val=>$key){ 
if($key['3']!=''){

$flight_data = unserialize(getcustomcarriername($key['1'],10));

//print_r($flight_data);

?>

<table width="850" style="font-size:16px;">
  <tr>
    <td width="120"><img src="<?php echo $path.$flight_data['carriers_id'].'.'.$flight_data['carriers_logo'];  ?>" width="60" /></td>
    <td align="center"><strong>Passenger Ticket <br />and Baggage Check</strong></td>
    <td width="120"><strong>Flight Ticket</strong></td>
  </tr>
</table>


<table width="850">
  <tr>
    <td width="120"><?php echo $flight_data['carriers_name']; ?></td>
    <td><?php // print_r(unserialize(getcustomcarriername($key['1'],10))); ?></td>
    <td width="120"><strong>Ticket No:</strong></td>
  </tr>
  <tr>
    <td rowspan="3"><?php echo $flight_data['carriers_address']; ?></td>
    <td>Passenger Ticket and Baggage Check</td>
    <td><?php echo$ticket_id[$i]; // rand(1000000,9999999); ?></td>
  </tr>
  <tr>
    <td rowspan="2">Important-- Before Travelling you should carefully examine this ticket -- particularly the conditions of contract and notices contained herein</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Date of Issue:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo date('d-M-Y'); ?></td>
  </tr>
</table>



<table width="850" id="product-table">
  <tr>
    <td width="50"><strong>From</strong></td>
    <td width="50"><strong>Terminal</strong></td>
    <td width="50"><strong>To</strong></td>
    <td width="50"><strong>Terminal</strong></td>
    <td width="80"><strong>Issued On Behalf Of Carrier</strong></td>
    <td width="50"><strong>Flight No</strong></td>
    <td width="50"><strong>Class</strong></td>
    <td width="50"><strong>Flight Date</strong></td>
    <td width="50"><strong>Dep Time</strong></td>
    <td width="30"><strong>Allow</strong></td>
    <td width="30"><strong>Chkd</strong></td>
    <td width="30"><strong>Weight</strong></td>
    <td width="30"><strong>Unckd</strong></td>
    <td width="40"><strong>Seat#</strong></td>
  </tr>
  <tr>
    <td><?php echo $key['3']; ?></td>
    <td><?php echo getterminalname($flight_data['dterminal']); ?></td>
    <td><?php echo $key['4']; ?></td>
    <td><?php echo getterminalname($flight_data['aterminal']); ?></td>
    <td><?php echo $flight_data['carriers_name']; ?></td>
    <td><?php echo $key['1']; ?></td>
    <td><?php echo $key['2']; ?></td>
    <td><?php echo $key['0']; ?></td>
    <td><?php echo $flight_data['time1']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><strong>Last Name:</strong><?php echo $key['6']; ?></td>
    <td colspan="2"><strong>First Name:</strong><?php echo $key['7']; ?></td>
    <td colspan="4"><strong>Passport No:</strong><?php echo $key['11']; ?></td>
    <td><strong>M</strong></td>
    <td><strong>F</strong></td>
    <td><strong>C</strong></td>
    <td><strong>I</strong></td>
    <td><strong># Of Pieces</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php if($key['9']=='M'){ echo 'X';} ?></td>
    <td><?php if($key['9']=='F'){ echo 'X';} ?></td>
    <td><?php if($key['9']=='C'){ echo 'X';} ?></td>
    <td><?php if($key['9']=='I'){ echo 'X';} ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="850" style="vertical-align:text-top;" >
  <tr>
    <td width="400">Please read conditions of contract and advice<br />
      to international passengers on the lmitation of liability.</td>
    <td>This ticket is not to be issued in conjuntion with any other ticket.<br />
      This ticket is not transferable/refundable to any other flight or person.</td>
  </tr>
</table>

<br /><br /><br />
<br /><br /><br />
<?php
unset($flight_data);

$i++;
}
}
} ?>
</div>

<?php // echo $_REQUEST['error_data']; $error_data[] = unserialize($_REQUEST['error_data']); print_r(unserialize($_REQUEST['error_data'])); ?>


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