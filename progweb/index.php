<?php
session_start();
include_once("connection.php");
$email = isset($_SESSION['email']) ? $_SESSION['email'] : (isset($_COOKIE['email']) ? $_COOKIE['email'] : '');
$isLoggedIn = isset($_SESSION['email']) || isset($_COOKIE['email']);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Konseria</title>
        <link rel="stylesheet" href="index.css">
        <script src="index.js"></script>
    </head>
    <body>
        <div class="BOX">
            <header id="atas">
                <a href="index.php"><img src="images/logoKonseriafixed.png"></a>
                <?php if (isset($_SESSION['email']) || isset($_COOKIE['email'])) : ?>
                    <a href="logout.php" id="Logout" class="button">Logout</a>
                    <a href="histori.php" id="Histori" class="button">Histori</a>
                <?php else: ?>
                    <a href="login.php" id="Login" class="button">Login</a>
                    <a href="sign_up.php" id="Sign_Up" class="button">Sign Up</a>
                <?php endif; ?>
            </header>
            <main id="tengah">
            <div id="Search">
                <!-- start -->
                <table>
                    <tr>
                        <th>
                            <div class="dropdown">
                                <button onclick="dropDownShow()" name="searchBy" id="dropbtn" class="dropbtn"> 
                                SearchBy
                                <!-- <span id="searchByVal">SearchBy </span> <i class="fa fa-caret-down"></i> -->
                                </button>
                                <form method="GET" action="index.php">
                                    <div id="myDropdown" class="dropdown-content">
                                        <input onclick="changeSearchBy()" type="radio" name="searchBy" id="searchBy" value="Konser" checked>Konser</input><br>
                                        <input onclick="changeSearchBy()" type="radio" name="searchBy" id="searchBy" value="Artis">Artis</input><br>
                                        <input onclick="changeSearchBy()" type="radio" name="searchBy" id="searchBy" value="Lokasi">Lokasi</input><br>
                                        <input onclick="changeSearchBy()" type="radio" name="searchBy" id="searchBy" value="Tanggal">Tanggal</input><br>
                                    </div>
                        </th>
                        <th>
                            <div id="SearchInp">
                                <input type="text" name="searchInp" id="searchID" placeholder="  Search...">
                            </div>
                        </th>
                        <th>
                            <button type="submit" id="searchBtn"><i class="fa fa-search"></i></button>
                            </form>
                        </th>
                    </tr>
                </table>
                <!-- end -->
            </div>
            <div>
                <hr>
            </div>
                <div class="featured">
                    <img class="featured_img" src="images/radwimps poster.png">
                </div>
                
                <div class="urutan">
                        <?php
                         function generateSQL($who, $inp)
                         {
                             include("connection.php");
                             $sql = "SELECT * from event
                                     WHERE $who LIKE '%$inp%'
                                     ORDER BY $who";
                             $result = mysqli_query($conn, $sql);
                             while ($row = mysqli_fetch_assoc($result)) {
                                 $temp = $row['harga'];
                                 $value = number_format($temp, 0, '', '.');
                                 echo "<div class='event_isi'>";
                                 echo "<img class='event_img' src='$row[image_path]'>";
                                 echo '<p class="nama_event">' . $row["nama_event"] . '</p>';
                                 echo "<p class='nama_artis'>$row[nama_artis]</p>";
                                 echo "<p class='alamat_event'>$row[provinsi]</p>";
                                 echo "<p class='tgl_event'>$row[tanggal]</p>";
                                 echo "<p class='event_startfrom'>start from :</p>";
                                 echo "<p class='event_harga'>Rp $value</p>";
                                 echo "<a class='event_link' href='event.php?id=$row[id]'></a>";
                                 echo "</div>";
                             }
                         }
         
                         if ($_GET) {
                             $searchBy = $_GET['searchBy'];
                             $searchInp  = $_GET['searchInp'];
                             switch ($searchBy) {
                                 case "Artis":
                                     generateSQL('nama_artis', $searchInp);
                                     break;
                                 case "Lokasi":
                                     generateSQL('lokasi', $searchInp);
                                     break;
                                 case "Tanggal":
                                     generateSQL('tanggal', $searchInp);
                                     break;
                                 default:
                                     generateSQL('nama_event', $searchInp);
                                     break;
                             }
                         }
                         else{
                             generateSQL('nama_event', '');
                         }
                        
                ?>
                </div>
                
            </main>
            <footer id="bawah">
                <p>Konseria &copy 2024. All rights reserved</p>
              </footer>
        </div>
    </body>
</html>