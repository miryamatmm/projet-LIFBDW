<!-- ATAMNA Miryam p2100162 / FERREIRA Rémi p2107991 -->

<?php
switch ($_GET['p']) {
    case 'connexion':
        ?>
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
                    <td><a class="employes" href="./index.php?page=ecole&id=<?php echo get_ecole_by_nom($nom,$prénom);?>&p=accueil" ><?php echo $nom; echo ' '; echo $prénom;?></a></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
        <?php
        break;
    case 'accueil':
        ?>
    <div class="panneau">

          <div class="panneau_details"> <!-- Second bloc permettant l'affichage du détail d'une requête -->
          <div class = liens>
          <a class="cours" href="./index.php?page=ecole&id=<?php echo $id;?>&p=accueil">Accueil</a>
          <a class="cours" href="./index.php?page=ecole&id=<?php echo $id;?>&p=infos">Infos</a>
          <a class="cours" href="./index.php?page=ecole&id=<?php echo $id;?>&p=cours">Cours</a>
          <a class="cours" href="./index.php?page=ecole&p=connexion">Déconnexion</a>
          </div>
            <h2>Notre école</h2>

          <form class="bloc_commandes" method="post" action="#">  

              <label for="choixRequete">Informations sur </label>
              <select name="nomTable" id="nomTable">
                  <option value="requete1">Ecole</option> 
                  <option value="requete2">Employés</option> 
                  <option value="requete3">Adhérents</option> 
                  <option value="requete4">Cours</option> 
              </select>
                  <input type="submit" name="boutonAfficher" value="Afficher"/>
              </form>

          <div>

              <?php 
              if(isset($_POST['boutonAfficher'])) {
                  $nomTable = $_POST['nomTable'];

                  switch($nomTable) {
                      case "requete1":
                          // Affichage des statistiques pour la requête 1
                          ?>
                        <div>
                          <table class="table_resultat">
                            <thead>
                              <tr>
                                <th>Nom de l'école</th>
                                <th>Adresse</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td><?php echo $infos['nom']; ?></td>
                                <td><?php echo $infos['adresse']; ?></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      <?php
                          break;
                      
                      case "requete2":
                          // Affichage des statistiques pour la requête 2
                          ?>
                          <div>
                            <table class="table_resultat">
                              <thead>
                                  <tr>
                                    <th>Liste des employés</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td><?php echo $listeEmp['fondateurs']?></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <?php
                          break;
                      
                      case "requete3":
                          // Affichage des statistiques pour la requête 3
                          ?>
                          <div>
                            <table class="table_resultat">
                              <thead>
                                <tr>
                                  <th>Nombre d'adhérent en 2022</th>
                                </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td><?php echo $nbAdherents['nbAdherents']?></td>
                            </tr>
                            </tbody>
                          </table>
                          </div>
                          <?php
                          break;

            case "requete4":
              // Affichage des statistiques pour la requête 4
              ?>
              <div>
                <table class="table_resultat">
                    <thead>
                      <tr>
                        <th>IdCours</th>
                        <th>Libellé</th>
                        <th>Catégorie d'age</th>
                        <th>Professeur</th>
                      </tr>
                          </thead>
                            <tbody>
                                <?php
                                foreach ($cours as $c) {
                                  echo "<tr>";
                                  echo "<td>" . $c['idCours'] . "</td>";
                                  echo "<td>" . $c['libellé'] . "</td>";
                                  echo "<td>" . $c['categorieAge'] . "</td>";
                                  echo "<td>" . $c['prof'] . "</td>";
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
    case 'infos':
        ?>
        <div class="panneau">

            <div class="panneau_details"> <!-- Second bloc permettant l'affichage du détail d'une requête -->
            <div class = liens>
              <a class="cours" href="./index.php?page=ecole&id=<?php echo $id;?>&p=accueil">Accueil</a>
              <a class="cours" href="./index.php?page=ecole&id=<?php echo $id;?>&p=infos">Infos</a>
              <a class="cours" href="./index.php?page=ecole&id=<?php echo $id;?>&p=cours">Cours</a>
              <a class="cours" href="./index.php?page=ecole&p=connexion">Déconnexion</a>
            </div>
              <h2>Modifier les informations</h2>
              <div>
                <form class="bloc_commandes" method="GET" action="#">
                  <input type="hidden" name="page" value="ecole">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <input type="hidden" name="p" value="infos">

                  <label for="nom">Nom de l'école :</label>
                  <input type="text" id="nom" name="nom" value="<?php echo $infosEcoles['nom']; ?>"></br>

                  <label for="numVoie">Numéro de voie :</label>
                  <input type="text" id="numVoie" name="numVoie" value="<?php echo $infosEcoles['numVoie']; ?>"></br>

                  <label for="rue">Rue :</label>
                  <input type="text" id="rue" name="rue" value="<?php echo $infosEcoles['rue']; ?>"></br>

                  <label for="codePostal">Code Postal :</label>
                  <input type="text" id="codePostal" name="codePostal" value="<?php echo $infosEcoles['codePostal']; ?>"></br>

                  <label for="nomVille">Ville :</label>
                  <input type="text" id="nomVille" name="nomVille" value="<?php echo $infosEcoles['nomVille']; ?>"></br></br>

                  <input name="Modifier" type="submit" value="Modifier">
                </form>
            </div>
          </div>
        </div>
        <?php
        break;
        case 'cours':
          ?>
         <div class="panneau">
            <div class="panneau_details">
              <div class="liens">
                <a class="cours" href="./index.php?page=ecole&id=<?php echo $id; ?>&p=accueil">Accueil</a>
                <a class="cours" href="./index.php?page=ecole&id=<?php echo $id; ?>&p=infos">Infos</a>
                <a class="cours" href="./index.php?page=ecole&id=<?php echo $id; ?>&p=cours">Cours</a>
                <a class="cours" href="./index.php?page=ecole&p=connexion">Déconnexion</a>
              </div>
              <?php if (!isset($_GET['c'])): ?>
                <h2>Cours</h2>
                <p>Sélectionnez un cours</p>
              <div>
                    <table class="table_resultat">
                        <thead>
                            <tr>
                                <th>Liste des cours</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cours as $c) { ?>
                                <tr>
                                    <td style="display: flex; justify-content: space-between; align-items: center;">
                                        <a class="choix_cours" href="./index.php?page=ecole&id=<?php echo $id; ?>&p=cours&c=<?php echo $c['idCours']; ?>&m=infosC"><?php echo $c['libellé']; ?></a>
                                        <form class="form-inline" action="#" method="GET">
                                            <input type="hidden" name="page" value="ecole">
                                            <input type="hidden" name="id" value="<?php echo $id ?>">
                                            <input type="hidden" name="p" value="cours">
                                            <input type="hidden" name="idC" value="<?php echo $c['idCours']; ?>">
                                            <button type="submit" name="Supprimer" class="btn btn-danger">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
              </div>
             </br>
                <div class="liens_cours">
                  <a class="cours" href="./index.php?page=ecole&id=<?php echo $id; ?>&p=cours&c=-1&m=ajouter">Ajouter un cours</a> 
                  <!-- c = -1 parce que pas de cours sélectionné -->
                </div>
        </div>
      </div>
          <?php 
            else:
              switch ($_GET['m']) {
                case 'infosC':?>

                <div class="panneau">
                  <div class="panneau_details">
                  <h2>Information sur le cours</h2>
                      <div>
                      <table class="table_resultat">
                    <thead>
                      <tr>
                        <th>Nom de l'école</th>
                        <th>Adresse de l'école</th>
                        <th>Professeur</th>
                        <th>Libellé</th>
                        <th>Catégorie d'age</th>
                        <th>Code</th>
                        <th>IdCours</th>
                      </tr>
                          </thead>
                            <tbody>
                              <td><?php echo $infosCours['nom']?></td>
                              <td><?php echo $infosCours['adresse']?></td>
                              <td><?php echo $infosCours['prof']?></td>
                              <td><?php echo $infosCours['libellé']?></td>
                              <td><?php echo $infosCours['categorieAge']?></td>
                              <td><?php echo $infosCours['code']?></td>
                              <td><?php echo $idCours ?></td>
                            </tbody>
                  </table>
                      </div>
                    </br>
                      <div class="liens_cours">
                        <a class="cours" href="./index.php?page=ecole&id=<?php echo $id;?>&p=cours&c=<?php echo $idCours;?>&m=modifier">Modifier le cours</a>
                    </div>
                  </div>
                </div>
                  
                 <?php break;
                
                case 'modifier': ?>
                <div class="panneau">

                  <div class="panneau_details"> <!-- Second bloc permettant l'affichage du détail d'une requête -->
                    <h2>Modifier le cours</h2>
                    <div>
                      <form class="bloc_commandes" method="GET" action="#">

                          <input type="hidden"  name="page" value="ecole">
                          <input type="hidden"  name="id" value="<?php echo $id ?>">
                          <input type="hidden"  name="p" value="cours">
                          <input type="hidden"  name="c" value="<?php echo $idCours ?>">
                          <input type="hidden"  name="m" value="modifier">

                        <label for="professeur">Professeur :</label>
                          <select id="professeur" name="professeur">
                            <option value="<?php echo $infosCours['prof']; ?>" selected><?php echo $infosCours['prof'] ?></option>
                          </select>

                        <label for="libelle">Libellé :</label>
                        <input type="text" id="libelle" name="libelle" value="<?php echo $infosCours['libellé']; ?>"></br>

                        <label for="categorieAge">Catégorie d'age :</label>
                          <select id="categorieAge" name="categorieAge">
                            <option value="3-6ans" <?php if($infosCours['categorieAge'] == '3-6ans') echo 'selected'; ?>>3-6 ans</option>
                            <option value="7-10ans" <?php if($infosCours['categorieAge'] == '7-10ans') echo 'selected'; ?>>7-10 ans</option>
                            <option value="11-15ans" <?php if($infosCours['categorieAge'] == '11-15ans') echo 'selected'; ?>>11-15 ans</option>
                            <option value="16-18ans" <?php if($infosCours['categorieAge'] == '16-18ans') echo 'selected'; ?>>16-18 ans</option>
                            <option value="adulte" <?php if($infosCours['categorieAge'] == 'adulte') echo 'selected'; ?>>Adulte</option>
                          </select>

                        <input name="Modifier" type="submit" value="Modifier">
                      </form>
                  </div>
                  </div>
                  </div>
            
                  <?php break;
                
                case 'ajouter': ?>
                    <div class="panneau">

                  <div class="panneau_details"> <!-- Second bloc permettant l'affichage du détail d'une requête -->
                    <h2>Ajouter un cours</h2>
                    <div>
                    <form  class="bloc_commandes" action="#" method="GET">
                          <input type="hidden"  name="page" value="ecole">
                          <input type="hidden"  name="id" value="<?php echo $id ?>">
                          <input type="hidden"  name="p" value="cours">
                          <input type="hidden"  name="c" value=-1>
                          <input type="hidden"  name="m" value="ajouter">

                          <label for="libelle">Libellé : *</label>
                          <input type="text" id="libelle" name="libelle"><br>

                          <label for="categorieAge">Catégorie d'âge :</label>
                          <select id="categorieAge" name="categorieAge">
                            <option value="3-6ans">3-6 ans</option>
                            <option value="7-10ans">7-10 ans</option>
                            <option value="11-15ans">11-15 ans</option>
                            <option value="16-18ans">16-18 ans</option>
                            <option value="adulte">Adulte</option>
                          </select><br>

                          </br>
                          <input type="submit" name="Ajouter" value="Ajouter">
                  </form>

                  </div>
                  <?php echo $message ?>
                  </div>
                  </div>
            <?php  }
            ?>
                <?php endif;
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
}
?>

  