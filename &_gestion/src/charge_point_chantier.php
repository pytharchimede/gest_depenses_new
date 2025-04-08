<?php
    session_start();
  include('../../../logi/connex.php');
  
    ini_set('memory_limit','512M');
    ini_set('max_execution_time', 12000);
  
  
    if(isset($_POST['recher_chantier']) && $_POST['recher_chantier']!='')
	{
	$recher_chantier=$_POST['recher_chantier'];
	}
	else
	{
	$recher_chantier='';
	}

   	
  
  if( $recher_chantier!=''){
  ?>
  <script>
   function change_page_point(page_id){
   
   var recher_chantier='<?php echo $recher_chantier; ?>';

   var dataString = 'page_id='+page_id+'&recher_chantier='+recher_chantier;
   
     $.ajax({
            type: "POST",
            url: "src/charge_point_chantier.php",
           data: dataString,
           cache: false,
        beforeSend: function(){
      $("div.chargement").html('<img src="../../img/giphy.gif" style="width:65px; height:65px;" />').show();
            },
           success: function(result){
      $("div.chargement").html('<img src="../../img/giphy.gif" style="width:65px; height:65px;" />').hide();
      $(".affiche_point_chantier").html(result);
       }
      });
    }
  </script>
  <?php 
   }
   
    $_SESSION["recher_chantier"]=$recher_chantier;

	
	 $requete="SELECT * FROM fiche LEFT JOIN chantier ON chantier.id_chantier=fiche.chantier_id LEFT JOIN decaissement ON decaissement.num_fiche_decaissement=fiche.num_fiche WHERE id_fiche!='' ";
	 
	 if($_SESSION['secur_hop']!='dgfidest' && $_SESSION['secur_hop']!='lol')
	 {
	     $requete.=' AND affectation_id!=29 AND affectation_id!=30 ';
	 }
	 


     if($recher_chantier!=""){
        $requete.=" AND chantier_id='".$recher_chantier."' ";
     }

     $requete_1=$requete;

 
	 
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



    $_SESSION["recher_chantier"]=$recher_chantier;
 
    $requete="SELECT * FROM fiche LEFT JOIN chantier ON chantier.id_chantier=fiche.chantier_id LEFT JOIN decaissement ON decaissement.num_fiche_decaissement=fiche.num_fiche WHERE id_fiche!='' ";
    
     if($_SESSION['secur_hop']!='dgfidest' && $_SESSION['secur_hop']!='lol')
	 {
	     $requete.=' AND affectation_id!=29 AND affectation_id!=30 ';
	 }

     if($recher_chantier!=""){
        $requete.=" AND chantier_id='".$recher_chantier."' ";
     }

   

	 $requete.=" ORDER BY id_fiche DESC LIMIT $start, $records_per_page";

     $requete_1=$requete;

	 $records= $con->query($requete);
	 
  
	 
   
$count  = $records->rowCount();
$HTML='';

$HTML.='<p class="col_titre">Nombre chantier trouvés : <b>'.$count_1.'</b>&nbsp;&nbsp;';

