CREATE TABLE Adresse(
   numVoie INT,
   rue VARCHAR(50),
   codePostal VARCHAR(50),
   nomVille VARCHAR(50),
   pays VARCHAR(50) NOT NULL,
   complémentRue VARCHAR(50),
   numCedex INT,
   boitePostale VARCHAR(50),
   PRIMARY KEY(numVoie, rue, codePostal, nomVille)
);

CREATE TABLE Employé(
   idEmp INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   prénom VARCHAR(50) NOT NULL,
   PRIMARY KEY(idEmp)
);

CREATE TABLE Période(
   annee INT,
   PRIMARY KEY(annee)
);

CREATE TABLE GroupeDanse(
   idGroupe INT AUTO_INCREMENT,
   nom VARCHAR(50),
   infosGenre VARCHAR(50),
   PRIMARY KEY(idGroupe)
);

CREATE TABLE Fédération(
   nomFede VARCHAR(50),
   sigle VARCHAR(50),
   president VARCHAR(50),
   numVoie INT NOT NULL,
   rue VARCHAR(50) NOT NULL,
   codePostal VARCHAR(50) NOT NULL,
   nomVille VARCHAR(50) NOT NULL,
   PRIMARY KEY(nomFede),
   FOREIGN KEY(numVoie, rue, codePostal, nomVille) REFERENCES Adresse(numVoie, rue, codePostal, nomVille)
);

CREATE TABLE Comité(
   idComité INT AUTO_INCREMENT,
   nom VARCHAR(50),
   niveau VARCHAR(50),
   numVoie INT NOT NULL,
   rue VARCHAR(50) NOT NULL,
   codePostal VARCHAR(50) NOT NULL,
   nomVille VARCHAR(50) NOT NULL,
   idComitéR INT,
   nomFede VARCHAR(50) NOT NULL,
   code VARCHAR(50) NOT NULL ;
   PRIMARY KEY(idComité),
   FOREIGN KEY(numVoie, rue, codePostal, nomVille) REFERENCES Adresse(numVoie, rue, codePostal, nomVille),
   FOREIGN KEY(idComitéR) REFERENCES Comité(idComité),
   FOREIGN KEY(nomFede) REFERENCES Fédération(nomFede)
);

CREATE TABLE StructureSportive(
   idSS INT AUTO_INCREMENT,
   nom VARCHAR(50),
   typeStructure VARCHAR(50),
   numVoie INT NOT NULL,
   rue VARCHAR(50) NOT NULL,
   codePostal VARCHAR(50) NOT NULL,
   nomVille VARCHAR(50) NOT NULL,
   PRIMARY KEY(idSS),
   FOREIGN KEY(numVoie, rue, codePostal, nomVille) REFERENCES Adresse(numVoie, rue, codePostal, nomVille)
);

CREATE TABLE typeDanse(
   idType INT AUTO_INCREMENT,
   nomType VARCHAR(50) NOT NULL,
   PRIMARY KEY(idType)
);

CREATE TABLE Couple(
   idCouple INT AUTO_INCREMENT,
   PRIMARY KEY(idCouple)
);

CREATE TABLE Ecole(
   idEcole INT AUTO_INCREMENT,
   nom VARCHAR(50),
   fondateurs VARCHAR(50),
   nomFede VARCHAR(50),
   numVoie INT NOT NULL,
   rue VARCHAR(50) NOT NULL,
   codePostal VARCHAR(50) NOT NULL,
   nomVille VARCHAR(50) NOT NULL,
   PRIMARY KEY(idEcole),
   FOREIGN KEY(nomFede) REFERENCES Fédération(nomFede),
   FOREIGN KEY(numVoie, rue, codePostal, nomVille) REFERENCES Adresse(numVoie, rue, codePostal, nomVille)
);

CREATE TABLE Salle(
   idEcole INT,
   numSalle INT,
   nom VARCHAR(50),
   superficie VARCHAR(50),
   PRIMARY KEY(idEcole, numSalle),
   FOREIGN KEY(idEcole) REFERENCES Ecole(idEcole)
);

CREATE TABLE EspaceDanse(
   idEcole INT,
   numSalle INT,
   typeAeration VARCHAR(50),
   typeChauffage VARCHAR(50),
   PRIMARY KEY(idEcole, numSalle),
   FOREIGN KEY(idEcole, numSalle) REFERENCES Salle(idEcole, numSalle)
);

CREATE TABLE Vestiaires(
   idEcole INT,
   numSalle INT,
   mixte BOOL,
   avecDouches BOOL,
   PRIMARY KEY(idEcole, numSalle),
   FOREIGN KEY(idEcole, numSalle) REFERENCES Salle(idEcole, numSalle)
);

