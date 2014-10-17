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
$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT(flight_id) FROM agency_seat_allocation WHERE agency_id='".$_SESSION['agency_id']."' ORDER BY createdon DESC LIMIT $start, $nor");
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
          <th class="table-header-repeat line-left" ><a href="#">Flight ID</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Model</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Source</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Destination</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Report</a></th>
         </tr>
        </thead>
		<tbody>
		<?php foreach($show_disp as $val=>$key ) {
			$run_info = $db->query("SELECT * FROM flights WHERE flight_id='".$key['flight_id']."' AND status='Active'");
			$row_info = $db->fetch($run_info);
			
		?>
        <tr>
          <td><?php echo $row_info['flight_no']; ?></td>
          <td><?php echo getflightmodel($key['flight_id']);  ?></td>
          <td><?php echo getflightlocationname($row_info['source']);  ?></td>
          <td><?php echo getflightlocationname($row_info['destination']);  ?></td>
          <td><div align="center"><a href="<?php echo $_SESSION['basemodule']; ?>eticketlist.php?id=<?php echo base64_encode($key['flight_id']);  ?>" title="Eticket" >Eticket</a> || <a href="<?php echo $_SESSION['basemodule']; ?>boardingpasslist.php?id=<?php echo base64_encode($key['flight_id']);  ?>" title="Boarding pass"> Boarding Pass</a></td> 
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