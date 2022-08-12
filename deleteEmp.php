<?php 
include_once 'inc/connect.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
}else{
    if ($_SESSION['user_id']!=1) {
        header('Location: index.php');
    }
}



if (isset($_GET['id'])) {
$id=$_GET['id'];

if($id==1){
    header('Location: employees.php');
}else{

$q="UPDATE `users` SET `archived`=1 WHERE `id`='$id'";
$r=mysqli_query($dbc,$q);

if($r){
    header('Location: employees.php?delete=1');
}else{
    header('Location: employees.php?delete=0');
}
}

}else{
    header('Location: employees.php');
}
 ?>