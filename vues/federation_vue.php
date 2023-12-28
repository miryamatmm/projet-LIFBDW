<!-- ATAMNA Miryam p2100162 / FERREIRA Rémi p2107991 -->

<?php
switch ($_GET['p']) {

  case 'connexion' : ?>

    <div class="panneau_connexion">
        <div>
          <h2>Authentification</h2>
          <div>
            <table class="table_resultat">
              <thead>
                <tr>
                  <th>Nom Prénom</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($liste_employés as $nom => $prénom): ?>
                    <td><a class="employes" href="./index.php?page=federation&fede=<?php echo get_fede_by_nom($nom,$prénom);?>&p=accueil" ><?php echo $nom; echo ' '; echo $prénom;?></a></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          </div>
    </div>

 <?php
  break;

  case 'accueil' : ?>

    <div class="panneau">
    
              <div class="panneau_details">
              <div class = liens>
              <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=accueil">Accueil</a>
              <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=competition">Compétitions</a>
              <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=comite">Comité</a>
              <a class="cours" href="./index.php?page=federation&p=connexion">Déconnexion</a>
              </div>
                <h2>Votre Fédération</h2>
    
              <form class="bloc_commandes" method="post" action="#">  
    
                  <label for="choixRequete">Informations sur </label>
                  <select name="nomTable" id="nomTable">
                      <option value="requete1">Fédération</option> 
                      <option value="requete2">Comité</option> 
                      <option value="requete3">Membre</option> 
                      <option value="requete4">Compétiton</option> 
                  </select>
                      <input type="submit" name="boutonAfficher" value="Afficher"/>
                  </form>
    
              <div>
    
                  <?php 
                  if(isset($_POST['boutonAfficher'])) {
                      $nomTable = $_POST['nomTable'];
    
                      switch($nomTable) {
                          case "requete1":
                              ?>
                            <div>
                              <table class="table_resultat">
                                <thead>
                                  <tr>
                                    <th>Nom de la fédération</th>
                                    <th>Sigle</th>
                                    <th>Adresse</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td><?php echo $infoFede['nomFede']; ?></td>
                                    <td><?php echo $infoFede['sigle']; ?></td>
                                    <td><?php echo $infoFede['adresse']; ?></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          <?php
                              break;
                          
                          case "requete2":
                              ?>
                              <div>
                                <table class="table_resultat">
                                  <thead>
                                      <tr>
                                        <th>Nombre de comité</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td><?php echo $nbComite['nbComite']?></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                              <?php
                              break;
                          
                          case "requete3":
                              ?>
                              <div>
                                <table class="table_resultat">
                                  <thead>
                                    <tr>
                                      <th>Nombre de membres</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td><?php echo $nbMembre['nbMembre']?></td>
                                </tr>
                                </tbody>
                              </table>
                              </div>
                              <?php
                              break;
    
                          case "requete4":
                              ?>
                              <div>
                                <table class="table_resultat">
                                  <thead>
                                   <tr>
                                    <th>Libellé</th>
                                    <th>Code</th>
                                    <th>Niveau</th>
                                   </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    foreach ($competition as $c) {
                                      echo "<tr>";
                                      echo "<td>" . $c['libellé'] . "</td>";
                                      echo "<td>" . $c['code'] . "</td>";
                                      echo "<td>" . $c['niveau'] . "</td>";
                                      echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                      </table>
                  </div>
                  <?php
                  break;
                      } } ?>
              </div>
              </div>
              
            </div>
            <?php
    break;
    case 'competition': ?>
      <div class="panneau">

          <div class="panneau_details"> 
          <div class = liens>
              <?php 
                if ((isset($_GET['m']))&&($_GET['m'] == 'infosCompet')){ ?>
                  <a href="./index.php?page=federation&fede=<?php echo $fede;?>&p=competition"> <- </a>
                  <?php   }
                if ((isset($_GET['m']))&&($_GET['m'] == 'edition')){ ?>
                  <a href="./index.php?page=federation&fede=<?php echo $fede;?>&p=competition&m=infosCompet&code=<?php echo $code;?>"> <- </a>
                  <?php   }
              ?>
            <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=accueil">Accueil</a>
            <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=competition">Compétitions</a>
            <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=comite">Comité</a>
            <a class="cours" href="./index.php?page=federation&p=connexion">Déconnexion</a>
          </div>
          <br>
          <?php if (!isset($_GET['m'])): ?>
              <div class = liens_cours>
                <a href="./index.php?page=federation&fede=<?php echo $fede ?>&p=competition&m=ajouter">Ajouter une compétition</a>
              </div>
              <h2>Compétitions</h2>
              <div>
                <table class="table_resultat">
                  <thead>
                    <tr>
                      <th>Compétitions de la fédération</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($competition as $c): ?>
                      <tr>
                        <td style="display: flex; justify-content: space-between; align-items: center;">
                          <a class="employes" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=competition&m=infosCompet&code=<?php echo $c['code']?>" ><?php echo $c['code']?></a>
                              <form action="#" method="GET">
                                            <input type="hidden" name="page" value="federation">
                                            <input type="hidden" name="fede" value="<?php echo $fede ?>">
                                            <input type="hidden" name="p" value="competition">
                                            <input type="hidden" name="codeSupp" value="<?php echo $c['code']?>">
                                            <button type="submit" name="SupprimerCompet">Supprimer</button>
                              </form>
                      </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>

    <?php if (isset($_GET['m']) && $_GET['m'] == 'ajouter'): ?>
      <h2>Ajouter une compétition</h2>

        <form class="bloc_commandes" method="GET" action="index.php?">
          <input type="hidden" name="page" value="federation">
          <input type="hidden" name="fede" value="<?php echo $fede;?>">
          <input type="hidden" name="p" value="competition">
          <input type="hidden" name="m" value="ajouter">

          <label for="ajouterCode">Code: *</label>
          <input type="text" name="ajouterCode" id="ajoutCode" placeholder="Code" ><br><br>

          <label for="ajouterLibellé">Libellé : *</label>
          <input type="text" name="ajouterLibellé" id="ajoutLibellé" placeholder="Libellé"><br><br>

          <label for="ajouterNiveau">Niveau : *</label>

          <input type="radio" id="National" name="ajouterNiveau" value="National">
          <label for="National">National</label>

          <input type="radio" id="Régional" name="ajouterNiveau" value="Régional" checked>
          <label for="Régional">Régional</label>

          <input type="radio" id="Départemental" name="ajouterNiveau" value="Départemental">
          <label for="Départemental">Départemental</label></br></br>

          <input name="ajouterComp" type="submit"  value="Ajouter">
        </form>
        <?php echo $message ?>
      <?php 
            else: 
          if(isset($_GET['m'])){
            switch ($_GET['m']) {
              case 'infosCompet' : ?>
                <div class="panneau">
  
                  <div class="panneau_details"> 
                    <h2>Compétition <?php echo $code ?></h2>
                    <div>
                      <table class="table_resultat">
                        <thead>
                          <tr>
                            <th>Code</th>
                            <th>Libellé</th>
                            <th>Niveau</th>
                            <th> </th>
                          </tr>
                              </thead>
                                <tbody>
                                  <td><?php echo $code ?></td>
                                  <td><?php echo $infosCompet['libellé']; ?></td>
                                  <td><?php echo $infosCompet['niveau']; ?></td>
                                  <td>
                                    <form class="form-inline" action="#" method="GET">
                                              <input type="hidden" name="page" value="federation">
                                              <input type="hidden" name="fede" value="<?php echo $fede ?>">
                                              <input type="hidden" name="p" value="competition">
                                              <input type="hidden" name="m" value="infosCompet">
                                              <input type="hidden" name="code" value="<?php echo $code;?>">
                                              <button type="submit" name="ModifierCompet">Modifier</button>
                                    </form>
                                  </td>
                                </tbody>
                      </table>
  
                  </div>  
              </br>
                  <div class="liens_cours">
                          <a class="lien_cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=competition&m=edition&code=<?php echo $code;?>">Édition de la compétition</a>
                  </div>            
              </div>
              </div>
  
        <?php
        break;
  
        case 'modifier' : ?>
  
          <h2>Modifier la compétition <?php echo $code ?></h2>
              <div>
                  <form class="bloc_commandes" method="GET" action="#">
                    <input type="hidden" name="page" value="federation">
                    <input type="hidden" name="fede" value="<?php echo $fede; ?>">
                    <input type="hidden" name="p" value="competition">
                    <input type="hidden" name="m" value="modifier">
                    <input type="hidden" name="code" value="<?php echo $code; ?>">
  
                    <label for="codeT">Code :</label>
                    <input type="text" id="codeT" name="codeT" value="<?php echo $code ?>" disabled="disabled"></br>
  
                    <label for="libelle">Libellé :</label>
                    <input type="text" id="libelle" name="libelle" value="<?php echo $infosCompet['libellé']; ?>"></br>
  
                    <label for="niveau">Niveau :</label>
  
                    <input type="radio" id="National" name="niveau" value="National" 
                    <?php if(strcmp($infosCompet['niveau'], 'National')==0) echo 'checked="checked"' ;?>>
                    <label for="National">National</label>
  
                    <input type="radio" id="Régional" name="niveau" value="Régional"
                    <?php if(strcmp($infosCompet['niveau'], 'Régional')==0) echo 'checked="checked"'; ?>>
                    <label for="Régional">Régional</label>
  
                    <input type="radio" id="Départemental" name="niveau" value="Départemental"
                    <?php if(strcmp($infosCompet['niveau'], 'Départemental')==0) echo 'checked="checked"'; ?>>
                    <label for="Départemental">Départemental</label></br></br>
  
                    <input name="modifCompet" type="submit" value="Modifier">
                  </form>
              </div>
      <?php
      break;
      case 'edition' : 
      if(!isset($_GET['e'])) { ?>
        <h2>Edition de la compétition <?php echo $code; ?></h2>
                  <div>
                    <table class="table_resultat">
                        <thead>
                          <tr>
                            <th>Edition de la compétiton</th>
                            <th> </th>
                          </tr>
                      </thead>
                        <tbody>
                          <?php foreach($liste_edition as $annee => $villeOrganisatrice): ?>
                              <td style="display: flex; justify-content: space-between; align-items: center;">
                                <a class="employes" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=competition&m=edition&code=<?php echo $code?>&e=infosE&annee=<?php echo $annee ?>"><?php echo $villeOrganisatrice; echo ' : '; echo $annee;?></a>
                                <form class="form-inline" action="#" method="GET">
                                              <input type="hidden" name="page" value="federation">
                                              <input type="hidden" name="fede" value="<?php echo $fede ?>">
                                              <input type="hidden" name="p" value="competition">
                                              <input type="hidden" name="m" value="edition">
                                              <input type="hidden" name="code" value="<?php echo $code ?>">
                                              <input type="hidden" name="e" value="infosE">
                                              <input type="hidden" name="annee" value="<?php echo $annee ?>">
                                              <button type="submit" name="ModifEd">Modifier</button>
                                </form>
                              </td>
                              <td>
                                <form class="form-inline" action="#" method="GET">
                                              <input type="hidden" name="page" value="federation">
                                              <input type="hidden" name="fede" value="<?php echo $fede ?>">
                                              <input type="hidden" name="p" value="competition">
                                              <input type="hidden" name="m" value="edition">
                                              <input type="hidden" name="code" value="<?php echo $code ?>">
                                              <input type="hidden" name="anneeSupp" value="<?php echo $annee ?>">
                                              <button type="submit" name="SupprimerEdition">Supprimer</button>
                                </form>
                              </td>
                              </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                  </div>
                    </br></br>
                    <div class = liens_cours>
                      <a href="./index.php?page=federation&fede=<?php echo $fede;?>&p=competition&m=edition&code=<?php echo $code;?>&e=ajouter">Ajouter une édition</a>
                    </div>
        <?php } else 
          if($_GET['e'] == 'ajouter') { ?>
            <div class="panneau">
              <div class="panneau_details"> 
  
                  <h2>Ajouter une édition</h2>
  
                  <form class="bloc_commandes" method="GET" action="#">
                          <input type="hidden" name="page" value="federation">
                          <input type="hidden" name="fede" value="<?php echo $fede;?>">
                          <input type="hidden" name="p" value="competition">
                          <input type="hidden" name="m" value="edition">
                          <input type="hidden" name="code" value="<?php echo $code;?>">
                          <input type="hidden" name="e" value="ajouter">
  
                    <label for="ajouterAnnee">Année: *</label>
                    <input type="text" name="ajouterAnnee" id="ajoutAnnee" placeholder="2023" ><br><br>
  
                    <label for="ajouterVille">Ville : *</label>
                    <input type="text" name="ajouterVille" id="ajoutVille" placeholder="Tarare" ><br><br>
  
                    <input name="ajouterEdition" type="submit"  value="Ajouter">
                  </form>
                  <?php echo $message ?>
              </div>
        </div>
            <?php   }
            else if($_GET['e'] == 'infosE'){ ?>
              <div>
                <h2>Modifier l'édition <?php echo $infoEdition['annee']; ?></h2>
              <form class="bloc_commandes" method="GET" action="#">
                    <input type="hidden" name="page" value="federation">
                    <input type="hidden" name="fede" value="<?php echo $fede; ?>">
                    <input type="hidden" name="p" value="competition">
                    <input type="hidden" name="m" value="edition">
                    <input type="hidden" name="code" value="<?php echo $code; ?>">
                    <input type="hidden" name="e" value="infosE">
                    <input type="hidden" name="annee" value="<?php echo $infoEdition['annee']; ?>">
      
                    <label for="codeT">Code :</label>
                    <input type="text" id="codeT" name="codeT" value="<?php echo $code ?>" disabled="disabled"></br> 
      
                    <label for="anneeT">Annee :</label>
                    <input type="text" id="anneeT" name="anneeT" value="<?php echo $infoEdition['annee'];?>" disabled="disabled"></br> 
      
                    <label for="ville">Ville :</label>
                    <input type="text" id="ville" name="ville" value="<?php echo $infoEdition['villeOrganisatrice']; ?>"></br> </br>
      
                    <input name="modifEdition" type="submit" value="Modifier">
                </form></br>
                <div class = liens_cours>
                  <a href="./index.php?page=federation&fede=<?php echo $fede;?>&p=competition&m=edition&code=<?php echo $code;?>&e=inscrireCouple&annee=<?php echo $infoEdition['annee'];?>">Inscrire un couple</a>
                </div>
              </div>
              
          <?php }
            else if($_GET['e'] == 'inscrireCouple'){ ?>

            <div>
              <h2>Inscrire un couple</h2>
              <form class="bloc_commandes" method="GET" action="#">
                    <input type="hidden" name="page" value="federation">
                    <input type="hidden" name="fede" value="<?php echo $fede; ?>">
                    <input type="hidden" name="p" value="competition">
                    <input type="hidden" name="m" value="edition">
                    <input type="hidden" name="code" value="<?php echo $code; ?>">
                    <input type="hidden" name="e" value="infosE">
                    <input type="hidden" name="annee" value="<?php echo $infoEdition['annee']; ?>">
      
                    <label for="numLicence1">Numéro Licence 1 :</label>
                    <input type="text" id="numLicence1" name="numLicence1" placeholder="2022024" ></br> 
      
                    <label for="numLicence2">Numéro Licence 2 :</label>
                    <input type="text" id="numLicence2" name="numLicence2" placeholder="2022028" ></br> 

                    <label for="rangCouple">Rang :</label>
                    <input type="text" id="rangCouple" name="rangCouple" placeholder="1" ></br></br>
      
                    <input name="ajoutCouple" type="submit" value="Ajouter">
                </form></br>
            </div>
          <?php  }
          ?>
            
      <?php break;
       }
          }
            ?>
    <?php endif;
    break;     
    case 'comite' : ?>
      <?php if(!isset($_GET['m'])) { ?>
       <div class="panneau">

          <div class="panneau_details"> <!-- Second bloc permettant l'affichage du détail d'une requête -->
          <div class = liens>
              <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=accueil">Accueil</a>
              <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=competition">Compétitions</a>
              <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=comite">Comité</a>
              <a class="cours" href="./index.php?page=federation&p=connexion">Déconnexion</a>
          </div><br>
              <div class = liens_cours>
                <a href="./index.php?page=federation&fede=<?php echo $fede ?>&p=comite&m=ajoutComiteR">Ajouter un comité régional</a>
              </div>
            <h2>Comités</h2>
            <div>
            <table class="table_resultat">
              <thead>
                <tr>
                  <th>Comités régionaux</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($liste_comite as $l): ?>
                  <tr>
                    <td><a class="employes" href="./index.php?page=federation&fede=<?php echo $fede?>&p=comite&idComité=<?php echo $l['idComité'] ?>&m=infoComite" ><?php echo $l['nom'] ?></a></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          </div>

            <?php }
            if(isset($_GET['m'])){
            switch ($_GET['m']) {
              case 'infoComite' : ?>

              <div class="panneau">
              <div class="panneau_details"> <!-- Second bloc permettant l'affichage du détail d'une requête -->
              <div class = liens>
                  <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=accueil">Accueil</a>
                  <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=competition">Compétitions</a>
                  <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=comite">Comité</a>
                  <a class="cours" href="./index.php?page=federation&p=connexion">Déconnexion</a>
                  </div>
                <div class="panneau">
  
                  <div class="panneau_details"> 
                    <h2><?php echo $infoComite['nom'] ?></h2>
                    <div>
                      <table class="table_resultat">
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Niveau</th>
                            <th>Adresse</th>
                            <th>Nom fédération</th>
                            <th>Président</th>
                            <th> </th>
                          </tr>
                        </thead>
                        <tbody>
                          <td><?php if(isset($_GET['idComitéDep'])){
                              echo $idCd;
                              }
                             else{
                             echo $idCr;
                             } ?></td>
                          <td><?php echo $infoComite['nom']; ?></td>
                          <td><?php echo $infoComite['niveau']; ?></td>
                          <td><?php echo $infoComite['adresse']; ?></td>
                          <td><?php echo $infoComite['nomFede']; ?></td>
                          <td><?php echo $infoComite['president']; ?></td>
                          <td>
                          <form class="form-inline" action="#" method="GET">
                              <input type="hidden" name="page" value="federation">
                              <input type="hidden" name="fede" value="<?php echo $fede ?>">
                              <input type="hidden" name="p" value="comite">
                              <input type="hidden" name="m" value="modifComite">
                              <input type="hidden" name="idComité" value="<?php echo $idCr;?>">
                              <?php 
                                if(isset($_GET['idComitéDep'])){?>
                                <input type="hidden" name="idComitéDep" value="<?php echo $idCd;?>">
                              <?php } ?>
                              <button type="submit" name="ModifierComite">Modifier</button>
                          </form>
                          </td>
                        </tbody>
                  </table>
                  </div>
                  <br>
              <?php if(!isset($_GET['idComitéDep'])){ ?>
              <table class="table_resultat">
              <thead>
                <tr>
                  <th>Comités départementaux</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($liste_comite_dept as $l): ?>
                  <tr>
                    <td><a class="employes" href="./index.php?page=federation&fede=<?php echo $fede?>&p=comite&idComité=<?php echo $idCr?>&idComitéDep=<?php echo $l['idComité'] ?>&m=infoComite" ><?php echo $l['nom'] ?></a></td>
                  </tr>
                <?php endforeach; ?>
                </br>
              </tbody>
              </table>
              </br>
              <div class = liens_cours>
                <a href="./index.php?page=federation&fede=<?php echo $fede ?>&p=comite&idComité=<?php echo $idCr ?>&m=ajoutComiteD">Ajouter un comité départemental</a>
              </div>
              <?php } ?>    
              </div>
              </div>
              </div>

            <?php break;
            
            case 'modifComite' : ?>
            
            <div class="panneau">
              <div class="panneau_details"> <!-- Second bloc permettant l'affichage du détail d'une requête -->
              <div class = liens>
                  <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=accueil">Accueil</a>
                  <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=competition">Compétitions</a>
                  <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=comite">Comité</a>
                  <a class="cours" href="./index.php?page=federation&p=connexion">Déconnexion</a>
              </div></br>
              <h2>Modifier <?php echo $infoModifComite['nom']?> </h2>
              <form class="bloc_commandes" method="GET" action="index.php?">
                    <input type="hidden" name="page" value="federation">
                    <input type="hidden" name="fede" value="<?php echo $fede;?>">
                    <input type="hidden" name="p" value="comite">
                    <input type="hidden" name="m" value="infoComite">
                    <input type="hidden" name="idComité" value="<?php echo $idCr;?>">
                    <?php if(isset($_GET['idComitéDep'])){ ?>
                    <input type="hidden" name="idComitéDep" value="<?php echo $idCd;?>">
                    <?php } ?>  

                    <label for="modifierIDC2">ID: *</label>
                    <input type="text" name="modifierIDC2" id="modifierIDC2" value="<?php echo $idCr ?>" disabled="disabled"><br><br>

                    <label for="modifierNomCR">Nom : *</label>
                    <input type="text" name="modifierNomCR" id="modifierNomCR" value="<?php echo $infoModifComite['nom'] ?>"><br><br>

                    <label for="modifierNumVoieC">Numéro de voie : *</label>
                    <input type="text" name="modifierNumVoieCR" id="modifierNumVoieCR" value="<?php echo $infoModifComite['numVoie'] ?>"><br><br>

                    <label for="modifierRueC">Rue : *</label>
                    <input type="text" name="modifierRueCR" id="modifierRueCR" value="<?php echo $infoModifComite['rue'] ?>"><br><br>

                    <label for="modifierVilleC">Ville : *</label>
                    <input type="text" name="modifierVilleCR" id="modifierVilleCR" value="<?php echo $infoModifComite['nomVille'] ?>"><br><br>

                    <label for="modifierCodePosCR">Code postal : *</label>
                    <input type="text" name="modifierCodePosCR"  id="modifierCodePosCR" value="<?php echo $infoModifComite['codePostal'] ?>"><br><br>

                    <input name="modifierComiteCR" type="submit" value="Modifier">
                  </form>

            <?php
            break;
            case 'ajoutComiteR' : ?>

              <div class="panneau">
              <div class="panneau_details"> <!-- Second bloc permettant l'affichage du détail d'une requête -->
              <div class = liens>
                  <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=accueil">Accueil</a>
                  <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=competition">Compétitions</a>
                  <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=comite">Comité</a>
                  <a class="cours" href="./index.php?page=federation&p=connexion">Déconnexion</a>
              </div>
              <h2>Ajouter un comité régional</h2>
                  <form class="bloc_commandes" method="GET" action="index.php?">
                    <input type="hidden" name="page" value="federation">
                    <input type="hidden" name="fede" value="<?php echo $fede;?>">
                    <input type="hidden" name="p" value="comite">
                    <input type="hidden" name="m" value="ajoutComiteR">

                    <label for="ajouterNomC">Nom : *</label>
                    <input type="text" name="ajouterNomC" placeholder="Comité de Lyon lpb ville de France"><br><br>

                    <label for="ajouterNumVoieC">Numéro de voie : *</label>
                    <input type="text" name="ajouterNumVoieC" placeholder="123"><br><br>

                    <label for="ajouterRueC">Rue : *</label>
                    <input type="text" name="ajouterRueC" placeholder="rue de la Goule"><br><br>

                    <label for="ajouterVilleC">Ville : *</label>
                    <input type="text" name="ajouterVilleC" placeholder="Tarare"><br><br>

                    <label for="ajouterCodePosC">Code postal : *</label>
                    <input type="text" name="ajouterCodePosC" placeholder="69170"><br><br>

                    <input name="ajouterComiteC" type="submit"  value="Ajouter">
                  </form>
                </div>
              </div>

            <?php break;
            case 'ajoutComiteD': ?>

              <div class="panneau">
              <div class="panneau_details"> <!-- Second bloc permettant l'affichage du détail d'une requête -->
              <div class = liens>
                  <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=accueil">Accueil</a>
                  <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=competition">Compétitions</a>
                  <a class="cours" href="./index.php?page=federation&fede=<?php echo $fede;?>&p=comite">Comité</a>
                  <a class="cours" href="./index.php?page=federation&p=connexion">Déconnexion</a>
              </div></br>
              <h2>Ajouter un comité départemental</h2>
                  <form class="bloc_commandes" method="GET" action="index.php?">
                    <input type="hidden" name="page" value="federation">
                    <input type="hidden" name="fede" value="<?php echo $fede;?>">
                    <input type="hidden" name="p" value="comite">
                    <input type="hidden" name="idComité" value="<?php echo $idCr;?>">
                    <input type="hidden" name="m" value="ajouterComiteD">
                    

                    <label for="ajouterNomC">Nom : *</label>
                    <input type="text" name="ajouterNomC" placeholder="Le comité des plus belles danseuses de France"><br><br>

                    <label for="ajouterNumVoieC">Numéro de voie : *</label>
                    <input type="text" name="ajouterNumVoieC" placeholder="12"><br><br>

                    <label for="ajouterRueC">Rue : *</label>
                    <input type="text" name="ajouterRueC" placeholder="Rue Alfred de Musset"><br><br>

                    <label for="ajouterVilleC">Ville : *</label>
                    <input type="text" name="ajouterVilleC" placeholder="Tarare"><br><br>

                    <label for="ajouterCodePosC">Code postal : *</label>
                    <input type="text" name="ajouterCodePosC" placeholder="69170"><br><br>

                    <input name="ajouterComiteCD" type="submit"  value="Ajouter">
                  </form>
                </div>
              </div>


            

            <?php
             }}
            ?>
    <?php 
    break;
    default:
    ?>

        <div class="panneau">
            <div>
                <h2>Page non trouvée</h2>
                <div>
                    <!-- Code HTML de la page d'erreur -->
                </div>
            </div>
        </div>
        <?php
        break;
} ?>