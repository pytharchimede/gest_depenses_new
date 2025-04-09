<?php
    session_start ();
    
    $_SESSION['num_fiche']=$_GET['num_fiche'];
     
        include('../../../connex.php');
    	 
    	include("../../../pdf/phpToPDF.php");
    
    	require('../../../pdf/mysql_table.php');
    	
    	require_once("phpqrcode/qrlib.php");
    
    /*
    require('../../../cells_bold/cells_bold.php');
    */
    
    class PDF extends PDF_MySQL_Table
    {
    
    function Header()
    {
               
     
    }
    
    // Pied de page
    function Footer()
    {
    	// Position at 1.5 cm from bottom
        $this->SetY(-22);
    	
        $this->Image('../../../img/logo_veritas.jpg', 10,275,30);	
        // Arial italic 8
        $this->SetFont('Arial','',7);
    
    	$this->Cell(0,3.5,utf8_decode("FOURNITURES INDUSTRIELLES, DEPANNAGE ET TRAVAUX PUBLIQUES"),0,1,'C');
    	$this->Cell(0,3.5,utf8_decode('Au capital de 10 000 000 F CFA - Siège Social : Abidjan, Koumassi, Zone industrielle '),0,1,'C');
    	$this->Cell(0,3.5,utf8_decode("01 BP 1642 Abidjan 01 - Téléphone : (+225) +225 27-21-36-27-27  -  Email : info@fidest.org"),0,1,'C');
    	$this->Cell(0,3.5,utf8_decode('RCCM : CI-ABJ-2017-B-20163  -  N° CC : 010274200088 '),0,1,'C');
    	
    	$this->Image('../../../img/logo_veritas.jpg', 172,275,30);	
    	
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    	
    } 
    
    //HTML CLASS
    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';

    function WriteHTML($html)
    {
        // Parseur HTML
        $html = str_replace("\n",' ',$html);
        $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                // Texte
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                else
                    $this->Write(5,$e);
            }
            else
            {
                // Balise
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    // Extraction des attributs
                    $a2 = explode(' ',$e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag,$attr);
                }
            }
        }
    }
    
    function OpenTag($tag, $attr)
    {
        // Balise ouvrante
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF = $attr['HREF'];
        if($tag=='BR')
            $this->Ln(5);
    }
    
    function CloseTag($tag)
    {
        // Balise fermante
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF = '';
    }
    
    function SetStyle($tag, $enable)
    {
        // Modifie le style et sélectionne la police correspondante
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach(array('B', 'I', 'U') as $s)
        {
            if($this->$s>0)
                $style .= $s;
        }
        $this->SetFont('',$style);
    }
    
    function PutLink($URL, $txt)
    {
        // Place un hyperlien
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }
    }
            
			//Paramètres du fichier PDF 
			$pdffilename = 'fiche_expression_besoin.pdf';
			clearstatcache();
			if (file_exists($pdffilename)) {
			//Si le fichier PDF existe, il faut le supprimer d'abord
			unlink($pdffilename);
			}
			 
			//Création du fichier PDF
			$pdf=new PDF('P','mm','A4');
			 
			$pdf->AliasNbPages();

			//$pdf->AddPage('L');
			$pdf->AddPage();
			
		
			$pdf->SetTextColor(0);
			$pdf->SetFont('Arial','',10);
			$entreprise=utf8_decode("Fidest Entreprises");
			$pdf->Image("../../../img/entete_fiche.jpg", 5, 10,  200, 'C');
			$pdf->Ln(25);
			//$pdf->Cell(0,2,utf8_decode("Application de Gestion des Formations "),0,1,'C');
			//$pdf->Line(10, 35, 200, 35); 
			$pdf->Ln(5);

			$pdf->SetFont('Arial','',7);
			$mot="N°";
			$num=utf8_decode($mot);
			$date=gmdate('d/m/Y');


			
	$req=" SELECT * FROM fiche WHERE num_fiche='".$_SESSION['num_fiche']."' ";
			 
	$reta=$con->prepare($req); 
    $reta->execute();
	$nbre_serv=$reta->rowcount();


	$req0=$con->prepare(" SELECT * FROM fiche LEFT JOIN utilisateur ON utilisateur.secur=fiche.secur_approuve WHERE num_fiche='".$_SESSION['num_fiche']."' ");
	$req0->execute();
	$info_fiche0=$req0->fetch();	

	if($info_fiche0['photo_beneficiaire']!=''){ $photo=$info_fiche0['photo_beneficiaire']; }else{ $photo='default_picture.jpg'; }

			
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,3.3,utf8_decode('Ref: '.$_SESSION['num_fiche']),0,1,'L');
    $pdf->Ln(5);
    
    $pdf->Image("../../../../img_demande/".$photo, 12, 48, 25, 'C');
    
    //create a QR Code and save it as a png image file named test.png
    QRcode::png("https://fidest.ci/src/recup_dem.php?num_demande=".$_SESSION['num_fiche']." ","qr_code_".$_SESSION['num_fiche'].".png");
    
    //this is the second method
    //$pdf->Image("qr_code_".$_SESSION['num_fiche'].".png", 40, 10, 20, 20, "png");
    $pdf->Image("qr_code_".$_SESSION['num_fiche'].".png", 170, 52,  30, 'C');
    /*
    //Old QR_Code
    $qr_code='qr_code.jpg';
    $pdf->Image("../../../../img_demande/".$qr_code, 170, 42,  30, 'C');
    $pdf->Ln(25);
    */

    $date_oj=gmdate('d/m/Y');
    			
    $pdf->SetFont('Arial','',10);
    
    $pdf->Cell(0,4,'
    			                                                                                                                                                                 Date :'.$date_oj,0,1,'L'); 	
    $pdf->Ln(6);

    $pay=utf8_decode("Côte d'Ivoire");
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,3.3,utf8_decode('FICHE D\'EXPRESSION DE BESOIN'),0,1,'C');
    $pdf->Ln(4);
    //$pdf->SetFont('Arial','I',13);

    $pdf->SetFont('Arial','B',20);
  
  /*  
            if($info_fiche0['approuve']==1)
			{
	$pdf->SetTextColor(0, 255, 50);
	$pdf->Cell(0,3.3,utf8_decode('APPROUVE PAR M. '.strtoupper($info_fiche0['nom_utilisateur'])),0,1,'C');
	$montant_aff=$info_fiche0['montant_fiche'];
			}
		
*/

      
      $fi=$con->prepare('SELECT * FROM fiche WHERE num_fiche=:A');
      $fi->execute(array('A'=>$_SESSION['num_fiche']));
      $ifi=$fi->fetch();
      $montant_fiche=$ifi['montant_fiche'];
      
      $montant_den=0;
      
      $den=$con->prepare('SELECT * FROM decaissement WHERE num_fiche_decaissement=:A');
      $den->execute(array('A'=>$_SESSION['num_fiche']));
      while($iden=$den->fetch())
      {
      $montant_den=$iden['montant']+$montant_den;
      }
      
      $montant_dispo=$montant_fiche-$montant_den;
      
      $dec_pa=0;
      	if($montant_den>0 && $montant_dispo>0){
	$pdf->SetTextColor(0, 255, 50);
	$pdf->Cell(0,3.3,utf8_decode('FICHE DECAISSEE PARTIELEMENT'),0,1,'C');
//	$montant_aff=$montant_den;
$dec_pa=1;
		}
		
		 if($montant_den==$montant_fiche){
	$pdf->SetTextColor(0, 255, 50);
	$pdf->Cell(0,3.3,utf8_decode('FICHE DECAISSEE TOTALEMENT'),0,1,'C');
//	$montant_aff=$montant_den;
		}
		
		if($montant_dispo==$montant_fiche && $info_fiche0['etat_fiche']==1){
	$pdf->SetTextColor(0, 255, 50);
	$pdf->Cell(0,3.3,utf8_decode('FICHE VALIDEE EN ATTENTE DE DECAISSEMENT'),0,1,'C');
//	$montant_aff=$montant_fiche;
		}
		
		if($info_fiche0['etat_fiche']==2){
	$pdf->SetTextColor(255, 0, 50);
	$pdf->Cell(0,3.3,utf8_decode('DEMANDE REFUSEE'),0,1,'C');
//	$montant_aff=$montant_fiche;
		}
		
		/*
		if($info_fiche0['etat_fiche']==0){
    $pdf->SetTextColor(255, 128, 0);
    $pdf->Cell(0,3.3,utf8_decode('EN ATTENTE DE VALIDATION'),0,1,'C');
  //  $montant_aff=$montant_fiche;
    	}
		*/
		

			

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial','B',7);
    			
    $pdf->Cell(20);
    $pdf->Ln(17);
    
    $req1=$con->prepare(" SELECT * FROM fiche LEFT JOIN affectation ON affectation.id_affectation=fiche.affectation_id LEFT JOIN chantier On chantier.id_chantier=fiche.chantier_id WHERE num_fiche='".$_SESSION['num_fiche']."' ");
    $req1->execute();
    $info_fiche=$req1->fetch();	
    
    if($info_fiche['serv_bureau_banamur_id']!=0){
            $ser_ban=$con->prepare(" SELECT * FROM serv_bureau_banamur WHERE id_serv_bureau_banamur=:A ");
            $ser_ban->execute(array('A'=>$info_fiche['serv_bureau_banamur_id']));
            $iser_ban=$ser_ban->fetch();	
            
            $categorie_bureau=$iser_ban['lib_serv_bureau_banamur'];
    }
    
    if($info_fiche['serv_bureau_fidest_id']!=0){
            $ser_fid=$con->prepare(" SELECT * FROM serv_bureau_fidest WHERE id_serv_bureau_fidest=:A ");
            $ser_fid->execute(array('A'=>$info_fiche['serv_bureau_fidest_id']));
            $iser_fid=$ser_fid->fetch();	
            
            $categorie_bureau=$iser_fid['lib_serv_bureau_fidest'];
    }
    
    if($info_fiche['serv_rh_id']!=0){
            $ser_fid=$con->prepare(" SELECT * FROM serv_rh WHERE id_serv_rh=:A ");
            $ser_fid->execute(array('A'=>$info_fiche['serv_rh_id']));
            $iser_fid=$ser_fid->fetch();	
            
            $categorie_rh=$iser_fid['lib_serv_rh'];
    }
    
    if($info_fiche['serv_log_id']!=0){
            $ser_fid=$con->prepare(" SELECT * FROM serv_log WHERE id_serv_log=:A ");
            $ser_fid->execute(array('A'=>$info_fiche['serv_log_id']));
            $iser_fid=$ser_fid->fetch();	
            
            $categorie_log=$iser_fid['lib_serv_log'];
    }
    
        $pdf->SetFont('Arial','U',10);
    $pdf->Cell(0,3.7,utf8_decode('AUTH-FEB : '.$info_fiche['code_autorisation_feb']),0,1,'L');
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,3.7,utf8_decode(''.$info_fiche['beficiaire_fiche'].''),0,1,'L');
    $pdf->Ln(8);
    
    
    $pdf->SetFont('Arial','U',10);
    $pdf->Cell(0,3.7,utf8_decode('NOM ET PRENOM(S) DU BENEFICIAIRE'),0,1,'L');
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,3.7,utf8_decode(''.$info_fiche['beficiaire_fiche'].''),0,1,'L');
    $pdf->Ln(8);
    
    $pdf->SetFont('Arial','U',10);
    $pdf->Cell(0,3.7,utf8_decode('LIBELLE DE L\'AFFECTATION'),0,1,'L');
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,3.7,utf8_decode(' '.$info_fiche['lib_affectation'].' '.$info_fiche['lib_chantier'].' '),0,1,'L');
    $pdf->Ln(8);
    
    if($info_fiche['serv_bureau_banamur_id']!=0 || $info_fiche['serv_bureau_fidest_id']!=0)
    {
    $pdf->SetFont('Arial','U',10);
    $pdf->Cell(0,3.7,utf8_decode('CATEGORIE'),0,1,'L');
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,3.7,utf8_decode(' '.$categorie_bureau.' '),0,1,'L');
    $pdf->Ln(8);
    }
    
    if($info_fiche['serv_rh_id']!=0)
    {
    $pdf->SetFont('Arial','U',10);
    $pdf->Cell(0,3.7,utf8_decode('CATEGORIE'),0,1,'L');
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,3.7,utf8_decode(' '.$categorie_rh.' '),0,1,'L');
    $pdf->Ln(8);
    }
    
    if($info_fiche['serv_log_id']!=0)
    {
    $pdf->SetFont('Arial','U',10);
    $pdf->Cell(0,3.7,utf8_decode('CATEGORIE'),0,1,'L');
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,3.7,utf8_decode(' '.$categorie_log.' '),0,1,'L');
    $pdf->Ln(8);
    }
    
    $pdf->SetFont('Arial','U',10);
    $pdf->Cell(0,3.7,utf8_decode('DESIGNATION'),0,1,'L');
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,3.7,utf8_decode(''.$info_fiche['designation_fiche'].' '),0,1,'L');
    $pdf->Ln(8);
    $pdf->SetFont('Arial','U',10);
    $pdf->Cell(0,3.7,utf8_decode('DESCRIPTION'),0,1,'L');
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,3.7,utf8_decode(''.$info_fiche['precision_fiche'].' '),0,1,'L');
   
    $pdf->Ln(8);
    $pdf->SetFont('Arial','U',10);
    $pdf->Cell(0,3.7,utf8_decode('RECAP DECAISSEMENT'),0,1,'L');
    $pdf->Ln(2);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial','B',14);
      //Calcul
      $fi=$con->prepare('SELECT * FROM fiche WHERE num_fiche=:A');
      $fi->execute(array('A'=>$_SESSION['num_fiche']));
      $ifi=$fi->fetch();
      $montant_fiche=$ifi['montant_fiche'];
      
      $montant_den=0;
      
      $den=$con->prepare('SELECT * FROM decaissement WHERE num_fiche_decaissement=:A');
      $den->execute(array('A'=>$_SESSION['num_fiche']));
      while($iden=$den->fetch())
      {
      $montant_den=$iden['montant']+$montant_den;
      }
      
      $montant_dispo=$montant_fiche-$montant_den;
      //Calcul 
    $pdf->Cell(0,3.7,utf8_decode(' Demandé : '.number_format($montant_fiche,0,',',' ').' FCFA '),0,1,'L');
    $pdf->Ln(8);
     if($dec_pa==1){
   // $pdf->Ln(8);
    $pdf->SetFont('Arial','U',10);
    $pdf->Cell(0,3.7,utf8_decode('Décaissement prochain'),0,1,'L');
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,3.7,utf8_decode(''.$info_fiche['date_decaissement'].' '),0,1,'L');
    }
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial','U',10);
    $pdf->Cell(0,3.7,utf8_decode('NUMERO DE TELEPHONE DU BENEFICIAIRE'),0,1,'L');
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,3.7,utf8_decode(' '.$info_fiche['tel_beneficiaire_fiche'].' '),0,1,'L');
    $pdf->Ln(8);
    $pdf->SetFont('Arial','U',10);
    $pdf->Cell(0,3.7,utf8_decode('MODE DE PAIEMENT'),0,1,'L');
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,3.7,utf8_decode(''.$info_fiche['num_piece'].' '),0,1,'L');
    
    /*
    $pdf->SetFont('Arial','',10);
    $text  = "Let's show... \n\n";
    $text .= " [This is a cell][and another cell]\n\n";
    $text .= "<This is a bold sentence> and another non bold sentence.";
    $pdf->WriteText($text);
    */
    
    $pdf->SetTextColor(0, 0, 0);
    
    $pdf->Ln(8);
    
    $pdf->Ln(8);
    			
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,4,utf8_decode('SIGNATURE BENEFICIAIRE                      APPROBATION DU DIRECTEUR                    APPROBATION DU DG'),0,1,'R'); 
    $pdf->Ln(4);
    
    if($info_fiche0['etat_fiche']!=0){
    	//$sign_y=13.5*floatval($nbre_serv);
    	$pdf->Image("../../../img/signature_small.jpg", 150, 235,  50);
    }
    
    
    //Cachet payé
    if($info_fiche0['signature_beneficiaire']!='' && $montant_dispo==0 && ($montant_fiche==$montant_den)){
    	//$sign_y=13.5*floatval($nbre_serv);
    	$pdf->Image("../../../images/cachet_paye.jpg", 120, 170,  75);
    }
    
    
    if($info_fiche0['approuve']==1){
    	//$sign_y=13.5*floatval($nbre_serv);
    	$pdf->Image("../../../img_sign/".$info_fiche0['signature_util']."", 110, 235,  50);
    }
    
    
    	if($info_fiche0['cni_beneficiaire']!=''){ $img_cni=$info_fiche0['cni_beneficiaire']; }else{ $img_cni='cni_benef.jpg'; }
    	//$sign_y=13.5*floatval($nbre_serv);
    	$pdf->Image("../../../img/".$img_cni, 38, 48, 15);
    	
    		if($info_fiche0['signature_beneficiaire']!=''){ $img_signature_beneficiaire=$info_fiche0['signature_beneficiaire']; }else{ $img_signature_beneficiaire='signature.jpg'; }
    	//$sign_y=13.5*floatval($nbre_serv);
    	$pdf->Image("../../signature/".$img_signature_beneficiaire, 25, 238, 30);
    
    
    $pdf->SetFont('Arial','BI',10);
    $pdf->Cell(0,4,utf8_decode('                              M. '.strtoupper($info_fiche0['nom_utilisateur']).'                               Paul Alex BRAUD'),0,1,'R'); 
    $pdf->Ln(4);
    
    
    
    
    //Infos validateurs
    $va1=$con->prepare('SELECT * from fiche LEFT JOIN utilisateur ON fiche.secur_valid=utilisateur.secur WHERE num_fiche="'.$_SESSION['num_fiche'].'" ');
    $va1->execute();
    $iva1=$va1->fetch();
    if($iva1['secur_valid']!='' && $iva1['secur_refus']=='')
    {
    	$validateur_1=$iva1['nom_utilisateur'];
    	$note_1='Validée par';
    }
    if($iva1['secur_valid']=='' && $iva1['secur_refus']=='')
    {
    	$validateur_1=$iva1['nom_utilisateur'];
    	$note_1='En attente de décision';
    }
    
    //Infos validateurs
    $va1=$con->prepare('SELECT * from fiche LEFT JOIN utilisateur ON fiche.secur_refus=utilisateur.secur WHERE num_fiche="'.$_SESSION['num_fiche'].'" ');
    $va1->execute();
    $iva1=$va1->fetch();
    if($iva1['secur_valid']=='' && $iva1['secur_refus']!='')
    {
    	$validateur_1=$iva1['nom_utilisateur'];
    	$note_1='Réfusée par';
    }
    
    			
    $pdf->SetFont('Arial','I',10);
    $pdf->Cell(0,4,utf8_decode('                                                                                                                                          ('.$note_1.' '.$validateur_1.') '),0,1,'R'); 
    /*
    $pdf->Ln(20);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,4,utf8_decode('Approbation du DG (nom, date et visa)'),0,1,'R'); 
    */
    
    $pdf->Ln(149);
    $pdf->Line(10, 272, 200, 272);
    			
    //Sauvegarde du fichier PDF généré
    $pdf->Output($pdffilename);
    			
    echo "<META HTTP-EQUIV='Refresh' CONTENT='2;URL=$pdffilename'>";

?>