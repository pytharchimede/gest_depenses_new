<?php
    session_start();
  include('../../../logi/connex.php');
  
    ini_set('memory_limit','512M');
    ini_set('max_execution_time', 12000);
  
    if(isset($_POST['recher_etat']) && $_POST['recher_etat']!='')
	{
	$recher_etat=intval($_POST['recher_etat']);
	}
	else
	{
	$recher_etat='';
	}
	
	if(isset($_POST['recher_date_debut']) && $_POST['recher_date_debut']!='')
	{
	$recher_date_debut=$_POST['recher_date_debut'];
	}
	else
	{
	$recher_date_debut='';
	}
	
	if(isset($_POST['recher_date_fin']) && $_POST['recher_date_fin']!='')
	{
	$recher_date_fin=$_POST['recher_date_fin'];
	}
	else
	{
	$recher_date_fin='';
	}
	
    if(isset($_POST['recher_motif']) && $_POST['recher_motif']!='')
	{
	$recher_motif=$_POST['recher_motif'];
	}
	else
	{
	$recher_motif='';
	}

    if(isset($_POST['recher_chantier']) && $_POST['recher_chantier']!='')
	{
	$recher_chantier=$_POST['recher_chantier'];
	}
	else
	{
	$recher_chantier='';
	}

    if(isset($_POST['recher_affectation']) && $_POST['recher_affectation']!='')
	{
	$recher_affectation=$_POST['recher_affectation'];
	}
	else
	{
	$recher_affectation='';
	}

    if(isset($_POST['recher_demandeur']) && $_POST['recher_demandeur']!='')
	{
	$recher_demandeur=$_POST['recher_demandeur'];
	}
	else
	{
	$recher_demandeur='';
	}

    if(isset($_POST['recher_approbation']) && $_POST['recher_approbation']!='')
	{
	$recher_approbation=$_POST['recher_approbation'];
	}
	else
	{
	$recher_approbation='';
	}
	
	if(isset($_POST['recher_serv_log']) && $_POST['recher_serv_log']!='')
	{
	$recher_serv_log=$_POST['recher_serv_log'];
	}
	else
	{
	$recher_serv_log='';
	}
	
	if(isset($_POST['recher_serv_rh']) && $_POST['recher_serv_rh']!='')
	{
	$recher_serv_rh=$_POST['recher_serv_rh'];
	}
	else
	{
	$recher_serv_rh='';
	}

	
	
  
  if($recher_etat!='' || $recher_date_debut!='' || $recher_date_fin!='' || $recher_motif!='' || $recher_chantier!='' || $recher_demandeur!='' || $recher_approbation!='' || $recher_affectation!='' || $recher_serv_log!='' || $recher_serv_rh!=''){
  ?>
  <script>
   function change_page_point(page_id){
   
   var recher_etat='<?php echo $recher_etat; ?>';
   var recher_date_debut='<?php echo $recher_date_debut; ?>';
   var recher_date_fin='<?php echo $recher_date_fin; ?>';
   var recher_motif='<?php echo $recher_motif; ?>';
   var recher_chantier='<?php echo $recher_chantier; ?>';
   var recher_affectation='<?php echo $recher_affectation; ?>';
   var recher_demandeur='<?php echo $recher_demandeur; ?>';
   var recher_approbation='<?php echo $recher_approbation; ?>';
   var recher_serv_log='<?php echo $recher_serv_log; ?>';
   var recher_serv_rh='<?php echo $recher_serv_rh; ?>';

   dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_motif='+recher_motif+'&recher_chantier='+recher_chantier+'&recher_affectation='+recher_affectation+'&recher_demandeur='+recher_demandeur+'&recher_approbation='+recher_approbation+'&recher_serv_log='+recher_serv_log+'&recher_serv_rh='+recher_serv_rh;
   
     $.ajax({
            type: "POST",
            url: "src/charge_point.php",
           data: dataString,
           cache: false,
        beforeSend: function(){
      $("div.chargement").html('<img src="../../img/giphy.gif" style="width:65px; height:65px;" />').show();
            },
           success: function(result){
      $("div.chargement").html('<img src="../../img/giphy.gif" style="width:65px; height:65px;" />').hide();
      $(".affiche_point").html(result);
       }
      });
    }
  </script>
  <?php 
   }
   
 
 
    $_SESSION["recher_etat"]=$recher_etat;
	$_SESSION["recher_date_debut"]=$recher_date_debut;
	$_SESSION["recher_date_fin"]=$recher_date_fin;
    $_SESSION["recher_motif"]=$recher_motif;
    $_SESSION["recher_chantier"]=$recher_chantier;
    $_SESSION["recher_affectation"]=$recher_affectation;
    $_SESSION["recher_demandeur"]=$recher_demandeur;
    $_SESSION["recher_approbation"]=$recher_approbation;
    $_SESSION["recher_serv_log"]=$recher_serv_log;
    $_SESSION["recher_serv_rh"]=$recher_serv_rh;

	
	 $requete="SELECT * FROM fiche WHERE id_fiche!='' ";
	 
	 if($_SESSION['secur_hop']!='dgfidest' && $_SESSION['secur_hop']!='lol')
	 {
	     $requete.=' AND affectation_id!=29 AND affectation_id!=30 ';
	 }
	 
	if($recher_etat==1){
	    $requete.=" AND etat_fiche=1 AND decaisse=0   ";
	}

    if($recher_etat==2){
        $requete.=" AND etat_fiche=2  ";
    }

    if($recher_etat==3){
        $requete.=" AND sauvegarder=1 ";
    }

    if($recher_etat==4){
        $requete.=" AND etat_fiche=1 AND decaisse=1 ";
    }
	 
	 if($recher_date_debut!=""){
	 $requete.=" AND date_creat_fiche>='".$recher_date_debut."'  ";
	 }
	 
	 if($recher_date_fin!=""){
	 $requete.=" AND date_creat_fiche<='".$recher_date_fin."' ";
	 }

     if($recher_motif!=""){
        $requete.=" AND designation_fiche LIKE '%".$recher_motif."%' ";
     }

     if($recher_chantier!=""){
        $requete.=" AND chantier_id='".$recher_chantier."' ";
     }

     if($recher_affectation!=""){
        $requete.=" AND affectation_id='".$recher_affectation."' ";
     }

     if($recher_demandeur!=""){
        $requete.=" AND beficiaire_fiche LIKE '%".$recher_demandeur."%' ";
     }

     if($recher_approbation!=""){
        $requete.=" AND approuve='".$recher_approbation."' ";
     }
     
     if($recher_serv_log!=""){
        $requete.=" AND serv_log_id='".$recher_serv_log."' ";
     }
     
     if($recher_serv_rh!=""){
        $requete.=" AND serv_rh_id='".$recher_serv_rh."' ";
     }
	 
	 
	 if($_SESSION['resp_ch48']==1){
	     $requete.=" AND chantier_id=51 ";
	 }
	 
	 $sqlQuery= $con->query($requete);
	
   
    $count    = $sqlQuery->rowCount();
    $count_1    = $sqlQuery->rowCount();
  
  $adjacents = 2;
  $records_per_page =12;
  
  $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);
  $page = ($page == 0 ? 1 : $page);
  $start = ($page-1) * $records_per_page;
  
  $next = $page + 1;    
  $prev = $page - 1;
  $last_page = ceil($count/$records_per_page);
  $second_last = $last_page - 1; 

  

  
  $pagination = "";
  if($last_page > 1){
        $pagination .= "<div class='gridjs-pages'>";
        if($page > 1)
            $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(1);'>&laquo; Debut</button>";
        else
            $pagination.= "<button tabindex='0' role='button' tabindex='0' role='button' title='Previous' aria-label='Previous' class='' disabled=''>&laquo; Debut</button>";
    
    if ($page > 1)
            $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(".($prev).");'>&laquo; Precedent&nbsp;&nbsp;</button>";
        else
            $pagination.= "<button tabindex='0' role='button' tabindex='0' role='button' title='Previous' aria-label='Previous' class='' disabled=''>&laquo; Precedent&nbsp;&nbsp;</button>";   
    
        if ($last_page < 7 + ($adjacents * 2))
        {   
            for ($counter = 1; $counter <= $last_page; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<button tabindex='0' role='button' role='button' class='gridjs-currentPage'>$counter</button>";
                else
                    $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(".($counter).");'>$counter</button>";     
                         
            }
        }
        elseif($last_page > 5 + ($adjacents * 2))
        {
            if($page < 1 + ($adjacents * 2))
            {
                for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                {
                    if($counter == $page)
                        $pagination.= "<button tabindex='0' role='button' role='button' class='gridjs-currentPage'>$counter</button>";
                    else
                        $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(".($counter).");'>$counter</button>";     
                }
                $pagination.= "...";
                $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(".($second_last).");'> $second_last</button>";
                $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(".($last_page).");'>$last_page</button>";   
           
           }
           elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))
           {
               $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(1);'>1</button>";
               $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(2);'>2</button>";
               $pagination.= "...";
               for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
               {
                   if($counter == $page)
                       $pagination.= "<button tabindex='0' role='button' role='button' class='gridjs-currentPage'>$counter</button>";
                   else
                       $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(".($counter).");'>$counter</button>";     
               }
               $pagination.= "..";
               $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(".($second_last).");'>$second_last</button>";
               $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(".($last_page).");'>$last_page</button>";   
           }
           else
           {
               $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(1);'>1</button>";
               $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(2);'>2</button>";
               $pagination.= "..";
               for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)
               {
                   if($counter == $page)
                        $pagination.= "<button tabindex='0' role='button' role='button' class='gridjs-currentPage'>$counter</button>";
                   else
                        $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(".($counter).");'>$counter</button>";     
               }
           }
        }
        if($page < $counter - 1)
            $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(".($next).");'>Suivant &raquo;</button>";
        else
            $pagination.= "<button tabindex='0' role='button' tabindex='0' role='button' title='Previous' aria-label='Previous' class='' disabled=''>Suivant &raquo;</span>";
    
    if($page < $last_page)
            $pagination.= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_point(".($last_page).");'>Fin &raquo;</button>";
        else
            $pagination.= "<button tabindex='0' role='button' tabindex='0' role='button' title='Previous' aria-label='Previous' class='' disabled=''>Fin &raquo;</button>";
        
        $pagination.= "</div>";       
    }



 
    $_SESSION["recher_etat"]=$recher_etat;
	$_SESSION["recher_date_debut"]=$recher_date_debut;
	$_SESSION["recher_date_fin"]=$recher_date_fin;
    $_SESSION["recher_motif"]=$recher_motif;
    $_SESSION["recher_chantier"]=$recher_chantier;
    $_SESSION["recher_affectation"]=$recher_affectation;
    $_SESSION["recher_demandeur"]=$recher_demandeur;
 
	 $requete="SELECT * FROM fiche WHERE id_fiche!='' ";
	 
	 if($_SESSION['secur_hop']!='dgfidest' && $_SESSION['secur_hop']!='lol')
	 {
	     $requete.=' AND affectation_id!=29 AND affectation_id!=30 ';
	 }
	 
	 if($recher_etat==1){
	    $requete.=" AND etat_fiche=1 AND decaisse=0   ";
	 }

    if($recher_etat==2){
        $requete.=" AND etat_fiche=2  ";
    }

    if($recher_etat==3){
        $requete.=" AND sauvegarder=1 ";
    }

    if($recher_etat==4){
        $requete.=" AND etat_fiche=1 AND decaisse=1 ";
    }
	 
	 if($recher_date_debut!=""){
	 $requete.=" AND date_creat_fiche>='".$recher_date_debut."'  ";
	 }
	 
	 if($recher_date_fin!=""){
	 $requete.=" AND date_creat_fiche<='".$recher_date_fin."' ";
	 }

     if($recher_motif!=""){
        $requete.=" AND designation_fiche LIKE '%".$recher_motif."%' ";
     }

     if($recher_chantier!=""){
        $requete.=" AND chantier_id='".$recher_chantier."' ";
     }

     if($recher_affectation!=""){
        $requete.=" AND affectation_id='".$recher_affectation."' ";
     }

     if($recher_demandeur!=""){
        $requete.=" AND beficiaire_fiche LIKE '%".$recher_demandeur."%' ";
     }

     if($recher_approbation!=""){
        $requete.=" AND approuve='".$recher_approbation."' ";
     }
     
     if($recher_serv_log!=""){
        $requete.=" AND serv_log_id='".$recher_serv_log."' ";
     }
     
     if($recher_serv_rh!=""){
        $requete.=" AND serv_rh_id='".$recher_serv_rh."' ";
     }
     
     if($_SESSION['resp_ch48']==1){
	     $requete.=" AND chantier_id=51 ";
	 }

	 $requete.=" ORDER BY id_fiche DESC LIMIT $start, $records_per_page";
	 $records= $con->query($requete);
	 
  
	 
   
