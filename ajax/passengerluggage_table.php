<?php
if(isset($_REQUEST['val'])){ include("../common/functions.php");  }
$db = new Database();
$current_val=0;
$start =0;
$nor = NOR;
$limit = $nor;

if(isset($_GET['val']))
{
	$flightid = $_GET['flightid'];
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}

$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM luggage WHERE flight_id='".$flightid."' ORDER BY createdon DESC LIMIT $start, $nor");
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
<h3><a href="../common/generateluggagepdf.php?id=<?php echo $flightid; ?>" target="_blank"><img src="../images/pdf.png" width="32" />Download list</a></h3>


<h3>FLIGHT NO : <?php echo getflightno($flightid); ?></h3>
	  <table id="product-table" width="850">
		<thead>
        <tr>
          <th class="table-header-repeat line-left" ><a href="#">Passport No</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Name</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Eticket No</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Agency</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Extra Luggage</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Payment</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Print Label</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Action</a></th>
       </tr>
        </thead>
		<tbody>
		<?php foreach($show_disp as $val=>$key ) {
			
			$run_info = $db->query("SELECT * FROM eticket e RIGHT JOIN luggage l ON l.eticket_id=e.id LEFT JOIN pilgrims p USING(pilgrim_id) WHERE l.id='".$key['id']."'");
			$row_info = $db->fetch($run_info);
			
		?>
        <tr>
          <td><?php echo $row_info['passport_no']; ?></td>
          <td><?php echo $row_info['full_name'];  ?></td>
          <td><?php echo $row_info['eno'];  ?></td>
          <td><?php echo getstatename($row_info['state']); ?></td>
          <td><?php echo array_sum(explode('@',$key['luggage']));  ?></td>
          <td><?php echo $key['extra_payment'];  ?></td>
          <td><a href="#" onclick="printLabel('<?php echo base64_encode($key['id']); ?>'); return false;">Print Label</a></td>
          <td><div align="center"><a href="<?php echo $_SESSION['basemodule']; ?>registeredluggage.php?id=<?php echo base64_encode($key['id']); ?>" title="Edit" class="icon-1 info-tooltip"></a>
<a href="<?php echo $_SESSION['basemodule']; ?>registeredluggage.php?id=<?php echo base64_encode($key['id']); ?>&action=delete" title="Delete" onclick="adduser('delete',<?php // echo $key['user_id']; ?>);" class="icon-2 info-tooltip"  ></a>
</div>
</td>
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