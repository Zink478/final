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

<header> 

<div class="head-top">
    <div class="container">
      <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
          <div class="email"> <a href="#">Dvs va aflati pe pagina adminului, fiţi atenţi cu datele !</a> </div>
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
        <li class="nav-item"> <a class="nav-link" href="index.html">Acasă</a> </li>
        <li class="nav-item active"> <a class="nav-link" href="cazare.php">Cazare</a> </li>
        <li class="nav-item"> <a class="nav-link" href="inregistrari.php">Panou Inregistrari</a> </li>
        <li class="nav-item"> <a class="nav-link" href="studenti.php">Studenti</a> </li>
        <li class="nav-item"> <a class="nav-link" href="angajati.php">Angajati</a> </li>
        <li class="nav-item"> <a class="nav-link" href="locatii.php">Locatii</a> </li>
        <li class="nav-item"> <a class="nav-link" href="tip_confort.php">Tip confort</a> </li>
        
        <li class="nav-item active"> <a class="nav-link" href="../index.html">Log out</a> </li>
      </ul>
    </div>
  </nav>
</header>

</header>

<section class="slider_section">
  <div class="container">
    <div class="row">
      <div>
      <div class="col-md-12">
        <div>
          <h1>Se vor prezenta informatia in parte pentru fiecare student precum si in camera in care se afla</h1>
          <p>Posibilităţi:</p>
          <p>- Mutarea studentului în altă cameră de locuit</p>
          <p>- Eliminarea persoanei dintr-o cameră</p>
          <hr>
          
          <h3>Pachetul : minim necesar</h3>
          <br>
          <?php  while($row = mysqli_fetch_array($nr_pers_in_camera)) { ?>

        <?php 
          echo("<div class='camera' style='width: 309px; display:inline-block;'>");
          echo("<div style='border: 1px solid #555;'>");
          ?>
            <h5 style='text-align: center;'>Camera nr : <strong><?php echo $row['ID_camera'];?></strong></h5>
            <h5>Pachetul: <strong><?php echo $row['nume_tip_confort'];?></strong></h5>
            <h5>Etaj: <strong><?php echo substr($row['ID_camera'],0,1);?></strong></h5>
            <hr>
            <h5>Nume student: <strong><?php echo $row['nume_student'];?></strong></h5>
            <h5>Prenume student: <strong><?php echo $row['prenume_student'];?></strong></h5>
            <h5>Grupa: <strong><?php echo $row['grupa_student'];?></strong></h5>
            <h5>IDNP: <strong><?php echo $row['IDNP_student'];?></strong></h5>
            <h5>Contact: <strong><?php echo $row['contact_student'];?></strong></h5>
            <div class='col text-center'>
              <a class="btn btn-info" href="cazare.php?edit_inregistrare=<?php echo $row['IDNP_student'];?> ">Mută</a>
              <a class='btn btn-danger' href="cazare.php?del_inregistrare=<?php echo $row['IDNP_student']; ?> ">Elimină</a>
            </div>  
        </div>
        <form method="post" action="db.php">
        <input type="hidden" name="IDNP_student" value="<?php  echo $id;  ?>"> 
              <div>
                <?php if($edit_state == false): ?>                   
                    
                <?php else: ?>    
                  

                  <?php  
                    $result = $mysqli->query("SELECT ID_camera, 
                    tip_confort.nume_tip_confort,      
                    Count(*) AS nr_pers_in_camera, 
                    locatii.nume_locatie, 
                    camere.nr_persoane_max,
                    inregistrari.IDNP_student
               FROM inregistrari 
               NATURAL JOIN camere 
               NATURAL JOIN tip_confort 
               NATURAL JOIN locatii 
              WHERE ID_camera in (SELECT DISTINCT(ID_camera) FROM camere)
              Group by ID_camera, 
                       tip_confort.nume_tip_confort,
                       locatii.nume_locatie,
                       camere.nr_persoane_max,
                       inregistrari.IDNP_student");  
                    ?>
                  <select  name="ID_camera">
                    <?php 
                      $cnt=0;
                        
                      if($nume == null)
                      {
                        echo "<option value='' disabled>Nu exista camere</option> "; 
                      }   
                      else
                      {
                        echo "<option value=''></option> ";
                        echo "<optgroup label='Camere Disponibile'>
                            ";
                      }      
                          while($rows= $result->fetch_assoc())
                        {
                            if($row['nr_pers_in_camera'] >= $row['nr_persoane_max'])
                            {
                              $id_=$rows['ID_camera'];
                              
                              echo "<option  value='$id_' disabled> $id_</option>";
                              echo("</optgroup>");
                            }

                            if($row['nr_pers_in_camera'] < $row['nr_persoane_max'])
                            {
                              $id_=$rows['ID_camera'];
                              
                              echo "<option  value='$id_'> $id_</option>";
                              echo("</optgroup>");
                            }
                            
                        }       
                    ?>
                  </select><br>
                  <div class="col text-center">
                    <br>
                  <button type="submit" name="update_inregistrare" class="btn btn-danger">Modificare</button>
                  <button class="btn btn-danger"><a href="cazare.php" style="color:white">Anulare modificare</a></button>
                  </div>
                
                <?php endif ?>	
            </div>
            <br>
            </form>
        </div>
		<?php } ?>

      </div>
          <br>
          <hr>
          <h3>Pachetul : standart</h3>
          <br>
          <?php  while($row = mysqli_fetch_array($nr_pers_in_camera_basic)) { ?>

<?php 
  echo("<div class='camera' style='width: 309px; display:inline-block;'>");
  echo("<div style='border: 1px solid #555;'>");
  ?>
    <h5 style='text-align: center;'>Camera nr : <strong><?php echo $row['ID_camera'];?></strong></h5>
    <h5>Pachetul: <strong><?php echo $row['nume_tip_confort'];?></strong></h5>
    <h5>Etaj: <strong><?php echo substr($row['ID_camera'],0,1);?></strong></h5>
    <hr>
    <h5>Nume student: <strong><?php echo $row['nume_student'];?></strong></h5>
    <h5>Prenume student: <strong><?php echo $row['prenume_student'];?></strong></h5>
    <h5>Grupa: <strong><?php echo $row['grupa_student'];?></strong></h5>
    <h5>IDNP: <strong><?php echo $row['IDNP_student'];?></strong></h5>
    <h5>Contact: <strong><?php echo $row['contact_student'];?></strong></h5>
    <div class='col text-center'>
      <a class="btn btn-info" href="cazare.php?edit_inregistrare2=<?php echo $row['IDNP_student'];?> ">Mută</a>
      <a class='btn btn-danger' href="cazare.php?del_inregistrare=<?php echo $row['IDNP_student']; ?> ">Elimină</a>
    </div>  
</div>
<form method="post" action="db.php">
<input type="hidden" name="IDNP_student" value="<?php  echo $id;  ?>"> 
      <div>
        <?php if($edit_state2 == false): ?>                   
            
        <?php else: ?>    
          

          <?php  
            $result = $mysqli->query("SELECT ID_camera, 
            tip_confort.nume_tip_confort,      
            Count(*) AS nr_pers_in_camera, 
            locatii.nume_locatie, 
            camere.nr_persoane_max,
            inregistrari.IDNP_student
       FROM inregistrari 
       NATURAL JOIN camere 
       NATURAL JOIN tip_confort 
       NATURAL JOIN locatii 
      WHERE ID_camera in (SELECT DISTINCT(ID_camera) FROM camere)
      Group by ID_camera, 
               tip_confort.nume_tip_confort,
               locatii.nume_locatie,
               camere.nr_persoane_max,
               inregistrari.IDNP_student");  
            ?>
          <select  name="ID_camera">
            <?php 
              $cnt=0;
                
              if($nume == null)
              {
                echo "<option value='' disabled>Nu exista camere</option> "; 
              }   
              else
              {
                echo "<option value=''></option> ";
                echo "<optgroup label='Camere Disponibile'>
                    ";
              }      
                  while($rows= $result->fetch_assoc())
                {
                    if($row['nr_pers_in_camera'] >= $row['nr_persoane_max'])
                    {
                      $id_=$rows['ID_camera'];
                      
                      echo "<option  value='$id_' disabled> $id_</option>";
                      echo("</optgroup>");
                    }

                    if($row['nr_pers_in_camera'] < $row['nr_persoane_max'])
                    {
                      $id_=$rows['ID_camera'];
                      
                      echo "<option  value='$id_'> $id_</option>";
                      echo("</optgroup>");
                    }
                    
                }       
            ?>
          </select><br>
          <div class="col text-center">
            <br>
          <button type="submit" name="update_inregistrare" class="btn btn-danger">Modificare</button>
          <button class="btn btn-danger"><a href="cazare.php" style="color:white">Anulare modificare</a></button>
          </div>
        
        <?php endif ?>	
    </div>
    <br>
    </form>
</div>
<?php } ?>
    <br>
    <hr>
    <h3>Pachetul : superior</h3>
    <br>
    <?php  while($row = mysqli_fetch_array($nr_pers_in_camera_premium)) { ?>

<?php 
  echo("<div class='camera' style='width: 309px; display:inline-block;'>");
  echo("<div style='border: 1px solid #555;'>");
  ?>
    <h5 style='text-align: center;'>Camera nr : <strong><?php echo $row['ID_camera'];?></strong></h5>
    <h5>Pachetul: <strong><?php echo $row['nume_tip_confort'];?></strong></h5>
    <h5>Etaj: <strong><?php echo substr($row['ID_camera'],0,1);?></strong></h5>
    <hr>
    <h5>Nume student: <strong><?php echo $row['nume_student'];?></strong></h5>
    <h5>Prenume student: <strong><?php echo $row['prenume_student'];?></strong></h5>
    <h5>Grupa: <strong><?php echo $row['grupa_student'];?></strong></h5>
    <h5>IDNP: <strong><?php echo $row['IDNP_student'];?></strong></h5>
    <h5>Contact: <strong><?php echo $row['contact_student'];?></strong></h5>
    <div class='col text-center'>
      <a class="btn btn-info" href="cazare.php?edit_inregistrare3=<?php echo $row['IDNP_student'];?> ">Mută</a>
      <a class='btn btn-danger' href="cazare.php?del_inregistrare=<?php echo $row['IDNP_student']; ?> ">Elimină</a>
    </div>  
</div>
<form method="post" action="db.php">
<input type="hidden" name="IDNP_student" value="<?php  echo $id;  ?>"> 
      <div>
        <?php if($edit_state3 == false): ?>                   
            
        <?php else: ?>    
          

          <?php  
            $result = $mysqli->query("SELECT ID_camera, 
            tip_confort.nume_tip_confort,      
            Count(*) AS nr_pers_in_camera, 
            locatii.nume_locatie, 
            camere.nr_persoane_max,
            inregistrari.IDNP_student
       FROM inregistrari 
       NATURAL JOIN camere 
       NATURAL JOIN tip_confort 
       NATURAL JOIN locatii 
      WHERE ID_camera in (SELECT DISTINCT(ID_camera) FROM camere)
      Group by ID_camera, 
               tip_confort.nume_tip_confort,
               locatii.nume_locatie,
               camere.nr_persoane_max,
               inregistrari.IDNP_student");  
            ?>
          <select  name="ID_camera">
            <?php 
              $cnt=0;
                
              if($nume == null)
              {
                echo "<option value='' disabled>Nu exista camere</option> "; 
              }   
              else
              {
                echo "<option value=''></option> ";
                echo "<optgroup label='Camere Disponibile'>
                    ";
              }      
                  while($rows= $result->fetch_assoc())
                {
                    if($row['nr_pers_in_camera'] >= $row['nr_persoane_max'])
                    {
                      $id_=$rows['ID_camera'];
                      
                      echo "<option  value='$id_' disabled> $id_</option>";
                      echo("</optgroup>");
                    }

                    if($row['nr_pers_in_camera'] < $row['nr_persoane_max'])
                    {
                      $id_=$rows['ID_camera'];
                      
                      echo "<option  value='$id_'> $id_</option>";
                      echo("</optgroup>");
                    }
                    
                }       
            ?>
          </select><br>
          <div class="col text-center">
            <br>
          <button type="submit" name="update_inregistrare" class="btn btn-danger">Modificare</button>
          <button class="btn btn-danger"><a href="cazare.php" style="color:white">Anulare modificare</a></button>
          </div>
        
        <?php endif ?>	
    </div>
    <br>
    </form>
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