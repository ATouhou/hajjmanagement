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
$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM lga ORDER BY lga_name DESC LIMIT $start, $nor");
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
          <th class="table-header-repeat line-left" ><a href="#">State Name</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Lga Name</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Options</a></th>
        </tr>
        </thead>
		<tbody>
		<?php foreach($show_disp as $val=>$key ) {		?>
        <tr>
          <td><?php echo getstatename($key['state_id']); ?></a></td>
          <td><?php echo $key['lga_name']; ?></a></td>
          <td>
          <div align="center"><a href="<?php echo ADMIN; ?>addlga.php?id=<?php echo $key['lga_id']; ?>" title="Edit" class="icon-1 info-tooltip"></a>
          <!--<a href="#" title="Delete" onclick="addpilgrim('delete',<?php // echo $key['pilgrim_id']; ?>);" class="icon-2 info-tooltip"  ></a>          
          -->
          <div id="status_<?php echo $key['lga_id']; ?>" style="width:40px; float:left;">
                  <a href="#"  title="<?php echo $key['status']; ?>" onclick="changelgastatus('status','<?php echo $key['lga_id']; ?>','<?php echo $key['status']; ?>'); return false;" class="<?php if($key['status']=='Active'){ echo "icon-5 info-tooltip"; }else echo "icon-3 info-tooltip"; ?>"></a>
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