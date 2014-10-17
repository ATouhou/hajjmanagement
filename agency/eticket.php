<?php 
include("../common/functions.php");
include('../common/header.php');
include('../menu/menu_agency_book.php');
$db = new Database();

//echo base64_decode($_REQUEST['id']);
$run = $db->query("SELECT * FROM agency_seat_allocation LEFT JOIN eticket USING (allocation_id) WHERE eno='".base64_decode($_REQUEST['id'])."' ORDER BY eticket.flight_order");
$rec = $db->total();
$data1 = $db->fetch($run);
//$[] = $row;	
$pilgrim_info = $db->query("SELECT * FROM pilgrims WHERE pilgrim_id='".$data1['pilgrim_id']."'");
$pdata = $db->fetch($pilgrim_info);


$flight_info = $db->query("SELECT * FROM flights LEFT JOIN carriers ON flights.agency_id=carriers.carriers_id WHERE flight_id='".$data1['flight_id']."'");
$fdata1 = $db->fetch($flight_info);
if($rec==2)
{
// MEANS RETURN TICKET IS THERE
$data2 = $db->fetch($run);
$flight_info = $db->query("SELECT * FROM flights LEFT JOIN carriers ON flights.agency_id=carriers.carriers_id WHERE flight_id='".$data2['flight_id']."'");
$fdata2 = $db->fetch($flight_info);
}
$path = BASEURL.'image_content/carriers/carriers_images_th/';
?>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">
<div id="page-heading"><h1>Eticket</h1></div>
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="../images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="../images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
        <?php notification(); ?>
        <div style="display:block;" >
            <input type="button" value="PRINT" onclick="printContent('print_area')" style="padding:5px;"  />	&nbsp;&nbsp; <a href="eticket_pdf.php?id=<?php echo $_REQUEST['id']; ?>" target="_blank"><img src="../images/pdf.png" width="32" style="vertical-align:bottom;" /></a>
            </div>
<br />
<br />
				<div class="clear"></div>

<div id="print_area">        
    <table width="650" border="0" id="eticket">
        <tr>
            <td width="281" rowspan="4"><img src="<?php echo $path . $fdata1[ 'carriers_id' ] . '.' . $fdata1[ 'carriers_logo' ]; ?>" width="60" height="60"/></td>
            <td width="51">&nbsp;</td>
            <td width="135">&nbsp;</td>
            <td width="142">&nbsp;</td>
            <td width="19">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" align="center"><strong><font color="#CC6600">ELECTRONIC TICKET</font></strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" align="center"><strong><font color="#CC6600">PASSENGER ITINERARY RECEIPT</font></strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2"><strong><font color="#009966">CARRIER NAME</font>&nbsp;&nbsp;&nbsp;&nbsp;</strong><?php echo $fdata1[ 'carriers_name' ]; ?></td>
            <td>&nbsp;</td>
            <td><strong><font color="#009966">CARRIER IATA CODE:</font>&nbsp;&nbsp;&nbsp;&nbsp;</strong><?php echo $fdata1[ 'iata_code' ]; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2"><strong><font color="#009966">CARRIER ADDRESS</font>&nbsp;&nbsp;&nbsp;&nbsp; </strong><br />
                &nbsp;<?php echo $fdata1[ 'carriers_address' ]; ?></td>
            <td>&nbsp;</td>
            <td><strong><font color="#009966">PHONE NO.</font>&nbsp;&nbsp;&nbsp;&nbsp;</strong>+234 - <?php echo $fdata1[ 'carriers_phoneno' ]; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><b>Agency Name:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php echo getstatename( $data1[ 'agency_id' ] ); ?></td>
            <td>&nbsp;</td>
            <td colspan="2"><strong>Email:&nbsp;&nbsp;</strong><?php echo $fdata1[ 'email' ]; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td rowspan="3"><img src="<?php echo BASEURL . "common/"; ?>barcode.php?barcode=<?php echo $data1[ 'eno' ]; ?>&height=60&width=300"/>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td colspan="3"><strong>Passenger E-ticket No.</strong> <?php echo $data1[ 'eno' ]; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><strong>Date of Issue:</strong> <?php echo $data1[ 'createdon' ]; ?></td>
            <td colspan="2"><strong>Validity</strong>&nbsp;<?php echo $fdata1[ 'validity' ]; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Passenger Information</strong></td>
            <td>&nbsp;</td>
            <td><strong>Passenger Status:</strong><?php echo $pdata[ 'pilgrim_status' ]; ?></td>   
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td height="20"><strong>Full Name Title : </strong></td>    
            <td colspan="2"><?php if ( $pdata[ 'sex' ] == "Male" ) {
    echo "Mr.";
} else {
    echo "Mrs.";
} ?><?php echo $pdata[ 'full_name' ]; ?></td>
            <td rowspan="2"><img src="<?php echo BASEURL . "common/"; ?>barcode.php?barcode=<?php echo $pdata[ 'passport_no' ]; ?>&amp;height=60&amp;width=300" /></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><strong>Passport</strong>: <?php echo $pdata[ 'passport_no' ]; ?></td>
            <td colspan="2"><strong>Nationality</strong>: <?php echo $pdata[ 'nationality' ]; ?> </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="background-color:#333;"><font color="#FFF"><strong>DEPARTURE DATE:&nbsp;&nbsp;&nbsp;</strong><?php echo $fdata1[ 'date2' ]; ?></font></td>
            <td colspan="2"><strong>FLIGHT NO:</strong> &nbsp;<?php echo $fdata1[ 'flight_no' ]; ?> </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="2"><strong><font color="#009966">FROM</font>&nbsp;&nbsp;&nbsp;&nbsp; </strong>
