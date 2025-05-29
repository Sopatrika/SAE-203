<?php 
require "modele.php";
$resultat = "";
$erreur = "";

// Initialisation des variables
if(!empty($_POST["nom"])) //Initialise nom
  $formu_nom = $_POST["nom"];
else
$formu_nom = '';

if(!empty($_POST["code_iso"])) //Initialise Code_ISO
  $formu_code_iso = $_POST["code_iso"]; 
else
$formu_code_iso = '';

if(!empty($_POST["capitale"])) //Initialise capitale
  $formu_capitale = $_POST["capitale"];
else
  $formu_capitale = '';

if(!empty($_POST["population"]))//Initialise population
  $formu_population = $_POST["population"];
else
  $formu_population = '';
if(!empty($_POST["superficie"])) //Initialise superficie
  $formu_superficie = $_POST["superficie"];
else
  $formu_superficie = ''; 
if(!empty($_POST["PIB"])) //Initialise PIB
  $formu_PIB = $_POST["PIB"];
else
  $formu_PIB = '';
if(!empty($_POST["IDH"])) //Initialise IDH
  $formu_IDH = $_POST["IDH"];
else
  $formu_IDH = '';
if(!empty($_POST["drapeau"]))
  $formu_drapeau = $_POST["drapeau"];
else
  $formu_drapeau = '';

if(!empty($_POST["continent"]))
  $formu_continent = $_POST["continent"];
else
  $formu_continent = array(); //Tableau car on peut choisir plusieurs continents

$verif_ISO = Verification_codeISO(); //fonction pour vérifier que le Code ISO (identifiant) ne soit pas identique à un autre

// Le résultat du traitement est enregistré dans $resultat
if (isset($_POST["clic"]))    // Si le formulaire a été validé
{
  // Traitement de la civilité
  if (empty($formu_nom)) //Si nom est vide
    $erreur = "Veuillez indiquer le nom de pays <br>";
  
  // Traitement de la désignation
  if (empty($formu_code_iso)) //Si Code_ISO est vide
    $erreur .= "Veuillez indiquer le code ISO du pays <br>";

  foreach ($verif_ISO as $iso) { //Vérification pour éviter de mettre le même code ISO (identifiant) qu'un autre
    if ($iso['code_ISO'] === $formu_code_iso) { //Vérifie pour chaque pays si le code ISO renseigné est identique à un autre.
      $erreur .= "Le code ISO ne peut pas être le même que celui d'un autre pays <br>";
    }
  }
 
  if (empty($formu_capitale)) //Si capitale est vide
    $erreur .= "Veuillez indiquer la capitale du pays <br>";
  
  if (empty($formu_population) && !is_numeric($formu_population))//Si population n'est pas vide et numérique
    $erreur .= "Veuillez indiquer la population du pays<br>";

    if (empty($formu_PIB) && !is_numeric($formu_PIB)) //Si PIB n'est pas vide et numérique
    $erreur .= "Veuillez indiquer le du pays<br>";

    if (!is_numeric($formu_IDH) && $formu_IDH <= 0 && $formu_IDH >= 1 && empty($formu_PIB)) //Si population est numérique, entre 0 et 1 ou est null.
    $erreur .= "Veuillez indiquer une valeur numérique pour l'HDI du pays <br>";

    if (empty($formu_drapeau)) //Si drapeau est vide
    $erreur .= "Veuillez indiquer l'URL du drapeau du pays du pays <br>";

    if (empty($formu_continent)) //Si continent est vide
    $erreur .= "Veuillez inclure au moins un continent <br>";

  if (empty($erreur)) // Si aucune erreur : enregistrement du pays
  {
    $continent = is_array($formu_continent) ? implode(',', $formu_continent) : $formu_continent; //Si continent est un tableau, on converti le tableau composé des continents choisi en chaîne séparée par des virgules avec implode.
    $requete = "INSERT INTO pays (Code_ISO, nom_pays, continent, capitale, population_pays, superficie, PIB, IDH, drapeau) VALUES ('$formu_code_iso', '$formu_nom', '$continent', '$formu_capitale', '$formu_population', '$formu_superficie', '$formu_PIB', '$formu_IDH', '$formu_drapeau')";
    // envoie de la requete SQL afin d'intégrer le pays.
    $nb_ecriture = InscrirePays($requete);
    if ($nb_ecriture == 1) //Si l'enregistrement a réussi
      $resultat = "<h3 class='resultat'>$formu_nom a été enregistré dans la base de données</h3>";
    else
      $erreur = "Echec lors de l'enregistrement du Pays";
  }
}?>

<!---------------------------------- HTML ---------------------------------->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire pour intégrer un pays</title>
    <link rel="stylesheet" href="styles/style_formulaire.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alef:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="img/logo.svg" type="image/x-icon">
</head>
<body>
    <header>
        <nav class="header_nav">
            <a href="ranking_page.php">Classement</a>
            <a href="formulaire.php">Formulaire</a>
            <a href="index.php">Retour</a>
        </nav>
    </header>
    <h1 class="Titre_page">FORMULAIRE</h1>
