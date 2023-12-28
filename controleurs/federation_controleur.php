<!-- ATAMNA Miryam p2100162 / FERREIRA Rémi p2107991 -->

<?php
$message = "";

if (isset($_GET['fede'])) {
    // p = accueil
    $fede = $_GET['fede'];
    $donnees = get_tdb_fede($fede);
    $infoFede = $donnees['infoFede'];
    $nbComite = $donnees['nbComite'];
    $nbMembre = $donnees['nbMembre'];
    $competition = $donnees['competition'];      
} else{
    //p = connexion
    $liste_employés = get_employe();
}

if(isset($_GET['p'])){
        $p = $_GET['p'];
        if($p == "competition"){
            if(isset($_GET['m'])){
                $m = $_GET['m'];
                if($m=='ajouter'){
                    //ajouter une compétition
                    if (isset($_GET['ajouterComp']) and 
                    isset($_GET['ajouterCode']) and
                    isset($_GET['ajouterLibellé']) and
                    isset($_GET['ajouterNiveau'])) {
                        $ajouterCode = $_GET['ajouterCode'];   
                        $ajouterLibellé = $_GET['ajouterLibellé'];
                        $ajouterNiveau = $_GET['ajouterNiveau'];
                        $res = add_compet ($ajouterCode,$ajouterLibellé,$ajouterNiveau,$fede);
                        if($res){
                            header("Location: {$_SERVER['PHP_SELF']}?page=federation&fede=$fede&p=competition");
                            exit;
                        }else{
                            $message = 'Veuillez renseignez correctement toutes les informations';
                        }
                    }
                }
            }
            //pas de m ici
            if (isset($_GET['codeSupp'])){
                $codeSupp = $_GET['codeSupp'];
                if (isset($_GET['SupprimerCompet'])) {
                    // Supprimer toutes les éditions associées à la compétition
                    $liste_edition = get_edition($codeSupp);
                    foreach($liste_edition as $annee => $villeOrganisatrice) {
                        suppr_edition($codeSupp,$annee);
                    }
                    
                    // Supprimer la compétition elle-même
                    $suppComp = suppr_compet($codeSupp);
                    if ($suppComp) {
                        header("Location: {$_SERVER['PHP_SELF']}?page=federation&fede=$fede&p=competition");
                        exit;
                    }
                }
            }                
           if(isset($_GET['code'])){
                $code = $_GET['code'];
                if(isset($_GET['m'])){
                    $m = $_GET['m'];
                    if($m=='infosCompet'){
                        $infosCompet = info_compet($code);
                        //bouton pour modifier une compet
                        if (isset($_GET['ModifierCompet'])){
                            header("Location: {$_SERVER['PHP_SELF']}?page=federation&fede=$fede&p=competition&m=modifier&code=$code");
                            exit;
                        }
                    }
                    if($m == 'modifier'){
                        //modifier une compétition
                        //recup infos de la compet
                        $infosCompet = info_compet($code);
                        if(isset($_GET['modifCompet'])){
                            $libellé = $_GET['libelle'];
                            $niveau = $_GET['niveau'];
                            $donneesM = modifierCompet($code,$libellé,$niveau);
                            if($donneesM){
                                header("Location: {$_SERVER['PHP_SELF']}?page=federation&fede=$fede&p=competition&m=infosCompet&code=$code");
                                exit;
                            }
                        }
                    }
                    if($m == 'edition'){
                        //infos sur les éditions
                        $liste_edition = get_edition($code);
                        //bouton supprimer pour les éditions
                        if(isset($_GET['SupprimerEdition'])){
                            $code = $_GET['code'];
                            $anneeSupp = $_GET['anneeSupp'];
                            $supp = suppr_edition($code,$anneeSupp);
                            if($supp){
                                header("Location: {$_SERVER['PHP_SELF']}?page=federation&fede=$fede&p=competition&m=edition&code=$code");
                                exit;
                            }
                        }
                        if(isset($_GET['e'])){
                            $e = $_GET['e'];
                            if($e == 'ajouter'){
                                if (isset($_GET['ajouterEdition']) and 
                                isset($_GET['ajouterAnnee']) and
                                isset($_GET['ajouterVille'])) {
                                    $ajouterAnnee = $_GET['ajouterAnnee'];
                                    $ajouterVille = $_GET['ajouterVille'];
                                    $res = add_edition ($code,$ajouterAnnee,$ajouterVille);
                                    if($res){
                                        header("Location: {$_SERVER['PHP_SELF']}?page=federation&fede=$fede&p=competition&m=edition&code=$code");
                                        exit;
                                    }else{
                                        $message = 'Veuillez renseignez correctement toutes les informations';
                                    }
                            }
                            }
                            if($e == 'infosE'){
                                $infoEdition = info_edition($code,$_GET['annee']);
                                if(isset($_GET['modifEdition'])){
                                    $res3 = modifierEdition($code,$_GET['annee'],$_GET['ville']);
                                    if($res3){
                                        header("Location: {$_SERVER['PHP_SELF']}?page=federation&fede=$fede&p=competition&m=edition&code=$code");
                                        exit;
                                    }else{
                                        $message = 'Veuillez renseignez correctement toutes les informations';
                                    }
                                }
                                if(isset($_GET['ajoutCouple'])){
                                    $aj=ajouterCouple($code,$_GET['annee'],$_GET['numLicence1'],$_GET['numLicence2'],$_GET['rangCouple']);
                                }
                            }
                            if($e == 'inscrireCouple'){
                                $infoEdition = info_edition($code,$_GET['annee']);
                            }
                        }
                    }
                }
        }
    }
        if($p == "comite"){
            if(isset($_GET['idComité'])){
                $idCr=$_GET['idComité'];
                if (isset($_GET['m']) and $_GET['m']=='ajoutComiteD'){
                    $numAjoutCom=id_auto_fede ($fede);
                }
                if(isset($_GET['m'])){
                    $m=$_GET['m'];
                    switch($m){
                        case 'infoComite':
                            if(isset($_GET['modifierComiteCR'])){
                                if(isset($_GET['idComitéDep'])){
                                    $modifierNomCR=$_GET['modifierNomCR'];
                                    $modifierNumVoieCR=$_GET['modifierNumVoieCR'];
                                    $modifierRueCR=$_GET['modifierRueCR'];
                                    $modifierVilleCR=$_GET['modifierVilleCR'];
                                    $modifierCodePosCR=$_GET['modifierCodePosCR'];
                                    $temp2=modifierComite($_GET['idComitéDep'],$modifierNomCR,$modifierNumVoieCR,$modifierRueCR,$modifierCodePosCR,$modifierVilleCR);
                                }
                                else{
                                    $modifierNomCR=$_GET['modifierNomCR'];
                                    $modifierNumVoieCR=$_GET['modifierNumVoieCR'];
                                    $modifierRueCR=$_GET['modifierRueCR'];
                                    $modifierVilleCR=$_GET['modifierVilleCR'];
                                    $modifierCodePosCR=$_GET['modifierCodePosCR'];
                                    $temp2=modifierComite($idCr,$modifierNomCR,$modifierNumVoieCR,$modifierRueCR,$modifierCodePosCR,$modifierVilleCR);
                                }
                            }
                            if(isset($_GET['idComitéDep'])){
                                $idCd=$_GET['idComitéDep'];
                                $infoComite = info_comite($idCd);
                            }
                            else{
                                $infoComite = info_comite($idCr);
                            }
                            $liste_comite_dept=get_comite_dept_fede($fede,$idCr);
                        break;
                        case 'modifComite':
                            if(isset($_GET['idComitéDep'])){
                                $idCd=$_GET['idComitéDep'];
                                $infoModifComite = info_comite($idCd);
                            }else{
                                $infoModifComite = info_comite($idCr);
                            }
                        break;
                    }
                }
                if (isset($_GET['ajouterComiteCD'])){
                    // pr recup le nom
                    echo 'rentre';
                    $infoComite = info_comite($idCr);
                    $nomAjoutCom=$_GET['ajouterNomC'];
                    $numVoieAjoutCom=$_GET['ajouterNumVoieC'];
                    $rueAjoutCom=$_GET['ajouterRueC'];
                    $villeAjoutCom=$_GET['ajouterVilleC'];
                    $codePosAjoutCom=$_GET['ajouterCodePosC'];
                    $nomCR = $infoComite['nom'];
                    $debug = $nomAjoutCom.$numVoieAjoutCom.$rueAjoutCom.$villeAjoutCom.$codePosAjoutCom.$fede.$idCr.$nomCR;
                    echo $debug;
                    $temp1=add_comite_departemental($nomAjoutCom,$numVoieAjoutCom,$rueAjoutCom,$villeAjoutCom,$codePosAjoutCom,$nomCR,$fede);
                    if($temp1){
                        header("Location: {$_SERVER['PHP_SELF']}?page=federation&fede=$fede&p=comite&idComité=$idCr&m=infoComite");
                        exit;
                    }
                    else{
                        $message = 'Veuillez renseignez correctement toutes les informations';
                        echo 'fonction degeu';
                    }
                }
            }
            else{
                $liste_comite=get_comite_reg_fede($fede);
                if (isset($_GET['m']) and $_GET['m']=='ajoutComiteR'){
                    $numAjoutCom=id_auto_fede ($fede);
                }
                if (isset($_GET['ajouterComiteC'])){
                    $nomAjoutCom=$_GET['ajouterNomC'];
                    $numVoieAjoutCom=$_GET['ajouterNumVoieC'];
                    $rueAjoutCom=$_GET['ajouterRueC'];
                    $villeAjoutCom=$_GET['ajouterVilleC'];
                    $codePosAjoutCom=$_GET['ajouterCodePosC'];
                    $temp1=add_comite_regional($nomAjoutCom,$numVoieAjoutCom,$rueAjoutCom,$villeAjoutCom,$codePosAjoutCom,$fede);
                    if($temp1){
                        header("Location: {$_SERVER['PHP_SELF']}?page=federation&fede=$fede&p=comite");
                        exit;
                    }else{
                        $message = 'Veuillez renseignez correctement toutes les informations';
                    }
                }
            }

        }
}
?>