<?php
if(isset($_REQUEST['val'])){ include("../common/functions.php");  }
$db = new Database();
$current_val=0;
$start =0;
$nor = 20;
$limit = $nor;
$sno=1;

if(isset($_GET['val']))
{
	$id = $_REQUEST['id'];
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
	if($current_val!=0){$sno = $current_val *$nor; }else{ $sno=1; }
}
$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM custom_eticket WHERE flight_no='".$id."' ORDER BY id DESC LIMIT $start, $nor");
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
if(count($show_disp)==0)
{
echo "No record Found";
}else
{
?>

<div id="print_area">

	  <table id="product-table" width="850">
		<thead>
        <tr>
          <th class="table-header-repeat line-left" ><a href="#">S.No</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Name</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Passport No</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Flight No</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Flight Date</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Eticket No </a> </th>
          <th class="table-header-repeat line-left" ><a href="#">Boarding Ticket No </a> </th>
       </tr>
        </thead>
		<tbody>
		<?php $sno = ($current_val*$nor+1);  		foreach($show_disp as $val=>$key ) {
//			$run_info = $db->query("SELECT * FROM pilgrims WHERE pilgrim_id='".$key['pilgrim_id']."' AND status='Active'");
//			$row_info = $db->fetch($run_info);
		?>
        <tr>
          <td><?php echo $sno++;   ?></td>
          <td><?php echo $key['first_name'].' '.$key['last_name'];  ?></td>
          <td><?php echo $key['passport_no'];  ?></td>
          <td><?php echo $key['flight_no'];  ?></td>
          <td><?php echo $key['flight_date'];  ?></td>
          <td><?php echo $key['ticket_id'];  ?></td>
          <td><?php echo $key['bp_ticketid'];  ?></td>
          
       </tr>
		<?php
		}
		?>
		</tbody>
      </table>     
</div>      
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