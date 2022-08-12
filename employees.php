<?php 
session_start();
include_once 'inc/connect.php';
include_once 'inc/function_inc.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
}else{
    if ($_SESSION['user_id']!=1) {
        header('Location: index.php');
    }
}

if(isset($_POST['addEmp'])){
$fullname=$_POST['fullname'];
$username=$_POST['username'];
$phone=$_POST['phone'];
$password=$_POST['password'];
$cpassword=$_POST['cpassword'];

$q="SELECT * FROM `users` WHERE `username`='$username'";
$r=mysqli_query($dbc,$q);
$num=mysqli_num_rows($r);

if($num==0){
    if($password==$cpassword){

        $q="INSERT INTO `users`(`fullname`, `phone`, `username`, `password`) VALUES ('$fullname', '$phone', '$username', '$password')";
        //echo $q; exit();
        $r=mysqli_query($dbc,$q);
        $msg='تمت عملية التسجيل بنجاح';

    }else{
        $msg="كلمتا السر غير متطابقتين";
    }
}else{
    $msg="اسم المستخدم موجود مسبقا";
}
}

if(isset($_POST['updateEmp'])){
    $fullname=$_POST['fullname'];
    $phone=$_POST['phone'];
    $emp_id=$_POST['emp_id'];

    $q="UPDATE `users` SET `fullname`='$fullname',`phone`='$phone' WHERE id='$emp_id'";
        //echo $q; exit();
        $r=mysqli_query($dbc,$q);
        $msg='تمت عملية التعديل بنجاح';
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

    <title>الموظفين</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

    <?php include('inc/sidebar.html'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            <?php include('inc/topbar.html'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800 text-right">الموظفين</h1>

                    <?php if(isset($msg)){ ?>
                    <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>تنبيه</strong> <?= $msg ?>
                    </div>
                    <?php } ?>

                    <?php if(isset($_GET['delete']) and $_GET['delete']==1){ ?>
                    <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>تنبيه</strong> تمت عملية الحذف بنجاح
                    </div>
                    <?php } ?>

                    <?php if(isset($_GET['delete']) and $_GET['delete']==0){ ?>
                    <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>تنبيه</strong> فشلت عملية الحذف، حاول مجددا
                    </div>
                    <?php } ?>

                    <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

                            <?php
                            $q="SELECT * FROM `users` WHERE `archived`=0";
                            $r=mysqli_query($dbc,$q);
                            ?>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><a href="" data-toggle="modal" data-target="#add_emp">موظف جديد +</a></h6>

<!-- begin Modal -->
  <div class="modal fade" id="add_emp">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">موظف جديد</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <form action="employees.php" method="post" dir="rtl">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="الاسم الكامل" name="fullname" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="اسم المستخدم" name="username" required>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" placeholder="رقم الهاتف" name="phone" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="كلمة السر" name="password" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="تأكيد كلمة السر" name="cpassword" required>
            </div>
            <input type="submit" name="addEmp" class="btn btn-primary" value="موظف جديد">
        </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
        </div>
        
      </div>
    </div>
  </div>
<!-- end Modal -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>حذف</th>
                                            <th>تعديل</th>
                                            <th>الحساب</th>
                                            <th>تاريخ التسجيل</th>
                                            <th>رقم الهاتف</th>
                                            <th>كلمة السر</th>
                                            <th>اسم المستخدم</th>
                                            <th>الاسم الكامل</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>حذف</th>
                                            <th>تعديل</th>
                                            <th>الحساب</th>
                                            <th>تاريخ التسجيل</th>
                                            <th>رقم الهاتف</th>
                                            <th>كلمة السر</th>
                                            <th>اسم المستخدم</th>
                                            <th>الاسم الكامل</th>
                                            <th>#</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php while($row=mysqli_fetch_assoc($r)){ ?>
                                        <tr>
                                            <td>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_emp<?= $row['id'] ?>">
                                                حذف
                                                </button>

<!-- begin Modal-->
<div class="modal fade" id="delete_emp<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">حذف</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">هل أنتت متأكد من حذف هذا الموظف ؟</div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">لا</button>
            <a class="btn btn-danger" href="deleteEmp.php?id=<?= $row['id'] ?>">نعم</a>
        </div>
    </div>
</div>
</div>
<!-- end Modal-->
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#update_emp<?= $row['id'] ?>">
                                                تعديل
                                                </button>

<!-- begin Modal -->
  <div class="modal fade" id="update_emp<?= $row['id'] ?>">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">تعديل</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <?php
            $id=$row['id'];
            $empInfo=getInfoById('users',$id);
            ?>
        <form action="employees.php" method="post" dir="rtl">
            <div class="form-group">
                <input type="text" class="form-control" value="<?= $empInfo['fullname'] ?>" name="fullname" required>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" value="<?= $empInfo['phone'] ?>" name="phone" required>
            </div>
            <input type="hidden" name="emp_id" value="<?= $id ?>">
            <input type="submit" name="updateEmp" class="btn btn-success" value="تعديل">
        </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
        </div>
        
      </div>
    </div>
  </div>
<!-- end Modal -->
                                            </td>
                                            <td>
                                                <a href="employee.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-block">الحساب</a>
                                            </td>
                                            <td><?= $row['date'] ?></td>
                                            <td><?= $row['phone'] ?></td>
                                            <td><?= $row['password'] ?></td>
                                            <td><?= $row['username'] ?></td>
                                            <td><?= $row['fullname'] ?></td>
                                            <td><?= $row['id'] ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include('inc/footer.html'); ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>