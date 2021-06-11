<?php
include('../config/db.php');
if ($_POST) {
    $cid = $_POST['cid'];
    $group = $_POST['group'];
    if ($cid != "") {
        $sql = "UPDATE list_name_62 SET status_shirt = 1, recip_cid = '', recip_name = '', recip_tel = '', recip_status = null WHERE cid = '$cid'";
    }else{
        $sql = "UPDATE list_name_62 SET status_shirt = 1, recip_cid = '', recip_name = '', recip_tel = '', recip_status = null WHERE group_name = '$group'";
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
            'status' => '400'
        );
    }
    echo json_encode($data);
}
