<?php
    session_start();
	
	include('../../../connex.php');
	
    ini_set('memory_limit','512M');
    ini_set('max_execution_time', 12000);
	
	if(isset($_POST['recher_historique']) && ($_POST['recher_historique']!=''))
	{
	$recher_historique=$_POST['recher_historique'];
	}
	else
	{
	$recher_historique='';
    }
    $_SESSION["recher_historique"]=$recher_historique;

    if(isset($_POST['recher_utilisateur']) && ($_POST['recher_utilisateur']!=''))
	{
	$recher_utilisateur=$_POST['recher_utilisateur'];
	}
	else
	{
	$recher_utilisateur='';
    }
    $_SESSION["recher_utilisateur"]=$recher_utilisateur;

    if(isset($_POST['dp1']) && ($_POST['dp1']!=''))
	{
    $dp1=$_POST['dp1'];
	$_SESSION['dp1']=$dp1;
	///$dp1 = date("Y-d-m", strtotime($dp1_));
	}
	else
	{
    $dp1='';
	$_SESSION['dp1']='';
	}
	
    if(isset($_POST['dp2']) && ($_POST['dp2']!=''))
	{
    $dp2=$_POST['dp2'];
	$_SESSION['dp2']=$dp2;
	///$dp2 = date("Y-d-m", strtotime($dp2_));
	}
	else
	{
	$dp2='';
	$_SESSION['dp2']='';
	}

    if($recher_historique!='' || $recher_utilisateur!='' || $dp1!='' || $dp2!=''){
    ?>
    <script>

	 function change_page_historique(page_id_cons){
	 
    var recher_historique='<?php echo $recher_historique; ?>';
    var recher_utilisateur='<?php echo $recher_utilisateur; ?>';
    var dp1='<?php echo $dp1; ?>';
    var dp2='<?php echo $dp2; ?>';
  	
    var dataString = 'page_id_cons='+ page_id_cons+"&recher_historique="+recher_historique+"&recher_utilisateur="+recher_utilisateur+"&dp1="+dp1+"&dp2="+dp2;
	 
     $.ajax({
           type: "POST",
           url: "historique/charge_historique.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
            $("div.chargement").html('<img src="../../../images/loading.gif" style="width:50px; height:50px;" />').show();
            $(".affiche_historique").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../../images/loading.gif" style="width:50px; height:50px;" />').hide();
		  $(".affiche_historique").html(result).show();
		   }
      });
    }
	</script>
    <?php
    }

$requete=" SELECT * FROM trace LEFT JOIN utilisateur ON trace.secur=utilisateur.secur WHERE ref_trace!='' ";

if($recher_historique!=""){
$requete.=" AND (lib_trace LIKE '%".$recher_historique."%' || nom_utilisateur LIKE '%".$recher_historique."%' || date_trace LIKE '%".$recher_historique."%' || adresse_ip LIKE '%".$recher_historique."%' ) ";           
    }

if($recher_utilisateur!=""){
$requete.=" AND (id_utilisateur ='".$recher_utilisateur."') ";           
    }

if($dp1!=""){ 
$requete.=" AND date_trace>='".$dp1."' ";
    }
           
