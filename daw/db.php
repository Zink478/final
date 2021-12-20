<?php
    $host="localhost";
	$user="root";
    $password="";
    $db_name="administrare_camin";
    $db = mysqli_connect($host, $user, $password, $db_name);

    //init null
    $id=0;
    $edit_state = false;
    $tip_mediu = 0;
    $value_hid=false;

    $_id_camera=null;
    $afisare_personal_camin = mysqli_query($db, "SELECT * FROM personal_camin");

    $afisare_camere_minimal= mysqli_query($db, "SELECT ID_camera, nume_tip_confort, nume_locatie, nr_persoane_max FROM camere NATURAL JOIN tip_confort NATURAL JOIN locatii WHERE ID_tip_confort = 3;");

    $afisare_camere_standard= mysqli_query($db, "SELECT ID_camera, nume_tip_confort, nume_locatie, nr_persoane_max FROM camere NATURAL JOIN tip_confort NATURAL JOIN locatii WHERE ID_tip_confort = 1; ");

    $afisare_camere_superior= mysqli_query($db, "SELECT ID_camera, nume_tip_confort, nume_locatie, nr_persoane_max FROM camere NATURAL JOIN tip_confort NATURAL JOIN locatii WHERE ID_tip_confort = 2; ");

    $verificare_max_odaie =mysqli_query($db, "SELECT COUNT(ID_inregistrare) FROM inregistrari WHERE ID_camera=501; ");

    $afisare_studenti =mysqli_query($db, "select nume_student, prenume_student, contact_student, IF(IDNP_student IN (SELECT IDNP_student FROM inregistrari),1,0) AS bol_cazat,grupa_student FROM studenti");

    $nr_pers_in_camera=mysqli_query($db, "
    SELECT ID_camera, 
       tip_confort.nume_tip_confort,      
       Count(*) AS nr_pers_in_camera, 
       locatii.nume_locatie, 
       camere.nr_persoane_max  
  FROM inregistrari 
  NATURAL JOIN camere 
  NATURAL JOIN tip_confort 
  NATURAL JOIN locatii 
 WHERE camere.ID_tip_confort =3
   AND ID_camera in (SELECT DISTINCT(ID_camera) FROM camere)
 Group by ID_camera, 
          tip_confort.nume_tip_confort,
          locatii.nume_locatie,
          camere.nr_persoane_max
    ");

    $nr_pers_in_camera_basic=mysqli_query($db, "
    SELECT ID_camera, 
       tip_confort.nume_tip_confort,      
       Count(*) AS nr_pers_in_camera, 
       locatii.nume_locatie, 
       camere.nr_persoane_max  
  FROM inregistrari 
  NATURAL JOIN camere 
  NATURAL JOIN tip_confort 
  NATURAL JOIN locatii 
 WHERE camere.ID_tip_confort =1
   AND ID_camera in (SELECT DISTINCT(ID_camera) FROM camere)
 Group by ID_camera, 
          tip_confort.nume_tip_confort,
          locatii.nume_locatie,
          camere.nr_persoane_max
    ");

    $nr_pers_in_camera_premium=mysqli_query($db, "
    SELECT ID_camera, 
       tip_confort.nume_tip_confort,      
       Count(*) AS nr_pers_in_camera, 
       locatii.nume_locatie, 
       camere.nr_persoane_max  
  FROM inregistrari 
  NATURAL JOIN camere 
  NATURAL JOIN tip_confort 
  NATURAL JOIN locatii 
 WHERE camere.ID_tip_confort =2
   AND ID_camera in (SELECT DISTINCT(ID_camera) FROM camere)
 Group by ID_camera, 
          tip_confort.nume_tip_confort,
          locatii.nume_locatie,
          camere.nr_persoane_max
    ");
?>