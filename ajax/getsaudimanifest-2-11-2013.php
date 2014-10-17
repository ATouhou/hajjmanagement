<?php
include("../common/functions.php");  
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
$flight_id = $_REQUEST['flight_id'];


$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM boardingpass  LEFT JOIN agency_seat_allocation USING(allocation_id) WHERE flight_id= $flight_id AND bconfirmation='Yes' ORDER BY boardingpass.createdon DESC LIMIT $start, $nor");
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
	$carrier_id = $row_disp['carrier_id'];
}
if(count($show_disp)==0)
{
echo "No record Found";
}else
{
?>
<h3><a href="../common/displaysaudimanifestpdf.php?flight_id=<?php echo base64_encode($flight_id); ?>" target="_blank"><img src="../images/pdf.png" width="32" /></a></h3>    

	<table id="product-table" width="850">
    	<tr>
        	<td align="center"><b>NATIONAL HAJJ COMISSION OF NIGERIA(NAHCON)</b></td>
         </tr>
    	<tr>
        	<td align="center"><b>ROYALITY PAYMENT SLIP</b></td>
         </tr>
    </table>
    <p>&nbsp;</p>
	<table id="product-table" width="850">
    	<tr>
        	<td><b>Flight ID</b></td>
            <td><?php echo getflightno($flight_id); ?>
        	<td><b>Carrier Name</b></td>
            <td><?php echo getcarriername($carrier_id); ?></td>	
        </tr>
    </table>
    <p>&nbsp;</p>
	  <table id="product-table" width="850">
		<thead>
        <tr>
          <th class="table-header-repeat line-left" >S.No</th>
          <th class="table-header-repeat line-left" ><a href="#">Picture</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Name</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Passport No</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Agency</a></th>
          <th class="table-header-repeat line-left" ><a href="#">L.Govt</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Gender</a></th>
          <th class="table-header-repeat line-left" ><a href="#">Status</a></th>
       </tr>
        </thead>
		<tbody>
		<?php   
			$sno = ($current_val*$nor+1);  		foreach($show_disp as $val=>$key ) {
			$run_info = $db->query("SELECT * FROM pilgrims WHERE pilgrim_id='".$key['pilgrim_id']."' AND status='Active'");
			$row_info = $db->fetch($run_info);
			if($row_info['image']==''){			
				if($row_info['sex']='Male'){
					$logo = '../images/male.png';	
				}else{
					$logo = '../images/female.png';				
				}
			}else{
				$image_th = BASEURL.'image_content/pilgrim/pilgrim_images_th/';
				$logo = $image_th.$row_info['pilgrim_id'].'.'.$row_info['image']; 
			}
			
		?>
        <tr>
          <td><?php echo $sno++;  ?></td>
          <td><img src="<?php echo $logo; ?>" width="50" height="50" /></td>
          <td><?php echo $row_info['full_name'];  ?></td>
          <td><?php echo $row_info['passport_no'];  ?></td>
          <td><?php echo getstatename($row_info['state']);  ?></td>
          <td><?php echo getlganame($row_info['lga']);  ?></td>
          <td><?php echo $row_info['sex'];  ?></td>
          <td><?php echo $row_info['pilgrim_status'];  ?></td>
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