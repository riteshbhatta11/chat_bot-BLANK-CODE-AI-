<?php
include('database.php');

//$fullname = $_POST['fullname'];
$email = $_POST['email'];
$user_password = $_POST['user_password'];

//$sql = "INSERT INTO `user`(`fullname`,`email`,`user_password`) VALUES ('$fullname','$email','$user_password')";
//mysqli_query($con,$sql);

$sql = "SELECT * FROM `user` WHERE `email` = '$email' AND `user_password` = '$user_password'";
$cheak = mysqli_query($con,$sql);

if(mysqli_num_rows($cheak)>0)
{
    header('location:successful.html');
}
else
{
    header('location:faild.html');
}
?>