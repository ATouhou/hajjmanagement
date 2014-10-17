<?php
$db = new Database();
$current_val=0;
$run_disp = $db->query("SELECT * FROM `agency_seat_allocation` WHERE flight_id='".$_REQUEST['flight_id']."'");
$num_disp = $db->total();
$show_disp = array();
while($row_disp = $db->fetch($run_disp))
{
	$show_disp[] = $row_disp;
}
if(count($show_disp)==0)
{
echo "No Records Found";
}else
{
	
?>
	  <table id="product-table" width="850">
		<thead>
        <tr>
          <th class="table-header-repeat line-left" ><a href="">Sno.</a></th>
          <th class="table-header-repeat line-left" ><a href="">Agency Name</a></th>
          <th class="table-header-repeat line-left" ><a href="">Total Seats</a></th>
          <th class="table-header-repeat line-left" ><a href="">Booked</a></th>
          <th class="table-header-repeat line-left" ><a href="">Options</a></th>
       </tr>
        </thead>
		<tbody>
		<?php $sno =1; foreach($show_disp as $val=>$key ) {	?>
        <?php $run = $db->query("SELECT COUNT(id) seatbooked FROM eticket LEFT JOIN pilgrims USING (pilgrim_id) WHERE allocation_id='".$key['allocation_id']."' AND pilgrims.agency='".$key['agency_id']."'");  ?>
        <?php $row = $db->fetch($run); ?>
        <?php $seatbooked = $row['seatbooked']; ?>
        <tr>
          <td><?php echo $sno;  ?></td>
          <td><?php echo getstatename($key['agency_id']);  ?></td>
          <td><?php echo $key['seat_allocated'];  ?></td>
          <td><?php echo $seatbooked;  ?></td>
			  <td><div align="center"><a href="<?php echo CARRIERS; ?>editseatallocation.php?id=<?php echo $key['allocation_id']; ?>&flightid=<?php echo $_REQUEST['flight_id']; ?>" title="Edit" class="icon-1 info-tooltip"></a>
</div>
		  </td>
       </tr>
		<?php
		$sno++; 
		}
		?>
		</tbody>
      </table>     
<?php
}
?>