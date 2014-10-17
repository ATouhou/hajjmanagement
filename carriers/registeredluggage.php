<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_luggage_flights.php');
if(!isset($_SESSION['flights']))
{
	$_SESSION['flights'] = array();
	$db = new Database();	
	$db_run = $db->query("SELECT flight_id,flight_no FROM flights WHERE agency_id='".$_SESSION['agency_id']."' AND status='Active' ORDER BY flight_no");
	while($db_row = $db->fetch($db_run))
	{
		$_SESSION['flights'][] = $db_row;
	}
}
	$db = new Database();
	$carrier_info = $db->query("SELECT * FROM carriers WHERE carriers_id='".$_SESSION['agency_id']."'");
	$row_carrierinfo = $db->fetch($carrier_info);
    $logo = '../image_content/carriers/carriers_images_th/'.$_SESSION['agency_id'].'.'.$row_carrierinfo['carriers_logo'];


?>

<!--************TO FETCH THE LGA VALUES***********-->
<script type="text/javascript">
function fetchDetails()
{
	var passport_no = document.getElementById('passportno').value;
	var flight_id = document.getElementById('flight_id').value;
//	alert(passport_no);
		
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
		 document.getElementById("display_information").innerHTML=xmlhttp.responseText;
	 }
  }
xmlhttp.open("GET","../ajax/getpassportdetails.php?value="+passport_no+"&flightid="+flight_id,true);
xmlhttp.send();
	
}


        function addRow(tableID) {
 
            var table = document.getElementById(tableID);
 
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
 
            var colCount = table.rows[0].cells.length;
 
            for(var i=0; i<colCount; i++) {
 
                var newcell = row.insertCell(i);
 
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
           //     alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                 }
            }
        }
 
        function deleteRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
 
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
 
 
            }
            }catch(e) {
                alert(e);
            }
        }
		
		function totalSum(tableID)
		{
			
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
			var sum = 0;
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var txtbox = row.cells[1].childNodes[0];
				sum +=parseInt(txtbox.value); 
            }
			
				document.getElementById('sum').value=sum;
				if(sum>40)
				{
					document.getElementById('payment').value =  (sum-40)*10;
					document.getElementById('extraluggage').value = sum-40;
				}else
				{
					document.getElementById('payment').value = 	0;			
					document.getElementById('extraluggage').value =0;
				}
				
				document.getElementById('disp_button').style.visibility="visible";
            }catch(e) {
                alert(e);
            }


		}
		
		



</script> 
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Registered Passengers</h1></div>

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
		<div id="step-holder">
			<div class="step-no">1</div>
			<div class="step-dark-left"><a href="">Luggage details</a></div>
			<div class="step-dark-round">&nbsp;</div>
			<div class="clear"></div>
		</div>
		<!--  end step-holder -->
	
		<!-- start id-form -->
        
<?php notification(); ?>
<?php if(isset($_REQUEST['flightid']))
{	
	$db= new Database();
	$run = $db->query("SELECT * FROM flights WHERE flight_id='".$_REQUEST['flightid']."' AND agency_id='".$_SESSION['agency_id']."'");
	if($db->total()>0)
	{ 
		$row = $db->fetch($run);
		$time1 = explode(':',$row['time1']);
		$time2 = explode(':',$row['time2']);
		
	}
}
?>
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
	    <tr>
	      <th valign="top">Passport No</th>
	      <td><label>
	        <input type="text" name="passportno" id="passportno" class="input-medium"  value="" />
	        </label></td>
	      <td><div id="error_flightid"></div></td>
        </tr>
		<tr>
		  <th valign="top">Flight NO</th>
		  <td><label>
		    <select name="flight_id" id="flight_id" class="input-medium" >
              <option value="" selected="selected">Select</option>
<?php 
//		$aircraft_data = array();
		foreach($_SESSION['flights'] as $val=>$key)
		{	
			$val = '';
			if(isset($_REQUEST['flight_id']) && ($key['flight_id']==$row['flight_id']))
			{
				$val ='selected="selected"';			
			}
			
			echo '<option value='.$key['flight_id'].' '.$val.'>'.$key['flight_no'].'</option>';
		}
?>
		      </select>
		    </label></td>
		  <td><div id="error_dterminal"></div></td>
        </tr>
	    <tr>
			<th valign="top"></th>
			<td> <input type="button" value="Get Details" onclick="fetchDetails();" style="padding:5px;"  />
            </td>
			<td><div id="error_model"></div></td>
		</tr> 
        <tr>
   	</table>
