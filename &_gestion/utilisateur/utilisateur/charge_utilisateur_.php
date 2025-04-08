<?php
    session_start();
	
	include('../../../connex.php');
	
    ini_set('memory_limit','512M');
    ini_set('max_execution_time', 12000);
	
	if(isset($_POST['recher_utilisateur']) && ($_POST['recher_utilisateur']!=''))
	{
	$recher_utilisateur=$_POST['recher_utilisateur'];
	}
	else
	{
	$recher_utilisateur="";
    }
    
    if(isset($_POST['recher_groupe']) && ($_POST['recher_groupe']!=''))
	{   
    $recher_groupe=$_POST['recher_groupe'];
    }
	else
	{
	$recher_groupe="";
    }
    
    
    if(isset($_POST['recher_service']) && ($_POST['recher_service']!=''))
	{
    $recher_service=$_POST['recher_service'];
    }
	else
	{
	$recher_service="";
    }

    if(isset($_POST['recher_statut']) && ($_POST['recher_statut']!=''))
	{
    $recher_statut=$_POST['recher_statut'];
	}
	else
	{
	$recher_statut="";
    }

    if($recher_utilisateur!="" || $recher_service!="" || $recher_statut!="" || $recher_groupe!="" ){
    ?>
    <script>

	 function change_page_utilisateur(page_id_cons){
	 
	 var recher_utilisateur='<?php echo $recher_utilisateur; ?>';
     var recher_service='<?php echo $recher_service; ?>';
     var recher_statut='<?php echo $recher_statut; ?>';
     var recher_groupe='<?php echo $recher_groupe; ?>';

  var dataString = 'page_id_cons='+ page_id_cons+"&recher_utilisateur="+recher_utilisateur+"&recher_service="+recher_service+"&recher_statut="+recher_statut+"&recher_groupe="+recher_groupe;

     $.ajax({
           type: "POST",
           url: "utilisateur/charge_utilisateur.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
            $("div.chargement").html('<img src="../../images/loading.gif" style="width:25px; height:25px;" />').show();
            $(".aff_utilisateur").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../images/loading.gif" style="width:25px; height:25px;" />').hide();
		  $(".aff_utilisateur").html(result).show();
		   }
      });
    }
	</script>
     
    <?php
    }
        
    if($recher_utilisateur!="" || $recher_groupe!="" || $recher_service!="" || $recher_statut!="" ){
        
    $requete=" SELECT * FROM utilisateur LEFT JOIN personnel_soignant ON personnel_soignant.id_personnel_soignant=utilisateur.personnel_soignant_id INNER JOIN service ON service.id_service=personnel_soignant.service_id  INNER JOIN fonction ON fonction.id_fonction=personnel_soignant.fonction_id WHERE id_utilisateur!='' ";

    if($recher_statut!=""){
    $requete.=" AND statut =".$recher_statut." ";
    }
    else
    {
    $requete.=" AND statut='0' ";
    }
 
    if($recher_utilisateur!=""){		 
    $requete.=" AND (nom_personnel_soignant LIKE '%".$recher_utilisateur."%' || email_personnel_soignant LIKE '%".$recher_utilisateur."%' || tel_personnel_soignant LIKE '%".$recher_utilisateur."%') ";
    }        
 
    if($recher_groupe!=""){
    $requete.=" AND type_groupe_id =".$recher_groupe." ";
    }
   
    if($recher_service!=""){	 
    $requete.=" AND service_id =".$recher_service." "; 
    }

    
    }
    else
    {
        $requete=" SELECT * FROM utilisateur LEFT JOIN personnel_soignant ON personnel_soignant.id_personnel_soignant=utilisateur.personnel_soignant_id INNER JOIN service ON service.id_service=personnel_soignant.service_id  INNER JOIN fonction ON fonction.id_fonction=personnel_soignant.fonction_id WHERE id_utilisateur!='' ";
    }

    $sqlQuery=$con->query($requete);

	$count  	= $sqlQuery->rowCount();
    $count_1  	= $sqlQuery->rowCount();
	
	$adjacents = 2;
	$records_per_page = 6;
	
	$page = (int) (isset($_POST['page_id_cons']) ? $_POST['page_id_cons'] : 1);
	$page = ($page == 0 ? 1 : $page);
	$start = ($page-1) * $records_per_page;
	
	$next = $page + 1;    
	$prev = $page - 1;
	$last_page = ceil($count/$records_per_page);
	$second_last = $last_page - 1; 

	
	$pagination = "";
	if($last_page > 1){
        $pagination .= "<div class='pagination'>";
        if($page > 1)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(1);'>&laquo; Debut</a>";
        else
            $pagination.= "<span class='disabled'>&laquo; Debut</span>";
		
		if ($page > 1)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(".($prev).");'>&laquo; Precedent&nbsp;&nbsp;</a>";
        else
            $pagination.= "<span class='disabled'>&laquo; Precedent&nbsp;&nbsp;</span>";   
		
        if ($last_page < 7 + ($adjacents * 2))
        {   
            for ($counter = 1; $counter <= $last_page; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<span class='current'>$counter</span>";
                else
                    $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(".($counter).");'>$counter</a>";     
                         
            }
        }
        elseif($last_page > 5 + ($adjacents * 2))
        {
            if($page < 1 + ($adjacents * 2))
            {
                for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                {
                    if($counter == $page)
                        $pagination.= "<span class='current'>$counter</span>";
                    else
                        $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(".($counter).");'>$counter</a>";     
                }
                $pagination.= "...";
                $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(".($second_last).");'> $second_last</a>";
                $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(".($last_page).");'>$last_page</a>";   
           
           }
           elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))
           {
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(1);'>1</a>";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(2);'>2</a>";
               $pagination.= "...";
               for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
               {
                   if($counter == $page)
                       $pagination.= "<span class='current'>$counter</span>";
                   else
                       $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(".($counter).");'>$counter</a>";     
               }
               $pagination.= "..";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(".($second_last).");'>$second_last</a>";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(".($last_page).");'>$last_page</a>";   
           }
           else
           {
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(1);'>1</a>";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(2);'>2</a>";
               $pagination.= "..";
               for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)
               {
                   if($counter == $page)
                        $pagination.= "<span class='current'>$counter</span>";
                   else
                        $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(".($counter).");'>$counter</a>";     
               }
           }
        }
        if($page < $counter - 1)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(".($next).");'>Suivant &raquo;</a>";
        else
            $pagination.= "<span class='disabled'>Suivant &raquo;</span>";
		
		if($page < $last_page)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_utilisateur(".($last_page).");'>Fin &raquo;</a>";
        else
            $pagination.= "<span class='disabled'>Fin &raquo;</span>";
        
        $pagination.= "</div>";       
    }

    if($recher_utilisateur!="" || $recher_groupe!="" || $recher_service!="" || $recher_statut!="" ){
    $req=" SELECT * FROM utilisateur LEFT JOIN personnel_soignant ON personnel_soignant.id_personnel_soignant=utilisateur.personnel_soignant_id INNER JOIN service ON service.id_service=personnel_soignant.service_id  INNER JOIN fonction ON fonction.id_fonction=personnel_soignant.fonction_id WHERE id_utilisateur!='' ";
    
   
    if($recher_statut!="" && $recher_statut!=""){
        $req.=" AND statut =".$recher_statut." ";
    }
    else
    {
        $req.=" AND statut='0' ";
    }
 
    if($recher_utilisateur!=""){		 
    $req.=" AND (nom_personnel_soignant LIKE '%".$recher_utilisateur."%' || email_personnel_soignant LIKE '%".$recher_utilisateur."%' || tel_personnel_soignant LIKE '%".$recher_utilisateur."%') ";
    }        

    if($recher_groupe!="" && $recher_groupe!=""){
    $req.=" AND type_groupe_id =".$recher_groupe." ";
    }

    if($recher_service!="" && $recher_service!=""){	 
    $req.=" AND service_id =".$recher_service." "; 
    }
        
    }
    else
    {
        $req=" SELECT * FROM utilisateur LEFT JOIN personnel_soignant ON personnel_soignant.id_personnel_soignant=utilisateur.personnel_soignant_id INNER JOIN service ON service.id_service=personnel_soignant.service_id  INNER JOIN fonction ON fonction.id_fonction=personnel_soignant.fonction_id WHERE id_utilisateur!='' ";
    }
	

