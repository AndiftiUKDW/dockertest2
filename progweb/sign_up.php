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
        <link rel="stylesheet" href="sign_up.css">
    </head>
    <body>
        <div class="BOX">
            <header id="atas">
                <a href="index.php"><img src="images/logoKonseriafixed.png"></a>
            </header>
            <main id="tengah">
                <div class="kotak">
                    <form method="post" action="sign_up.php">
                        <h1>SIGN-UP</h1>
                        <div class="isi">
                            <strong>Email </strong><br>
                            <input type="email" name="email" id="email"> <br> <br>
                            <strong>Full Name </strong><br>
                            <input type="text" name="nama" id="nama"><br><br>
                            <strong>Password </strong><br>
                            <input type="password" name="password" id="password"> <br><br>
                            <strong>Date of Birth (dd/mm/yyyy)</strong><br> 
                            <input type="number" name="date" id="date" class="dob">
                            <input type="number" name="month" id="month" class="dob">
                            <input type="number" name="year" id="year" class="dob"> <br><br>
                        </div>
                        
                        <input type="submit" value="Sign_Up" id="submit"> </input>
                        <p>Sudah punya akun? <a href="login.php">Log In 😡</a> </p>
                    </form>
                </div>
                
            </main>
            <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $date = $_POST['date'];
                $month = $_POST['month'];
                $year = $_POST['year'];
                $email =$_POST['email'];
                $nama = $_POST['nama'];
                $password = $_POST['password'];


                if ($date && $month && $year) {
                    $dob = sprintf('%04d-%02d-%02d', $year, $month, $date); 
                } else {
                    die("Invalid date");
                }
                $stmt = $conn->prepare("INSERT INTO user (email, fullName, password, dob) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $email, $nama, $password, $dob);
                if ($stmt->execute()) {
                    echo "New record created successfully";
                    header("Location: index.php");
                    $stmt -> close();
                } 
            }
            
            ?>
            <footer id="bawah">
                <p>Konseria &copy 2024. All rights reserved</p>
              </footer>
        </div>
    </body>
</html>