CREATE TABLE Adhérent(
   numLicence INT,
   prénom VARCHAR(50),
   nom VARCHAR(50),
   dateNaiss DATE,
   numVoie INT NOT NULL,
   rue VARCHAR(50) NOT NULL,
   codePostal VARCHAR(50) NOT NULL,
   nomVille VARCHAR(50) NOT NULL,
   idGroupe INT NOT NULL,
   idCouple INT NOT NULL,
   idEcole INT NOT NULL,
   PRIMARY KEY(numLicence),
   FOREIGN KEY(numVoie, rue, codePostal, nomVille) REFERENCES Adresse(numVoie, rue, codePostal, nomVille),
   FOREIGN KEY(idGroupe) REFERENCES GroupeDanse(idGroupe),
   FOREIGN KEY(idCouple) REFERENCES Couple(idCouple),
   FOREIGN KEY(idEcole) REFERENCES Ecole(idEcole)
);

CREATE TABLE Compétition(
   code VARCHAR(50),
   libellé VARCHAR(50),
   niveau VARCHAR(50),
   nomFede VARCHAR(50) NOT NULL,
   PRIMARY KEY(code),
   FOREIGN KEY(nomFede) REFERENCES Fédération(nomFede)
);



CREATE TABLE Edition(
   code VARCHAR(50),
   annee VARCHAR(50),
   villeOrganisatrice VARCHAR(50),
   idComité INT NOT NULL,
   idSS INT NOT NULL,
   PRIMARY KEY(code, annee),
   FOREIGN KEY(code) REFERENCES Compétition(code),
   FOREIGN KEY(idComité) REFERENCES Comité(idComité),
   FOREIGN KEY(idSS) REFERENCES StructureSportive(idSS)
);

CREATE TABLE Certificat(
   idCertificat INT AUTO_INCREMENT,
   annee INT NOT NULL,
   numLicence INT NOT NULL,
   PRIMARY KEY(idCertificat),
   FOREIGN KEY(annee) REFERENCES Période(annee),
   FOREIGN KEY(numLicence) REFERENCES Adhérent(numLicence)
);

CREATE TABLE Cours(
   idCours INT AUTO_INCREMENT,
   libellé VARCHAR(50),
   categorieAge VARCHAR(50),
   idEcole INT NOT NULL,
   idEmp INT NOT NULL,
   PRIMARY KEY(idCours),
   FOREIGN KEY(idEcole) REFERENCES Ecole(idEcole),
   FOREIGN KEY(idEmp) REFERENCES Employé(idEmp)
);


CREATE TABLE Séance(
   idCours INT,
   idSeance INT,
   jour VARCHAR(50),
   créneau VARCHAR(50),
   PRIMARY KEY(idCours, idSeance),
   FOREIGN KEY(idCours) REFERENCES Cours(idCours)
);


CREATE TABLE EveilDanse(
   idCours INT,
   PRIMARY KEY(idCours),
   FOREIGN KEY(idCours) REFERENCES Cours(idCours)
);

CREATE TABLE Danse(
   idCours INT,
   catégorie VARCHAR(50),
   idType INT NOT NULL,
   PRIMARY KEY(idCours),
   FOREIGN KEY(idCours) REFERENCES Cours(idCours),
   FOREIGN KEY(idType) REFERENCES typeDanse(idType)
);


CREATE TABLE Zumba(
   idCours INT,
   ambiance VARCHAR(50),
   PRIMARY KEY(idCours),
   FOREIGN KEY(idCours) REFERENCES Cours(idCours)
);

CREATE TABLE travaille(
   idEcole INT,
   idEmp INT,
   annee INT,
   fonction VARCHAR(50),
   PRIMARY KEY(idEcole, idEmp, annee),
   FOREIGN KEY(idEcole) REFERENCES Ecole(idEcole),
   FOREIGN KEY(idEmp) REFERENCES Employé(idEmp),
   FOREIGN KEY(annee) REFERENCES Période(annee)
);

CREATE TABLE participe(
   idGroupe INT,
   code VARCHAR(50),
   annee VARCHAR(50),
   numP INT,
   rangF INT,
   PRIMARY KEY(idGroupe, code, annee),
   FOREIGN KEY(idGroupe) REFERENCES GroupeDanse(idGroupe),
   FOREIGN KEY(code, annee) REFERENCES Edition(code, annee)
);

CREATE TABLE a_participe(
   idCours INT,
   idSeance INT,
   numLicence INT,
   PRIMARY KEY(idCours, idSeance, numLicence),
   FOREIGN KEY(idCours, idSeance) REFERENCES Séance(idCours, idSeance),
   FOREIGN KEY(numLicence) REFERENCES Adhérent(numLicence)
);

CREATE TABLE a_une_influence(
   idType INT,
   idType2 INT,
   PRIMARY KEY(idType, idType2),
   FOREIGN KEY(idType) REFERENCES typeDanse(idType),
   FOREIGN KEY(idType2) REFERENCES typeDanse(idType)
);

CREATE TABLE participe_couple(
idCouple INT AUTO_INCREMENT,
   numLicence1 INT,
   numLicence2 INT,
   code VARCHAR(50),
   annee VARCHAR(50),
   rangF INT,
   PRIMARY KEY(idCouple ,numLicence1,numLicence2),
   FOREIGN KEY(numLicence1) REFERENCES Adhérent(numLicence),
   FOREIGN KEY(numLicence2) REFERENCES Adhérent(numLicence),
   FOREIGN KEY(code, annee) REFERENCES Edition(code, annee)
)
