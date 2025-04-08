<?php
    session_start();
	
	include('../../../connex.php');
	
    ini_set('memory_limit','512M');
    ini_set('max_execution_time', 12000);

    $id_pers=$_GET['personnel_id'];

    $red=$con->prepare(" SELECT * FROM personnel_soignant INNER JOIN service ON service.id_service=personnel_soignant.service_id INNER JOIN fonction ON fonction.id_fonction=personnel_soignant.fonction_id WHERE id_personnel_soignant=:A ");
    $red->execute(array('A'=>$id_pers));
    $inf=$red->fetch();

    $red1=$con->prepare(" SELECT * FROM personnel_soignant LEFT JOIN utilisateur ON personnel_soignant.id_personnel_soignant=utilisateur.personnel_id INNER JOIN groupe_utilisateur ON utilisateur.type_groupe_id=groupe_utilisateur.id_type_groupe WHERE id_utilisateur=:A ");
    $red1->execute(array('A'=>$id_pers));
    $inf1=$red1->fetch();
    
    $type_groupe=$inf1['type_groupe_id'];

    $nom= $inf['nom_personnel_soignant'];
    $email= $inf['email_personnel_soignant'];
    $tel= $inf['tel_personnel_soignant'];
    $service=$inf['lib_service'];
    $fonction= $inf['lib_fonction'];
    
    $test['nom'] = stripslashes($nom);
    $test['email'] = stripslashes($email);
    $test['tel'] = stripslashes($tel);
    $test['service'] = stripslashes($service);
    $test['fonction'] = stripslashes($fonction);
    $test['type_groupe'] = stripslashes($type_groupe);

    echo json_encode($test);
   
	
unset($con);

?>