<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=='delete'){ ?>
<form name="deletefrm" id="deletefrm" action="../action/luggage_transact.php?action=delete" method="post">
<p>&nbsp;</p>
<p>&nbsp;</p>
<h3> Delete Passenger </h3>
<input type="hidden" name="id" id="id" value="<?php echo base64_decode($_REQUEST['id']); ?>" />
<input type="submit" name="delete" value="Delete" style="padding:5px;" id="delete" />
<p>&nbsp;</p>
<p>&nbsp;</p>
</form>
<?php } ?>
<!-- TABLE TO DISPLAY RECIEPT -->
<?php if(isset($_REQUEST['id'])&& isset($_REQUEST['reciept'])){ ?>

<?php
//echo $_SESSION['agency_id'];
	$db = new Database();
	$run_luggage = $db->query("SELECT * FROM eticket e RIGHT JOIN luggage l ON l.eticket_id=e.id LEFT JOIN pilgrims p USING(pilgrim_id) WHERE l.id='".base64_decode($_REQUEST['id'])."'");
	$row_luggage = $db->fetch($run_luggage);
	$total_luggage = array_sum(explode('@',$row_luggage['luggage'])); 

	//$logo = '../image_content/carriers/carriers_images_th/'.$_SESSION['agency_id'].'.'.$['carriers_logo'];

	
//	$sql = "SELECT * FROM eticket RIGHT JOIN luggage ON luggage.eticket_id=eticket.id" 
?>
<input type="button" value="PRINT RECIEPT" onclick="printContent('luggage_recipt')" style="padding:5px;"  />
<br /><br />
<div id="luggage_recipt">
<table border="2" width="340" cellpadding="4px;" height="380" style="font-size:16px;">
    <tr>	
        <td colspan="2" style="padding:4px;">
        <table>
        	<tr>
            	<td rowspan="2"><img src="<?php echo $logo; ?>" width="80" /></td>
				<td align="center"><?php echo getcarriername($_SESSION['agency_id']); ?></td>
            </tr>
            <tr>
            	<td style="padding-top:4px;"><img src="<?php echo BASEURL."common/"; ?>barcode.php?barcode=<?php echo $row_luggage['reciept_no']; ?>" width="240" height="70" align="right" /></td>
            </tr>
            </table>
            </td>
    </tr>
    <tr>	
        <td colspan="2" style="padding:4px;"  align="center">RECIEPT NO: <?php echo $row_luggage['reciept_no']; ?></td>
    </tr>
    <tr>	
        <td colspan="2" style="padding:4px;" align="center"><?php echo $row_luggage['full_name']; ?></td>
    </tr>
    <tr>	
        <td style="padding:4px;">TICKET NO</td>
        <td style="padding:4px;"><?php echo $row_luggage['eno']; ?></td>
    </tr>
    <tr>	
        <td width="170" style="padding:4px;">FLIGHT NO.</td>
        <td style="padding:4px;"><?php echo getflightno($row_luggage['flight_id']); ?></td>
    </tr>
    <tr>	
        <td style="padding:4px;">NO. OF PIECES</td>
        <td style="padding:4px;"><?php echo count(explode('@',$row_luggage['luggage'])); ?></td>
    </tr>
    <tr>	
        <td style="padding:4px;">EXCESS WEIGHT</td>
        <td style="padding:4px;"><?php $extra_luggage = $total_luggage-40 ; if($extra_luggage > 0){ echo $extra_luggage; }else{ echo 0;} ?></td>
    </tr>
    <tr>	
        <td style="padding:4px;">TOTAL WEIGHT</td>
        <td style="padding:4px;"><?php echo $total_luggage; ?></td>
    </tr>
    <tr>	
        <td style="padding:4px;">PAYMENT MADE</td>
        <td style="padding:4px;"><?php echo $row_luggage['extra_payment']; ?></td>
    </tr>
    <tr>	
        <td style="padding:4px;">USER</td>
        <td style="padding:4px;"><?php echo $_SESSION['username']; ?></td>
    </tr>
</table>
<!--
<table width="600" id="product-table">
  <tr>
    <td width="150">Reciept No</td>
    <td width="200"><?php// echo $row_luggage['reciept_no']; ?></td>
    <td width="100">&nbsp;</td>
    <td width="150">&nbsp;</td>
  </tr>
  <tr>
    <td>Passenger Name</td>
    <td><?php // echo $row_luggage['full_name']; ?></td>
    <td>Passport No</td>
    <td><?php // echo $row_luggage['passport_no']; ?></td>
  </tr>
  <tr>
    <td>Total No Of Baggage</td>
    <td><?php // echo count(explode('@',$row_luggage['luggage'])); ?></td>
    <td>Flight No</td>
    <td><?php // echo getflightno($row_luggage['flight_id']); ?></td>
  </tr>
  <tr>
    <td>Total Luggage</td>
    <td><?php // echo array_sum(explode('@',$row_luggage['luggage'])); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Payment Made</td>
    <td><?php // echo $row_luggage['extra_payment']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

-->
</div>

<br /><br />
<?php } ?>

<!-- END OF TABLE -->


<!-- TABLE TO DISPLAY FLIGHT INFORMATION AS WELL AS FORM FOR LUGGAGE -->

	<div id="display_information">
<?php if(isset($_REQUEST['id'])){ ?>
<?php include('../ajax/getpassportdetails.php'); ?>
<?php } ?>
    </div>








		<!-- end id-form  -->

	</td>
    
	<td>

	<!--  start related-activities -->
<?php include('../common/luggage_latestactivity.php'); ?>
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