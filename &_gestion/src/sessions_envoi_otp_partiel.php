<?php
session_start();

$_SESSION['num_fiche'] = $_POST['num_fiche'];
$_SESSION['montant_decaisser'] = $_POST['montant_decaisser'];
$_SESSION['date_prochain_decaissement'] = $_POST['date_prochain_decaissement'];
$_SESSION['montant_restant_final'] = $_POST['montant_restant_final'];
