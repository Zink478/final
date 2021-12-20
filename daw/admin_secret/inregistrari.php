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
        <li class="nav-item"> <a class="nav-link" href="cazare.php">Cazare</a> </li>
        <li class="nav-item active"> <a class="nav-link" href="inregistrari.php">Panou Inregistrari</a> </li>
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
        <div >
          <h3>Introducerea studentului într-o cameră<br> <em>Studenţii care nu sunt cazataţi, sunt numiţi ,,în lista de aşteptare/respinşi,,</em></h3>
          <p>! Doar adminul poate să cazeze mai muli studenţi într-o cameră, indiferent de nr maxim. <br> ! Un student poate fi atribuit doar unei singure camere</p>
          
          
          <table class="table table-hover w-auto centertable" style="border-style: solid;">
          <thead class="thead-dark">
            <tr> 
              <th scope="col">IDNP</th>
              <th scope="col">Nume student</th>
              <th scope="col">Prenume student</th>
              <th scope="col">Grupa student</th>
              <th scope="col">Nr camerei</th>
              <th scope="col">Etajul</th>
              <th scope="col">Data sosire</th> 
              <th scope="col"></th>

            </tr>
          </thead>
		<tbody>
		<?php  while($row = mysqli_fetch_array($afisare_inregistrari)) { ?>
    <tr>
          <td><?php echo $row['IDNP_student'];?></td>
          <td><?php echo $row['nume_student'];?></td>
          <td><?php echo $row['prenume_student'];?></td>
          <td><?php echo $row['grupa_student']; ?></td>
          <td><?php echo $row['ID_camera']; ?></td>
          <td><?php echo substr($row['ID_camera'],0,1); ?></td>
          <td><?php echo $row['data_sosire']; ?></td>
          <td>
            <a class='btn btn-danger' href="inregistrari.php?del_inregistrare2=<?php echo $row['IDNP_student']; ?> ">Elimină</a>
          </td>
    </tr>		
		<?php } ?>
    </tbody>
            </table>
            <br>
            <h3 style="text-align: center;">Introducerea datelor:</h3>

            <form method="post" action="db.php">
            
              
              <div>Nume Prenume student: 
                    <?php  
                      $result = $mysqli->query("SELECT * FROM studenti WHERE IF(IDNP_student IN (SELECT IDNP_student FROM inregistrari),1,0)=0");  
                      ?>
                    <select  name="IDNP_student">
                      <?php 
                        if($nume == null)
                        {
                          echo "<option value='' disabled>Student</option> "; 
                        }        
                            while($rows= $result->fetch_assoc())
                          {
                            $id_=$rows['IDNP_student'];
                            $nume=$rows['nume_student'];
                            $prenume=$rows['prenume_student'];
                            echo "<option  value='$id_'> $nume $prenume</option>";
                            echo("</optgroup>"); 
                          }       
                      ?>
                    </select><br>
              <div>
              
              <div>Camera 
                    <?php  
                      $result = $mysqli->query("SELECT * FROM camere");  
                      ?>
                    <select  name="ID_camera">
                      <?php 
                        if($nume == null)
                        {
                          echo "<option value='' disabled>Camere</option> "; 
                        }        
                            while($rows= $result->fetch_assoc())
                          {
                            $id_=$rows['ID_camera'];
                            echo "<option  value='$id_'> $id_</option>";
                            echo("</optgroup>"); 
                          }       
                      ?>
                    </select><br>
              <div>
              <button type="submit" name="save_inreg" class="btn btn-success">Adauga</button>
                    
            <br>
            </form>
          <hr>
          <br>
        </div>
      </div>
    </div>
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