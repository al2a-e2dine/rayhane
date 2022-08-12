<?php
include_once('inc/connect.php');

session_start();

if(isset($_SESSION['user_id'])){
    header('location:index.php');
}

if(isset($_POST['user_login'])){
    $username=$_POST['username'];
    $password=$_POST['password'];

    $q="SELECT * FROM `users` WHERE `username`='$username' and `password`='$password'";
    $r=mysqli_query($dbc,$q);
    $num=mysqli_num_rows($r);

    if($num==1){
        $row=mysqli_fetch_assoc($r);

            if($row['archived']==0){
                $_SESSION['user_id']=$row['id'];
                $_SESSION['user_fullname']=$row['fullname'];
                $_SESSION['user_phone']=$row['phone'];
                $_SESSION['user_username']=$row['username'];
                header('location:index.php');
            }else{
                $msg="تم حذف هذا الحساب";
            }
        
    }else{
        $msg="هناك خطأ في اسم المستخدم أو كلمة السر";
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>مركز الريحان</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">مرحبا بعودتك</h1>

                                    <?php if(isset($msg)){ ?>
                                        <div class="alert alert-info">
                                            <strong>مركز الريحان!</strong> <?= $msg ?>
                                        </div>
                                    <?php } ?>

                                    </div>
                                    <form class="user" action="user_login.php" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                placeholder="اسم المستخدم" name="username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="كلمة السر" name="password" required>
                                        </div>
                                        <input type="submit" name="user_login" class="btn btn-primary btn-user btn-block" value="تسجيل الدخول">
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="index.php">الصفحة الرئيسية</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="user_register.php">انشاء حساب جديد</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>