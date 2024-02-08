<?php
    require_once("connect.php");

    $sql = "SELECT *FROM esp8266 WHERE id = 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
    if($row["status_finger"] == 1){
        $ID = array("RT_ID" => $row["RT_ID"], "status_finger" => $row["status_finger"]);
        echo json_encode($ID);
        header('Refresh: 10; url = addfingerprint.php'); 
    }
    if($row["status_finger"] == 2){
        $id = $row["RT_ID"];
        $sql = "DELETE FROM student WHERE id='$id'";
        mysqli_query($conn, $sql);
        $ID = array("RT_ID" => $row["RT_ID"], "status_finger" => $row["status_finger"]);
        echo json_encode($ID);
        header('Refresh: 10; url = addfingerprint.php'); 
    }
    if($row["status_finger"] == 0 && $row["del_or_add"] == 0){ ?>
        <head>    
            <script script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">
        </head>
        <body>
            <script>Swal.fire({
                icon: "success",
                title: "บันทึกลายนิ้วมือเสร็จสิ้น",
                text: "สามารถนำมือออกจากตัวสแกนได้",
            });</script>
            <?php header('Refresh: 3; url = stdinfo.php');  ?>
        </body>
        
    <?php }
    if($row["status_finger"] == 0 && $row["del_or_add"] == 1){ ?>
        <head>    
            <script script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">
        </head>
        <body>
            <script>Swal.fire({
                icon: "success",
                title: "ลบข้อมูลแล้ว",
                text: "ลบข้อมูลออกจากระบบเรียบร้อย",
            });</script>
            <?php header('Refresh: 3; url = stdinfo.php');  ?>
        </body>
    <?php }
    
?>


