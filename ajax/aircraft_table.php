<?php
if(isset($_REQUEST['val'])){ include("../common/functions.php");  }
$db = new Database();
$current_val=0;
$start =0;
$nor = NOR;
$limit = $nor;
$image_th = BASEURL.'image_content/aircraft/aircraft_images_icon/';
$total = $db->query("SELECT * FROM aircraft WHERE agency_id='".$_SESSION['agency_id']."' ORDER BY createdon");
$total_val = $db->total();
$nop = ceil($total_val/NOR);
if(isset($_GET['val']))
{
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}
$run_disp = $db->query("SELECT * FROM aircraft WHERE agency_id='".$_SESSION['agency_id']."' ORDER BY createdon  LIMIT $start, $nor");
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
          <th class="table-header-repeat line-left" ><a href="">Model</a></th>
          <th class="table-header-repeat line-left" ><a href="">Manufacturer Name</a></th>
          <th class="table-header-repeat line-left" ><a href="">Rows</a></th>
          <th class="table-header-repeat line-left" ><a href="">Column</a></th>
          <th class="table-header-repeat line-left" ><a href="">Edit Seats</a></th>
          <th class="table-header-repeat line-left" ><a href="">Options</a></th>
       </tr>
        </thead>
		<tbody>
		<?php foreach($show_disp as $val=>$key ) { ?>
        <tr>
          <td><?php echo $key['model'];  ?></td>
          <td><a href="#" onclick="displayinfo('<?php echo $key['aircraft_id']; ?>'); return false;"><?php echo $key['manufacturer'];  ?></a></td>
          <td><?php echo $key['nor'];  ?></td>
          <td><?php echo $key['noc'];  ?></td>
          <td><a href="<?php echo $_SESSION['basemodule'].'aircraftseatallocation.php?latestid='.$key['aircraft_id']; ?>">Edit Seats</a></td>
			  <td><div align="center"><a href="<?php echo $_SESSION['basemodule']; ?>addaircraft.php?aircraft_id=<?php echo $key['aircraft_id']; ?>" title="Edit" class="icon-1 info-tooltip"></a>
<!--<a href="#" title="Delete" onclick="addaircraft('delete',<?php // echo $key['aircraft_id']; ?>);" class="icon-2 info-tooltip"  ></a>          
-->
<div id="status_<?php echo $key['aircraft_id']; ?>" style="width:40px; float:left;">
		<a href="#"  title="<?php echo $key['status']; ?>" onclick="changeaircrafttatus('status','<?php echo $key['aircraft_id']; ?>','<?php echo $key['status']; ?>'); return false;" class="<?php if($key['status']=='Active'){ echo "icon-5 info-tooltip"; }else echo "icon-3 info-tooltip"; ?>"></a>
</div>

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
          <th  colspan="2" align="left" width="300">Total No of aircraft : <?php echo $total_val; ?></th>
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