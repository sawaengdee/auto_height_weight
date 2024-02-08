<?php
require_once("connect.php");
if(isset($_GET["error_msg"])){

    $error_msg = $_GET["error_msg"];

    $sql = "UPDATE esp8266 SET error_msg='$error_msg' WHERE id=1";
    mysqli_query($conn, $sql);
  }

?>