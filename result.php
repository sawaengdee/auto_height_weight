<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <title>ประวัติ</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/Login-Form-Basic-icons.css" />
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Brand-Dark-icons.css" />
    <link rel="stylesheet" href="assets/css/styles.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
       th,td{
        text-align:center;
       }
       img{
        width: 25px;
        height: 25px;
       }
    </style>
  </head>
  <body>
  <?php
    include("connect.php");
    session_start();
    include("checksession.php");
    $id = $_SESSION['tech_id'];
      if(isset($_GET['exit']) == 1){
        session_destroy();
        header('Refresh: 0; url = index.php');
      }else{
        $sql = "SELECT fname, lname FROM teacher WHERE tech_id = '$id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        }
      } 
      if(isset($_GET["remove"])){
      
      } 
  ?>
    <nav class="navbar navbar-expand-md bg-dark py-3" data-bs-theme="dark">
        <div class="container">
          <a class="navbar-brand d-flex align-items-center" href="#"
            ><span
              class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon"
              style="height: 85px; width: 85px"
              ><img
                style="
                  height: 100%;
                  width: 100%;
                  max-height: none;
                  max-width: none;
                  border-radius: auto;
                "
                src="assets/img/person.png" 
                /></span
            ><span><?php echo $row["fname"]. $row["lname"] ;?></span></a
          ><button
            data-bs-toggle="collapse"
            class="navbar-toggler"
            data-bs-target="#navcol-5"
          >
            <span class="visually-hidden">Toggle navigation</span
            ><span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navcol-5">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a class="nav-link active" href="homepage.php">หน้าหลัก</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="stdinfo.php">ข้อมูลนักเรียน</a>
              </li>
              <li class="nav-item"><a class="nav-link" href="result.php">ผลการบันทึก</a></li>
            </ul>
            <a class="btn btn-primary ms-md-2" role="button" href="homepage.php?exit=1"
              >ออกจากระบบ</a
            >
          </div>
        </div>
      </nav>

    <div style="margin-top: 299px">
        <div style="text-align-last: end; margin-bottom: 10px;">
        <!-- <input class="" type="text" border="4px">  -->
        <!-- <a type="button" class="btn btn-success">ค้นหา </a>
        <a type="button" class="btn btn-outline-danger"> ยกเลิก</a> -->
        </div>
        <div class="table-responsive-sm">
          <table class="table table-hover table-bordered text-justify" style="height: 100px;">
            <thead class="table-primary">
              <tr>
                <th scope="col" class="align-middle">หมายเลขไอดี</th>
                <th scope="col" class="align-middle">คำนำหน้า</th>
                <th scope="col" class="align-middle">ชื่อ-นามสกุล</th>
                <th scope="col" class="align-middle">วัน-เดือน-ปี เกิด</th>
                <th scope="col" class="align-middle">วันที่บันทึกข้อมูล</th>
                <th scope="col" class="align-middle">อายุ</th>
                <th scope="col" class="align-middle">น้ำหนัก</th>
                <th scope="col" class="align-middle">ส่วนสูง</th>
                <th scope="col" class="align-middle">รูปร่าง</th>
                <!-- <th scope="col"  class="align-middle">การดำเนินการ</th> -->
              </tr>
            </thead>
            <?php
            $sql = " SELECT * FROM student INNER JOIN w_h ON ( id = id_wh ) ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0 ) {
              // output data of each row
              while($row = $result->fetch_assoc()) {              
            ?>
            <tbody>
              <tr>
                <td><?php echo $row["id"] ?></td>
                <td><?php echo $row["prename"] ?></td>
                <td><?php echo $row["name"] ?></td>
                <td><?php echo $row["bdo"] ?></td>
                <td><?php echo $row["time_stamp"] ?></td>
                <td><?php echo $row["age"] ?></td>
                <td><?php echo $row["weight_wh"] ?></td>
                <td><?php echo $row["height_wh"] ?></td>
                <td><?php echo $row["body_wh"] ?></td>
                <!-- <td><a href="stdinfo.php?edit=<?php echo $row["id"] ?>" type="button" class="btn btn-warning" name="edit">แก้ไข</a>   <a href="stdinfo.php?remove=<?php echo $row["id"] ?>" type="button" class="btn btn-outline-danger" name="remove">ลบ</a></td> -->
              </tr>
            <?php } } ?>
            </tbody>
          </table>
        </div>
    </div>
            <div style="text-align-last: end; margin-bottom: 10px;">
                <!-- <button type="button" class="btn btn-outline-success"><img src="img/excel.png" style="height: 25px; width: 25px;"> พิมพ์ข้อมูล</button> -->
            </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
