<?php
include('../common/functions.php'); 
$db = new Database();

if(isset($_REQUEST['passport_no']))
{
	$show=1;
	$run_passport = $db->query("SELECT * FROM boardingpass LEFT JOIN pilgrims  USING(pilgrim_id) WHERE pilgrims.passport_no='".$_REQUEST['passport_no']."' AND pilgrims.status='Active' ORDER BY boardingpass.createdon");
	
// CHECK BOARDING PASS IS IS CONFIRMED OR NOT	
	if($db->total()!=0){
		$css1 ='style="background-color:#090; color:#FFF;"';
		$css2 ='style="background-color:#090; color:#FFF;"';
		$css3 ='style="background-color:#090; color:#FFF;"';
		$row_passport = $db->fetch($run_passport);
		if($row_passport['image']==''){	
		
			if($row_passport['sex']='Male'){
				$logo = '../images/male.png';	
			}else{
				$logo = '../images/female.png';				
			}
		}else{
			$image_th = BASEURL.'image_content/pilgrim/pilgrim_images_th/';
			$logo = $image_th.$row_passport['pilgrim_id'].'.'.$row_passport['image']; 
		}
		if($row_passport['bconfirmation']=='Yes')
		{
			$css4='style="background-color:#090; color:#FFF;"';
		}else{
			$css4='';	
		}
		
		$run_flightdetails = $db->query("SELECT flight_id, carrier_id FROM agency_seat_allocation WHERE allocation_id='".$row_passport['allocation_id']."'");
		$row_flightdetails = $db->fetch($run_flightdetails);
		
	}else{
// CHCEK E-TICKET IS THERE OR NOT	
			$run_passport = $db->query("SELECT * FROM eticket LEFT JOIN pilgrims USING(pilgrim_id) WHERE pilgrims.passport_no='".$_REQUEST['passport_no']."' AND pilgrims.status='Active' ORDER BY eticket.createdon");
		if($db->total()!=0){

			$css1 ='style="background-color:#090; color:#FFF;"';
			$css2 ='style="background-color:#090; color:#FFF;"';
			$css3 ='';
			$css4 ='';
			
			$row_passport = $db->fetch($run_passport);
			$row_passport['bno']='';
			if($row_passport['image']==''){			
				if($row_passport['sex']='Male'){
					$logo = '../images/male.png';	
				}else{
					$logo = '../images/female.png';				
				}
			}else{
				$image_th = BASEURL.'image_content/pilgrim/pilgrim_images_th/';
				$logo = $image_th.$row_passport['pilgrim_id'].'.'.$row_passport['image']; 
			}

			$run_flightdetails = $db->query("SELECT flight_id, carrier_id FROM agency_seat_allocation WHERE allocation_id='".$row_passport['allocation_id']."'");
			$row_flightdetails = $db->fetch($run_flightdetails);
	
		}else{
		// CHECK FOR PILGRIM REGISTRATION
		
			$run_passport = $db->query("SELECT * FROM pilgrims WHERE passport_no='".$_REQUEST['passport_no']."' AND status='Active' ORDER BY registration_date");
		
		if($db->total()!=0){

			$css1 ='style="background-color:#090; color:#FFF;"';
			$css2 ='';
			$css3 ='';
			$css4 ='';
			
			$row_passport = $db->fetch($run_passport);
			$row_passport['bno']='';

			if($row_passport['image']==''){			
				if($row_passport['sex']='Male'){
					$logo = '../images/male.png';	
				}else{
					$logo = '../images/female.png';				
				}
			}else{
				$image_th = BASEURL.'image_content/pilgrim/pilgrim_images_th/';
				$logo = $image_th.$row_passport['pilgrim_id'].'.'.$row_passport['image']; 
			}
			$row_flightdetails['carrier_id']='';
			$row_flightdetails['flight_id']='';
			$row_passport['eno']='';
		
		}else{
			$css1 ='';
			$css2 ='';
			$css3 ='';
			$css4 ='';
			$show=0;		
		
		}
			
		}
	
	}
		
?>


<table cellpadding="4" width="850" border="2" id="product-table" style="border:#090 solid 2px;padding:4px;" >
	<tr style="padding:4px;">
    	<td <?php echo $css1; ?>>Registration</td>
        <td <?php echo $css2; ?>>E-ticket</td>
        <td <?php echo $css3; ?>>Boarding Pass</td>
        <td <?php echo $css4; ?>>Boarding Confirmation</td>
    </tr>    
</table>

<br /><br />
<?php if($show==1){ ?>
<table  width="840" id="id-form">
  <tr>
    <td rowspan="7"><img src="<?php echo $logo; ?>" width="150" height="150" /></td>
    <th>Passport No</th>
    <td><?php echo $row_passport['passport_no']; ?></td>
    <th>Flight Id</th>
    <td><?php if($row_flightdetails['flight_id']!=''){ echo getflightno($row_flightdetails['flight_id']); } ?></td>
  </tr>
  <tr>
    <th>Name</th>
    <td><?php echo $row_passport['full_name']; ?></td>
    <th>Carrier Name</th>
    <td><?php if($row_flightdetails['carrier_id']!=''){ echo getcarriername($row_flightdetails['carrier_id']); } ?></td>
  </tr>
  <tr>
    <th>Gender</th>
    <td><?php echo $row_passport['sex']; ?></td>
    <th>E-ticket No</th>
    <td><?php echo $row_passport['eno']; ?></td>
  </tr>
  <tr>
    <th>Status</th>
    <td><?php echo $row_passport['pilgrim_status']; ?></td>
    <th>Boardingpass No</th>
    <td><?php echo $row_passport['bno']; ?></td>
  </tr>
  <tr>
    <th>LGA</th>
    <td><?php echo getlganame($row_passport['lga']); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th>Agency</th>
    <td><?php echo getstatename($row_passport['state']); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th>Nationality</th>
    <td><?php echo $row_passport['nationality']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table>
<?php } ?>	
<?php	

	
//	$passport_no = $row_passport['passport_no'];
	


}else{
//	$passport_no = $_REQUEST['value'];
//	$flight_id = $_REQUEST['flightid'];
}
/*
$run = $db->query("SELECT * FROM eticket LEFT JOIN pilgrims USING (pilgrim_id) LEFT JOIN agency_seat_allocation using (allocation_id) WHERE pilgrims.passport_no='".$passport_no."' AND agency_seat_allocation.carrier_id='".$_SESSION['agency_id']."' AND agency_seat_allocation.flight_id='$flight_id'");
$row = $db->fetch($run);


if($db->total()>0)
{
$run_flight_info = $db->query("SELECT * FROM flights WHERE flight_id='".$row['flight_id']."'");
$row_flight_info = $db->fetch($run_flight_info);
?>

<table width="840" id="id-form">
  <tr>
    <td>Pilgrim Name</td>
    <td><?php echo $row['full_name']; ?></td>
    <td>Gender</td>
    <td><?php echo $row['sex']; ?></td>
  </tr>
  <tr>
    <td>Passport No</td>
    <td><?php echo $row['passport_no']; ?></td>
    <td>Nationality</td>
    <td><?php echo $row['nationality']; ?></td>
  </tr>
  <tr>
    <td>Flight No</td>
    <td><?php echo $row_flight_info['flight_no']; ?></td>
    <td>Departure From</td>
    <td><?php echo getflightlocationname($row_flight_info['source']); ?></td>
  </tr>
  <tr>
    <td>Departure Date & time</td>
    <td><?php echo $row_flight_info['date1'].'  '.$row_flight_info['time1']; ?></td>
    <td>Departure To</td>
    <td><?php echo getflightlocationname($row_flight_info['destination']); ?></td>
  </tr>
  <tr>
    <td>Arrival Date & time</td>
    <td><?php echo $row_flight_info['date2'].'  '.$row_flight_info['time2']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<form name="luggageinformation" method="post" action="../action/luggage_transact.php?action=<?php if(isset($_REQUEST['id'])){ echo "edit";}else { echo "add"; }?>">
<?php echo 'the acess right is'.$_SESSION['access_right']; ?>
<input type="hidden" name="flight_id" value="<?php echo $row['flight_id']; ?>" />
<input type="hidden" name="eticket_id" value="<?php echo $row['id']; ?>" />
<input type="hidden" name="passportno" id="passportno" value="<?php echo $passport_no; ?>" />
<h3>Luggage Information</h3>
<p>&nbsp;</p>
Enter Luggage weight 
<br />
<table id="dataTable" width="450px"  style="padding:10px;" >
<?php if(isset($_REQUEST['id'])){ $total_luggage =0; $luggage = explode('@', $row_luggage['luggage']); for($i=0; $i<count($luggage);$i++){ $total_luggage +=$luggage[$i]; ?>
<input type="hidden" name="luggageid" id="luggageid" value="<?php echo base64_decode($_REQUEST['id']); ?>" />
        <tr style="padding:10px;">
            <td><input type="checkbox" name="chk"/></td>
            <td><input type="text" name="txt[]" class="input-medium" value="<?php echo $luggage[$i]; ?>"/></td>
            <td>Enter Luggage</td>
        </tr>
<?php } }else{ ?>
        <tr style="padding:10px;">
            <td><input type="checkbox" name="chk"/></td>
            <td><input type="text" name="txt[]" class="input-medium" value="0" /></td>
            <td>Enter Luggage</td>
        </tr>
<?php } ?>        
    </table> 
  <table id="id-form">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><input type="button" value="Add Row" onclick="addRow('dataTable')" style="padding:5px;" /></td>
        <td><input type="button" value="Delete Row" onclick="deleteRow('dataTable')" style="padding:5px;" /></td>
        <td><input type="button" value="Total" onclick="totalSum('dataTable')" style="padding:5px;" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Total Luggage</td>
        <td><input type="text" name="sum" id="sum" readonly="readonly" class="input-medium" <?php if(isset($_REQUEST['id'])){ echo 'value='.$total_luggage; } ?> /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Extra Luggage</td>
        <td><input type="text" name="extraluggage" id="extraluggage" readonly="readonly" class="input-medium" <?php if(isset($_REQUEST['id'])){ $extra_luggage = ($total_luggage-40) ; if($extra_luggage>40){ echo 'value='.$extra_luggage; }else{ echo 'value=0';}} ?> /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Total Payment</td>
        <td><input type="text" name="payment" id="payment"  readonly="readonly" class="input-medium" <?php if(isset($_REQUEST['id'])){ echo 'value='.$row_luggage['extra_payment']; } ?> /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div id="disp_button" style="visibility:hidden;"><input type="submit" name="submit" id="submit_button" value="Submit" class="form-submit"  /></div></td>
        <td>&nbsp;</td>
      </tr>
  </table>
</form>
  <?php }else{ ?>
Passport No does not match
<?php }

*/
?>