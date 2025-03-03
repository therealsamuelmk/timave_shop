<?php
include "connection.php";
session_start();
$logout = mysqli_query($connect,
 "UPDATE `ONLINE_STATUS` SET `USER_STATUS` = 'offline', `EXIT_TIME` = CURRENT_TIMESTAMP() WHERE `ONLINE_STATUS`.`USER_ID` = '".$_SESSION["USER_SESSION"]."'");
session_destroy();
header("location:../index.php");

?>