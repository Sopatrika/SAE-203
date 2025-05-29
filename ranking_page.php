<?php
require "modele.php";

$liste = ""; //va accueilir toute les données
$liste_attributs = ""; //nom des colonnes du tableau
$liste_entite = ""; //données du tableau
$options = ""; //rempli la balise select pour $choix2
$titre_class = ""; //Titre du classement

// Initialisation des variables
if(isset($_REQUEST["choix"])) { //$_REQUEST combine $_GET et $_POST
    $choix = $_GET["choix"];
} else
$choix = ""; // Valeur par défaut

if(!empty($_POST["choix2"])) //Si choix2 est vide
  $choix2 = $_POST["choix2"];
else
$choix2  = ""; // Valeur par défaut
if(!empty($_POST["ordre"])) //Si ordre est vide
  $ordre = $_POST["ordre"];
else
$ordre = ""; // Valeur par défaut

// Définition des colonnes par défaut selon la table (Si on clique par exemple sur Pays, choix2 sera par défaut nom_pays si on n'a pas choisi une autre option). Le titre sera également initialisé en fonction de la table choisi.
if ($choix == "pays") {
    $titre_class = "Classement des pays";
    if (empty($choix2))
    $choix2 = "nom_pays";
} elseif ($choix == "villes") {
    $titre_class = "Classement des villes";
    if (empty($choix2))
    $choix2 = 'nom_ville';
} elseif ($choix == "langues") {
    $titre_class = "Classement des langues";
    if (empty($choix2))
    $choix2 = 'nom_langue';
} elseif ($choix == "organisations_internationales") {
    $titre_class = "Classement des organisations internationales";
    if (empty($choix2))
    $choix2 = 'nom_court';
}

if($choix){
 $liste = Classement($choix, $choix2, $ordre);//Envoie la requete SQL
 
 if(!empty($liste)) { //On rempli la balise select et les titres des colonnes du tableau avec les clés
    foreach (array_keys($liste[0]) as $key) {
        if ($key !== 'drapeau' && $key !== 'id_ville') { //On exclue 'drapeau' et 'id_ville'
            // Pour les <option>
            $selected = ($key === $choix2) ? ' selected' : ''; // Si cette clé correspond à $choix2, on ajoute l'attribut 'selected' sinon on ne met rien
            $options .= '<option value="' . $key . '"' . $selected . '>' . $key . '</option>';
            //Remplir les titres des colonnes du tableau
            $liste_attributs .= '<th>' . $key . '</th>';
        }
    }
    //Remplir la table avec les données
    foreach ($liste as $row) {
        $liste_entite .= "<tr class='table_infos'>";
        foreach ($row as $key => $value) {
            if ($key !== 'drapeau' && $key !== 'id_ville') {// On exclue 'drapeau' et 'id ville'
                $liste_entite .= "<td>" . $value . "</td>";
        }
    }
    $liste_entite .= "</tr>";
}
}
}
else {
    $titre_class = "Veillez choisir une catégorie";
}
?>

<!---------------------------------- HTML ---------------------------------->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement
        <?php if (!empty($choix)): ?>
            <?= "des " . $choix ?>
            <?php endif; ?> 
    </title>
    <link rel="stylesheet" href="styles/ranking.css">
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
    <h1 class="Titre_page">CLASSEMENT</h1>
    <main class="interface_liste_pays" id="scroll_accueil">
        <?php if (!empty($titre_class)): ?>
            <h2><?= $titre_class ?></h2>
        <?php endif;?>
        <div class="choix_table">
        <a href="ranking_page.php?choix=pays" class="table-label" id="btn-pays">Pays</a>
        <a href="ranking_page.php?choix=villes" class="table-label" id="btn-villes">Villes</a>
        <a href="ranking_page.php?choix=langues" class="table-label"  id="btn-langues">Langues</a>
        <a href="ranking_page.php?choix=organisations_internationales" class="table-label"  id="btn-organisations_internationales">Organisations</a>
        </div>

        <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>?choix=<?= $choix ?>" class="filtres">
            <img class="icone" src="https://img.icons8.com/?size=100&id=3720&format=png&color=ffffff" alt="icone_filtre">
        <input type="hidden" name="choix" value="<?= $choix ?>">
            <select class="select_option" name="choix2" id="choix2">
                <?= $options ?>
            </select>
        </div>
            <select class="select_option" name="ordre" id="ordre">
                <option value="ASC" <?php 
              if ($ordre == "ASC") 
                echo "selected";
            ?>>Croissant</option>
                <option value="DESC" 
                <?php if ($ordre == "DESC") 
                echo "selected";?>
                >Décroissant</option>
            </select>
            <div class="submit_hover" type="submit"><button class="table-label ranking_submit" type="submit" value="Valider">Valider</button></div>
            </form>
            <h3><?php $titre?></h3>
        <table class="table_donnees">
            <thead>
                <tr class="table_objets">
                    <?= $liste_attributs ?>
                </tr>
            </thead>
            <tbody>
                <?= $liste_entite?>
            </tbody>
        </table>
        <a href="#scroll_accueil" class="boutton_retour">Retour au début</a>
    </main>
    <footer>
        <h2>WORLD DATA</h2>
            <div><a href="ranking_page.php">Classement</a></div>
            <div><a href="formulaire.php">Formulaire</a></div>
            <div><a href="index.php">Retour</a></div>
            créateur du site : Dimitri KNYAZEV
            <a href="https://www.linkedin.com/in/dimitri-knyazev-77754132b/" target="_blank"><svg class="icone" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#ffffff"><path d="M22.23 0H1.77C.8 0 0 .77 0 1.72v20.56C0 23.23.8 24 1.77 24h20.46c.98 0 1.77-.77 1.77-1.72V1.72C24 .77 23.2 0 22.23 0zM7.27 20.1H3.65V9.24h3.62V20.1zM5.47 7.76h-.03c-1.22 0-2-.83-2-1.87 0-1.06.8-1.87 2.05-1.87 1.24 0 2 .8 2.02 1.87 0 1.04-.78 1.87-2.05 1.87zM20.34 20.1h-3.63v-5.8c0-1.45-.52-2.45-1.83-2.45-1 0-1.6.67-1.87 1.32-.1.23-.11.55-.11.88v6.05H9.28s.05-9.82 0-10.84h3.63v1.54a3.6 3.6 0 0 1 3.26-1.8c2.39 0 4.18 1.56 4.18 4.89v6.21z"/></svg></a>
    </footer>

    <script src="js/classement.js"></script>
    <script src="js/script.js"></script>
</script>
</body>
</html>