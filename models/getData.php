<?php
include('../config/db.php');
if ($_POST) {
    if ($_POST['keyword']!="") {
        $cid = trim($_POST['keyword']);
        $sql = mysql_query("SELECT * FROM list_name_62 WHERE cid = '$cid' OR bib_number = '$cid' OR `name` LIKE '%$cid%'");
    } else if($_POST["dataGroup"]!="") {
        $dataGroup = trim($_POST['dataGroup']);
        $sql = mysql_query("SELECT * FROM list_name_62 WHERE group_name like '%$dataGroup%'");
    }
    $rs = mysql_fetch_array($sql);
    $num_rows = mysql_num_rows($sql);
    if ($num_rows > 0) {
        $cidcard = $rs['cid'];
        $groupname = $rs['group_name'];
        $sex = "";
        $bib_array = array();
        $type_array = array();
        $size_array = array();
        if ($groupname != "") {
            $sqlGetType = "SELECT `type`,COUNT(*) as cnt_type FROM list_name_62 WHERE group_name = '$groupname' GROUP BY `type` ORDER BY `type`";
            $sqlGetSize = "SELECT size,COUNT(*) cntSize FROM list_name_62 WHERE group_name = '$groupname' GROUP BY size";
            $sqlGetBIB = "SELECT CONCAT(bib_category,'-',bib_number) AS bibnumber FROM list_name_62 WHERE group_name = '$groupname'";
        } else {
            $sqlGetType = "SELECT `type`,COUNT(*) as cnt_type FROM list_name_62 WHERE cid = '$cidcard' GROUP BY `type` ORDER BY `type`";
            $sqlGetSize = "SELECT size,COUNT(*) cntSize FROM list_name_62 WHERE cid = '$cidcard' GROUP BY size";
            $sqlGetBIB = "SELECT CONCAT(bib_category,'-',bib_number) AS bibnumber FROM list_name_62 WHERE cid = '$cidcard'";
        }
        $getBib = mysql_query($sqlGetBIB);
        while ($rs_bib = mysql_fetch_array($getBib)) {
            array_push($bib_array, $rs_bib['bibnumber']);
        }
        $getSize = mysql_query($sqlGetSize);
        while ($rs_size = mysql_fetch_array($getSize)) {
            array_push($size_array, $rs_size['size'] . ' (' . $rs_size['cntSize'] . ') ');
        }
        $cntType = mysql_query($sqlGetType);
        while ($rs_type = mysql_fetch_array($cntType)) {
            array_push($type_array, $rs_type['type'] . ' (' . $rs_type['cnt_type'] . ') ');
        }

        $data = array(
            'cid' => $rs['cid'],
            'bib_number' => $bib_array,
            'name' => $rs['name'],
            'sex' => $rs['sex'],
            'phone_number' => $rs['phone_number'],
            'place' => $rs['place'],
            'type' => $type_array,
            'age' => $rs['age'],
            'size' => $size_array,
            'address' => $rs['address'],
            'categoryrun' => $rs['category_run'],
            'groupname' => $rs['group_name'],
            'status_shirt' => $rs['status_shirt'],
            'status' => '200',
            'recipcid' => $rs['recip_cid'],
            'recipname' => $rs['recip_name'],
            'reciptel' => $rs['recip_tel'],
            'recipstatus' => $rs['recip_status'],
            'unit' => $num_rows
        );
    } else {
        $data = array(
            'message' => mysql_error(),
            'status' => '400',
        );
    }
    echo json_encode($data);
}
