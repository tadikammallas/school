<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define('__VS_SERVER_PATH',"localhost");
define('__VS_DB_USER',"root");
define('__VS_DB_PSWD',"");
define('__VS_DB_NAME',"SCHOOL");

define('ENCRYPT','base64_encode(CRYPT_STD_DES)');
define("DEFAULTIMG",DS."images".DS."defaultImg.jpg");
define("DATAPATH",DS."data".DS);


define('__VS_PRINT_PRIORITY',5);
printMsg('coming to config file');
include_once(__VS_LIBS_PATH.'db.class.php');
?>