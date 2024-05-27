<?php
session_start();

if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {
    header("Location: index.php");
    exit();
}

include('connection.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Konseria</title>
        <link rel="stylesheet" href="lupa.css">
    </head>
    <body>
        <div class="BOX">
            <header id="atas">
                <a href="index.php"><img src="images/logoKonseriafixed.png"></a>

            </header>
            <main id="tengah">
                <div class="kotak">
                    <p>"Lupa password Anda? Jangan khawatir! Hubungi customer service kami di konseria@gmail.com untuk mendapatkan bantuan dalam mereset password Anda.<br><br>
                    <div class="button">
                        <a href="login.php">Kembali</a>
                    </div>
                </div>

                
            </main>
            <footer id="bawah">
                <p>Konseria &copy 2024. All rights reserved</p>
              </footer>
        </div>
    </body>
</html>