$req.=" ORDER BY nom_personnel_soignant ASC LIMIT $start, $records_per_page ";

$records=$con->query($req);    

	 
$count  = $records->rowCount();
$HTML='';

$HTML.='<p class="col_titre">Nombre d&rsquo; utilisateur(s) : <b>'.$count_1.'</b></p>';
					             
if($count > 0)
{

$i=1;

    foreach($records as $row) {
	
	$red=$con->prepare("SELECT * FROM groupe_utilisateur WHERE id_type_groupe=:A"); 
    $red->execute(array('A' =>$row['type_groupe_id']));
    $uti=$red->fetch();
	
	            if($uti['ajout_type_groupe']== 1){ $ajout="<span class='badge rounded-pill bg-primary'>Ajouter</span>"; }else{ $ajout=""; }
                if($uti['modif_type_groupe']==1){ $modif="<span class='badge rounded-pill bg-primary'>Modifier</span>"; }else{ $modif=""; }
                if($uti['sup_type_groupe']==1){ $t_sup="<span class='badge rounded-pill bg-primary'>Supprimer</span>"; }else{ $t_sup=""; }
                if($uti['visual_type_groupe']==1){ $visual="<span class='badge rounded-pill bg-primary'>Visualiser</span>"; }else{ $visual=""; }
                if($uti['config_type_groupe']==1){ $configura ="<span class='badge rounded-pill bg-primary'>Configuration</span>"; }else{ $configura =""; }
                if($uti['secur_type_groupe']==1){ $securite ="<span class='badge rounded-pill bg-primary'>Sécurité</span>"; }else{ $securite =""; }

 if($row['valide_util']==1)
{
     $statu="<i class='fa fa-unlock-alt'></i>"; $actf="Activez le compte"; $bgc='bg-yellow-active'; $modifi=""; $supri="<i class='fa fa-trash'></i>"; 
}


if($row['valide_util']==0)
{ 
    $statu="<i class='fa fa-unlock'></i>";  $actf="D&eacute;sactivez le compte"; $bgc='bg-green-active'; $modifi="<i class='fa fa-edit'></i>"; $supri="<i class='fa fa-trash'></i>";
}

				
		       $HTML.='<div class="col-md-4">
          <div class="box box-widget widget-user-2 pro_util" style="border-radius:25px; background-color:#fff; box-shadow: 0 3px 3px #eaedf2; padding:10px; margin:5px;">
            <div class="action_user">';
            /*
            if($_SESSION['id_utilisateur']!=$row['id_utilisateur'])
            {
                */
            $HTML.='
			<a class="edit" href="javascript:void(0);"  data-toggle="modal" data-target="#myModal_utilisateur_mod" data-id='.$row['id_utilisateur'].' title="Modifier">'.$modifi.'</a>&nbsp;&nbsp;&nbsp;
			<a class="valide" href="javascript:void(0);" data-id='.$row['id_utilisateur'].' title="'.$actf.'">'.$statu.'</a>
  &nbsp;&nbsp;&nbsp;<a class="delete" href="javascript:void(0);" data-toggle="modal" data-target="#myModal_utilisateur_sup" data-id='.$row['id_utilisateur'].' title="Supprimer">'.$supri.'</a>';
            /*
            }
            */
            $HTML.='
			</div>
            <div class="widget-user-header '.$bgc.' ">
			
		
            <div class="widget-user-image">';
            if($row['photo_util']!='') { 
			$HTML.='<img  class="rounded-circle" src="../photo/'.$row['photo_util'].'" style="height:100px; width:100px; margin-left:35%; border:5px solid #f7f8fa;" alt="Image utilisateur"/>';
		    }else{ 
			$HTML.='<img class="rounded-circle" src="../photo/profile-2398782.png" style="height:100px; width:100px; margin-left:35%; border:1px solid #f7f8fa;" alt="Image utilisateur"/>';
			} 
            $HTML.='</div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username user_nom" style="color:#000; font-size:15px; text-align:center;">'.stripslashes($row['nom_utilisateur']).'</h3>
              <h5 class="widget-user-desc"  style="color:#000;">'.stripslashes($uti['nom_type_groupe']).'</h5>
            </div>
            <div class="box-footer no-padding util_footer">
			
              <ul class="nav nav-stacked">
			  
                <li><a><strong>SERVICE(S)</strong><br/>';
							
                $HTML.='<span class="label lab_use bg-green">'.stripslashes($row['lib_service']).'</span>';
                
				$HTML.='</a></li>
 <li><a class="a_droi" style="background-color:#fff;"><strong style="color:black">DROIT(S)</strong><br/>'.$ajout.' '.$modif.' '.$t_sup.' '.$visual.' '.$configura.' '.$securite.'</a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>';	
									$i++;	                                                                 
}
			
}
 
else
{
    $titre='<br />Aucun utilisateur trouv&eacute;';
    $donnee=utf8_encode($titre);
    $HTML.='<div><font color="#990000" style="font-size:11px; align="center"">'.$donnee.'</font></div>';
}
	   	
$HTML.='';	   
echo $HTML;
echo $pagination;
echo'<br /><br />';
unset($con);

?>