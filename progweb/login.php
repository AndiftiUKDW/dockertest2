<?php
session_start();

if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {
    header("Location: index.php");
    exit();
}

include('connection.php');

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $dataUser = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $email;
        
        header("Location: index.php");
        exit();
    } else {
        $error = "Email atau password salah.";
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Konseria</title>
        <link rel="stylesheet" href="login.css">
    </head>
    
    <body>
        <div class="BOX">
            <header id="atas">
                <a href="index.php"><img src="images/logoKonseriafixed.png"></a>
            </header>
            <main id="tengah">
                <div class="kotak">
                    <form method="post">
                        <h1>LOG-IN</h1>
                        <div class="isi">
                            <strong>Email </strong> <br>
                            <input type="email" name="email" id="email" required ><br><br>
                            <strong>Password </strong> <br>
                            <input type="password" name="password"id="password" required> <br><br>                            
                        </div>
                        <a href="lupa.php">Lupa Password?</a> <br><br>
                        <input type="submit" name="login" value="Log-In" id="login"> </input>
                        <p>Belum punya akun? <a href="sign_up.php">Sign Up 😡</a> </p>
                    </form> 
                </div>
               
            </main>
            <footer id="bawah">
                <p>Konseria &copy 2024. All rights reserved</p>
              </footer>
        </div>
    </body>
</html>