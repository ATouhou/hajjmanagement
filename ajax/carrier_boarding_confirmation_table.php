<?php
if(isset($_REQUEST['val'])){ include("../common/functions.php");  }
$db = new Database();
$current_val=0;
$start =0;
$nor = NOR;
$limit = $nor;
$sno=1;

if(isset($_GET['val']))
{
	$id = $_REQUEST['id'];
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
	if($current_val!=0){ $sno = $current_val *$nor; }else{ $sno=1; }
}
//$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM agency_seat_allocation LEFT JOIN boardingpass ON agency_seat_allocation.allocation_id = boardingpass.allocation_id LEFT JOIN flights USING(flight_id) WHERE flight_id='".$id."' AND agency_seat_allocation.agency_id='".$_SESSION['agency_id']."' ORDER BY boardingpass.createdon DESC LIMIT $start, $nor");

//$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM agency_seat_allocation LEFT JOIN boardingpass ON agency_seat_allocation.allocation_id = boardingpass.allocation_id LEFT JOIN flights USING(flight_id) WHERE flight_id='".$id."' ORDER BY boardingpass.createdon DESC LIMIT $start, $nor");
$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM agency_seat_allocation asa, boardingpass bp, flights f WHERE asa.flight_id='".$id."' AND f.flight_id='".$id."' AND asa.allocation_id=bp.allocation_id AND bp.bconfirmation='Yes' ORDER BY f.createdon DESC LIMIT $start, $nor");

$num_disp = $db->total();
$run_total = $db->query("SELECT FOUND_ROWS() num;");
$row_total = $db->fetch($run_total);
$total_val = $row_total['num'];

$nop = ceil($total_val/NOR);
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
if(count($show_disp)==0)
{
echo "No record Found";
}else
{
?>
	  <table id="product-table" width="850">
		<thead>
        <tr>
          <th class="table-header-repeat line-left" >S.No</th>
          <th class="table-header-repeat line-left" ><a href="#">Name</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Passport No</a></th>
          <th class="table-header-repeat line-left" ><a href="#">State</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Nationality</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Boarding No </a> </th>
       </tr>
        </thead>
		<tbody>
		<?php   $sno = ($current_val*$nor+1);  		foreach($show_disp as $val=>$key ) {
			$run_info = $db->query("SELECT * FROM pilgrims WHERE pilgrim_id='".$key['pilgrim_id']."' AND status='Active'");
			$row_info = $db->fetch($run_info);
		?>
        <tr>
          <td><?php echo $sno++;   ?></td>
          <td><?php echo $row_info['full_name'];  ?></td>
          <td><?php echo $row_info['passport_no'];  ?></td>
          <td><?php echo getstatename($row_info['state']);  ?></td>
          <td><?php echo $row_info['nationality'];  ?></td>
          <td><?php echo $key['bno'];  ?></td>
       </tr>
		<?php
		}
		?>
		</tbody>
      </table>     
<table width="850">
        <tr>
          <th width="200">
          <?php 
		  if(($current_val-1)>=0)
		  {
		  ?>
          <a href="#" onclick="pagination('<?php echo $id; ?>',<?php echo $current_val-1; ?>); return false;"><img src="../images/forms/prev.gif" /></a>
          <?php
		  }
		  ?>
          </th>
          <th  colspan="2" align="left" width="300">Total No of Records : <?php echo $total_val; ?></th>
		  <th align="left"><?php echo $current_val+1; ?>/<?php echo $nop; ?> </th>	
          <th width="200">
          <?php
          if($limit<$total_val)
		  {
		  ?>
          <a href="#" onclick="pagination('<?php echo $id; ?>',<?php echo $current_val+1; ?>); return false;"><img src="../images/forms/next.gif" /></a>
          <?php
		  }
          ?>
          </th>
        </tr> 
</table>
<?php
}
?>