<main>
    <p>Cette page permet d'ajouter un nouveau pays avec les attributs qui lui sont associés. Veillez remplir toute les renseignements du pays avec des données cohérentes.</p>
    <div><?php if (!empty($erreur)): ?> <!-- Si il y'a une erreur -->
            <div class="erreur"><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='#ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z'></path><line x1='12' y1='9' x2='12' y2='13'></line><line x1='12' y1='17' x2='12.01' y2='17'></line></svg><?= $erreur ?></div>
        <?php endif;?></div>
    <div><?= $resultat ?></div>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="section_formulaire">
        <div class="input_formulaire">
            <label for="" class="label_formulaire">Nom <span class="etoile">*</span></label>
            <input type="text" placeholder="nom" name="nom" required>
        </div>
        <div class="input_formulaire">
            <label for="" class="label_formulaire">Code ISO (3 Lettres) <span class="etoile">*</span></label>
            <input type="text" placeholder="Code ISO" name="code_iso" required>
        </div>
        <div class="input_formulaire">
            <label for="" class="label_formulaire">Capitale <span class="etoile">*</span></label>
            <input type="text" placeholder="capitale" name="capitale" required>
        </div>
        <div class="input_formulaire">
            <label for="" class="label_formulaire">Population <span class="etoile">*</span></label>
            <input type="number" min="0.000" placeholder="Population" name="population" required>
        </div>
        <div class="input_formulaire">
            <label for="" class="label_formulaire">Superficie <span class="etoile">*</span></label>
            <input type="number" min="0.000" placeholder="Superficie" name="superficie" required>
        </div>
        <div class="input_formulaire">
            <label for="" class="label_formulaire">PIB <span class="etoile">*</span></label>
            <input type="number" min="1" placeholder="PIB" name="PIB" required>
        </div>
        <div class="input_formulaire">
            <label for="" class="label_formulaire">IDH <span class="etoile">*</span></label>
            <input type="number" min="0.000" max="1" step="0.001" name="IDH" placeholder="IDH">
        </div>
        <div class="input_formulaire">
            <label for="" class="label_formulaire">Drapeau (lien)<span class="etoile">*</span></label>
            <input type="text" placeholder="URL du drapeau" name="drapeau" required>
        </div>
        <!-- Choix Continent -->
        <div class="input_formulaire_continent">
            <input type="checkbox" id="europe" value="Europe" name="continent[]" class="input_continent">
            <label for="europe" class="label_continent">Europe</label>

            <input type="checkbox" id="asie" value="Asie" name="continent[]" class="input_continent">
            <label for="asie" class="label_continent">Asie</label>

            <input type="checkbox"id="amerique_du_nord" value="Amérique du Nord" name="continent[]" class="input_continent">
            <label for="amerique_du_nord" class="label_continent">Amérique du Nord</label>
            
            <input type="checkbox" id="amerique_du_sud" value="Amérique du Sud" name="continent[]" class="input_continent">
            <label for="amerique_du_sud" class="label_continent">Amérique du Sud</label>

            <input type="checkbox" id="afrique" value="Afrique" name="continent[]" class="input_continent">
            <label for="afrique" class="label_continent">Afrique</label>
            
            <input type="checkbox" id="oceanie" value="Océanie" name="continent[]" class="input_continent">
            <label for="oceanie" class="label_continent">Océanie</label>
        </div>
        <div class="input_formulaire">
            <input type="submit" name="clic" value="Inscrire">
        </div>
    </form>
</main>
<footer>
        <h2>WORLD DATA</h2>
            <div><a href="ranking_page.php">Classement</a></div>
            <div><a href="formulaire.php">Formulaire</a></div>
            <div><a href="index.php">Retour</a></div>
            créateur du site : Dimitri KNYAZEV
            <a href="https://www.linkedin.com/in/dimitri-knyazev-77754132b/" target="_blank"><svg class="icone" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#ffffff"><path d="M22.23 0H1.77C.8 0 0 .77 0 1.72v20.56C0 23.23.8 24 1.77 24h20.46c.98 0 1.77-.77 1.77-1.72V1.72C24 .77 23.2 0 22.23 0zM7.27 20.1H3.65V9.24h3.62V20.1zM5.47 7.76h-.03c-1.22 0-2-.83-2-1.87 0-1.06.8-1.87 2.05-1.87 1.24 0 2 .8 2.02 1.87 0 1.04-.78 1.87-2.05 1.87zM20.34 20.1h-3.63v-5.8c0-1.45-.52-2.45-1.83-2.45-1 0-1.6.67-1.87 1.32-.1.23-.11.55-.11.88v6.05H9.28s.05-9.82 0-10.84h3.63v1.54a3.6 3.6 0 0 1 3.26-1.8c2.39 0 4.18 1.56 4.18 4.89v6.21z"/></svg></a>
    </footer>
   <script src="js/script.js"></script>
</body>
</html>