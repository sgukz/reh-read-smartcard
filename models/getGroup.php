<?php
include('../config/db.php');
if ($_POST) {
    $getGroup = "SELECT group_name FROM list_name_62 WHERE group_name IS NOT NULL GROUP BY group_name ORDER BY group_name";
    $query = mysql_query($getGroup);
    $array_group = array();
    while($rs = mysql_fetch_array($query)){
        array_push($array_group, $rs['group_name']);
    }
    $data = array(
        'groupname' => $array_group,
        'status' => '200',
    );
    echo json_encode($data);
}