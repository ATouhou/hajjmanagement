<?php
if(isset($_REQUEST['val'])){	include("../common/functions.php"); }
$db = new Database();
$current_val=0;
$image_th = BASEURL.'image_content/agency/agency_images_icon/';
$total = $db->query("SELECT * FROM agency ORDER BY agency_name, agency_status");
$total_val = $db->total();
$start =0;
$nor = NOR;
$limit =$nor;
if(isset($_GET['val']))
{
	$current_val=$_GET['val'];
	$start = ($nor*$current_val);	
	$limit = ($current_val+1)*$nor;
}
$run_disp = $db->query("SELECT * FROM agency ORDER BY agency_name, agency_status  LIMIT $start, $nor");
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
          <th class="table-header-repeat line-left" ><a href="">Logo</a></th>
          <th class="table-header-repeat line-left" ><a href="">Agnecy Name</a></th>
          <th class="table-header-repeat line-left" ><a href="">Admin</a></th>
          <th class="table-header-repeat line-left" ><a href="">Phone No</a></th>
          <th class="table-header-repeat line-left" ><a href="">Options</a></th>
<!--          <th class="table-header-repeat line-left" width="85"><a href="">Edit</a></th>
          <th class="table-header-repeat line-left" width="86"><a href="">Delete</a> </th>
          <th class="table-header-repeat line-left" width="85"><a href="">Status</a></th>
-->     </tr>
        </thead>
		<tbody>
		<?php foreach($show_disp as $val=>$key ) { ?>
        <tr>
          <td><img src="<?php echo $image_th.$key['agency_id'].'.'.$key['agency_logo'];  ?>" /></td>
          <td><?php echo $key['agency_name'];  ?></td>
          <td><?php echo $key['agency_adminname'];  ?></td>
          <td><?php echo $key['agency_phoneno'];  ?></td>
			  <td><div align="center"><a href="<?php echo ADMIN; ?>add_agency.php?agency_id=<?php echo $key['agency_id']; ?>" title="Edit" class="icon-1 info-tooltip"></a>
<div id="status_<?php echo $key['agency_id']; ?>" style="width:40px; float:left;">
		<a href="#"  title="<?php echo $key['agency_status']; ?>" onclick="changeagencystatus('status','<?php echo $key['agency_id']; ?>','<?php echo $key['agency_status']; ?>'); return false;" class="<?php if($key['agency_status']=='Active'){ echo "icon-5 info-tooltip"; }else echo "icon-3 info-tooltip"; ?>"></a>
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
          <th colspan="5">Total No of agency Test : <?php echo $total_val; ?></th>
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