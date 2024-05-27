<?php
session_start();
if (!isset($_SESSION['email']) && !isset($_COOKIE['email'])) {
  header("Location: login.php");
  exit();
}
$email = isset($_SESSION['email']) ? $_SESSION['email'] : (isset($_COOKIE['email']) ? $_COOKIE['email'] : '');
$isLoggedIn = isset($_SESSION['email']) || isset($_COOKIE['email']);

include_once("connection.php");
if($_GET){
    $ID = $_GET['id'];
    $sql = "SELECT * FROM event where id=$ID";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    $poster  = $row['image_path'];
    $judul = $row['nama_event'];
    $artis = $row['nama_artis'];
    $lokasi = $row['lokasi'];
    $jam = date("H:i",strtotime($row['jam']));
    $tgl = date('d F Y',strtotime($row['tanggal']));
    $deskripsi = $row['deskripsi'];
    $syarat = $row['snk'];
    $curdate = new DateTime(date('d F Y'));
    $datadate = new DateTime($tgl);
    $kelebihan = " ";
    if($curdate > $datadate){
        $kelebihan = "disabled";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Konseria</title>
        <link rel="stylesheet" href="event.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                <!-- BreadCrumb -->
                
                <p id="BreadCrumb"> <a class="home_button"href="index.php"> <i class="fa fa-home"></i> </a> > <a id="currentPage"> <?php echo $judul;?> </a> </p>
                
                
                <div id="fotokonser"><img src="<?php echo $poster;?>" alt="fotokonser"></div>
                
                <!-- tambahin foto -->

                <div class="event_info">
                    <p id="judulevent"><?php echo $judul;?></p>
                    <p id="lokasievent"> <i class="material-icons">place</i> <a id="Alamat"><?php echo $lokasi;?></a></p>
                    <p id="waktuevent"> <i class="fa fa-clock-o"></i> <?php echo $jam;?></p>
                    <p id="tanggalevent"><i class="fa fa-calendar"></i><?php echo $tgl;?></p>
                    <p id="Artist"><i class="fa fa-circle"></i><?php echo $artis;?></p>

                    <p class="penyelenggara" id="diselenggarakan">Diselenggarakan oleh:</p>
                    <img src="images/logo-pk-black.png" alt="logo" id="pkenter" class="penyelenggara">
                    <p class="penyelenggara" id="namapenyelenggara">PK ENTERTAINMENT</p>
                    <img src="images/sozo.png" alt="logo" id="sozo" class="penyelenggara">
                    <p class="penyelenggara" id="namapenyelenggara">SOZO</p>
                </div>
                <div class="fotoseater">
                    <img src="<?php echo $row['seating_path'];?>" alt="fotoseat">
                </div>
                

                <div class="package">
                    <form action="Pembayaran.php" method="post" onsubmit="return validateFORM()">
                        <?php
                        $sql = "SELECT * FROM ticket WHERE event_ID=$ID";
                        $result = mysqli_query($conn,$sql);
                        while($row = mysqli_fetch_assoc($result)){
                        $value= number_format($row["harga"],0,'','.');
                        $maxawal = $row['max'];
                        $sql2 = "SELECT count(*) as jumlah FROM detail_order where id_ticket=$row[Id]";
                        $result2 = mysqli_query($conn,$sql2);
                        $row2 = mysqli_fetch_assoc($result2);
                        $maxawal -= $row2['jumlah'];
                        echo "<div class='isi_package'> ";
                        echo "<p id='judulpackage'>$row[Name]</p>";
                        echo "<div id='descPackage'><p class='italic'>$row[Deskripsi]";
                        echo '<p class="notice"><i class="fa fa-exclamation-circle"></i> Penjualan berakhir pada '.$tgl.' • 20.00 WIB</p> 
                        </div>';
                        echo "<p class='sisa_tiket'>Sisa : $maxawal</p>";
                        echo "<div class='picker'>Rp. $value";
                        echo "<select id='ticket' name='ticket[{$row['Id']}]'>";
                        if ($maxawal>5){
                            for($i = 0;$i<6;$i++){
                                echo "<option value='$i'>$i</option>";
                            }
                        } else {
                            for($i = 0;$i<$maxawal+1;$i++){
                                echo "<option value='$i'>$i</option>";
                            }
                        }                       
                        echo "</select>";                       
                        echo "</div>";
                        echo "<input type='hidden' name='ticketID[]' value='$row[Id]'>";
                        echo "<input type='hidden' name='eventID' value='$ID'>";
                        echo "</div>";
                        }
                        ?>
                        <input type="hidden" name="id" value="<?php echo $ID;?>">
                        <?php
                        if($curdate > $datadate):
                        ?>
                        <p class="peringatan">Melebihi batasan Waktu</p>
                        <?php else:
                        ?>
                        <input type="submit" class="ACC" value="Pembayaran">
                        <?php
                        endif;
                        ?>
                    </form>
                </div>
                
                <script>
                    function validateFORM(){
                        let tickets = document.querySelectorAll("select[name^='ticket']");
                        let isAnyTicketSelected = false;
                        tickets.forEach(function(select) {
                            if (select.value > 0) {
                                isAnyTicketSelected = true;
                            }
                        });
                        if (!isAnyTicketSelected) {
                            alert("Tidak ada ticket yang diorder");
                            return false;
                        }
                        return true;
                    }
                </script>
                

                <div class="syarat">
                    <p class="headSyarat"><b>Syarat & Ketentuan</b></p>
                    <ol type="1" id="sdank">
                        <?php echo $syarat;?>
                    </ol>
                </div>

                <div class="deskripsi">
                    <p id="juduldesk"><b>Deskripsi</b></p>
                    <p id="isidesk"><?php echo $deskripsi;?></p>
                </div>
            </main>
            <footer id="bawah">
                <p>Konseria &copy 2024. All rights reserved</p>
              </footer>
        </div>
    </body>
</html>