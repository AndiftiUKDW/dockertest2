<?php
session_start();
if (!isset($_SESSION['email']) && !isset($_COOKIE['email'])) {
  header("Location: login.php");
  exit();
}
$email = isset($_SESSION['email']) ? $_SESSION['email'] : (isset($_COOKIE['email']) ? $_COOKIE['email'] : '');
$isLoggedIn = isset($_SESSION['email']) || isset($_COOKIE['email']);

include_once("connection.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Konseria</title>
        <link rel="stylesheet" href="konfirmasi.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body>
        <div class="BOX">
            <header id="atas">
            <a href="index.php"><img src="images/logoKonseriafixed.png"></a>
                <?php if (isset($_SESSION['email']) || isset($_COOKIE['email'])) : ?>
                    <a href="logout.php" id="Logout" class="button">Logout</a>
                <?php else: ?>
                    <a href="login.php" id="Login" class="button">Login</a>
                    <a href="sign_up.php" id="Sign_Up" class="button">Sign Up</a>
                <?php endif; ?>
            </header>
            <main id="tengah">
                <!-- tambahin foto -->
                <?php 
                    if($_POST):
                        $sql = "SELECT idUser from user where email='$_SESSION[email]'";
                        $hasil = mysqli_query($conn,$sql);
                        $row = mysqli_fetch_assoc($hasil);
                        $iduser = $row["idUser"];
                        // untuk bagian per ticket nya 
                        $email = (array)$_POST["email"];
                        $name = (array)$_POST["name"];
                        $DoB = (array)$_POST["DoB"];
                        $gender = (array)$_POST["gender"];
                        $phonenum = (array)$_POST["phoneNum"];
                        $Identity = (array)$_POST["Identity"];
                        $Address = (array)$_POST["Address"];
                        $tipeticket = (array)$_POST["tipeticket"];
                        $bayar = $_POST['bayar'];
                        $eventid = $_POST['eventID'];
                        $sql = "INSERT INTO ordered(user_id,event_id,metode,tgl) values($iduser,$eventid,'$bayar',now())";
                        mysqli_query($conn,$sql);
                        $orderid= mysqli_insert_id($conn);
                        foreach($tipeticket as $tipe):
                            if(isset($name[$tipe])){
                                $jumlahtiketordered = sizeof((array)$name[$tipe]);
                                for($i=0;$i<$jumlahtiketordered;$i++){
                                    $sql = "INSERT into detail_order(nama,email,dob,gender,phonenum,nik,address,id_order,id_ticket) values('{$name[$tipe][$i]}','{$email[$tipe][$i]}','{$DoB[$tipe][$i]}','{$gender[$tipe][$i]}',{$phonenum[$tipe][$i]}, '{$Identity[$tipe][$i]}','{$Address[$tipe][$i]}',$orderid,$tipe)";
                                    mysqli_query($conn,$sql);
                                }
                            }
                        endforeach;
                ?>
                <div class="THX">
                    <h1>Pesanan Berhasil!</h1>
                    <p>Terima kasih atas kepercayaan Anda.</p>
                    <p>Tiket dikirim melalui email.</p>
                    <a class="kembali"href="index.php" >Kembali ke Halaman Utama</a>
                    <br>
                </div>
                <?php endif;?>
            </main>


            <footer id="bawah">
                <p>Konseria &copy 2024. All rights reserved</p>
              </footer>
        </div>
    </body>
</html>