$count  = $records->rowCount();
$HTML='';

$HTML.='<p class="col_titre">Nombre fiches trouvées : <b>'.$count_1.'</b>&nbsp;&nbsp;';

$HTML.='
    <a href="exportation/pdf/pdf_liste_recherche.php" target="_blank" style="font-size:20px; font-weight:600; color: #da0909" title="Générer le fichier pdf">
        <i class="fa fa-file-pdf"></i>
    </a>  &nbsp;&nbsp;&nbsp;
   
    <a href="exportation/excel/excel_liste_recherche.php" target="_blank" style="font-size:20px; font-weight:600; color: #006f38" title="Générer le fichier excel">
        <i class="fa fa-file-excel"></i>
    </a> &nbsp;&nbsp;
     <!--
    <a href="javascript:void()" target="_blank" style="font-size:20px; font-weight:600; color: #000000" title="Imprimer">
        <i class="fa fa-print"></i>
    </a>
    -->
</p>
<br/>
';

                       
if($count > 0)
{

$HTML.=' <div class="row">';
 $i=1;
 $couleur[0]="#ffffff";
 $couleur[1]="#f6f6f6"; 
 $k=0; 

$HTML.='
 <div class="table-responsive" id="parent" style="margin-top:10px auto;">
 <table id="list_trait" class="table table-hover table-nowrap mb-0 align-middle table-check">
	 <thead class="bg-light">
		 <tr>
             <th>Photo</th>
			 <th>Date</th>
			 <th>N° Fiche</th>
             <th>Affectation</th>
			 <th>Bénéficiaire</th>
             <th>Motif</th>
             <th>Téléphone</th>
             <th>Montant</th>
			 <th>Etat</th>
			 <th colspan="2" class="rounded-end">Action</th>
		 </tr>
		 <!-- end tr -->
	 </thead>
	 <!-- end thead -->
	 <tbody>';
 
    foreach($records as $row) {
    /*
	            $rep=$con->prepare("SELECT * FROM service WHERE id_service='".$row['service_id']."'");
                $rep->execute(); 
	            $ro=$rep->fetch();
				
	

				if($row['valide']==0){ $class_act='unlock'; }else{ $class_act='lock'; }
				
				
if($row['sexe_personnel']=='1'){ $sexe='HOMME'; }else if($row['sexe_personnel']=='2'){ $sexe='FEMME'; }else{ $sexe=''; } 

$date_nais = date("d/m/Y", strtotime($row['date_nais_personnel']));

	*/

$HTML.='	
			<tr>
            <td>
                <img src="../../img_demande/'; if($row['photo_beneficiaire']!=''){$HTML.= $row['photo_beneficiaire'];}else{ $HTML.= 'default_picture.png';} $HTML.='" class="avatar-lg img-thumbnail h-auto rounded-circle" alt="Error">
            </td>
			<td><span class="c_0">'.stripslashes(strtoupper($row['date_creat_fiche'])).'</span></td>
			
			<td><span class="text-lg text-semibold text-main fo_per">'.stripslashes($row['num_fiche']).'</span></td>
            <td><span class="text-lg text-semibold text-main fo_per">'.stripslashes($row['affectation_id']).'</span></td>
            <td><span class="text-lg text-semibold text-main fo_per">'.stripslashes($row['beficiaire_fiche']).'</span></td>
            <td><span class="text-lg text-semibold text-main fo_per">'.stripslashes($row['designation_fiche']).'</span></td>
			<td>'.stripslashes($row['tel_beneficiaire_fiche']).'</td>
			<td>'.stripslashes($row['montant_fiche']).'</td>
			<td>'.stripslashes($row['etat_fiche']).'</td>

';
			
           $HTML.=' 
        <td>	       
        ';
        
        $HTML.='    
            <a target="_blank" href="exportation/pdf/pdf_fiche.php?num_fiche='.$row['num_fiche'].'" class="dropdown-item"> <i class="fa fa-file-pdf"></i> Fiche</a>
		';
        
        $HTML.='
        </td>
		</tr>
		';
								
                    
                  $i++;
                  $k++;                                                                    
}
      

$HTML.='
</tbody><!-- end tbody -->
</table><!-- end table -->
</div>
';
                  

}
 
else
{
    $titre='<br />Aucune personne trouv&eacute;e';
    $donnee=utf8_encode($titre);
    $HTML.='<div align="center"><font color="#990000" style="font-size:11px;">'.$donnee.'</font></div>';
}
      
$HTML.='</div>';
                             
echo $HTML;
echo $pagination;
echo'<br /><br />';
unset($con);

?>

<script src="../assets/libs/tabletolist/tableToList.js"></script>
        <script>
            $(function() {
                getList('#list_trait', '#parent');
            });
        </script>