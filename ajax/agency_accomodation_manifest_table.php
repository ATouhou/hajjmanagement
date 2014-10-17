<?php
if(isset($_REQUEST['val'])){ include("../common/functions.php");  }
$db = new Database();
$current_val=0;
$start =0;
$nor = NOR;
$limit = $nor;
$id = base64_decode($_REQUEST['id']);

if(isset($_GET['val']))
{
	$current_val=$_GET['val'];
	$id=$_REQUEST['id'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}
$run_accomodationinfo = $db->query("SELECT * FROM accomodation WHERE agency_id='".$_SESSION['agency_id']."' AND id='".$id."'");
$row_accomodationinfo = $db->fetch($run_accomodationinfo);


$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM accomodation_manifest WHERE agency_id='".$_SESSION['agency_id']."' AND accomodation_id='".$id."' ORDER BY created_on DESC LIMIT $start, $nor");
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
          <th class="table-header-repeat line-left" ><a href="#">S.No</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Pilgrim Name</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Passport No</a></th>
          <th class="table-header-repeat line-left" ><a href="#">LGA</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Room No</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Status</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Agency</a></th>
       </tr>
        </thead>
		<tbody>
		<?php foreach($show_disp as $val=>$key ) {
			$run_pilgrim = $db->query("SELECT * FROM pilgrims WHERE pilgrim_id='".$key['pilgrim_id']."' AND status='Active'");
			$row_pilgrim = $db->fetch($run_pilgrim);
			
		?>
        <tr>
          <td><?php echo ++$start; ?></td>
          <td><a href="#" onclick="displayinfo('<?php echo base64_encode($key['manifest_id']); ?>'); return false;"><?php echo $row_pilgrim['full_name'];  ?></a></td>
          <td><?php echo $row_pilgrim['passport_no'];  ?></td>
          <td><?php echo getlganame($row_pilgrim['lga']);  ?></td>
          <td><?php echo $key['bed_no'];  ?></td>
          <td><?php echo $row_pilgrim['sex'];  ?></td>
          <td><?php echo getstatename($row_pilgrim['state']);  ?></td>
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