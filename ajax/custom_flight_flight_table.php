<?php
if(isset($_REQUEST['val'])){ include("../common/functions.php");  }
$db = new Database();
$current_val=0;
$start =0;
$nor = 50;
$limit = $nor;

if(isset($_GET['val']))
{
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}
$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT(custom_eticket.flight_no),departure, date1, custom_eticket.destination,flight_id FROM custom_eticket LEFT JOIN flights USING(flight_no) ORDER BY id DESC LIMIT $start, $nor");
$num_disp = $db->total();
$run_total = $db->query("SELECT FOUND_ROWS() num;");
$row_total = $db->fetch($run_total);
$total_val = $row_total['num'];
$nop = ceil($total_val/$nor);
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
	  <table id="product-table" width="850">
		<thead>
        <tr>
          <th class="table-header-repeat line-left" ><a href="#">Flight No</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Flight Date</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Departure</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Arrival</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Options</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Action</a></th>
        </thead>
		<tbody>
		<?php foreach($show_disp as $val=>$key ) { ?>
        <tr>
          <td><a href="#" ><?php echo $key['flight_no'];  ?></a></td>
          <td><?php echo $key['date1'];  ?></td>
          <td><?php echo $key['departure'];  ?></td>
          <td><?php echo $key['destination'];  ?></td>
          <td><a href="<?php echo $_SESSION['basemodule'].'eticketbyflight.php?id='.base64_encode($key['flight_no']); ?>" >Eticket</a>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="<?php echo $_SESSION['basemodule'].'boardingbyflight.php?id='.base64_encode($key['flight_no']); ?>" >Boarding</a></td>
<!--          <td><a href="<?php echo BASEURL.'action/deleteeticket_custom_transact.php?id='.base64_encode($key['flight_no']); ?>" >Delete Etickets</a></td>
-->          
		  <td><a href="<?php echo BASEURL.'action/deleteeticket_custom_transact.php?id='.base64_encode($key['flight_no']).'&date='.$key['date1']; ?>" >Delete Etickets</a></td>
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
          <th  colspan="2" align="left" width="300">Total No of Pilgrims : <?php echo $total_val; ?></th>
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