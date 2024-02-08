<?php
require_once("connect.php");
if(isset($_GET["status_finger"])){

    $status_finger = $_GET["status_finger"];
    $RT_ID = $_GET["RT_ID"];
    $del_or_add = $_GET["del_or_add"];

    $sql = "UPDATE esp8266 SET status_finger='$status_finger', RT_ID='$RT_ID', del_or_add='$del_or_add' WHERE id=1";
    mysqli_query($conn, $sql);
  }

?>