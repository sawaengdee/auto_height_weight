<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    />
    <title>หน้าหลัก</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Basic-icons.css" />
    <link  rel="stylesheet"  href="assets/css/Navbar-Centered-Brand-Dark-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="stylesheet" href="assets/css/styles.css">
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
              src="assets/img/person.png" /></span
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
              <li class="nav-item">
              <a class="nav-link" href="result.php">ผลการบันทึก</a>
            </li>
            </li>
          </ul>
          <a class="btn btn-primary ms-md-2" role="button" href="homepage.php?exit=1"
            >ออกจากระบบ</a
          >
        </div>
      </div>
    </nav>

    <div class="container" style="margin-top: 165px;">
      <h1>กราฟแสดงเกณฑ์การเจริญเติบโตเด็กชาย</h1>
      <img src="assets/img/boy1.jpg"/>
      <img src="assets/img/boy2.jpg"/>
      <h1>กราฟแสดงเกณฑ์การเจริญเติบโตเด็กหญิง</h1>
      <img src="assets/img/girl1.jpg"/>
      <img src="assets/img/girl2.jpg"/>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
