<?php
include('../config/db.php');
if ($_POST) {
    $cid = $_POST['cid'];
    $group = $_POST['group'];
    $recip_cid = $_POST['recip_cid'];
    $recip_name = $_POST['recip_name'];
    $recip_tel = $_POST['recip_tel'];
    $recip_status = $_POST['recip_status'];
    if ($cid != "") {
        $sql = "UPDATE list_name_62 SET status_shirt = 9, recip_cid = '$recip_cid', recip_name = '$recip_name', recip_tel = '$recip_tel', recip_status = $recip_status  WHERE cid = '$cid'";
    } else {
        $sql = "UPDATE list_name_62 SET status_shirt = 9, recip_cid = '$recip_cid', recip_name = '$recip_name', recip_tel = '$recip_tel', recip_status = $recip_status  WHERE group_name = '$group'";
    }
    $query = mysql_query($sql);
    if ($query) {
        $data = array(
            'message' => 'successfully.',
            'status' => '200'
        );
    } else {
        $data = array(
            'message' => 'failed !!!',
            'debug' => $sql,
            'status' => '400'
        );
    }

    // $data = array(
    //     'cid' => $cid,
    //     'group' => $group,
    //     'status' => '200'
    // );
    echo json_encode($data);
}
