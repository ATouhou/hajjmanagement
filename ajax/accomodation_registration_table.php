<?php
if(isset($_REQUEST['val'])){ include("../common/functions.php");  }
$db = new Database();
$current_val=0;
$start =0;
$nor = NOR;
$limit = $nor;

if(isset($_GET['val']))
{
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}
//$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT(flight_id) FROM agency_seat_allocation WHERE carrier_id='".$_SESSION['agency_id']."' ORDER BY createdon DESC LIMIT $start, $nor");
$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM accomodation WHERE agency_id='".$_SESSION['agency_id']."' ORDER BY createdon DESC LIMIT $start, $nor");
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
//	echo $_SESSION['agency_id'];
?>
	  <table id="product-table" width="850">
		<thead>
        <tr>
          <th class="table-header-repeat line-left" ><a href="#">Name</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Address</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Accomodation Duration</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Phone No</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Capacity</a></th>
          <th class="table-header-repeat line-left" width="110" ><a href="#">Action</a></th>
<!--          <th class="table-header-repeat line-left" ><a href="#">Departure </a> </th>
          <th class="table-header-repeat line-left" ><a href="#">Arrival</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Seats</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Remaning Seats</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Options</a></th>
-->     </tr>
        </thead>
		<tbody>
		<?php foreach($show_disp as $val=>$key ) {
			
		?>
        <tr>
          <td><a href="#"><?php echo $key['name']; ?></a></td>
          <td><?php echo $key['address'];  ?></td>
          <td><?php echo $key['email_id'];  ?></td>
          <td><?php echo $key['phone_no'];  ?></td>
          <td><?php echo $key['capacity'];  ?></td>
		  <td><div align="center"><a href="<?php echo $_SESSION['basemodule']; ?>editpilgrimaccomodation.php?id=<?php echo base64_encode($key['id']);  ?>" title="Edit" class="icon-1 info-tooltip"></a><div align="center"><a href="<?php echo $_SESSION['basemodule']; ?>addpilgrimaccomodation.php?id=<?php echo base64_encode($key['id']);  ?>" title="Add" class="icon-6 info-tooltip"></a><div align="center"><a href="<?php echo $_SESSION['basemodule']; ?>viewpilgrimaccomodation.php?id=<?php echo base64_encode($key['id']);  ?>" title="View" class="icon-5 info-tooltip"></a></td> 
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
          <a href="#" onclick="pagination(<?php echo $current_val-1; ?>); return false;"><img src="../images/forms/prev.gif" /></a>
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
          <a href="#" onclick="pagination(<?php echo $current_val+1; ?>); return false;"><img src="../images/forms/next.gif" /></a>
          <?php
		  }
          ?>
          </th>
        </tr> 
</table>
<?php
}
?>