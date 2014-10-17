<?php 
include('../common/functions.php');
$db = new Database();
$passportno = $_REQUEST['passportno'];
//echo $_SESSION['agency_id'];
//echo $eno;
$show_boarding_info =0;	
$run = $db->query("SELECT * FROM eticket LEFT JOIN pilgrims USING (pilgrim_id) LEFT JOIN agency_seat_allocation using (allocation_id)  WHERE pilgrims.passport_no='".$passportno."' AND agency_seat_allocation.carrier_id='".$_SESSION['agency_id']."'");
while($row = $db->fetch($run))
{
	$data[] = $row;
	$run_query_boardingpass = $db->query("SELECT allocation_id,bno,seat_no FROM boardingpass WHERE allocation_id='".$row['allocation_id']."' AND eno='".$row['eno']."' AND eticket_id='".$row['id']."'");
	if($db->total()>0)
	{
		$boarding_data[] = $db->fetch($run_query_boardingpass);	
		$show_boarding_info=1;
	}
	$run_query_flightinfo = $db->query("SELECT * FROM flights WHERE flight_id='".$row['flight_id']."'");
	if($db->total()>0)
	{
		$flight_data[] = $db->fetch($run_query_flightinfo);		
	}
	
}

//print_r($boarding_data);
if($db->total()>0)
{

?>
<br /><br />
<h3>Eticket No : <font size="+2"><b><?php echo $data[0]['eno']; ?></b></font></h3>
<table width="840" id="product-table" >
  <tr>
<?php if($show_boarding_info==1){ ?>  
     <th class="table-header-repeat line-left" ><a href="#">Boarding Pass</a></th>
     <th class="table-header-repeat line-left" ><a href="#">Seat No</a></th>
<?php } ?>     
     <th class="table-header-repeat line-left" ><a href="#">Pilgrim Name</a></th>
     <th class="table-header-repeat line-left" ><a href="#">Nationality</a></th>
     <th class="table-header-repeat line-left" ><a href="#">Flight No</a></th>
     <th class="table-header-repeat line-left" ><a href="#">From</a></th>    
     <th class="table-header-repeat line-left" ><a href="#">To</a></th>    
     <th class="table-header-repeat line-left" ><a href="#">Status</a></th>
     <th class="table-header-repeat line-left" ><a href="#">Action</a></th>
  </tr>
<?php for($i=0; $i<count($data);$i++){ ?>  
     
  <tr id="<?php echo $data[0]['eno']."_".$data[$i]['id']; ?>">
<?php if($show_boarding_info==1){ ?>  
    <td><?php echo $boarding_data[$i]['bno']; ?></td>
    <td><?php echo $boarding_data[$i]['seat_no']; ?></td>
<?php } ?>    
    <td><?php echo $data[$i]['full_name']; ?></td>
    <td><?php echo $data[$i]['nationality']; ?><?php // echo $data[$i]['id']; ?></td>    
    <td><?php echo $flight_data[$i]['flight_no']; ?></td>
    <td><?php echo getflightlocationname($flight_data[$i]['source']); ?></td>
    <td><?php echo getflightlocationname($flight_data[$i]['destination']); ?></td>
    <td><?php echo $data[$i]['bstatus']; ?></td>
    <td> <a href="<?php echo $_SESSION['basemodule'].'eticket.php?id='.base64_encode($data[0]['eno']); ?>">View</a>&nbsp;<?php if($_SESSION['access_right']!=3){ ?> <a href="#"class="icon-2 info-tooltip" title="Delete" onclick="eticketdelete(<?php  echo $data[0]['eno']; ?>,<?php echo $data[$i]['id']; ?>); return false;"></a> <?php } ?>  </td>
  </tr>
<?php } ?>  
</table>
<?php }else{ ?>
E-tcket No does not match
<?php } ?>