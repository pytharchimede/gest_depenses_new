<?php

session_start();
include('../../../connex.php');

$id = $_GET["ref"];

if($id!='')
{
$red=$con->prepare("SELECT * FROM designation WHERE id_designation=:A"); 
$red->execute(array('A' =>$id));
$uti=$red->fetch();

$_SESSION['id_designation_mod']=$uti['id_designation'];
$_SESSION['lib_designation_mod']=$uti["lib_designation"];
$_SESSION['operation_id_designation_mod']=$uti["operation_id_designation"];
$_SESSION['qte_designation_mod']=$uti["qte_designation"];
$_SESSION['prix_designation_mod']=$uti["prix_designation"];
$_SESSION['fourniture_debourse_mod']=$uti['fourniture_debourse'];
$_SESSION['mmain_doeuvre_debourse_mod']=$uti['main_doeuvre_debourse'];
$_SESSION['montant_debourse_mod']=$uti['montant_debourse'];
?>
		
                                <form action="#" name="form_designation_mod" id="form_designation_mod">
									<div class="modal-body">                
														
                                    <div class="row">
                                        <div class="col-md-4 col-xs-12">
                                            <label>operation concerné <span class="semi_aste">*</span></label>
                                            <select class="form-control selectpicker" data-placeholder="Choisir" id="operaton_id_designation_mod" title="Choisir..." style="width: 100%;" data-live-search="true" data-width="100%">
                                                <option value="">---Choisir---</option>
                                                        <?php
                                            $red=$con->prepare("SELECT * FROM operation ORDER BY lib_operation ASC");
                                            $red->execute();
                                            while($ro=$red->fetch())
                                            {
                                            ?>
                                            <option value="<?php echo''.$ro['id_operation'].''; ?>" <?php if($ro['id_operation']==$uti["operation_id_designation"]){ echo ' selected '; }?>><?php echo''.stripslashes($ro['lib_operation']).'' ; ?></option>
                                                    <?php
                                            }
                                                        ?>
                                            </select>
                                        </div>
                                        <div class="col-md-8 col-xs-12">
                                            <label>Libellé designation <span class="semi_aste">*</span></label>
                                            <input type="text" class="form-control" required id="lib_designation_mod" name="lib_designation_mod" value="<?php echo stripslashes($uti["lib_designation"]); ?>"  />
                                        </div>
		                            </div>	
                                    <div class="row">
                                        <div class="col-md-4 col-xs-12">
                                            <label>Quantité <span class="semi_aste">*</span></label>
                                            <input type="text" class="form-control" required id="qte_designation_mod" name="qte_designation_mod" value="<?php echo $uti["qte_designation"]; ?>"  />
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <label>Prix Unitaire <span class="semi_aste">*</span></label>
                                            <input type="text" class="form-control" required id="prix_designation_mod" name="prix_designation_mod" value="<?php echo $uti["prix_designation"]; ?>" />
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <label>Prix Total <span class="semi_aste">*</span></label>
                                            <input readonly type="text" class="form-control" required id="total_designation_mod" name="total_designation_mod" value="<?php echo $uti["prix_designation"]*$uti["qte_designation"]; ?>"  />
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-4 col-xs-12">
                                            <label>Fourniture déboursé <span class="semi_aste">*</span></label>
                                            <input type="number" class="form-control" required id="fourniture_debourse_mod" name="fourniture_debourse_mod" value="<?php echo $uti["fourniture_debourse"]; ?>"  />
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <label>Main d'oeuvre déboursé <span class="semi_aste">*</span></label>
                                            <input type="number" class="form-control" required id="main_doeuvre_debourse_mod" name="main_doeuvre_debourse_mod" value="<?php echo $uti["main_doeuvre_debourse"]; ?>" />
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <label>Montant déboursé <span class="semi_aste">*</span></label>
                                            <input readonly type="text" class="form-control" required id="montant_debourse_mod" name="montant_debourse_mod" value="<?php echo $uti["fourniture_debourse"]+$uti["main_doeuvre_debourse"]; ?>" />
                                        </div>
                                        </div>

									</div>   
                                    
                                    <div class="modal-footer ajout-footer_file"> 
                                        <button type="submit" id="submit_mod" class="btn button_enregistrer"><i class="fa  fa-floppy"></i> Enregistrer</button>
                                        <button type="button" class="btn button_annuler" data-dismiss="modal"><i class="fa fa-times"></i> Annuler</button>
                                    &nbsp;&nbsp;
                                    </div>
										
								</form>	

<?php
}
unset($con);
?>

<script>   
$("#prix_designation_mod").on('keyup', function(){
	var tot_des_mod = $("#qte_designation_mod").val()*$("#prix_designation_mod").val();
	$("#total_designation_mod").val(tot_des_mod);
});

$("#qte_designation_mod").on('keyup', function(){
	var tot_des_mod = $("#qte_designation_mod").val()*$("#prix_designation_mod").val();
	var tot_debour_mod = $("#qte_designation_mod").val()*$("#fourniture_debourse_mod").val()+parseFloat($("#main_doeuvre_debourse_mod").val());
	$("#total_designation_mod").val(tot_des_mod);
	$("#montant_debourse_mod").val(tot_debour_mod);
});
$("#fourniture_debourse_mod").on('keyup', function(){
	var tot_des_mod = $("#qte_designation_mod").val()*$("#prix_designation_mod").val();
	var tot_debour_mod = $("#qte_designation_mod").val()*$("#fourniture_debourse_mod").val()+parseFloat($("#main_doeuvre_debourse_mod").val());
	$("#total_designation_mod").val(tot_des_mod);
	$("#montant_debourse_mod").val(tot_debour_mod);
});
$("#main_doeuvre_debourse_mod").on('keyup', function(){
	var tot_des_mod = $("#qte_designation_mod").val()*$("#prix_designation_mod").val();
	var tot_debour_mod = $("#qte_designation_mod").val()*$("#fourniture_debourse_mod").val()+parseFloat($("#main_doeuvre_debourse_mod").val());
	$("#total_designation_mod").val(tot_des_mod);
	$("#montant_debourse_mod").val(tot_debour_mod);
});
</script>   