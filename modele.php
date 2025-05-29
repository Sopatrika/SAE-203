<?php 
function connexionBDD()
{
try // Connexion à la base de données
{
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
$database = new PDO('mysql:host=localhost;dbname=sae203', 'root', '', $options);
}
catch(Exception $err)
{
die('Erreur connexion MySQL : ' . $err->getMessage());
}
return $database;
}

function lectureBDD($requete)
{
  $bdd=connexionBDD(); // Connexion à la base de données
$reponse=$bdd->query($requete); // Envoi de la requête SQL
// Lecture de toutes les lignes de la réponse dans un tableau associatif
$tableau=$reponse->fetchAll(PDO::FETCH_ASSOC);
$bdd=null; // Fin de la connexion
return $tableau; // Renvoi du tableau associatif
}

function listePays() //Requete pour la liste des pays du monde
  { return lectureBDD("SELECT pays.Code_ISO, pays.nom_pays, pays.continent, pays.capitale, pays.population_pays, pays.superficie, pays.PIB, pays.IDH, pays.drapeau,
    (
        SELECT GROUP_CONCAT(DISTINCT v.nom_ville SEPARATOR '||')
        FROM villes v
        WHERE v.Code_ISO = pays.Code_ISO
    ) AS villes,
    (
        SELECT GROUP_CONCAT(DISTINCT l.nom_langue SEPARATOR '||')
        FROM parler p
        JOIN langues l ON p.nom_langue = l.nom_langue
        WHERE p.Code_ISO = pays.Code_ISO
    ) AS langues,
    (
        SELECT GROUP_CONCAT(DISTINCT oi.nom_court SEPARATOR '||')
        FROM appartenir a
        JOIN organisations_internationales oi ON a.nom_court = oi.nom_court
        WHERE a.Code_ISO = pays.Code_ISO
    ) AS organisations
FROM pays
ORDER BY pays.nom_pays, villes ASC;");} //GROUP_CONCAT permet de concatener les données en une seule chaine de tableau séparée par des || pour éviter d'avoir des répétitions.

function Classement($choix, $choix2, $ordre) //Requete pour le classement des données. $choix correspond à la table, $choix2 correspond à la clé choisi pour comparer les données et $ordre est l'ordre alphabétique choisi (ASC ou DESC).
{
  return lectureBDD("SELECT * FROM `$choix` ORDER BY `$choix2` $ordre");
}

function Verification_codeISO() { //Requete pour vérifier que le Code ISO écrit dans le formulaire n'est pas similaire à celui d'un pays existant
  return lectureBDD("SELECT code_ISO FROM pays;");
}

function InscrirePays($requete)
{
  $bdd=connexionBDD(); // Connexion à la base de données
  $nb=$bdd->exec($requete); // Exécution de la requête SQL
  return $nb;
}
?>