<?php
    session_start();
	
	include('../../../connex.php');
	
    ini_set('memory_limit','512M');
    ini_set('max_execution_time', 12000);
	
	
    ?>
    <script>

	 function change_page_designation(page_id_cons){
       
  var dataString = 'page_id_cons='+ page_id_cons;
	 
     $.ajax({
           type: "POST",
           url: "designation/charge_designation.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../../images/loading.gif" style="width:25px; height:25px;" />').show();
            $(".aff_designation").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../../images/loading.gif" style="width:25px; height:25px;" />').hide();
		  $(".aff_designation").html(result).show();
		   }
      });
    }
	</script>
     

    <?php

$requete=" SELECT * FROM designation LEFT JOIN operation ON operation.id_operation=designation.operation_id_designation WHERE id_designation!='' ";


    $sqlQuery=$con->query($requete);

	$count  	= $sqlQuery->rowCount();
    $count_1  	= $sqlQuery->rowCount();
	
	$adjacents = 2;
	$records_per_page = 4;
	
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
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(1);'>&laquo; Debut</a>";
        else
            $pagination.= "<span class='disabled'>&laquo; Debut</span>";
		
		if ($page > 1)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(".($prev).");'>&laquo; Precedent&nbsp;&nbsp;</a>";
        else
            $pagination.= "<span class='disabled'>&laquo; Precedent&nbsp;&nbsp;</span>";   
		
        if ($last_page < 7 + ($adjacents * 2))
        {   
            for ($counter = 1; $counter <= $last_page; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<span class='current'>$counter</span>";
                else
                    $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(".($counter).");'>$counter</a>";     
                         
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
                        $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(".($counter).");'>$counter</a>";     
                }
                $pagination.= "...";
                $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(".($second_last).");'> $second_last</a>";
                $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(".($last_page).");'>$last_page</a>";   
           
           }
           elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))
           {
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(1);'>1</a>";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(2);'>2</a>";
               $pagination.= "...";
               for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
               {
                   if($counter == $page)
                       $pagination.= "<span class='current'>$counter</span>";
                   else
                       $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(".($counter).");'>$counter</a>";     
               }
               $pagination.= "..";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(".($second_last).");'>$second_last</a>";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(".($last_page).");'>$last_page</a>";   
           }
           else
           {
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(1);'>1</a>";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(2);'>2</a>";
               $pagination.= "..";
               for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)
               {
                   if($counter == $page)
                        $pagination.= "<span class='current'>$counter</span>";
                   else
                        $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(".($counter).");'>$counter</a>";     
               }
           }
        }
        if($page < $counter - 1)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(".($next).");'>Suivant &raquo;</a>";
        else
            $pagination.= "<span class='disabled'>Suivant &raquo;</span>";
		
		if($page < $last_page)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_designation(".($last_page).");'>Fin &raquo;</a>";
        else
            $pagination.= "<span class='disabled'>Fin &raquo;</span>";
        
        $pagination.= "</div>";       
    }

    $req=" SELECT * FROM designation LEFT JOIN operation ON operation.id_operation=designation.operation_id_designation WHERE id_designation!=''   ";
 
    
    $req.=" ORDER BY id_designation ASC LIMIT ".$start.", ".$records_per_page." ";

$records=$con->query($req);    
 
$count  = $records->rowCount();
$HTML='';

$HTML.='
<p style="color:grey;">Nombre de designations : <b>'.$count_1.'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>';
					             
if($count > 0)
{

    $HTML.='<div class="table-responsive">
					                <table class="table table-striped table-vcenter">
					                    <thead>
					                        <tr>
                                                <th>&nbsp;</th>
                                                <th>Opération</th>
                                                <th>Désignation</th>
                                                <th>Quantité</th>	
                                                <th>Prix Unitaire</th>
                                                <th>Prix Total</th>	
                                                <th>Fourniture debourse</th>	
                                                <th>Main d\'oeuvre debourse</th>	
                                                <th>Montant debourse</th>	
					                            <th>Actions</th>
					                        </tr>
					                    </thead>
					                    <tbody>';

$i=1;

    foreach($records as $row) {
	
$HTML.=' 
<tr>

            <td><span class="text-muted" style="color:#CC9900; font-weight:600; text-transform:uppercase">'.stripslashes($row['id_designation']).'</span></td>
            <td><span class="text-muted" style="color:#CC9900; font-weight:600; text-transform:uppercase">'.stripslashes($row['lib_operation']).'</span></td> 
            <td><span class="text-muted" style="color:#CC9900; font-weight:600; text-transform:uppercase">'.stripslashes($row['lib_designation']).'</span></td> 
            <td><span class="text-muted" style="color:#CC9900; font-weight:600; text-transform:uppercase">'.stripslashes($row['qte_designation']).'</span></td> 
            <td><span class="text-muted" style="color:#CC9900; font-weight:600; text-transform:uppercase">'.stripslashes($row['prix_designation']).'</span></td> 
            <td><span class="text-muted" style="color:#CC9900; font-weight:600; text-transform:uppercase">'.stripslashes($row['qte_designation']*$row['prix_designation']).'</span></td> 
            <td><span class="text-muted" style="color:#CC9900; font-weight:600; text-transform:uppercase">'.stripslashes($row['fourniture_debourse']).'</span></td> 
            <td><span class="text-muted" style="color:#CC9900; font-weight:600; text-transform:uppercase">'.stripslashes($row['main_doeuvre_debourse']).'</span></td> 
            <td><span class="text-muted" style="color:#CC9900; font-weight:600; text-transform:uppercase">'.stripslashes($row['montant_debourse']).'</span></td> 
                
            <td>
                                                            <div class="btn-groups">   
        <a href="javascript:void();" data-id='.$row['id_designation'].' class="btn btn-icon icon-lg edit_designation" data-toggle="modal" data-target="#myModal_designation_mod"  title="Modifier" style="color:#006699; font-weight:600; text-transform:uppercase"><i class="fa fa-edit"></i></a>
        <a href="javascript:void();" class="btn btn-icon icon-lg delete_designation" data-toggle="modal" data-target="#myModal_designation_sup" data-id='.$row['id_designation'].' title="Supprimer" style="color:#006699; font-weight:600; text-transform:uppercase"><i class="fa fa-trash"></i></a>
                                                            '; 

                                                
$HTML.='
            </td>';

$HTML.='</tr>'; 

  $i++;		                                                                 
}

$HTML.='</div>';
			
}
 
else
{
    $titre='<br />Aucun designation trouv&eacute;';
    $donnee=utf8_encode($titre);
    $HTML.='<div><font color="#990000" style="font-size:11px; align="center"">'.$donnee.'</font></div>';
}
	   	
$HTML.='';	   
echo $HTML;
echo $pagination;
echo'<br /><br />';
unset($con);

?>