if($dp2!=""){ 
$requete.=" AND date_trace<='".$dp2."' ";
    }

    $sqlQuery=$con->query($requete);

	$count  	= $sqlQuery->rowCount();
    $count_1  	= $sqlQuery->rowCount();

	$adjacents = 2;
	$records_per_page = 1000;
	
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
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(1);'>&laquo; Debut</a>";
        else
            $pagination.= "<span class='disabled'>&laquo; Debut</span>";
		
		if ($page > 1)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(".($prev).");'>&laquo; Precedent&nbsp;&nbsp;</a>";
        else
            $pagination.= "<span class='disabled'>&laquo; Precedent&nbsp;&nbsp;</span>";   
		
        if ($last_page < 7 + ($adjacents * 2))
        {   
            for ($counter = 1; $counter <= $last_page; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<span class='current'>$counter</span>";
                else
                    $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(".($counter).");'>$counter</a>";     
                         
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
                        $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(".($counter).");'>$counter</a>";     
                }
                $pagination.= "...";
                $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(".($second_last).");'> $second_last</a>";
                $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(".($last_page).");'>$last_page</a>";   
           
           }
           elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))
           {
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(1);'>1</a>";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(2);'>2</a>";
               $pagination.= "...";
               for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
               {
                   if($counter == $page)
                       $pagination.= "<span class='current'>$counter</span>";
                   else
                       $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(".($counter).");'>$counter</a>";     
               }
               $pagination.= "..";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(".($second_last).");'>$second_last</a>";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(".($last_page).");'>$last_page</a>";   
           }
           else
           {
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(1);'>1</a>";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(2);'>2</a>";
               $pagination.= "..";
               for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)
               {
                   if($counter == $page)
                        $pagination.= "<span class='current'>$counter</span>";
                   else
                        $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(".($counter).");'>$counter</a>";     
               }
           }
        }
        if($page < $counter - 1)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(".($next).");'>Suivant &raquo;</a>";
        else
            $pagination.= "<span class='disabled'>Suivant &raquo;</span>";
		
		if($page < $last_page)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page_historique(".($last_page).");'>Fin &raquo;</a>";
        else
            $pagination.= "<span class='disabled'>Fin &raquo;</span>";
        
        $pagination.= "</div>";       
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

    $req.=" ORDER BY ref_trace DESC LIMIT $start, $records_per_page ";
    $records=$con->query($req);    

	 
$count  = $records->rowCount();
$HTML='';

$HTML.='<p class="col_titre">Nombre d&rsquo; op&eacute;ration(s) : <b>'.$count_1.'</b>&nbsp;';

$HTML.='<a href="historique/exportation/excel/excel_historique.php" target="_blank" title="Exporter en Excel" id="title">
    <img src="../../img/excel.png"  width="20" height="20">
</a>&nbsp;
<!--
<a href="historique/exportation/pdf/pdf_historique.php" target="_blank" title="Exporter en PDF" id="title">
    <img src="../../img/logo_pdf.png"  width="20" height="20">
</a>
-->
</p><br/>
';
					             
if($count > 0)
{

$i=1;

$HTML.='
        
<table id="tab_hist" class="table table-bordered table-striped">
<thead>
<tr>
  <th>Date et Heure</th>
  <th>Utilisateur</th>
  <th>Opération</th>
  <th>Adresse IP</th>
  </tr>
</thead>

<tbody>
<tr>



';

    foreach($records as $row) {

        $red=$con->prepare("SELECT * FROM utilisateur WHERE secur =:A"); 
        $red->execute(array('A' => $row["secur"]));
        $mem=$red->fetch();
        $nom=$mem['nom_utilisateur'];

        //$date_trace=date("d/m/Y H:i", strtotime($row['date_trace']));
	
        $HTML.='<tr bgcolor="" class="td td_color">
        <td width="70">'.$row['date_trace'].'</td>
        <td width="80">'.stripslashes(ucwords(strtolower($nom))).'</td>
        <td width="200">'.stripslashes(utf8_encode($row['lib_trace'])).'</td>
        <td width="90">'.$row['adresse_ip'].'</td></tr>';
                                    
        $i++;	                                                                 
}

$HTML.='
            </tr>
    </tbody>
    </tfoot>
    </table>
';
			
}
 
else
{
    $titre='<br />Aucun historique trouv&eacute;';
    $donnee=utf8_encode($titre);
    $HTML.='<div><font color="#990000" style="font-size:11px; align="center"">'.$donnee.'</font></div>';
}
	   	
$HTML.='';	   
echo $HTML;
echo $pagination;
echo"<br /><br />";

unset($con);
?>


