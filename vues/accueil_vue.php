 <!-- ATAMNA Miryam p2100162 / FERREIRA Rémi p2107991 -->

 <div class="panneau">

        <div class="panneau_details"> <!-- Second bloc permettant l'affichage du détail d'une requête -->

            <h2>Statistiques de la base</h2>

            <form class="bloc_commandes" method="post" action="#">  

                <label for="choixRequete">Statistiques pour la requête</label>
                <select name="nomTable" id="nomTable">
                    <option value="requete1">Statistiques générales</option> 
                    <option value="requete2">Écoles par département</option> 
                    <option value="requete3">Top 5 meilleures écoles</option> 
					<option value="requete4">Comités régionales de la FFD</option> 
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
                            <table class="table_resultat" id="stat1">
                                <thead>
                                    <tr>
										<th>Fédérations</th>
										<th>Comité régionaux</th>
										<th>Comité départementaux</th>
									</tr>
                                </thead>
                                <tbody>

                                <tr><td><?php echo $stats['nbFederations']?></td><td><?php echo $stats['nbComitesRegionaux']?></td><td><?php echo $stats['nbComitesDepartementaux'] ?></td></tr>
                            </tbody>
                            </table>
                            </div>
                            <?php
                            break;
                        
                        case "requete2":
                            // Affichage des statistiques pour la requête 2
                            ?>
                            <div>
                            <table class="table_resultat" id="stat2">
                                <thead>
                                    <tr>
										<th>Code département</th>
										<th>Nombre d'écoles</th>
									</tr>
                                </thead>
                                <tbody>
                                    <?php foreach($ecoles_par_departement as $code_dept => $nombre_ecoles): ?>
                                    <tr><td><?php echo $code_dept; ?></td><td><?php echo $nombre_ecoles; ?></td></tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            </div>
                            <?php
                            break;
                        
                        case "requete3":
                            // Affichage des statistiques pour la requête 3
                            ?>
                            <div>
                            <table class="table_resultat" id="stat3">
                                <thead>
                                    <tr>
										<th>Ecole</th>
										<th>Ville</th>
										<th>Nombre d'adhérents</th>
									</tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($meilleures_ecoles as $ecole) {
                                        echo "<tr>";
                                        echo "<td>" . $ecole['nom'] . "</td>";
                                        echo "<td>" . $ecole['ville'] . "</td>";
                                        echo "<td>" . $ecole['nbAdherents'] . "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            </div>
                            <?php
                            break;
						
							case "requete4":
								// Affichage des statistiques pour la requête 4
								?>
								<div>
								<table class="table_resultat" id="stat4">
									<thead>
										<tr>
											<th>IdComité</th>
											<th>Nom</th>
											<th>Niveau</th>
											<th>Numéro de voie</th>
											<th>Rue</th>
											<th>Code Postal</th>
											<th>Ville</th>
											<th>Fédération</th>
											<th>Code</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($comite_reg as $comite) {
											echo "<tr>";
											echo "<td>" . $comite['idComité'] . "</td>";
											echo "<td>" . $comite['nom'] . "</td>";
											echo "<td>" . $comite['niveau'] . "</td>";
											echo "<td>" . $comite['numVoie'] . "</td>";
											echo "<td>" . $comite['rue'] . "</td>";
											echo "<td>" . $comite['cp'] . "</td>";
											echo "<td>" . $comite['ville'] . "</td>";
											echo "<td>" . $comite['fede'] . "</td>";
											echo "<td>" . $comite['code'] . "</td>";
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