<?php
session_start();
if (!isset($_SESSION['email']) && !isset($_COOKIE['email'])) {
  header("Location: login.php");
  exit();
}
$email = isset($_SESSION['email']) ? $_SESSION['email'] : (isset($_COOKIE['email']) ? $_COOKIE['email'] : '');
$isLoggedIn = isset($_SESSION['email']) || isset($_COOKIE['email']);


include_once("connection.php");
if($_POST){
    $id = $_POST['orderid'];
    $sql = "DELETE from ordered where orderid=$id";
    $sql2 = "DELETE from detail_order where id_order=$id";
    $run = mysqli_query($conn,$sql);
    $run2 = mysqli_query($conn,$sql2);
    header("location:histori.php");
} else {
    header("location:index.php");
}

?>