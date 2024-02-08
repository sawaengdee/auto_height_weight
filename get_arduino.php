<head>    
    <script script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
  <?php
  require_once("connect.php");
  if(isset($_GET["status"])){

    $status = $_GET["status"];
    $sql = "UPDATE esp8266 SET status='$status' WHERE id=1";
    mysqli_query($conn, $sql);

  }

if(empty($_POST["prename"]) or empty($_POST["name"]) or empty($_POST["bdo"]) or empty($_POST["age"])){
   ?>
            <script>Swal.fire({
                icon: "error",
                title: "เกิดข้อผิดพลาด",
                text: "กรุณากรอกข้อมูลให้ครบ",
            });</script>
  <?php
            header('Refresh: 2; url = stdinfo.php');
  }else{
    $prename = $_POST["prename"];
    $name = $_POST["name"];
    $bdo = $_POST["bdo"];
    $age = $_POST["age"];

    $date2 = new DateTime();
    $date2->setTimezone(new DateTimeZone('Asia/Bangkok'));
    $date = $date2->format("Y-m-d H:i:s");

  $sql = "SELECT id FROM student";
  $result = $conn->query($sql);
  $i = 1;
  if ($result->num_rows > 0) {
  // output data of each row

    while($row = $result->fetch_assoc()) {
      if($i == $row["id"]){
        $i = $i + 1;
      }
    }
  }
    $sql = "INSERT INTO student (id, prename, name, bdo, time_stamp, age)
    VALUES ('$i', '$prename', '$name', '$bdo', '$date','$age');";
    mysqli_query($conn, $sql);

    
    $sql = "UPDATE esp8266 SET RT_ID='$i', status_finger=1 WHERE id=1";
    mysqli_query($conn, $sql);

    $sql = "SELECT *FROM esp8266 WHERE id = 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
    if($row["status"] == 1){
      ?>
          <script>Swal.fire({
        icon: "info",
        title: "กำลังสแกนลายนิ้วมือ",
        text: "โปรดนำมือแต่ที่ตัวสแกนลายนิ้วมือจนกว่าจะมีข้อความแจ้งเตือนเสร็จสิ้น",
});</script>
      <?php
    }else{
      ?>
      <script>Swal.fire({
    icon: "error",
    title: "ตรวจพบปัญหา",
    text: "เครื่องสแกนลายนิ้วมือไม่พร้อมใช้งาน",
});</script>
  <?php
    }
    ?>


<?php
header('Refresh: 10; url = addfingerprint.php');
  }
  
?>

</body>
