<?php
include('database.php');

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$user_password = $_POST['user_password'];
$phone_number = $_POST['phone_number'];

$sql = "SELECT * FROM `user` WHERE `email` = '$email'";
$cheak = mysqli_query($con,$sql);
    
if(mysqli_num_rows($cheak)>0)
{
    header('location:faild_reigster.html');
}
else
{
    $sql = "INSERT INTO `user`(`fullname`,`email`,`user_password`,`phone_number`) VALUES ('$fullname','$email','$user_password','$phone_number')";
    mysqli_query($con,$sql);
    header('location:successful.html');
}
?>