$HTML.='
    <a href="exportation/pdf/pdf_liste_recherche.php" target="_blank" style="font-size:20px; font-weight:600; color: #da0909" title="Générer le fichier pdf">
        <i class="fa fa-file-pdf"></i>
    </a>  &nbsp;&nbsp;&nbsp;
   
    <a href="exportation/excel/excel_chantier.php" target="_blank" style="font-size:20px; font-weight:600; color: #006f38" title="Générer le fichier excel">
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


 $detail=$con->query($requete_1);
 $idet=$detail->fetch();

 $montant_devis=0;
 $montant_debourse=0;
 $somme_avance_decaisse=0;

 //Calcul montant devis et montant chantier
 $cal=$con->prepare('SELECT * FROM chantier LEFT JOIN operation ON operation.chantier_id_operation=chantier.id_chantier LEFT JOIN designation ON designation.operation_id_designation=operation.id_operation  WHERE id_chantier=:A');
 $cal->execute(array('A'=>$idet['id_chantier']));
 while($ical=$cal->fetch())
 {
    $montant_devis=$montant_devis+(floatval($ical['qte_designation'])*floatval($ical['prix_designation']));
    $montant_debourse=$montant_debourse+floatval($ical['montant_debourse']);
 }


 //Calcul somme des avances à payer
 $cal2=$con->prepare('SELECT * FROM fiche LEFT JOIN decaissement ON decaissement.num_fiche_decaissement=fiche.num_fiche WHERE chantier_id=:A AND decaisse=1');
 $cal2->execute(array('A'=>$idet['id_chantier']));
 while($ical2=$cal2->fetch())
 {
    $somme_avance_decaisse=$somme_avance_decaisse+floatval($ical2['montant']);
 }

 $solde_restant_a_payer = $montant_debourse-$somme_avance_decaisse;

 $marge=1.18*$montant_devis-$montant_debourse;

 $HTML.='
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-reset" href="#"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="fw-semibold">Exporter vers :</span> <span
                                                    class="text-muted"><i
                                                        class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Fichier pdf</a>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="card-title mb-4">DETAILS DU CHANTIER  <b style="color:red;">'.$idet['lib_chantier'].' </b> </h4>

                                    <div class="row align-items-center">
                                        <div class="col-sm-11">
                                            <div class="row">
                                            
                                             <div class="col-12">
                                                    <p class="mb-2">MONTANT TOTAL DU DEVIS</p>
                                                    <h5>'.number_format(1.18*$montant_devis,0,',',' ').' FCFA</h5>
                                                </div>
                                            
                                                <div class="col-3">
                                                    <p class="mb-2">Montant du chantier</p>
                                                    <h5>'.number_format($montant_debourse,0,',',' ').' FCFA</h5>
                                                </div>

                                                <div class="col-3">
                                                    <p class="mb-2">SOMME DES AVANCES DECAISSEES</p>
                                                    <h5>'.number_format($somme_avance_decaisse,0,',',' ').' FCFA</h5>
                                                </div>
                                                
                                                <div class="col-3">
                                                    <p class=" mb-2">SOLDE RESTANT A PAYER</p>
                                                    <h5>'.number_format($montant_debourse-$somme_avance_decaisse,0,',',' ').' FCFA</h5>
                                                </div>
                                             
                                                <div class="col-3">
                                                    <p class="mb-2">MARGE</p>
                                                    <h5>'.number_format($marge,0,',',' ').' FCFA</h5>
                                                </div>
                                                
                                            </div>
                                            <p class="text-muted"><span class="text-success me-1"> 25.2%<i class="mdi mdi-arrow-up"></i></span>...</p>

                                            <div class="mt-4">
                                                <a href="" class="btn btn-soft-secondary btn-sm">Exporter en excel <i class="mdi mdi-arrow-right ms-1"></i></a>
                                            </div>
                                        </div> <!-- end col-->
                                        <div class="col-sm-1">
                                            <div class="mt-4 mt-0">
                                                <div id="donut_chart" class="apex-charts" dir="ltr"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end card -->
                            
                            <!--Camembert-->
                             <div class="row">
                             
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header justify-content-between d-flex align-items-center">
                                        <h4 class="card-title">Simple Pie Chart</h4>
                                         <a href="https://apexcharts.com/javascript-chart-demos/pie-charts/simple-pie-chart/" target="_blank" class="btn btn-sm btn-soft-secondary">Docs <i class="mdi mdi-arrow-right align-middle"></i></a>
                                     </div><!-- end card header --> 
                                    <div class="card-body">                                        
                                        <div id="simple_pie_chart" class="apex-charts" dir="ltr"></div> 
                                    </div>
                                </div><!--end card-->
                            </div><!-- end col -->
                            
                        </div><!-- end row --> 
                         <!--/Camembert-->
';


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
        /*
        $HTML.='    
            <a href="javascript:void();" class="btn btn-sm  actif" title="D&eacute;sactivez cette personne" data-toggle="modal" data-target="#modal_actif" data-id='.$row['num_fiche'].'><i class="fa fa-lock"></i></a>
            <a href="javascript:void();" class="btn btn-sm  supr" title="Supprimer" data-toggle="modal" data-target="#modal_sup" data-id='.$row['num_fiche'].'><i class="fa fa-trash"></i></a>
            <a href="javascript:void();" class="btn btn-sm  edit_mod" title="Modifier" data-toggle="modal" data-target="#modal_mod" data-id='.$row['num_fiche'].'><i class="fa fa-edit"></i></a>
            <a href="javascript:void();" class="btn btn-sm  detail" title="D&eacute;tail" data-toggle="modal" data-target="#modal_detail" data-id='.$row['num_fiche'].'><i class="fa fa-align-justify fa_jus"></i></a>
		';
        */
        $HTML.='
        AUCUNE
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
    $titre='<br />Aucun chantier trouv&eacute;e';
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