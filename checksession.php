<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
    </style>
</head>
<body>
    
   <?php if(empty($_SESSION['username'])){ ?>
       <script>
            Swal.fire({
                position: "center",
                icon: "warning",
                title: "กรุณาเข้าสู่ระบบ",
                showConfirmButton: false,
                timer: 1900
            });
       </script>
    <?php
        header('Refresh: 2; url = index.php');;
        exit();
        }
    ?>
</body>
</html>

