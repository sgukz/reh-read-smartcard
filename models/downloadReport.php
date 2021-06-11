<?php
/*
 * ส่งออกรายงานเป็น excel
 */
ini_set('max_execution_time', 1000);
ini_set('memory_limit', '-1');
date_default_timezone_set('Asia/Bangkok');
include('../config/db.php');
//require './connectDB.php';
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="รายชื่อผู้รับเสื้อแล้วทั้งหมด.xls"');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></meta>
    </head>
    <body STYLE='font-family:TH SarabunPSK;'>
        <table width="950" style="font-size: 14pt;" border="1" cellpadding="1" cellspacing="0">
            <tr>
                <th colspan="10">รายชื่อผู้รับเสื้อแล้วทั้งหมด </th>
            </tr>
            <tr height="50" style="padding: 25px;">
                <th class="text-center" width="50">ลำดับ</th>
                <th class="text-center" width="200">ประเภทการวิ่ง</th>
                <th class="text-center" width="200">เลขบัตรประชาชน | Passport</th>
                <th class="text-center" width="200">ชื่อ-สกุล</th>
                <th class="text-center" width="150">เบอร์ติดต่อ</th>
                <th class="text-center" width="100">เพศ</th>
                <th class="text-center" width="100">ช่วงอายุ</th>
                <th class="text-center" width="100">ไซต์เสื้อ</th>
                <th class="text-center" width="200">วันที่รับเสื้อ</th>
                <th class="text-center" width="200">สถานะ</th>
            </tr>
            <?php
            $i = 1;
            $query = mysql_query("SELECT * FROM list_name_new WHERE status_shirt = 9 GROUP BY `type`");
            while ($rs = mysql_fetch_array($query)) {
                    ?>
                    <tr>
                        <td align="center" style="padding: 2px;">
                            <?php echo $i; ?>
                        </td>
                        <td class=""  style="padding: 2px;">
                            <?php
                            echo $rs['type'];
                            ?>
                        </td>
                        <td  style="padding: 2px;">
                            <?php
                            echo $rs['cid'];
                            ?>
                        </td>
                        <td style="padding: 2px;">
                            <?php
                            echo $rs['name'];
                            ?>
                        </td>
                        <td style="padding: 2px;" align="center">
                            <?php
                            echo '&nbsp;'.$rs['phone_number'];
                            ?>
                        </td>
                        <td style="padding: 2px;" align="center">
                            <?php
                            echo ($rs['sex'] == 'M')? 'ชาย': 'หญิง';
                            ?>
                        </td>
                        <td style="padding: 2px;" align="center">
                            <?php
                            echo $rs['age'];
                            ?>
                        </td>
                        <td style="padding: 2px;" align="center">
                            <?php
                            echo $rs['size'];
                            ?>
                        </td>
                        <td style="padding: 2px;" align="center">
                            <?php
                            echo $rs['last_update'];
                            ?>
                        </td>
                        <td style="padding: 2px;" align="center">
                            <?php
                            echo ($rs['status_shirt'] == 9)? 'รับเสื้อแล้ว': 'ยังไม่รับเสื้อ';
                            ?>
                        </td>
                    </tr>
                    <?php
                    $i++;}
                    ?>  
            <?php
            mysql_close();
            ?>
        </table>
    </body>
</html>