<?php
    // $HOST_NAME = '61.19.254.4';
    // $USER_NAME = 'rehit';
    // $PASS_WORD = 'IT@101';
    // $DB_NAME = 'db_itreh';
    $HOST_NAME = 'localhost';
    $USER_NAME = 'root';
    $PASS_WORD = '';
    $DB_NAME = 'rundata_db';
    $ENCODE = "SET NAMES UTF8";
    $mysql = mysql_connect($HOST_NAME, $USER_NAME, $PASS_WORD);
    if (!$mysql) {
        die('Could not connect: ' . mysql_error());
        exit;
    } else {
        mysql_select_db($DB_NAME);
        mysql_query($ENCODE);
    }