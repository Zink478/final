<?php
    error_reporting(0);
    $host="localhost";
	  $user="root";
    $password="";
    $db_name="administrare_camin";

    $db = mysqli_connect($host, $user, $password, $db_name);




    $container = array(101, 501);
    //init null
    $id=0;
    $edit_state = false;
    $edit_state2 = false;
    $edit_state3 = false;
    $tip_mediu = 0;
    $value_hid=false;

    $_id_camera=null;
    $afisare_personal_camin = mysqli_query($db, "SELECT * FROM personal_camin");

    $afisare_camere_minimal= mysqli_query($db, "SELECT ID_camera, nume_tip_confort, nume_locatie, nr_persoane_max FROM camere NATURAL JOIN tip_confort NATURAL JOIN locatii WHERE ID_tip_confort = 3;");

    $afisare_camere_standard= mysqli_query($db, "SELECT ID_camera, nume_tip_confort, nume_locatie, nr_persoane_max FROM camere NATURAL JOIN tip_confort NATURAL JOIN locatii WHERE ID_tip_confort = 1; ");

    $afisare_camere_superior= mysqli_query($db, "SELECT ID_camera, nume_tip_confort, nume_locatie, nr_persoane_max FROM camere NATURAL JOIN tip_confort NATURAL JOIN locatii WHERE ID_tip_confort = 2; ");

    $verificare_max_odaie =mysqli_query($db, "SELECT COUNT(ID_inregistrare) FROM inregistrari WHERE ID_camera=501; ");

    $afisare_studenti =mysqli_query($db, "select nume_student, prenume_student, contact_student, IF(IDNP_student IN (SELECT IDNP_student FROM inregistrari),1,0) AS bol_cazat,grupa_student FROM studenti");

    $afisare_studenti_all =mysqli_query($db, "SELECT * FROM studenti");

    $afisare_locatii =mysqli_query($db, "select ID_locatie, nume_locatie, nume_personal, prenume_personal, contact_personal, IF(ID_locatie = ID_personal,1,0) AS rasp_de_altcv from locatii NATURAL JOIN personal_camin;");

    $afisare_tip_confort =mysqli_query($db, "SELECT * FROM tip_confort;");

    $afisare_inregistrari =mysqli_query($db, "SELECT IDNP_student,nume_student, prenume_student, grupa_student, ID_camera, nume_locatie, data_sosire FROM inregistrari NATURAL JOIN studenti NATURAL JOIN camere NATURAL JOIN locatii;");

    $nr_pers_in_camera=mysqli_query($db, "
    SELECT ID_camera, 
       tip_confort.nume_tip_confort,      
       Count(*) AS nr_pers_in_camera, 
       locatii.nume_locatie, 
       camere.nr_persoane_max,
       studenti.nume_student,
       studenti.prenume_student,
       studenti.grupa_student,
       studenti.IDNP_student,
       studenti.contact_student
  FROM inregistrari 
  NATURAL JOIN camere 
  NATURAL JOIN tip_confort 
  NATURAL JOIN locatii 
  NATURAL JOIN studenti
 WHERE camere.ID_tip_confort =3
   AND ID_camera in (SELECT DISTINCT(ID_camera) FROM camere)
 Group by ID_camera, 
          tip_confort.nume_tip_confort,
          locatii.nume_locatie,
          camere.nr_persoane_max,
          studenti.nume_student,
          studenti.prenume_student,
          studenti.grupa_student,
          studenti.IDNP_student,
          studenti.contact_student
    ");

    $nr_pers_in_camera_basic=mysqli_query($db, "
    SELECT ID_camera, 
       tip_confort.nume_tip_confort,      
       Count(*) AS nr_pers_in_camera, 
       locatii.nume_locatie, 
       camere.nr_persoane_max,
       studenti.nume_student,
       studenti.prenume_student,
       studenti.grupa_student,
       studenti.IDNP_student,
       studenti.contact_student
  FROM inregistrari 
  NATURAL JOIN camere 
  NATURAL JOIN tip_confort 
  NATURAL JOIN locatii 
  NATURAL JOIN studenti
 WHERE camere.ID_tip_confort =1
   AND ID_camera in (SELECT DISTINCT(ID_camera) FROM camere)
 Group by ID_camera, 
          tip_confort.nume_tip_confort,
          locatii.nume_locatie,
          camere.nr_persoane_max,
          studenti.nume_student,
          studenti.prenume_student,
          studenti.grupa_student,
          studenti.IDNP_student,
          studenti.contact_student
    ");

    $nr_pers_in_camera_premium=mysqli_query($db, "
    SELECT ID_camera, 
       tip_confort.nume_tip_confort,      
       Count(*) AS nr_pers_in_camera, 
       locatii.nume_locatie, 
       camere.nr_persoane_max,
       studenti.nume_student,
       studenti.prenume_student,
       studenti.grupa_student,
       studenti.IDNP_student,
       studenti.contact_student
  FROM inregistrari 
  NATURAL JOIN camere 
  NATURAL JOIN tip_confort 
  NATURAL JOIN locatii 
  NATURAL JOIN studenti
 WHERE camere.ID_tip_confort =2
   AND ID_camera in (SELECT DISTINCT(ID_camera) FROM camere)
 Group by ID_camera, 
          tip_confort.nume_tip_confort,
          locatii.nume_locatie,
          camere.nr_persoane_max,
          studenti.nume_student,
          studenti.prenume_student,
          studenti.grupa_student,
          studenti.IDNP_student,
          studenti.contact_student
    ");

/* Angajati */
    if(isset($_POST['save_angajat']))
    {
        $nume_personal=$_POST['nume_personal'];
        $prenume_personal=$_POST['prenume_personal'];
        $contact_personal=$_POST['contact_personal'];

        $query = "INSERT INTO personal_camin(nume_personal, prenume_personal, contact_personal) VALUES('$nume_personal', '$prenume_personal', '$contact_personal')";

		mysqli_query($db, $query);

    header('location: angajati.php');
    }

    if(isset($_GET['del_angajat']))
    {
      $id = $_GET['del_angajat'];
      mysqli_query($db, "DELETE FROM personal_camin WHERE ID_personal=$id");

      header('location: angajati.php');
    }


    if(isset($_GET['edit_angajat']))
    {
        $id = $_GET['edit_angajat'];
        $edit_state = true;
        $rec = mysqli_query($db, "SELECT * FROM personal_camin WHERE ID_personal=$id");

        $record=mysqli_fetch_array($rec);
        $id = $record['ID_personal'];
        $nume_personal = $record['nume_personal'];
        $prenume_personal=$record['prenume_personal'];
        $contact_personal=$record['contact_personal'];

	}
    
    if(isset($_POST['update_angajat']))
    {    
        $nume_personal=mysqli_real_escape_string($db, $_POST['nume_personal']);
        $prenume_personal=mysqli_real_escape_string($db, $_POST['prenume_personal']);
        $contact_personal=mysqli_real_escape_string($db, $_POST['contact_personal']);
        $id= mysqli_real_escape_string($db, $_POST['ID_personal']);
        

		mysqli_query($db, "UPDATE personal_camin SET nume_personal='$nume_personal', prenume_personal='$prenume_personal', contact_personal = '$contact_personal' WHERE ID_personal=$id");
		
		header('location: angajati.php');
    }
    /*--------------------- */
    /* Inregistrari*/
    if(isset($_GET['del_inregistrare']))
    {
      $id = $_GET['del_inregistrare'];
      mysqli_query($db, "DELETE FROM inregistrari WHERE IDNP_student=$id");

      header('location: cazare.php');
    }

    if(isset($_GET['del_inregistrare2']))
    {
      $id = $_GET['del_inregistrare2'];
      mysqli_query($db, "DELETE FROM inregistrari WHERE IDNP_student=$id");

      header('location: inregistrari.php');
    }

    if(isset($_GET['edit_inregistrare']))
    {
        $id = $_GET['edit_inregistrare'];
        $edit_state = true;
        $rec = mysqli_query($db, "SELECT ID_camera FROM inregistrari WHERE IDNP_student=$id");

        $record=mysqli_fetch_array($rec);
        $ID_camera=$record['ID_camera'];

  }
  if(isset($_GET['edit_inregistrare2']))
    {
        $id = $_GET['edit_inregistrare2'];
        $edit_state2 = true;
        $rec = mysqli_query($db, "SELECT ID_camera FROM inregistrari WHERE IDNP_student=$id");

        $record=mysqli_fetch_array($rec);
        $ID_camera=$record['ID_camera'];

  }
  if(isset($_GET['edit_inregistrare3']))
    {
        $id = $_GET['edit_inregistrare3'];
        $edit_state3 = true;
        $rec = mysqli_query($db, "SELECT ID_camera FROM inregistrari WHERE IDNP_student=$id");

        $record=mysqli_fetch_array($rec);
        $ID_camera=$record['ID_camera'];

	}
    
    if(isset($_POST['update_inregistrare']))
    {    
        $ID_camera=mysqli_real_escape_string($db, $_POST['ID_camera']);
        $id= mysqli_real_escape_string($db, $_POST['IDNP_student']);
        
		mysqli_query($db, "UPDATE inregistrari SET ID_camera='$ID_camera', data_sosire = CURRENT_DATE WHERE IDNP_student=$id");
		
		header('location: cazare.php');
    }


    /*--------------------- */

    /*--------------------- */
    /* Studenti*/

    if(isset($_POST['save_student']))
    {
        $IDNP_student =$_POST['IDNP_student'];
        $nume_student=$_POST['nume_student'];
        $prenume_student=$_POST['prenume_student'];
        $contact_student=$_POST['contact_student'];
        $grupa_student=$_POST['grupa_student'];

        $query = "INSERT INTO studenti(IDNP_student,nume_student, prenume_student, contact_student, grupa_student) VALUES('$IDNP_student', '$nume_student', '$prenume_student', '$contact_student', '$grupa_student')";

		mysqli_query($db, $query);

    header('location: studenti.php');
    }

    if(isset($_GET['del_student']))
    {
      $id = $_GET['del_student'];
      mysqli_query($db, "DELETE FROM studenti WHERE IDNP_student=$id");

      header('location: studenti.php');
    }

    if(isset($_GET['edit_student']))
    {
        $id = $_GET['edit_student'];
        $edit_state = true;
        $rec = mysqli_query($db, "SELECT * FROM studenti WHERE IDNP_student=$id");

        $record=mysqli_fetch_array($rec);
        $id = $record['IDNP_student'];
        $IDNP_student =$record['IDNP_student'];
        $nume_student=$record['nume_student'];
        $prenume_student=$record['prenume_student'];
        $contact_student=$record['contact_student'];
        $grupa_student=$record['grupa_student'];
	}
    
    if(isset($_POST['update_student']))
    {    
      $IDNP_student =mysqli_real_escape_string($db, $_POST['IDNP_student']);
        $nume_student=mysqli_real_escape_string($db, $_POST['nume_student']);
        $prenume_student=mysqli_real_escape_string($db, $_POST['prenume_student']);
        $contact_student=mysqli_real_escape_string($db, $_POST['contact_student']);
        $grupa_student=mysqli_real_escape_string($db, $_POST['grupa_student']);
        $id=mysqli_real_escape_string($db, $_POST['IDNP_student']);

        
		mysqli_query($db, "UPDATE studenti SET IDNP_student='$IDNP_student', nume_student = '$nume_student', prenume_student = '$prenume_student', contact_student = '$contact_student', grupa_student = '$grupa_student' WHERE IDNP_student=$id");
		
		header('location: studenti.php');
    }
    /*--------------------- */


    /*Locatii */

    if(isset($_POST['save_locatie']))
    {
        $nume_locatie=$_POST['nume_locatie'];
        $ID_personal=$_POST['ID_personal'];

        $query = "INSERT INTO locatii(nume_locatie, ID_personal) VALUES('$nume_locatie', '$ID_personal')";

		mysqli_query($db, $query);

    header('location: locatii.php');
    }

    if(isset($_GET['del_locatie']))
    {
      $id = $_GET['del_locatie'];
      mysqli_query($db, "DELETE FROM locatii WHERE ID_locatie=$id");

      header('location: locatii.php');
    }

    if(isset($_GET['edit_locatie']))
    {
        $id = $_GET['edit_locatie'];
        $edit_state = true;
        $rec = mysqli_query($db, "SELECT ID_locatie, nume_locatie, nume_personal, prenume_personal FROM locatii NATURAL JOIN personal_camin; WHERE ID_locatie=$id");

        $record=mysqli_fetch_array($rec);
        $id = $record['ID_locatie'];
        $nume_locatie =$record['nume_locatie'];
        $ID_personal=$record['ID_personal'];
	}
    
    if(isset($_POST['update_locatie']))
    {    
        $ID_locatie =mysqli_real_escape_string($db, $_POST['ID_locatie']);
        $nume_locatie=mysqli_real_escape_string($db, $_POST['nume_locatie']);
        $ID_personal=mysqli_real_escape_string($db, $_POST['ID_personal']);
        $id=mysqli_real_escape_string($db, $_POST['ID_personal']);

        
		mysqli_query($db, "UPDATE locatii SET nume_locatie = '$nume_locatie', ID_personal = '$ID_personal' WHERE ID_personal=$id");
		
		header('location: locatii.php');
    }
    /*--------------------- */
    /*tip confort */

    if(isset($_POST['save_tip_confort']))
    {
        $nume_tip_confort=$_POST['nume_tip_confort'];

        $query = "INSERT INTO tip_confort(nume_tip_confort) VALUES('$nume_tip_confort')";

      mysqli_query($db, $query);

      header('location: tip_confort.php');
    }

    if(isset($_GET['del_tip_confort']))
    {
      $id = $_GET['del_tip_confort'];
      mysqli_query($db, "DELETE FROM tip_confort WHERE ID_tip_confort=$id");

      header('location: tip_confort.php');
    }

    if(isset($_GET['edit_tip_confort']))
    {
        $id = $_GET['edit_tip_confort'];
        $edit_state = true;
        $rec = mysqli_query($db, "SELECT nume_tip_confort FROM tip_confort WHERE ID_tip_confort=$id");

        $record=mysqli_fetch_array($rec);
        $id = $record['ID_tip_confort'];
        $nume_tip_confort =$record['nume_tip_confort'];
	}
    
    if(isset($_POST['update_tip_confort']))
    {    
        $nume_tip_confort=mysqli_real_escape_string($db, $_POST['nume_tip_confort']);
        $id=mysqli_real_escape_string($db, $_POST['ID_tip_confort']);

        
		mysqli_query($db, "UPDATE tip_confort SET nume_tip_confort = '$nume_tip_confort' WHERE ID_tip_confort=$id");
		
		header('location: tip_confort.php');
    }

    /* inregistrari */
    if(isset($_POST['save_inreg']))
    {
        $IDNP_student=$_POST['IDNP_student'];

        $ID_camera=$_POST['ID_camera'];

        $query = "INSERT INTO inregistrari(IDNP_student, ID_camera, data_sosire) VALUES('$IDNP_student','$ID_camera',CURDATE())";

      mysqli_query($db, $query);

      header('location: inregistrari.php');
    }
    /* ---------------*/
?>