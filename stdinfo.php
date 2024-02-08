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
        $remove = $_GET["remove"];
        
        $sql = "UPDATE esp8266 SET status_finger=2, RT_ID='$remove' WHERE id=1";
        mysqli_query($conn, $sql);


        header('Refresh: 1; url = addfingerprint.php');
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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addinfostd" >เพิ่มข้อมูลนักเรียน</button>

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
                <th scope="col"  class="align-middle">การดำเนินการ</th>
              </tr>
            </thead>
            <?php
            $sql = "SELECT * FROM student";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
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
                <td><?php echo $row["weight"] ?></td>
                <td><?php echo $row["height"] ?></td>
                <td><?php echo $row["body"] ?></td>
                <td><a href="stdinfo.php?remove=<?php echo $row["id"] ?>" type="button" class="btn btn-outline-danger" name="remove">ลบ</a></td>
              </tr>
            <?php } } ?>
            </tbody>
          </table>
        </div>
    </div>
            <div style="text-align-last: end; margin-bottom: 10px;">
                <!-- <button type="button" class="btn btn-outline-success"><img src="img/excel.png" style="height: 25px; width: 25px;"> พิมพ์ข้อมูล</button> -->
            </div>
 
    <div class="modal fade" id="addinfostd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลนักเรียน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action ="get_arduino.php" method="POST">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">คำนำหน้า</label>
                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="prename">
                            <option value="ด.ช.">ด.ช.</option>
                            <option value="ด.ญ.">ด.ญ.</option>
                            <option value="นาย">นาย</option>
                            <option value="นางสาว">นางสาว</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">ชื่อ-นามสกุล</label>
                        <input type="text" class="form-control" id="recipient-name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">วัน-เดือน-ปี เกิด</label>
                        <input type="date" class="form-control" id="recipient-name" name="bdo">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">อายุ</label>
                        <input type="text" class="form-control" id="recipient-name" name="age">
                    </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <input type="submit" class="btn btn-primary" value="ถัดไป" name="submit1" id="submit1">
                <script>
                </script>
              </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
