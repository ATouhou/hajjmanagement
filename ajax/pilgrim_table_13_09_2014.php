<?php
if(isset($_REQUEST['val'])){ include("../common/functions.php");  }
$db = new Database();
$current_val=0;
$start =0;
$nor = NOR;
$limit = $nor;
$image_th = BASEURL.'image_content/pilgrim/pilgrim_images_icon/';
if($_SESSION['cid']==1){ $cond =''; }else { $cond = 'WHERE state="'.$_SESSION['agency_id'].'"'; }
//if($_SESSION['cid']==1){ $cond =''; }else { $cond = 'WHERE agency="'.$_SESSION['agency_id'].'"'; }
$total = $db->query("SELECT * FROM pilgrims ".$cond."");

$total_val = $db->total();
$nop = ceil($total_val/NOR);
if(isset($_GET['val']))
{
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}
$run_disp = $db->query("SELECT * FROM pilgrims ".$cond." ORDER BY  registration_date DESC,full_name, pilgrim_status  LIMIT $start, $nor");
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
          <th class="table-header-repeat line-left" ><a href="">Full Name</a></th>
          <th class="table-header-repeat line-left" ><a href="">Passport No.</a></th>
          <th class="table-header-repeat line-left" ><a href="">Agency</a></th>
          <th class="table-header-repeat line-left" ><a href="">Options</a></th>
<!--          <th class="table-header-repeat line-left" width="85"><a href="">Edit</a></th>
          <th class="table-header-repeat line-left" width="86"><a href="">Delete</a> </th>
          <th class="table-header-repeat line-left" width="85"><a href="">Status</a></th>
-->     </tr>
        </thead>
		<tbody>
		<?php foreach($show_disp as $val=>$key ) { ?>
        <tr>
          <td><img src="<?php echo $image_th.$key['pilgrim_id'].'.'.$key['image'];  ?>" /></td>
          <td><a href="#" onclick="displayinfo('<?php echo $key['pilgrim_id']; ?>'); return false;"><?php echo $key['full_name'];  ?></a></td>
          <td><?php echo $key['passport_no'];  ?></td>
          <td><?php echo getstatename($key['state']);  ?></td>
		  <td><div align="center"><a href="<?php echo $_SESSION['basemodule']; ?>newpilgrim.php?pilgrim_id=<?php echo $key['pilgrim_id']; ?>" title="Edit" class="icon-1 info-tooltip"></a>
<!--<a href="#" title="Delete" onclick="addpilgrim('delete',<?php // echo $key['pilgrim_id']; ?>);" class="icon-2 info-tooltip"  ></a>          
-->
<div id="status_<?php echo $key['pilgrim_id']; ?>" style="width:40px; float:left;">
		<a href="#"  title="<?php echo $key['status']; ?>" onclick="changepilgrimstatus('status','<?php echo $key['pilgrim_id']; ?>','<?php echo $key['status']; ?>'); return false;" class="<?php if($key['status']=='Active'){ echo "icon-5 info-tooltip"; }else echo "icon-3 info-tooltip"; ?>"></a>
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