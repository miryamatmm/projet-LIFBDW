<!-- ATAMNA Miryam p2100162 / FERREIRA Rémi p2107991 -->

<?php 

/*
Structure de données permettant de manipuler une base de données :
- Gestion de la connexion
----> Connexion et déconnexion à la base
- Accès au dictionnaire
----> Liste des tables et statistiques
- Informations (structure et contenu) d'une table
----> Schéma et instances d'une table
- Traitement de requêtes
----> Schéma et instances résultant d'une requête de sélection
*/



////////////////////////////////////////////////////////////////////////
///////    Gestion de la connxeion   ///////////////////////////////////
////////////////////////////////////////////////////////////////////////

/**
 * Initialise la connexion à la base de données courante (spécifiée selon constante 
	globale SERVEUR, UTILISATEUR, MOTDEPASSE, BDD)			
 */
function open_connection_DB() {
	global $connexion;

	$connexion = mysqli_connect(SERVEUR, UTILISATEUR, MOTDEPASSE, BDD);
	if (mysqli_connect_errno()) {
	    printf("Échec de la connexion : %s\n", mysqli_connect_error());
	    exit();
	}
}

/**
 *  	Ferme la connexion courante
 * */
function close_connection_DB() {
	global $connexion;

	mysqli_close($connexion);
}

function get_statistiques() {
	global $connexion;

	$requete1 = "SELECT 
	COUNT(DISTINCT Fédération.nomFede) as nbFederations,
    COUNT(DISTINCT ComitéRégional.idComité) as nbComitesRegionaux,
    COUNT(DISTINCT ComitéDepartemental.idComité) as nbComitesDepartementaux
	FROM 
    	Fédération 
    JOIN Comité ComitéRégional ON Fédération.nomFede = ComitéRégional.nomFede 
        AND ComitéRégional.niveau = 'reg' 
    JOIN Comité ComitéDepartemental ON Fédération.nomFede = ComitéDepartemental.nomFede
        AND ComitéDepartemental.niveau = 'dept'
";
	$res1 = mysqli_query($connexion,$requete1);
	$statistiques = mysqli_fetch_assoc($res1);

	$requete2 = "SELECT 
	CASE 
	  WHEN SUBSTRING(codePostal, 1, 2) != '97' THEN SUBSTRING(codePostal, 1, 2) 
	  ELSE SUBSTRING(codePostal, 1, 3) 
	END AS code_dept,
	COUNT(DISTINCT idEcole) AS nombre_ecoles
  	FROM 
		Ecole
  	GROUP BY 
		code_dept
  	ORDER BY 
		code_dept
";

	$res2 = mysqli_query($connexion,$requete2);

	$ecoles_par_departement = array();
    while ($row = mysqli_fetch_assoc($res2)) {
        $ecoles_par_departement[$row['code_dept']] = $row['nombre_ecoles'];
    }

    $statistiques['ecoles_par_departement'] = $ecoles_par_departement;

	$requete3 = "SELECT Ecole.nom, Ecole.nomVille, COUNT(DISTINCT Adhérent.numLicence) as nbAdherents
	FROM Ecole
	JOIN Adhérent ON Ecole.idEcole = Adhérent.idEcole
	WHERE Adhérent.annéeAdhésion = 2022
	GROUP BY Ecole.idEcole
	ORDER BY nbAdherents DESC
	LIMIT 5";

	$res3 = mysqli_query($connexion,$requete3);

	$meilleures_ecoles = array();

	while ($row = mysqli_fetch_assoc($res3)) {
        $meilleures_ecoles[] = array(
            'nom' => $row['nom'],
            'ville' => $row['nomVille'],
            'nbAdherents' => $row['nbAdherents']
        );
    }

	$requete4 = "SELECT *
	FROM Comité C
	WHERE C.niveau = 'reg' AND C.nomFede = 'Fédération Française de Danse'
	ORDER BY nom DESC
	";

	$res4 = mysqli_query($connexion,$requete4);

	$comite_reg = array();

	while ($row = mysqli_fetch_assoc($res4)) {
        $comite_reg[] = array(
            'idComité' => $row['idComité'],
            'nom' => $row['nom'],
            'niveau' => $row['niveau'],
			'numVoie' => $row['numVoie'],
			'rue' => $row['rue'],
			'cp' => $row['codePostal'],
			'ville' => $row['nomVille'],
			'fede' => $row['nomFede'],
			'code' => $row['code']
        );
	}

	// return $statistiques;
	return array(
        'statistiques' => $statistiques,
        'ecoles_par_departement' => $ecoles_par_departement,
		'meilleures_ecoles' => $meilleures_ecoles,
		'comite_reg' => $comite_reg
    );

}

