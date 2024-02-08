<?php

    require_once("connect.php");
    if(isset($_GET["weight"]) && isset($_GET["height"])&& isset($_GET["finger_id"])){
        $weight = $_GET["weight"];
        $height = $_GET["height"];
        $finger_id = $_GET["finger_id"];
        $sql = "UPDATE esp8266 SET weight='$weight', height='$height',finger_id='$finger_id'  WHERE id=1";
        mysqli_query($conn, $sql);
    }

    $sql = "SELECT *FROM esp8266 WHERE id = 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
    
    $weight = $row["weight"];
    $height = $row["height"];
    $finger_id = $row["finger_id"];


    if($finger_id != 0 && $weight > 5 && $height > 5){
        echo"hello";
        $date2 = new DateTime();
        $date2->setTimezone(new DateTimeZone('Asia/Bangkok'));
        $date = $date2->format("Y-m-d H:i:s");

        $h2 = $height/100;
        $bmi = $weight / ($h2*$h2);
        if($bmi > 30.0){
          $body = "อ้วนมาก";
        }else if($bmi > 25.0 && $bmi < 29.9){
          $body = "อ้วน";
        }else if($bmi > 18.6 && $bmi < 24.0){
          $body = "น้ำหนักปกติ";
        }else if($bmi < 18.5){
          $body = "ผอมเกินไป";
        }else{
            //
        }

        $sql = "INSERT INTO w_h (id_wh, weight_wh, height_wh, time_stamp_wh, body_wh)
        VALUES ('$finger_id', '$weight', '$height', '$date', '$body');";
        mysqli_query($conn, $sql);

        $sql = "UPDATE student SET weight='$weight', height='$height', body='$body' WHERE id='$finger_id'";
        mysqli_query($conn, $sql);
    }
    header('Refresh: 3; url = get_w_h_id.php');
    

?>