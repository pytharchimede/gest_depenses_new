<?php
//session_start();
include('../../../connex.php');

$id=$_GET['cpt_id'];

$red=$con->prepare("SELECT * FROM groupe_utilisateur WHERE id_type_groupe=:A"); 
$red->execute(array('A' =>$id));
$uti=$red->fetch();

                if($uti['ajout_type_groupe']==1){ $ajout="<span class='badge rounded-pill bg-primary'>Ajouter</span>&nbsp;"; }else{ $ajout=""; }
                if($uti['modif_type_groupe']==1){ $modif="<span class='badge rounded-pill bg-primary'>Modifier</span>&nbsp;"; }else{ $modif=""; }
                if($uti['sup_type_groupe']==1){ $t_sup="<span class='badge rounded-pill bg-primary'>Supprimer</span>&nbsp;"; }else{ $t_sup=""; }
				if($uti['config_type_groupe']==1){ $configura="<span class='badge rounded-pill bg-primary'>Configuration</span>&nbsp;"; }else{ $configura=""; }
                if($uti['secur_type_groupe']==1){ $securite="<span class='badge rounded-pill bg-primary'>Sécurité</span>&nbsp;"; }else{ $securite=""; }
				
			    echo "".$ajout."".$modif."".$t_sup."".$configura."".$securite;

unset($con);

?>