function get_employe(){
	global $connexion;

	$requete =
	"SELECT nom, prénom
	FROM Employé
	WHERE TRUE
	ORDER BY nom,prénom";


	$res = mysqli_query($connexion,$requete);


	$employes = array();
	while ($row = mysqli_fetch_assoc($res)) {
		$employes[$row['nom']] = $row['prénom'];
    }
	return $employes;
}

function get_ecole_by_nom($nom,$prenom){
	global $connexion;

    $requete = "SELECT E.idEcole 
                FROM Ecole E 
                JOIN Employé EP ON E.fondateurs=CONCAT(EP.prénom, ' ', EP.nom)
                WHERE EP.nom = ? AND EP.prénom = ?";

    $stmt = mysqli_prepare($connexion, $requete);
    mysqli_stmt_bind_param($stmt, "ss", $nom, $prenom);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    $ecoles = mysqli_fetch_assoc($res);
    return $ecoles['idEcole'];
}

function get_donnee_ecole($id){
	global $connexion;

	$requete = "SELECT * FROM Ecole WHERE idEcole = ?";
	$stmt = mysqli_prepare($connexion, $requete);
    mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
	$donnees = mysqli_fetch_assoc($res);
	return $donnees;
}

function modifierEcole($id, $nom, $numVoie, $rue, $codePostal, $nomVille){
    global $connexion;

    // Vérifier si l'adresse existe déjà dans la base de données
    $stmt = mysqli_prepare($connexion, "SELECT * FROM Adresse WHERE numVoie = ? AND rue = ? AND codePostal = ? AND nomVille = ?");
    mysqli_stmt_bind_param($stmt, "isis", $numVoie, $rue, $codePostal, $nomVille);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($res->num_rows > 0) {
		// L'adresse existe déjà 
        $adresse = mysqli_fetch_assoc($res);
		$adresseRecup = array('numVoie' => $numVoie, 'rue' => $rue, 'codePostal' => $codePostal, 'nomVille' => $nomVille);
    } else {
        // L'adresse n'existe pas encore, l'ajouter à la base de données
        $stmt = mysqli_prepare($connexion, "INSERT INTO Adresse(numVoie, rue, codePostal, nomVille) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "isis", $numVoie, $rue, $codePostal, $nomVille);
        mysqli_stmt_execute($stmt);

        // Récupérer les clés de l'adresse nouvellement insérée
        $adresseRecup = array('numVoie' => $numVoie, 'rue' => $rue, 'codePostal' => $codePostal, 'nomVille' => $nomVille);
    }

    // Mettre à jour l'école avec l'ID de l'adresse
    $stmt = mysqli_prepare($connexion, "UPDATE Ecole SET nom = ?, numVoie = ?, rue = ?, codePostal = ?, nomVille = ?  WHERE idEcole = ?");
    mysqli_stmt_bind_param($stmt, "sisisi", $nom, $adresseRecup['numVoie'], $adresseRecup['rue'], $adresseRecup['codePostal'], $adresseRecup['nomVille'], $id);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_affected_rows($stmt) == 1;
    mysqli_stmt_close($stmt);

    return $res;
}


function get_tdb_ecole($id){
	global $connexion;
	
	// pour récupérer les données de base 

	$requete1 = "SELECT nom, CONCAT(numVoie, ' ', rue, ', ', codePostal, ' ', nomVille) AS adresse 
    FROM Ecole 
    WHERE idEcole =".$id;

	$res1 = mysqli_query($connexion,$requete1);

	$infos = mysqli_fetch_assoc($res1);

	//return $infos;

	$requete2 = "SELECT fondateurs
	FROM Ecole
	WHERE idEcole =".$id;

	$res2 = mysqli_query($connexion,$requete2);
	
	$liste_employes = mysqli_fetch_assoc($res2);

	$requete3 = "SELECT COUNT(DISTINCT Adhérent.numLicence) as nbAdherents
	FROM Ecole
	JOIN Adhérent ON Ecole.idEcole = Adhérent.idEcole
	WHERE Adhérent.annéeAdhésion = 2022 AND Ecole.idEcole =".$id;

	$res3 = mysqli_query($connexion,$requete3);

	$nbAdherents = mysqli_fetch_assoc($res3);

	$requete4 = "SELECT C.idCours, C.libellé, C.categorieAge, CONCAT(Em.nom,' ', Em.prénom) as prof
	FROM Cours C
	JOIN Ecole E ON E.idEcole = C.idEcole
    JOIN Employé Em ON C.idEmp = Em.idEmp
	WHERE E.idEcole =".$id;

	$res4 = mysqli_query($connexion,$requete4);

	$cours = array();
	while ($row = mysqli_fetch_assoc($res4)) {
        $cours[] = array(
            'idCours' => $row['idCours'],
            'libellé' => $row['libellé'],
            'categorieAge' => $row['categorieAge'],
			'prof' => $row['prof']
        );
    }

	return array(
        'infos' => $infos,
        'listeEmp' => $liste_employes,
		'nbAdherents' => $nbAdherents,
		'cours' => $cours
    );

}

function get_infos_cours($idCours){
	global $connexion;

	$requete = "SELECT E.nom, CONCAT(E.numVoie, ' ', E.rue, ', ', E.codePostal, ' ', E.nomVille) AS adresse , CONCAT(Em.prénom, ' ', Em.nom) as prof, C.libellé, C.categorieAge, C.code
	FROM Cours C JOIN Ecole E ON C.idEcole = E.idEcole
    JOIN Employé Em ON Em.idEmp = C.idEmp
	WHERE idCours =".$idCours;

	$res = mysqli_query($connexion,$requete);

	$infos = mysqli_fetch_assoc($res);
	
	return $infos;
}

function modifierCours($idCours,$libelle, $categorieAge){
	global $connexion;

	$requete = "UPDATE Cours SET libellé = ?, categorieAge = ? WHERE idCours = ?";

	$stmt = mysqli_prepare($connexion, $requete);

	mysqli_stmt_bind_param($stmt, 'ssi', $libelle, $categorieAge, $idCours);

    // Exécuter la requête
    $res = mysqli_stmt_execute($stmt);

	if ($res) {
        return true;
    } else {
        return false;
    }
}

function get_employe_by_nom($nom,$prenom){
	global $connexion;

    $requete = "SELECT E.idEmp 
                FROM Employé EP
                WHERE EP.nom = ? AND EP.prénom = ?";

    $stmt = mysqli_prepare($connexion, $requete);
    mysqli_stmt_bind_param($stmt, "ss", $nom, $prenom);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    $emp = mysqli_fetch_assoc($res);
    return $emp['idEmp'];
}

function ajouterCours($libelle, $categorieAge, $id) {
    global $connexion;

    if(empty($libelle)) {
        return false;
    }

    $requete = "SELECT COUNT(*) as nb_cours FROM Cours WHERE idEcole = ".$id;

    $res = mysqli_query($connexion, $requete);

    $row = mysqli_fetch_assoc($res);

    $code = $row['nb_cours'] + 1;

    $requete = "INSERT INTO Cours (libellé, categorieAge, code, idEcole, idEmp) VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($connexion, $requete);

    mysqli_stmt_bind_param($stmt, 'ssiii', $libelle, $categorieAge, $code, $id, $id);

    // Exécuter la requête
    $res = mysqli_stmt_execute($stmt);

    if ($res) {
        return true;
    } else {
        return false;
    }
}


function supprimerCours($idCours) {
    global $connexion;

    $requete = "DELETE FROM Cours WHERE idCours =".$idCours;

    $res = mysqli_query($connexion, $requete);

    // Exécuter la requête

    if ($res) {
        return true;
    } else {
        return false;
    }
}
function get_fede_by_nom($nom,$prenom){
	global $connexion;

    $requete = "SELECT DISTINCT F.nomFede FROM Fédération F 
				JOIN Ecole EC ON EC.nomFede=F.nomFede 
				JOIN Cours C ON C.idEcole=EC.idEcole 
				JOIN Employé E ON E.idEmp=C.idEmp
                WHERE E.nom = ? AND E.prénom = ?";

    $stmt = mysqli_prepare($connexion, $requete);
    mysqli_stmt_bind_param($stmt, "ss", $nom, $prenom);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    $fede = mysqli_fetch_assoc($res);
    return $fede['nomFede'];
}

function info_fede($fede){

	global $connexion;

	$requete = "SELECT * FROM Fédération WHERE nomFede = ?";
	$stmt = mysqli_prepare($connexion, $requete);
    mysqli_stmt_bind_param($stmt, "s", $fede);
	mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
	$donnees = mysqli_fetch_assoc($res);
	return $donnees;
}

function get_tdb_fede($fede){
	global $connexion;
	
	// Requete 1

	$requete1 = "SELECT nomFede, sigle ,CONCAT(numVoie, ' ', rue, ', ', codePostal, ' ', nomVille) AS adresse 
    FROM Fédération 
    WHERE nomFede ='{$fede}'";

	$res1 = mysqli_query($connexion,$requete1);

	$infoFede = mysqli_fetch_assoc($res1);

	// Requete 2

	$requete2 = "SELECT count(DISTINCT idComité) as nbComite FROM Comité WHERE nomFede='{$fede}'";

	$res2 = mysqli_query($connexion,$requete2);

	$nbComite = mysqli_fetch_assoc($res2);

	// Requete 3

	$requete3 = "SELECT count(*) as nbMembre FROM Employé WHERE TRUE";

	$res3 = mysqli_query($connexion,$requete3);

	$nbMembre = mysqli_fetch_assoc($res3);

	// Requete 4

	$requete4 = "SELECT libellé, code, niveau FROM Compétition WHERE nomFede='{$fede}'";

	$res4 = mysqli_query($connexion,$requete4);

	$competition = array();
	while ($row = mysqli_fetch_assoc($res4)) {
        $competition[] = array(
            'libellé' => $row['libellé'],
            'code' => $row['code'],
			'niveau' => $row['niveau']
        );
    }

	// Requete 5

	// A faire

	return array(
        'infoFede' => $infoFede,
        'nbComite' => $nbComite,
		'nbMembre' => $nbMembre,
		'competition' => $competition
    );
}

function info_compet($code){

	global $connexion;

	$requete = "SELECT * FROM Compétition WHERE code = ?";
	$stmt = mysqli_prepare($connexion, $requete);
    mysqli_stmt_bind_param($stmt, "s", $code);
	mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
	$donnees = mysqli_fetch_assoc($res);
	return $donnees;
}

function modifierCompet($code,$libellé,$niveau){
    global $connexion;

    $requete = "UPDATE Compétition SET libellé = '{$libellé}', niveau = '{$niveau}' WHERE code = '{$code}'";

	$res = mysqli_query($connexion,$requete);

	return $res;
}

function get_edition($code){
	global $connexion;

	$requete =
	"SELECT annee, villeOrganisatrice
	FROM Edition
	WHERE code= '{$code}'";


	$res = mysqli_query($connexion,$requete);


	$edition = array();
	while ($row = mysqli_fetch_assoc($res)) {
		$edition[$row['annee']] = $row['villeOrganisatrice'];
    }
	return $edition;
}

function add_compet($code, $libelle, $niveau, $fede){
    global $connexion;
    
    if(empty($code) || empty($libelle) || empty($niveau)){
        return false;
    }

	if(!is_string($code) || !is_string($libelle)){
		return false;
	}

    $requete = "INSERT INTO Compétition (code, libellé, niveau, nomFede) 
    VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($connexion, $requete);

    mysqli_stmt_bind_param($stmt, 'ssss', $code, $libelle, $niveau, $fede);

    $res = mysqli_stmt_execute($stmt);

    if ($res) {
        return true;
    } else {
        return false;
    }
}



function suppr_compet($code){
	global $connexion;

	$requete =
	"DELETE FROM Compétition WHERE code = '{$code}' ";

	$res = mysqli_query($connexion,$requete);

	if($res){
		return true;
	}else{
		return false;
	}

}

function info_edition($code,$annee){

	global $connexion;

    $requete = "SELECT code, annee, villeOrganisatrice FROM Edition WHERE code = ? AND annee = ?";

    $stmt = mysqli_prepare($connexion, $requete);
    mysqli_stmt_bind_param($stmt, "si", $code, $annee);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    $edition = mysqli_fetch_assoc($res);
    return $edition;
}

function modifierEdition($code,$annee,$ville){
    global $connexion;

    $requete = "UPDATE Edition SET villeOrganisatrice = '{$ville}' WHERE code = '{$code}' AND annee = '{$annee}'";

	$res = mysqli_query($connexion,$requete);

	return $res;
}

function add_edition($code, $annee, $ville){
	global $connexion;

	if(empty($annee) || empty($ville)){
		return false;
	}

	if(!is_numeric($annee)){
		return false;
	}

	if(!is_string($annee)){
		return false;
	}

	$requete = "INSERT INTO Edition (code, annee, villeOrganisatrice) 
				VALUES (?, ?, ?)";

	$stmt = mysqli_prepare($connexion, $requete);

	mysqli_stmt_bind_param($stmt, 'sis', $code, $annee, $ville);

	$res = mysqli_stmt_execute($stmt);

	if ($res) {
		return true;
	} else {
		return false;
	}
}



function suppr_edition($code,$annee){
	global $connexion;

	$requete =
	"DELETE FROM Edition WHERE code = '{$code}' AND annee = '{$annee}' ";

	$res = mysqli_query($connexion,$requete);

	return $res;

}

function get_comite_reg_fede($fede)
{
	global $connexion;
	
	$requete="SELECT nom, idComité FROM Comité WHERE nomFede='{$fede}' AND niveau='reg'";

	$res = mysqli_query($connexion,$requete);

	$comite = array();
	while ($row = mysqli_fetch_assoc($res)) {
		$comite[] = array('idComité'=>$row['idComité'],'nom'=>$row['nom']);
    }

	return $comite;
}

function get_comite_dept_fede($fede,$idComitéR)
{
	global $connexion;
	
	$requete="SELECT nom, idComité FROM Comité WHERE nomFede='{$fede}' AND niveau='dept' AND idComitéR={$idComitéR}
	AND niveau='dept'";

	$res = mysqli_query($connexion,$requete);

	$comite = array();
	while ($row = mysqli_fetch_assoc($res)) {
		$comite[] = array('idComité'=>$row['idComité'],'nom'=>$row['nom']);
    }

	return $comite;
}


function id_auto_fede ($fede){
	global $connexion;

	$requete =
	"SELECT max(idComité)+1 as num FROM Comité WHERE nomFede='{$fede}'";

	$res = mysqli_query($connexion,$requete);

	$num = mysqli_fetch_assoc($res);

	return $num;

}

function info_comite($id){

	global $connexion;

	$requete = "SELECT C.idComité, C.nom, C.niveau, C.nomFede, C.numVoie, C.rue, C.codePostal, C.nomVille,
	F.president  AS president, CONCAT(C.numVoie, ' ', C.rue, ', ', C.codePostal, ' ', C.nomVille) AS adresse
	FROM Comité C JOIN Fédération F ON C.nomFede=F.nomFede WHERE C.idComité = ?";
	$stmt = mysqli_prepare($connexion, $requete);
    mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
	$donnees = mysqli_fetch_assoc($res);
	return $donnees;
}

function modifierComite($id,$nom,$numVoie, $rue, $codePostal, $nomVille){
    global $connexion;

		// Vérifier si l'adresse existe déjà dans la base de données
		$stmt = mysqli_prepare($connexion, "SELECT * FROM Adresse WHERE numVoie = ? AND rue = ? AND codePostal = ? AND nomVille = ?");
		mysqli_stmt_bind_param($stmt, "isis", $numVoie, $rue, $codePostal, $nomVille);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
	
		if ($res->num_rows > 0) {
			// L'adresse existe déjà 
			$adresse = mysqli_fetch_assoc($res);
			$adresseRecup = array('numVoie' => $numVoie, 'rue' => $rue, 'codePostal' => $codePostal, 'nomVille' => $nomVille);
		} else {
			// L'adresse n'existe pas encore, l'ajouter à la base de données
			$stmt = mysqli_prepare($connexion, "INSERT INTO Adresse(numVoie, rue, codePostal, nomVille) VALUES (?, ?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "isis", $numVoie, $rue, $codePostal, $nomVille);
			mysqli_stmt_execute($stmt);
	
			// Récupérer les clés de l'adresse nouvellement insérée
			$adresseRecup = array('numVoie' => $numVoie, 'rue' => $rue, 'codePostal' => $codePostal, 'nomVille' => $nomVille);
		}

    $requete = "UPDATE Comité SET nom = '{$nom}', nomVille='{$adresseRecup['nomVille']}', numVoie={$adresseRecup['numVoie']}
	, codePostal='{$adresseRecup['codePostal']}', rue='{$adresseRecup['rue']}' WHERE idComité = {$id}";

	$res = mysqli_query($connexion,$requete);

	return $res;
}

function add_comite_regional($nom, $numVoie, $rue, $ville, $codePostal, $fede){
    global $connexion;

    if(empty($nom) || empty($numVoie) || empty($rue) || empty($ville) || empty($codePostal)){
        return false;
    }

    if(!is_string($nom) || !is_string($rue) || !is_string($ville)){
        return false;
    }

    if(!is_numeric($numVoie)){
        return false;
    }

    // Vérifier si l'adresse existe déjà dans la base de données
    $stmt = mysqli_prepare($connexion, "SELECT * FROM Adresse WHERE numVoie = ? AND rue = ? AND codePostal = ? AND nomVille = ?");
    mysqli_stmt_bind_param($stmt, "issi", $numVoie, $rue, $codePostal, $ville);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($res->num_rows > 0) {
        // L'adresse existe déjà 
        $adresse = mysqli_fetch_assoc($res);
        $adresseRecup = array('numVoie' => $adresse['numVoie'], 'rue' => $adresse['rue'], 'codePostal' => $adresse['codePostal'], 'nomVille' => $adresse['nomVille']);
    } else {
        // L'adresse n'existe pas encore, l'ajouter à la base de données
        $stmt = mysqli_prepare($connexion, "INSERT INTO Adresse(numVoie, rue, codePostal, nomVille) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "isis", $numVoie, $rue, $codePostal, $ville);
        mysqli_stmt_execute($stmt);

        // Récupérer les clés de l'adresse nouvellement insérée
        $adresseRecup = array('numVoie' => $numVoie, 'rue' => $rue, 'codePostal' => $codePostal, 'nomVille' => $ville);
    }

    $requete = "INSERT INTO Comité (nom, numVoie, rue, codePostal, nomVille, nomFede, niveau) 
                VALUES (?, ?, ?, ?, ?, ?, 'reg')";

    $stmt2 = mysqli_prepare($connexion, $requete);

    mysqli_stmt_bind_param($stmt2, 'sisiss',$nom, $adresseRecup['numVoie'], 
                            $adresseRecup['rue'], $adresseRecup['codePostal'], $adresseRecup['nomVille'], $fede);

    $res2 = mysqli_stmt_execute($stmt2);

    if ($res2) {
        return true;
    } else {
        return false;
    }
}

function add_comite_departemental($nom, $numVoie, $rue, $ville, $codePostal, $nomComiteR, $nomFede){
    global $connexion;

    if(empty($nom) || empty($numVoie) || empty($rue) || empty($ville) || empty($codePostal) || strlen($codePostal) < 5){
        return false;
    }

    if(!is_string($nom) || !is_string($rue) || !is_string($ville)){
        return false;
    }

    if(!is_numeric($numVoie)){
        return false;
    }

    // Vérifier si l'adresse existe déjà dans la base de données
    $stmt = mysqli_prepare($connexion, "SELECT * FROM Adresse WHERE numVoie = ? AND rue = ? AND codePostal = ? AND nomVille = ?");
    mysqli_stmt_bind_param($stmt, "issi", $numVoie, $rue, $codePostal, $ville);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($res->num_rows > 0) {
        // L'adresse existe déjà 
        $adresse = mysqli_fetch_assoc($res);
        $adresseRecup = array('numVoie' => $adresse['numVoie'], 'rue' => $adresse['rue'], 'codePostal' => $adresse['codePostal'], 'nomVille' => $adresse['nomVille']);
    } else {
        // L'adresse n'existe pas encore, l'ajouter à la base de données
        $stmt = mysqli_prepare($connexion, "INSERT INTO Adresse(numVoie, rue, codePostal, nomVille) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "isis", $numVoie, $rue, $codePostal, $ville);
        mysqli_stmt_execute($stmt);

        // Récupérer les clés de l'adresse nouvellement insérée
        $adresseRecup = array('numVoie' => $numVoie, 'rue' => $rue, 'codePostal' => $codePostal, 'nomVille' => $ville);
    }

    // Récupérer l'ID du comité régional
    $stmt2 = mysqli_prepare($connexion, "SELECT idComité FROM Comité WHERE nom = ? AND niveau = 'reg'");
    mysqli_stmt_bind_param($stmt2, "s", $nomComiteR);
    mysqli_stmt_execute($stmt2);
    $res2 = mysqli_stmt_get_result($stmt2);

	if ($res2->num_rows == 0) {
		// Le comité régional n'existe pas
		return false;
	}
	
	$comite = mysqli_fetch_assoc($res2);
	$idComiteR = $comite['idComité'];
	
	// Vérifier si le comité départemental existe déjà dans la base de données
	$stmt3 = mysqli_prepare($connexion, "SELECT * FROM Comité WHERE nom = ? AND niveau = 'dept'");
	mysqli_stmt_bind_param($stmt3, "s", $nom);
	mysqli_stmt_execute($stmt3);
	$res3 = mysqli_stmt_get_result($stmt3);
	
	if ($res3->num_rows > 0) {
		// Le comité départemental existe déjà 
		return false;
	}
	
	// Ajouter le comité départemental à la base de données
	$stmt4 = mysqli_prepare($connexion, "INSERT INTO Comité (nom, numVoie, rue, codePostal, nomVille, idComitéR, nomFede, code, niveau) 
	VALUES (?, ?, ?, ?, ?, ?, ?, LEFT(?, 2), 'dept')");
	mysqli_stmt_bind_param($stmt4, "sisssiss", $nom, $adresseRecup['numVoie'], $adresseRecup['rue'], $adresseRecup['codePostal'], $adresseRecup['nomVille'], $idComiteR, $nomFede, $adresseRecup['codePostal']);
	$res = mysqli_stmt_execute($stmt4);



    if ($res) {
        return true;
    } else {
        return false;
    }
}

function ajouterCouple($code,$annee,$numLicence1,$numLicence2,$rangF){
    global $connexion;

    $requete = "INSERT INTO participe_couple(numLicence1,numLicence2,code,annee,rangF) VALUES ({$numLicence1},{$numLicence2},'{$code}','{$annee}',{$rangF})";
	$res = mysqli_query($connexion,$requete);

	return $res;
}




?>

