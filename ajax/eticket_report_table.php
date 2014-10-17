<?php
if(isset($_REQUEST['val'])){ include("../common/functions.php");   }
$db = new Database();
$current_val=0;
$start =0;
$nor = NOR;
$limit = $nor;
$image_th = BASEURL.'image_content/pilgrim/pilgrim_images_icon/';
$total = $db->query("SELECT DISTINCT(pilgrim_id),passport_no,image,full_name, lga,eno,eticket.createdon FROM eticket LEFT JOIN pilgrims USING(pilgrim_id) WHERE eticket.createdby='".base64_decode($_REQUEST['id'])."' ORDER BY createdon");

$total_val = $db->total();
$nop = ceil($total_val/$nor);
if(isset($_GET['val']))
{
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}
$sql = "SELECT DISTINCT(pilgrim_id),passport_no,image,full_name, lga,eno,eticket.createdon FROM eticket LEFT JOIN pilgrims USING(pilgrim_id) WHERE eticket.createdby='".base64_decode($_REQUEST['id'])."' ORDER BY createdon LIMIT $start,$nor";

$run_disp = $db->query($sql);
$num_disp = $db->total();
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
          <th class="table-header-repeat line-left" ><a href="">Photo</a></th>
          <th class="table-header-repeat line-left" ><a href="">Pilgrim Name</a></th>
          <th class="table-header-repeat line-left" ><a href="">Passport</a></th>
          <th class="table-header-repeat line-left" ><a href="">LGA</a></th>
          <th class="table-header-repeat line-left" ><a href="">E-ticket No</a></th>
          <th class="table-header-repeat line-left" ><a href="">Date & time</a></th>
       </tr>
        </thead>
		<tbody>
		<?php foreach($show_disp as $val=>$key ) { ?>
        <tr>
          <td><img src="<?php echo $image_th.$key['pilgrim_id'].'.'.$key['image'];  ?>" /></td>
          <td><?php echo $key['full_name'];  ?></td>
          <td><?php echo $key['passport_no'];  ?></td>
          <td><?php echo getlganame($key['lga']);  ?></td>
          <td><?php echo $key['eno'];  ?></td>
			  <td><?php echo $key['createdon']; ?>
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
          <a href="#" onclick="pagination(<?php echo $current_val-1; ?>,'<?php echo $_REQUEST['id']; ?>'); return false;"><img src="../images/forms/prev.gif" /></a>
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
          <a href="#" onclick="pagination(<?php echo $current_val+1; ?>,'<?php echo $_REQUEST['id']; ?>'); return false;"><img src="../images/forms/next.gif" /></a>
          <?php
		  }
          ?>
          </th>
        </tr> 
</table>
<?php
}
?>