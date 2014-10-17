<?php

include("../common/functions.php");
$db = new Database();
print_r( $_POST );
print_r( $_SESSION );

$bno = rand( 100000, 999999 ) . rand( 100000, 999999 );

$db->query( "INSERT INTO `boardingpass` (`bno` ,`eno` ,`pilgrim_id` ,`seat_no` ,`createdon` ,`allocation_id` ,`createdby` ,`status`,eticket_id)VALUES ('" . $bno . "', '" . $_POST[ 'eno' ] . "', '" . $_POST[ 'pilgrim_id' ] . "', '" . $_POST[ 'seats1' ] . "',CURRENT_TIMESTAMP , '" . $_POST[ 'allocation_id1' ] . "', '" . $_SESSION[ 'uid' ] . "', 'Active'," . $_POST[ 'eitcketrow1_id' ] . ")" );
$run = $db->query( "SELECT seats_no_alloted FROM agency_seat_allocation WHERE allocation_id ='" . $_POST[ 'allocation_id1' ] . "'" );
$row = $db->fetch( $run );
$seats_no_alloted = $row[ 'seats_no_alloted' ] . "," . $_POST[ 'seats1' ];
$db->query( "UPDATE agency_seat_allocation SET seats_no_alloted='" . $seats_no_alloted . "' WHERE allocation_id='" . $_POST[ 'allocation_id1' ] . "' " );
$id1 = $bno;
$bno = rand( 100000, 999999 ) . rand( 100000, 999999 );
if ( $_POST[ 'path' ] == 2 ) {
    $db->query( "INSERT INTO `boardingpass` (`bno` ,`eno` ,`pilgrim_id` ,`seat_no` ,`createdon` ,`allocation_id` ,`createdby` ,`status`,eticket_id)VALUES ('" . $bno . "', '" . $_POST[ 'eno' ] . "', '" . $_POST[ 'pilgrim_id' ] . "', '" . $_POST[ 'seats2' ] . "',CURRENT_TIMESTAMP , '" . $_POST[ 'allocation_id2' ] . "', '" . $_SESSION[ 'uid' ] . "', 'Active'," . $_POST[ 'eitcketrow2_id' ] . ")" );
    $run = $db->query( "SELECT seats_no_alloted FROM agency_seat_allocation WHERE allocation_id ='" . $_POST[ 'allocation_id2' ] . "'" );
    $row = $db->fetch( $run );
    $seats_no_alloted = $row[ 'seats_no_alloted' ] . "," . $_POST[ 'seats2' ];
    $db->query( "UPDATE agency_seat_allocation SET seats_no_alloted='" . $seats_no_alloted . "' WHERE allocation_id= '" . $_POST[ 'allocation_id2' ] . "' " );
    $id1 .= '&id2=' . $bno;
}

$link = 'displayboardingpass.php?id1=' . $id1;
notify( 'success', 'Eticket Created successfully' );

header( 'Location:' . $_SESSION[ 'basemodule' ] . $link );
?>