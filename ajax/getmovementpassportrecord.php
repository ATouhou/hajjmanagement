<?php 
include('../common/functions.php');
$db = new Database();
$passportno = $_REQUEST['passportno'];

$show_boarding_info =0;	
//$run = $db->query("SELECT * FROM pilgrims WHERE pilgrims.passport_no='".$passportno."' AND state='".$_SESSION['agency_id']."'");
$run = $db->query("SELECT * FROM pilgrims WHERE pilgrims.passport_no='".$passportno."'");
$row = $db->fetch($run);
if($db->total()>0)
{

?>
<input type="hidden" name="pilgrim_id" id="pilgrim_id" value="<?php echo $row['pilgrim_id']; ?>" />
<br /><br />
<table width="840" id="product-table" >
  <tr>
     <th class="table-header-repeat line-left" ><a href="#">Pilgrim Name</a></th>
     <th class="table-header-repeat line-left" ><a href="#">Nationality</a></th>
     <th class="table-header-repeat line-left" ><a href="#">Gender</a></th>
     <th class="table-header-repeat line-left" ><a href="#">Status</a></th>
     <th class="table-header-repeat line-left" ><a href="#">Action</a></th>
  </tr>
    <td><?php echo $row['full_name']; ?></td>
    <td><?php echo $row['nationality']; ?></td>    
    <td><?php echo $row['sex']; ?></td>
    <td><?php echo $row['pilgrim_status']; ?></td>
    <td> <input type="submit" value="Register" name="submit" style="padding:5px;" /></td>
  </tr>  
</table>
<?php }else{ ?>
Passport No does not match
<?php } ?>