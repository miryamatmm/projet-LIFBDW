<!-- ATAMNA Miryam p2100162 / FERREIRA Rémi p2107991 -->

<?php 

$message= '';
    //si un employé a déjà été séléctionné
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Récupérer les données de l'école à partir de la base de données en utilisant l'ID
        $donnees = get_tdb_ecole($id);

        $infos = $donnees['infos'];
        $listeEmp = $donnees['listeEmp'];
        $nbAdherents = $donnees['nbAdherents'];
        $cours = $donnees['cours'];
      
    }else{ 
        //liste des employés pour s'identifier (p == connexion)
        $liste_employés = get_employe();
    }

    if(isset($_GET['p'])){
        $p = $_GET['p'];
        if($p == "infos"){
            //infos de l'école
            $infosEcoles = get_donnee_ecole($id);

            //modifier les données d'une école
            if(isset($_GET['Modifier'])){
                echo "modifier";
                $nom = $_GET['nom'];
                $numVoie = $_GET['numVoie'];
                $rue = $_GET['rue'];
                $codePostal = $_GET['codePostal'];
                $nomVille = $_GET['nomVille'];
                $donneesM = modifierEcole($id,$nom,$numVoie,$rue,$codePostal,$nomVille);
                if($donneesM){
                    header("Location: {$_SERVER['PHP_SELF']}?page=ecole&id=$id&p=accueil");
                    exit;
                }
             }
        }
        if($p == "cours"){
            //cours sélectionné
            if (isset($_GET['idC'])){
                $idCours = $_GET['idC'];
                
                //supprimer un cours
                if (isset($_GET['Supprimer'])){
                $donneesS = supprimerCours($idCours);
                if($donneesS){
                    header("Location: {$_SERVER['PHP_SELF']}?page=ecole&id=$id&p=cours");
                    exit;
                }
             }
            }
            //pas de cours sélectionné
            if (isset($_GET['c'])){
                $idCours = $_GET['c'];
                
                //ajouter un cours
                if(isset($_GET['m'])){
                    $m=$_GET['m'];
                    if ($m != "ajouter"){
                        $infosCours = get_infos_cours($idCours);
                    }
                }
                //modifier un cours
                if(isset($_GET['Modifier'])){
                    $libelle = $_GET['libelle'];
                    $categorieAge = $_GET['categorieAge'];
                    $donneesC = modifierCours($idCours,$libelle,$categorieAge);
                    if($donneesC){
                        header("Location: {$_SERVER['PHP_SELF']}?page=ecole&id=$id&p=cours&&c=$idCours&m=infosC");
                        exit;
                    }
                 }
                 // ajouter un cours
                 if ((isset($_GET['libelle'])) and (isset($_GET['Ajouter']))){
                    $libelle = $_GET['libelle'];
                    $categorieAge = $_GET['categorieAge'];
                    $donneesA = ajouterCours($libelle,$categorieAge,$id);
                    if($donneesA){
                        header("Location: {$_SERVER['PHP_SELF']}?page=ecole&id=$id&p=cours");
                        exit;
                    }else{
                        $message = 'Veuillez renseignez toutes les informations';
                    }
                 }
            }
        }
        
    } 
?> 