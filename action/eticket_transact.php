<?php
include("../common/functions.php");
$db = new Database();
if($_REQUEST['action']=='edit'){
	
$checkdate1 = strtotime(date('Y-m-d'));
$checkdate2 = strtotime('2016-02-17');
if(($checkdate1-$checkdate2)<0){ 
	
	if($_SESSION['access_right']!=3)
	{
		// DELETE THE BOARDING PASS IF IT EXISTS
		$eno = $_POST['eno'];
		$id = $_POST['eticket_id'];
		$run_boardingpass = $db->query("SELECT * FROM boardingpass WHERE eno='".$eno."' AND eticket_id='".$id."'");	
		$total = $db->total();
		if($db->total()>0){
		// BORADING PASS EXISTS	
			$row_boardingpass = $db->fetch($run_boardingpass);
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
					$db->query("UPDATE agency_seat_allocation SET seats_no_alloted ='".$new_seats_no_allocated."' WHERE allocation_id='".$allocation_id."' ");

				}			
			}
			// DELETE THE BOARDING PASS		
			$db->query("DELETE FROM boardingpass WHERE eno ='".$eno."'  AND eticket_id='".$id."'");		
		}
		
		$sql ="UPDATE eticket SET allocation_id='".$_POST['allocation1']."' ,`pilgrim_id` ='".$_POST['pilgrim_id']."' ,`createdon`=CURRENT_TIMESTAMP ,`status`='Active' ,`createdby`='".$_SESSION['uid']."' ,`bstatus`='".$_POST['bstatus1']."' ,`class`='".$_POST['class1']."' ,`mop`='".$_POST['mop']."' WHERE id='".$_POST['eticket_id']."'";		
		$db->query($sql);
		notify('success','Eticket has been reschedule successfully');
		$link = 'eticket.php?id='.base64_encode($_POST['eno']);
	}else{
			notify('fail',"Cannnot be updated contact administrator");	
			if($_SESSION['cid']!=2)
			{
				$link = 'book.php';		
			}else
			{
				$link ='index.php';	
			}
	}


}else{

	notify('fail','Eticket Cannot be updated contact Administrator');
	$link = 'book.php';

}

}else{

$eno = rand(100000,999999).rand(100000,999999);
if($_POST['path']==2){ 	$allocation_id2 = $_POST['allocation2']; $weight2= $_POST['weight2']; $class2 = $_POST['class2']; $bstatus2=$_POST['bstatus2'];	}else{	$allocation_id2 = 0; $weight2= 0; $class2 ='NA' ; $bstatus2='NA';		}
//NEW CODE
if($db->query("INSERT INTO `eticket` (`id` ,`eno` ,`pilgrim_id` ,`allocation_id` ,`createdon` ,`status` ,`createdby` ,`bstatus` ,`class` ,`mop`, flight_order)VALUES (NULL , '".$eno."', '".$_POST['pilgrim_id']."', '".$_POST['allocation1']."', CURRENT_TIMESTAMP , 'Active', '".$_SESSION['uid']."', '".$_POST['bstatus1']."', '".$_POST['class1']."', '".$_POST['mop']."','1')"))
{
	if($_POST['path']==2)
	{
	$db->query("INSERT INTO `eticket` (`id` ,`eno` ,`pilgrim_id` ,`allocation_id` ,`createdon` ,`status` ,`createdby` ,`bstatus` ,`class` ,`mop`, flight_order)VALUES (NULL , '".$eno."', '".$_POST['pilgrim_id']."', '".$allocation_id2."', CURRENT_TIMESTAMP, 'Active', '".$_SESSION['uid']."', '".$bstatus2."', '".$class2."', '".$_POST['mop']."','2')");
	}

	$mno = getpilgrimmno($_POST['pilgrim_id']);
	$type='eticket';
	sendsms($mno,$type,$eno);
	$id = $eno;
	notify('success','Eticket Created successfully');
	$link = 'eticket.php?id='.base64_encode($id);

}else{
	
	notify('fail','Eticket Cannot be created contact Administrator');
	$link = 'book.php';
}
}

header('Location:'.$_SESSION['basemodule'].$link);
?>