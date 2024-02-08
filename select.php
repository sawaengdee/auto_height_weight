<?php
require_once("connect.php");

$sql = "SELECT * FROM height";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    echo "id: " . $row["id"]. " - Name: " . $row["height"]. "<br>";
  }
}
?>