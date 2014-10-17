<?php if(isset($_REQUEST['mid']) && ($_REQUEST['mid']!='')){ 
if(isset($_REQUEST['action'])){ include('functions.php'); } ?>

<?php 
$image_th = BASEURL.'image_content/pilgrim/pilgrim_images_th/';
$db = new Database();
//echo base64_decode($_REQUEST['mid']);
$run_latest = $db->query("SELECT * FROM  accomodation_manifest LEFT JOIN accomodation ON accomodation_manifest.accomodation_id=accomodation.id LEFT JOIN pilgrims USING (pilgrim_id) WHERE accomodation_manifest.manifest_id='".base64_decode($_REQUEST['mid'])."'"); ?>
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

		    <div class="right">
                    <div id="print_area">
                    <table>
                      <tr>
                        <td align="center" style="border: #000 1px solid;"><strong>ACCOMODATION VOUCHER</strong></td>
                      </tr>
                      <tr>
                        <td style="border: #000 1px solid;"><img src="<?php echo $image_th.$row_latest['pilgrim_id'].'.'.$row_latest['image'];  ?>" /></td>
                      </tr>
                      <tr>
                        <td style="font-size:10px;border: #000 1px solid;"><strong>NAME</strong> <?php echo $row_latest['full_name']; ?></td>
                      </tr>
                      <tr>
                        <td style="font-size:10px;border: #000 1px solid;"><strong>PASSPORT NO</strong> <?php echo $row_latest['passport_no']; ?></td>
                      </tr>
                      <tr>
                        <td style="font-size:10px;border: #000 1px solid;"><strong>LOCAL GOVT</strong> <?php echo getlganame($row_latest['lga']); ?></td>
                      </tr>
                      <tr>
                        <td style="font-size:10px;border: #000 1px solid;"><strong><?php echo $row_latest['name']; ?></strong></td>
                      </tr>
                      <tr>
                        <td style="font-size:10px; border: #000 1px solid;"><strong>ROOM NO</strong> <?php echo $row_latest['bed_no']; ?></td>
                      </tr>
                      <tr>
                        <td style="font-size:10px;border: #000 1px solid;"><strong>ADDRESS</strong> <?php echo $row_latest['address']; ?></td>
                      </tr>
                      <tr>
                        <td style="font-size:10px;border: #000 1px solid;"><strong>ACCOM. DURATION</strong> <?php echo $row_latest['email_id']; ?> DAYS</td>
                      </tr>
                      <tr>
                        <td style="font-size:10px;border: #000 1px solid;"><strong>TELEPHONE</strong> <?php echo $row_latest['phone_no']; ?></td>
                      </tr>
                    </table>

                    
                    
    <!--					<img src="<?php echo $image_th.$row_latest['eid'].'.'.$row_latest['image'];  ?>" />
                        <h5>Employee Id</h5><?php echo $row_latest['eid']; ?>
                        <h5>User Name</h5><?php echo $row_latest['username']; ?>
                        <h5>Name</h5><?php echo $row_latest['name']; ?>
                        <h5>Category</h5><?php echo getcategoryname($row_latest['cid']); ?>
     -->                   
              </div>    
			  </div>
				<div class="clear"></div>
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