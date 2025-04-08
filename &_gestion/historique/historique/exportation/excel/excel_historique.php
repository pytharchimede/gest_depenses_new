<?PHP 
include('../../../../../connex.php');
session_start ();
$date=gmdate("Y-m-d H:i:s");
   
	if(isset($_SESSION['recher_historique']) && ($_SESSION['recher_historique']!=''))
	{
	$recher_historique=$_SESSION['recher_historique'];
	}
	else
	{
	$recher_historique='';
    }

    if(isset($_SESSION['recher_utilisateur']) && ($_SESSION['recher_utilisateur']!=''))
	{
	$recher_utilisateur=$_SESSION['recher_utilisateur'];
	}
	else
	{
	$recher_utilisateur='';
    }

    if(isset($_SESSION['dp1']) && ($_SESSION['dp1']!=''))
	{
	$dp1=$_SESSION['dp1'];
	}
	else
	{
    $dp1='';
	}
	
    if(isset($_SESSION['dp2']) && ($_SESSION['dp2']!=''))
	{
	$dp2=$_SESSION['dp2'];
	}
	else
	{
	$dp2='';
	}

	$req=" SELECT * FROM trace LEFT JOIN utilisateur ON trace.secur=utilisateur.secur WHERE ref_trace!='' ";

    if($recher_historique!=""){
    $req.=" AND (lib_trace LIKE '%".$recher_historique."%' || nom_utilisateur LIKE '%".$recher_historique."%'  || date_trace LIKE '%".$recher_historique."%' || adresse_ip LIKE '%".$recher_historique."%' ) ";           
        }

    if($recher_utilisateur!=""){
    $req.=" AND (id_utilisateur ='".$recher_utilisateur."') ";           
        }

    if($dp1!=""){ 
    $req.=" AND date_trace>='".$dp1."' ";
        }
       
    if($dp2!=""){ 
    $req.=" AND date_trace<='".$dp2."' ";
        }

    $req.=" ORDER BY ref_trace DESC ";
	$records=$con->query($req);   
	
	/*
	$inf=$con->query(" SELECT * FROM utilisateur WHERE id_utilisateur='".$recher_utilisateur."' ");
	$info=$inf->fetch();
	$nom_utilisateur=$info['nom_utilisateur'];
	*/		  

header("Content-type: application/vnd.ms-excel; charset=iso-8859-1");
header("Content-disposition: attachment; filename=fichier_historique_".$date.".xls");

$count = $records->rowCount();

  echo'<h3>HISTORIQUE DE CONNEXION</h3>';
/*
  echo '<b>Crit&egrave;res:</b><p>Recherche= <b>'.$recher_historique.'</b>, Utilisateur= <b>'.$nom_utilisateur.'</b>,  Debut= <b>'.$dp1.'</b>, Fin= <b>'.$dp2.'</b></p> ';
  */
  echo'&Eacute;L&Eacute;MENTS TROUV&Eacute;S : '.$count;
  
   echo'<table  style="border:1px solid">
          <tr style="font-size:14px; font-weight:500; border:1px solid">
           <td width="150">DATE ET HEURE</td>
            <td width="130">UTILISATEUR</td>
			<td width="380">OP&Eacute;RATION</td>
			<td width="250">ADRESSE IP DE CONNEXION</td>
			</tr>'; 
 
	while($row= $records->fetch())
   {
 
	                $red=$con->prepare("SELECT * FROM utilisateur WHERE secur =:A"); 
                    $red->execute(array('A' => $row["secur"]));
                    $mem=$red->fetch();
	                $nom=$mem['nom_utilisateur'];
					
		
                   echo'<tr style="border:1px solid">
					 <td width="100">'.$row['date_trace'].'</td>
					 <td width="130">'.stripslashes(ucwords(strtolower($nom))).'</td>
			         <td width="300">'.stripslashes($row['lib_trace']).'</td>
			         <td width="180">'.$row['adresse_ip'].'</td>
					 </tr>';
 
	}
	
   echo'</table>';
   
   unset($con); 
 
?>