<?php echo getflightlocationname( $fdata1[ 'source' ] ); ?></td>
            <td><strong><font color="#009966">TO</font>&nbsp;&nbsp;&nbsp;&nbsp;</strong>
<?php echo getflightlocationname( $fdata1[ 'destination' ] ); ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><strong>Departing At :</strong> <?php echo $fdata1[ 'time1' ]; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><strong>Arriving At </strong> &nbsp;<?php echo $fdata1[ 'time2' ]; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><strong>Terminal</strong> &nbsp; <?php echo getterminalname( $fdata1[ 'dterminal' ] ); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><strong>Terminal</strong> &nbsp; <?php echo getterminalname( $fdata1[ 'aterminal' ] ); ?></td>
            <td>&nbsp;</td>
        </tr>	 
        <tr>
            <td><strong>Class :</strong> &nbsp;<?php echo $data1[ 'class' ]; ?> </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><strong>BAG :</strong> <?php echo $fdata1[ 'weight' ]; ?> KG </td>
            <td>&nbsp;</td>
        </tr>	
        <tr>
            <td><strong><font color="#009966">BOOKING STATUS:</font>&nbsp;&nbsp;&nbsp;<span class="small">&nbsp;</span></strong><span class="small"><?php echo $data1[ 'bstatus' ]; ?></span></td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
<?php if ( $rec == 2 ) { ?>
            <tr>
                <td style="background-color:#333;"><font color="#FFF"><strong>DEPARTURE DATE:&nbsp;&nbsp;&nbsp;</strong>
    <?php echo $fdata2[ 'date2' ]; ?></font></td>
                <td colspan="2"><strong>FLIGHT NO:</strong>&nbsp;<?php echo $fdata2[ 'flight_no' ]; ?> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="2"><strong><font color="#009966">FROM</font>&nbsp;&nbsp;&nbsp;&nbsp; </strong>
    <?php echo getflightlocationname( $fdata2[ 'source' ] ); ?></td>
                <td><strong><font color="#009966">TO</font>&nbsp;&nbsp;&nbsp;</strong>
    <?php echo getflightlocationname( $fdata2[ 'destination' ] ); ?></td>
                <td>&nbsp;</td>
            </tr>	
            <tr>
                <td><strong>Departing At :</strong> <?php echo $fdata2[ 'time1' ]; ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><strong>Arriving At </strong> <?php echo $fdata2[ 'time2' ]; ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><strong>Terminal</strong> &nbsp; <?php echo getterminalname( $fdata2[ 'dterminal' ] ); ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><strong>Terminal</strong> &nbsp; <?php echo getterminalname( $fdata2[ 'aterminal' ] ); ?></td>
                <td>&nbsp;</td>
            </tr>	 
            <tr>
                <td><strong>Class :</strong> &nbsp;<?php echo $data2[ 'class' ]; ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><strong>BAG :</strong> <?php echo $fdata2[ 'weight' ]; ?> KG </td>
                <td>&nbsp;</td>
            </tr>	
<?php } ?>
        <tr>
            <td height="35"><?php if ( $rec == 2 ) { ?><strong><font color="#009966">BOOKING STATUS:</font>&nbsp;&nbsp;&nbsp;&nbsp;</strong><?php echo $data2[ 'bstatus' ]; ?><?php } ?></td>
            <td colspan="2"><strong>AIR FARE&nbsp;&nbsp;&nbsp;&nbsp;</strong><?php echo $fdata1[ 'price' ]; ?></td>
            <td><strong>MODE OF PAYMENT&nbsp;&nbsp;&nbsp;&nbsp; </strong><?php echo $data1[ 'mop' ]; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5"><span class="small">&nbsp;AT CHECK-IN, PLEASE SHOW A PICTURE IDENTIFICATION AND THE DOCUMENT YOU GAVE FOR REFERENCE AT THE RESERVATION TIME. NOTE:RETURN DATE IS SUBJECT TO CONFIRMATION AND AVAILABILITY OF SCREENING BAY. </span></tr>
        <tr>
            <td colspan="5"><span class="small">ENDORESEMENT: <strong>NONE ENDORESABLE</strong></span>  </tr>
        <tr>
            <td colspan="5"><hr /></td>
        </tr>
        <tr>
            <td colspan="5" align="center"><strong><font color="#FF0000" size="0.6em" >CONDITIONS OF CARRIAGE</font></strong></td>
        </tr>
        <tr>
            <td colspan="5"><?php echo $fdata1[ 'terms_conditions' ]; ?>   </td>
        </tr>
        <tr>
            <td colspan="5" align="right"><font size="0.6em"><strong>Detailed Conditions of Carriage are available from our offices upon request</strong></font></td>
        </tr>
    </table>
</div>
<br />
				<div class="clear"></div>
            <input type="button" value="PRINT" onclick="printContent('print_area')" style="padding:5px;"  />	 
	</td>
	<td>
       <?php // include('../common/user_latestactivity.php'); ?>
</td>
</tr>
<tr>
<td><img src="../images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
<td></td>
</tr>
</table>
<div class="clear"></div>
</div>
<!--  end content-table-inner  -->
</td>
<td id="tbl-border-right"></td>
</tr>
<tr>
	<th class="sized bottomleft"></th>
	<td id="tbl-border-bottom">&nbsp;</td>
	<th class="sized bottomright"></th>
</tr>
</table>
<div class="clear">&nbsp;</div>
</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer -->
<div class="clear">&nbsp;</div>
<?php include('../common/footer.php'); ?>