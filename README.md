# Projet d'application de Gestion d'Écoles de Danse et de Compétitions

## BDance

Bienvenue dans l'application de gestion dédiée aux écoles de danse et aux compétitions de danse. Cette plateforme offre des fonctionnalités complètes pour la gestion des écoles, de leurs employés, des adhérents, des cours, des fédérations, des comités, des membres et des compétitions.

## Présentation du Projet

Ce projet a été développé en utilisant le modèle MVC (Modèle-Vue-Contrôleur) avec les technologies suivantes :
- HTML, CSS pour la structure et la présentation du site.
- PHP pour la logique côté serveur et l'interaction avec la base de données.
- SQL pour les requêtes dans les fonctions PHP.

## Modélisation de la Base de Données

L'application repose sur une base de données complète modélisée selon les spécifications suivantes :
- Gestion des écoles de danse avec leurs salles et informations détaillées.
- Suivi des employés avec leurs rôles et périodes d'affectation.
- Adhérents inscrits aux cours avec des informations personnelles et médicales.
- Fédérations, comités régionaux et départementaux, ainsi que leurs relations.
- Compétitions avec des détails sur les éditions, les structures sportives et les participations des adhérents.

## Mise en Place de la Base de Données

Le processus de construction de la base de données comprend les étapes suivantes :
1. Production d'un schéma Entité/Association. 
2. Génération du modèle relationnel dérivé.
3. Création du script SQL pour la création de la base de données. 
4. Intégration des données fournies dans la base de données.

Pour plus de détails, vous pouvez consulter le schéma Entité/Association ainsi que le script SQL inclus dans le projet

## Fonctionnalités

### Page d'accueil et statistiques

#### Statistiques générales :
- Affichage du nombre de fédérations, de comités régionaux et de comités départementaux stockés dans la base 
- Affichage du nombre d'écoles par code de département français.

#### Listes et classements :
- Liste des comités régionaux de la Fédération Française de Danse, triée par ordre alphabétique inverse.
- Top 5 des écoles françaises avec le plus grand nombre d'adhérents en 2022 (nom, ville, nombre d'adhérents).

### Fonctionnalités de base

- Affichage d'un résultat simple d'une requête.
- Affichage d'un résultat tabulaire d'une requête.
- Ajout d'un élément dans la base.
- Modification d'un n-uplet en base.
- Suppression d'un n-uplet en base.

### Tableau de bord d'une école de danse

#### Informations générales :
- Nom et adresse de l'école.
- Liste des employés.
- Nombre d'adhérents pour l'année en cours.
- Liste des cours proposés dans l'école.
- Nombre d'adhérents ayant participé à une compétition.

#### Page de gestion associées :
- Gestion des cours

### Tableau de bord d'une fédération

#### Informations générales :
- Nom, sigle, niveau de l'instance (nationale ou internationale), et adresse de la fédération.
- Nombre de comités.
- Nombre de membres de la fédération.
- Liste des compétitions organisées par la fédération.
- Nombre d'adhérents ayant participé à une compétition.
#### Pages de gestion associées

##### Gestion des informations des comités

Sur cette page, l'utilisateur peut :

- Visualiser le nom, le niveau de l'instance (régionale ou départementale), et le nom du président ou de la présidente des comités.
- Modifier les informations existantes.
- Ajouter un nouveau comité.
- Rattacher un comité à la fédération.

##### Gestion des compétitions

Sur cette page, l'utilisateur peut :

- Sélectionner une compétition.
- Visualiser le nom et la liste des éditions de la compétition sélectionnée.
- Modifier les informations relatives à la compétition.
- Ajouter une nouvelle compétition.
- Modifier les informations relatives à une édition, y compris sur la structure sportive accueillant l'événement.
- Ajouter une nouvelle édition.
- Supprimer une édition.
- Supprimer une compétition.
- Inscrire un couple ou un groupe de danseurs à une édition de compétition.
- Affecter un rang à un couple ou un groupe de danseurs lors d'une édition.

## Auteurs
FERREIRA Rémi, ATAMNA Miryam
