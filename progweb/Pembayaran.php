<?php
session_start();
if (!isset($_SESSION['email']) && !isset($_COOKIE['email'])) {
  header("Location: login.php");
  exit();
}
$email = isset($_SESSION['email']) ? $_SESSION['email'] : (isset($_COOKIE['email']) ? $_COOKIE['email'] : '');
$isLoggedIn = isset($_SESSION['email']) || isset($_COOKIE['email']);


include_once("connection.php");
if(!$_POST){
  header("Location: index.php");
} else {
  $sql = "SELECT * FROM event where id=$_POST[id]";
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($result);
  $judul = $row['nama_event'];
  $tgl = date('d F Y',strtotime($row['tanggal']));
  $jam = date("H:i",strtotime($row['jam']));
  $poster  = $row['image_path'];
  $lokasi = $row['lokasi'];
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Konseria</title>
    <link rel="stylesheet" href="Pembayaran.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"
    />
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
        <div>
          <p id="BreadCrumb">
            <a class="home_button" href="index.php">
              <i class="fa fa-home"></i> </a
            >> <a href="event.php?id=<?php echo $_POST['id'];?>"> <?php echo $judul;?> </a>> Pembayaran 
          </p>
        </div>
        <div class="eventdetail">
          <h1 class="bold">Detail Event</h1>

          <img
            class="event_img"
            src="<?php echo $poster;?>"
            alt="Gambar Konser"
          />
          <p id="judulevent"><b><?php echo $judul;?></b></p>

          <p id="lokasievent">
            <i class="material-icons">place</i>
            <a id="Alamat"><?php echo $lokasi;?></a>
          </p>
          <p id="waktuevent"><i class="fa fa-clock-o"></i> <?php echo $jam;?></p>
          <p id="tanggalevent"><i class="fa fa-calendar"></i><?php echo $tgl;?></p>
        </div>
        <div id="bagian_kanan">
          <script>
            function checkdata(){
              let kedobel = false;
              let email = [];
              let phone =[];
              let nik =[];
              let emailInput = document.querySelectorAll('input[name^="email"]');
              let phoneInput = document.querySelectorAll('input[name^="phoneNum"]');
              let NIKInput = document.querySelectorAll('input[name^="Identity"]');
              emailInput.forEach(function(input) {
                  if (email.includes(input.value)) {
                      kedobel = true;
                  }
                  email.push(input.value);
              });
              phoneInput.forEach(function(input) {
                  if (phone.includes(input.value)) {
                      kedobel = true;
                  }
                  phone.push(input.value);
              });
              NIKInput.forEach(function(input) {
                  if (nik.includes(input.value)) {
                      kedobel = true;
                  }
                  nik.push(input.value);
              });

              if(kedobel){
                alert("Satu orang tidak boleh lebih dari 1 ticket");
                return false;
              } else{
                return true;
              }
            }
          </script>
          <form action="konfirmasi lanjutan pembayaran.php" method="post" onsubmit="return checkdata()">
            <?php
            $idtick = $_POST['ticketID'];
            $harga = 0;
            foreach($idtick as $jenistiket){
                $sql = "SELECT Name,harga from ticket where id=$jenistiket";
                $hasil = mysqli_query($conn,$sql);
                $roq = mysqli_fetch_assoc($hasil);
                $namatiket =$roq["Name"];
                $hcount = $roq["harga"];
                for($i = 0;$i<$_POST["ticket"][$jenistiket];++$i){
                  $count = $i+1;
                  $harga += $hcount;
                  echo "<div id='RegistrationData'>";
                  echo "<h1 class='bold'>Registration Data</h1>";
                  echo "<p class='notiket'>$count# Tiket $namatiket</p>";
                  echo "<div id='spacer_regis'>";
                  echo "<label for='email[$jenistiket][$i]'>Email:</label><br />";
                  echo "<input type='email' id='email' name='email[$jenistiket][$i]' class='boxpanjang' required /><br />";
                  echo "<label for='name[$jenistiket][$i]'>Name:</label><br />";
                  echo "<input type='text' id='name' name='name[$jenistiket][$i]' class='boxpanjang' required /><br />";
                  echo "<label for='DoB[$jenistiket][$i]'>Date of Birth:</label><br />";
                  echo "<input type='date' id='DoB' name='DoB[$jenistiket][$i]' required /><br /><br />";
                  echo "<label for='gender[$jenistiket][$i]'>Gender</label><br />";
                  echo "<input type='radio' name='gender[$jenistiket][$i]' value='male' required /> Male";
                  echo "<input type='radio' name='gender[$jenistiket][$i]' value='female' required /> Female <br /> <br />";
                  echo "<label for='phoneNum[$jenistiket][$i]'>Phone Number</label> <br />";
                  echo "<input type='phoneNum' id='phoneNum' name='phoneNum[$jenistiket][$i]'class='boxpanjang' required /> <br />";
                  echo "<label for='Identity[$jenistiket][$i]'>Nomor KTP/NIK:</label><br />";
                  echo "<input type='text'id='Identity'name='Identity[$jenistiket][$i]'class='boxpanjang' required /> <br />";
                  echo "<label for='Address[$jenistiket][$i]'>Address</label><br />";
                  echo "<input type='text' id='Address'name='Address[$jenistiket][$i]' class='boxpanjang' required />";
                  echo "</div>";
                  echo "</div>";
                }
                echo "<input type='hidden' name='tipeticket[]' value='$jenistiket'>";
            }
            echo "<input type='hidden' name='eventID' value='$_POST[eventID]'>";
            ?>



            <div class="PaymentMethod">
              <h1>Metode Pembayaran</h1>
              <table>
                <tr>
                  <td>
                    <label for="Qris">
                    <p>Qris</p>
                    <img
                      src="images/qris.png"
                      class="logoPembayaran"
                    />
                    </label>
                  </td>

                  <td >
                    <label for="Gopay">
                    <p>Gopay</p>
                    <img
                      src="images/gopay.png"
                      class="logoPembayaran"
                      alt="Gopay"
                    />
                    </label>
                  </td>
                  <td>
                    <label for="dana">
                    <p>Dana</p>
                    <img
                      src="images/dana.png"
                      class="logoPembayaran"
                    />
                    </label>
                  </td>
                </tr>

                <tr>
                  <td>
                    <input type="radio" name="bayar" value="Qris" id="Qris" />
                  </td>
                  <td>
                    <input type="radio" name="bayar" value="Gopay" id="Gopay"/>
                  </td>
                  <td>
                    <input type="radio" name="bayar" value="Dana" id="dana"/>
                  </td>
                </tr>
              </table>
            </div>
            <?php
            $pajak = $harga*10/100;
            $servfee = 150000;
            $totalbayar = $harga+$servfee+$pajak;
            $pajak= number_format($pajak,0,'','.');
            $harga= number_format($harga,0,'','.');
            $servfee= number_format($servfee,0,'','.');
            $totalbayar= number_format($totalbayar,0,'','.');
            ?>

            <div class="checkout">
              <table>
                <tr>
                  <td>
                    <p id="harga">Ticket</p>
                  </td>
                  <td>
                    <p id="total">Rp <?php echo $harga;?></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p id="harga">Pajak</p>
                  </td>
                  <td>
                    <p id="total">Rp <?php echo $pajak;?></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p id="harga">Service Fee</p>
                  </td>
                  <td>
                    <p id="total">Rp <?php echo $servfee;?></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p id="harga">Sub Total</p>
                  </td>
                  <td>
                    <p id="total">Rp <?php echo $totalbayar;?></p>
                  </td>
                </tr>
              </table>
              <input type="submit" id="buttonbayar" value="Bayar">
            </div>
          </form>
        </div>
      </main>
      <footer id="bawah">
        <p>Konseria &copy 2024. All rights reserved</p>
      </footer>
    </div>
  </body>
</html>
