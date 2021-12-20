<?php include("db.php");
    $mysqli =  NEW MySQLi('localhost','root', '','administrare_camin');
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">

<title>Administrarea caminelor - UTM</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">

<link rel="stylesheet" href="css/bootstrap.min.css">

<link rel="stylesheet" href="css/style.css">

<link rel="stylesheet" href="css/responsive.css">

<link rel="icon" href="images/fevicon.png" type="image/gif" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
<link type="image/x-icon" href="https://utm.md/wp-content/uploads/2017/04/LOGO_UTM_2-1030x541.jpg" rel="shortcut icon">
<style>
    .camera {
        width: 250px;
        border: 1px solid #555;
        border-radius: 5px;
        margin: 10px;
        padding: 10px;
    }
    
    .btn-group1{
    	margin-top:2%;
    	display: flex;
        justify-content: center;
    }
    .container_btn {
  position: relative;
}

.vertical-center {
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}
</style>
</head>

<body class="main-layout">

<div class="loader_bg">
  <div class="loader"><img src="images/loading.gif" alt="#" /></div>
</div>

<header> 

  <div class="head-top">
    <div class="container">
      <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
          <div class="email"> <a href="#">Email : admin.camine@utm.com</a> </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
          <div class="icon"> <i> <a href="https://www.facebook.com/UTMoldova"><img src="icon/facebook.png"></a></i> <i> <a href="https://twitter.com/utm_md"><img src="icon/Twitter.png"></a></i> </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
          <div class="contact"> <a href="#">Contact :  (+373)068-45-25</a> </div>
        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="#">Caminul 1 UTM</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="active nav-item"> <a class="nav-link" href="index.html">Acasă</a> </li>
        <li class="nav-item active"> <a class="nav-link" href="cazare.php">Cazare</a> </li>
        <li class="nav-item"> <a class="nav-link" href="panou_informativ.php">Panou informativ</a> </li>
        <li class="nav-item"> <a class="nav-link" href="contacteaza_ne.php">Contactează-ne</a> </li>
        <li class="nav-item active"> <a class="nav-link" href="admin_secret/index.html">Admin</a> </li>
      </ul>
    </div>
  </nav>
</header>

