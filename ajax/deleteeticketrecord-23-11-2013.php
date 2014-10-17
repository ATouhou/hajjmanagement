<?php 
include('../common/functions.php');
$db = new Database();
$eno = $_REQUEST['eno'];
$checkdate1 = strtotime(date('Y-m-d'));
$checkdate2 = strtotime('2013-12-07');
if(($checkdate1-$checkdate2)<0){ 
//$eno = '767007847564'; //echo $eno;
$run = $db->query("select id  from eticket WHERE eno='".$eno."'");
if($db->total()>0)
{
	$row = $db->fetch($run);
	$eitcketid = $row['id'];
	$run_boardingpass = $db->query("SELECT * FROM boardingpass WHERE eno='".$eno."'");	
	if($db->total()>0){
	// BORADING PASS EXISTS	
		$row_boardingpass = $db->fetch($run_boardingpass);
	//	print_r($row_boardingpass);
		for($t=0; $t<$db->total();$t++)
		{
			 $allocation_id = $row_boardingpass['allocation_id'];
			 $seat_no = $row_boardingpass['seat_no'];
			 $bno = $row_boardingpass['bno'];
			
			if($seat_no!='')
			{
				$run_seats = $db->query("SELECT seats_no_alloted FROM agency_seat_allocation WHERE allocation_id='".$allocation_id."'");
				$row_seats = $db->fetch($run_seats);
				$seats_no_allocated = $row_seats['seats_no_alloted'];
				$new_seats_no_allocated = str_replace($seat_no,'',$seats_no_allocated);
		//		echo '<br/>';
				$new_seats_no_allocated;
			}			
		}
		// DELETE THE BOARDING PASS		
			$db->query("DELETE FROM boardingpass WHERE eno ='".$eno."'");
		
	}
	
	//DELETE THE LUGGAGE
		$db->query("DELETE FROM luggage WHERE eticket_id ='".$eitcketid."'");
	//DELETE THE E-TICKET
		$db->query("DELETE FROM eticket WHERE eno ='".$eno."'");	
}
}
/*
$run = $db->query("DELETE FROM eticket WHERE eno='".$eno."'");
if($db->total()>0)
{
$run = $db->query("SELECT * FROM boardingpass WHERE eno='".$eno."'");
$row = $db->fetch($run);

$msg =' Eticket Deleted successfully';

if($db->total()>0)
{
print_r($row);
$allocation_id = $row['allocation_id'];
$seat_no = $row['seat_no'];
$run_seats = $db->query("SELECT seats_no_alloted FROM agency_seat_allocation WHERE allocation_id='".$allocation_id."'");
$row_seats = $db->fetch($run_seats);
$seats_no_alloted = $row_seats['seats_no_alloted'].','.$seat_no;
$db->query("UPDATE agency_seat_allocation SET seats_no_alloted='".$seats_no_alloted."' WHERE allocation_id='".$allocation_id."' ");
$msg =' Eticket and Boarding Pass deleted successfully';

}

}else{ ?>
E-tcket No does not match
<?php } 
*/
?>
