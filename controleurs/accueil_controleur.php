<!-- ATAMNA Miryam p2100162 / FERREIRA Rémi p2107991 -->

<?php 
	$message = "";

	//on récupère les statistiques à afficher
	$resultats = get_statistiques();

	//on les tri pour pouvoir les afficher selon la requête
	$stats = $resultats['statistiques'];
	$ecoles_par_departement = $resultats['ecoles_par_departement'];
	$meilleures_ecoles = $resultats['meilleures_ecoles'];
	$comite_reg = $resultats['comite_reg'];

?>