<section class="slider_section">
  <div class="container">
    <div class="row">
      <div>
      <div class="col-md-12">
        <div>
          <h1>Se va efectua cazarea după pachetul ales de dvs</h1>
          <p>In cazul în care camera este colorată cu roşu, înseamnă că s-a atins nr maxim de persoane în odaie. <br></p>
          <hr>
          
          <h3>Pachetul : minim necesar</h3>
          <br>
    <?php  while($row = mysqli_fetch_array($nr_pers_in_camera)) { ?>
      <div class='camera' style='width: 309px; display:inline-block;'>
      <?php 
        if($row['nr_pers_in_camera'] >= $row['nr_persoane_max'])
        {
          echo("
          <div style='border: 1px solid #555;'>
            <h5 style='text-align: center;'>Camera nr : <strong>".$row['ID_camera']."</strong></h5>
            <h5>Pachetul : <strong>".$row['nume_tip_confort']."</strong></h5>
            <h5>Etaj: <strong>".$row['nume_locatie']."</strong></h5>
            <h5>Nr pers cazate : <strong><span style='color:red'>max</span>(".$row['nr_pers_in_camera']."/".$row['nr_persoane_max'].")</span></strong></h4>
          </div>
          ");
        }
        else
        {
          echo("
          <div style='border: 1px solid #555;'>
            <h5 style='text-align: center;'>Camera nr : <strong>".$row['ID_camera']."</strong></h5>
            <h5>Pachetul : <strong>".$row['nume_tip_confort']."</strong></h5>
            <h5>Etaj: <strong>".$row['nume_locatie']."</strong></h5>
            <h5>Nr pers cazate : <span style='color:green;'><strong>".$row['nr_pers_in_camera']."</span>/".$row['nr_persoane_max']."</strong></h5>
          </div>
          ");
        }
      ?>
      
      </div>	
		<?php } ?>
          <hr>
          <br>
          <h3>Pachetul : standart</h3>
          <br>
          <?php  while($row = mysqli_fetch_array($nr_pers_in_camera_basic)) { ?>
      <div class='camera' style='width: 309px; display:inline-block;'>
      <?php 
        if($row['nr_pers_in_camera'] >= $row['nr_persoane_max'])
        {
          echo("
          <div style='border: 1px solid #555;'>
            <h5 style='text-align: center;'>Camera nr : <strong>".$row['ID_camera']."</strong></h5>
            <h5>Pachetul : <strong>".$row['nume_tip_confort']."</strong></h5>
            <h5>Etaj: <strong>".$row['nume_locatie']."</strong></h5>
            <h5>Nr pers cazate : <strong><span style='color:red'>max</span>(".$row['nr_pers_in_camera']."/".$row['nr_persoane_max'].")</span></strong></h4>
          </div>
          ");
        }
        else
        {
          echo("
          <div style='border: 1px solid #555;'>
            <h5 style='text-align: center;'>Camera nr : <strong>".$row['ID_camera']."</strong></h5>
            <h5>Pachetul : <strong>".$row['nume_tip_confort']."</strong></h5>
            <h5>Etaj: <strong>".$row['nume_locatie']."</strong></h5>
            <h5>Nr pers cazate : <span style='color:green;'><strong>".$row['nr_pers_in_camera']."</span>/".$row['nr_persoane_max']."</strong></h5>
          </div>
          ");
        }
      ?>
      
      </div>	
    <?php } ?>
    <br>
    <hr>
    <h3>Pachetul : superior</h3>
    <br>
    <?php  while($row = mysqli_fetch_array($nr_pers_in_camera_premium)) { ?>
      <div class='camera' style='width: 309px; display:inline-block;'>
      <?php 
        if($row['nr_pers_in_camera'] >= $row['nr_persoane_max'])
        {
          echo("
          <div style='border: 1px solid #555;'>
            <h5 style='text-align: center;'>Camera nr : <strong>".$row['ID_camera']."</strong></h5>
            <h5>Pachetul : <strong>".$row['nume_tip_confort']."</strong></h5>
            <h5>Etaj: <strong>".$row['nume_locatie']."</strong></h5>
            <h5>Nr pers cazate : <strong><span style='color:red'>max</span>(".$row['nr_pers_in_camera']."/".$row['nr_persoane_max'].")</span></strong></h4>
          </div>
          ");
        }
        else
        {
          echo("
          <div style='border: 1px solid #555;'>
            <h5 style='text-align: center;'>Camera nr : <strong>".$row['ID_camera']."</strong></h5>
            <h5>Pachetul : <strong>".$row['nume_tip_confort']."</strong></h5>
            <h5>Etaj: <strong>".$row['nume_locatie']."</strong> </h5>
            <h5>Nr pers cazate : <span style='color:green;'><strong>".$row['nr_pers_in_camera']."</span>/".$row['nr_persoane_max']."</strong></h5>
            ");
        }
      ?>
      </div>	
		<?php } ?>
        </div>
      </div>
    </div>
    <br><br>
  </div>
  </div>
</section>


<footer>
  <div class="copyright">
    <div class="container">
      <p>Toate drepturile rezervate de către <a href="https://www.facebook.com/dragos.cojocaru.127">Cojocaru Dragoş</a></p>
    </div>
  </div>
</footer>

<script src="js/jquery.min.js"></script> 
<script src="js/popper.min.js"></script> 
<script src="js/bootstrap.bundle.min.js"></script> 
<script src="js/jquery-3.0.0.min.js"></script> 
<script src="js/plugin.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script> 
<script src="js/custom.js"></script>
</body>
</html>