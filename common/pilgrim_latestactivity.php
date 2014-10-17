<?php if(isset($_REQUEST['latestid']) && ($_REQUEST['latestid']!='')){
if(isset($_REQUEST['action'])){ include('functions.php'); } ?>
<?php $image_th = BASEURL.'image_content/pilgrim/pilgrim_images_th/';
$db = new Database();
$run_latest = $db->query("SELECT * FROM pilgrims WHERE pilgrim_id='".$_REQUEST['latestid']."'"); ?>
<?php $row_latest = $db->fetch($run_latest); ?>

	<!--  start related-activities -->
	<div id="related-activities">
		
		<!--  start related-act-top -->
		<div id="related-act-top">
		<img src="../images/forms/header_related_act.gif" width="271" height="43" alt="" />
		</div>
		<!-- end related-act-top -->
		
		<!--  start related-act-bottom -->
		<div id="related-act-bottom">
		
			<!--  start related-act-inner -->
			<div id="related-act-inner">
			
				<div class="left"><!--<a href=""><img src="../images/forms/icon_plus.gif" width="21" height="21" alt="" /></a>--></div>
				<div class="right">
                	<div id="print_area">
                   <!-- <img src="<?php // echo BASEURL."common/"; ?>barcode.php?barcode=<?php // echo $row_latest['passport_no']; ?>" width="240" height="70" align="left" style="float:left; margin-left:0px;" /><br /><br /><br />-->
                   <table border="0" style="margin:-5px;">
                   	  <tr>
                        <td align="center" ><img src="<?php   echo $image_th.$row_latest['pilgrim_id'].'.'.$row_latest['image'];  ?>" align="middle" height="120" /></td>
                      </tr>
                      <tr>
                        <td ><h5 style="margin-bottom:0px;">Name : <?php echo $row_latest['full_name']; ?></h5></td>                        
                      </tr>
                      <tr>
                        <td ><h5 style="margin-bottom:0px;">Passport No : <?php echo $row_latest['passport_no']; ?></h5></td>
                      </tr>
               	     <tr>
                        <td><h5 style="margin-bottom:0px;">Birth's Date. : <?php echo $row_latest['dob']; ?> </h5></td>
                      </tr> 
                      <tr>
                        <td><h5 style="margin-bottom:0px;">Gender. : <?php echo $row_latest['sex']; ?> </h5></td>
                      </tr>
                      <tr>
                        <td><h5 style="margin-bottom:0px;">Passenger Status. : <?php echo $row_latest['pilgrim_status']; ?> </h5></td>
                      </tr>
                      <tr>
                      	<td><h5 style="margin-bottom:0px;">Agency. : <?php echo getstatename($row_latest['state']);  ?></h5></td>
                      </tr>
                      <tr>
                      	<td><h5 style="margin-bottom:0px;">Local Govt. : <?php echo getlganame($row_latest['lga']); ?> </h5></td>  
					  </tr>
                      <tr>
                      	<td align="center"><img src="<?php echo BASEURL."common/"; ?>barcode.php?barcode=<?php echo $row_latest['passport_no']; ?>" width="160" height="50" align="center" />
						</td>
                        		
					</table>                    
                    </div>
				</div>
				<div class="clear"></div>
            <input type="button" value="PRINT" onclick="printContent('print_area')" style="padding:5px;"  />	 
				
			</div>
            
            

            
			<!-- end related-act-inner -->
			<div class="clear"></div>
		
		</div>
		<!-- end related-act-bottom -->
	
	</div>
	<!-- end related-activities -->
<?php } ?>    