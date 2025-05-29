<?php
$liste_pays = "";
$id_continent = "";
if($bloc_pays != "") {
    //Ce foreach vérifie quel continent fait partie le pays afin de lui donner comme classe son continent.
    foreach ($bloc_pays as $cle_donnees => $pays) {
        if ($pays['continent']=="Amérique du Nord")
        $id_continent = "amerique_du_nord";
        if ($pays['continent']=="Amérique du Sud")
        $id_continent = "amerique_du_sud";
        if ($pays['continent']=="Afrique")
        $id_continent = "afrique";
        if ($pays['continent']=="Europe")
        $id_continent = "europe";
        if ($pays['continent']=="Asie")
        $id_continent = "asie";
        if ($pays['continent']=="Océanie")
        $id_continent = "oceanie";

        $villes = !empty($pays['villes']) ? explode('||', $pays['villes']) : [];
        $langues = !empty($pays['langues']) ? explode('||', $pays['langues']) : [];
        $organisations = !empty($pays['organisations']) ? explode('||', $pays['organisations']) : [];
        //Si le tableau n'est pas vide, on convertie les chaines dont les éléments sont séparés par par || en tableaux. explode() permet de prendre un tableau et de le découper en morceaux plus petits. Sinon on lui affectera un tableau vide.
        
        $liste_pays .= "<div class='". $id_continent ."'><div class='affichage_pays'><div class='bloc_pays'><div class='drapeau_contain'><img src='".$pays['drapeau']."' alt='drapeau' class='drapeau_pays'></div>".$pays['nom_pays']."</div><div class='menu_pays'><div class='img_drapeau'><img src='".$pays['drapeau']."' alt='drapeau' loading='lazy'></div><h2>".$pays['nom_pays']."</h2><table class='table_infos'><tr><td>Code ISO</td><th>".$pays['Code_ISO']."</th></tr><tr><td>Continent</td><th>".$pays['continent']."</th></tr><tr><td>Capitale</td><th>".$pays['capitale']."</th></tr><tr><td>Population</td><th>".number_format($pays['population_pays'], 0, '', ' ')."</th></tr><tr><td>Superficie</td><th>".number_format($pays['superficie'], 2, '.', ' ')."</th></tr><tr><td>PIB</td><th>".number_format($pays['PIB'], 0, '', ' ')."</th></tr><tr><td>IDH</td><th>". $pays['IDH'] ."</th></tr></table><br><table class='table_infos'><tr><td>Villes :</td><th><ul>"; //number_format formate les nombres avec le nombre de décimales à afficher, le séparateur décimal (le point utilisé comme séparateur entre partie entière et décimale) et le séparateur de milliers (un espace sera utilisé pour séparer les milliers)
        
        // Affichage des villes
        foreach ($villes as $ville) {
            if(!empty($ville)) {
                $liste_pays .= "<li>". $ville ."</li>";
            }
        }
        $liste_pays .= "</ul></th></tr>
                    <tr><td>Langues :</td><th><ul>";
        // Affichage des langues officiels
        foreach ($langues as $langue) {
            if(!empty($langue)) {
                $liste_pays .= "<li>".$langue."</li>";
            }
        }
        
        $liste_pays .= "</ul></th></tr>
                    <tr><td>Organisations Internationales :</td><th><ul>";
        
        // Affichage des organisations internationales
        foreach ($organisations as $org) {
            if(!empty($org)) {
                $liste_pays .= "<li>".$org."</li>";
            }
        }
        
        $liste_pays .= "</ul></th></tr>
                </table>
            </div>
        </div></div>";
    }
}
?>

<!---------------------------------- HTML ---------------------------------->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WORLD DATA</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alef:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="img/favicon.svg" type="image/x-icon">
</head>
<body >
    <header>
        <h1 class="titre_page">WORLD DATA</h1>
        <nav class="header_nav">
            <a href="ranking_page.php">Classement</a>
            <a href="formulaire.php">Formulaire</a>
            <a href="index.php">Retour</a>
        </nav>
    </header>
    <main>
        <div class="section_presentation">
            Ce site présente l'intégralité des pays, villes principales, langues et organisations internationale et leurs attributs qui leurs sont associés:
            <div class="liste_attributs">
                <div>
                    <b>Pays</b>
                    <li>Nom</li>
                    <li>Code ISO 3166-1</li>
                    <li>Capitale</li>
                    <li>Population</li>
                    <li>Superficie</li>
                    <li>Produit intérieur brut (PIB)</li>
                    <li>Indice de développement humain (IDH)</li>
                    <li>Continent</li>
                </div>
                <div>
                    <b>Villes</b>
                    <li>Nom</li>
                    <li>Population</li>
                    <li>Code ISO du pays associé</li>
                    <li>Superficie</li>
                    <li>Statut</li>
                </div>
                <div>
                    <b>Langues</b>
                    <li>Nom</li>
                    <li>Groupe linguistique</li>
                    <li>Nombre locuteurs</li>
                    <li>Alphabet</li>
                </div>
                <div>
                    <b>Organisations</b>
                    <li>Nom court</li>
                    <li>Type</li>
                    <li>Date de création</li>
                    <li>Siège</li>
                    <li>Nom long</li>
                </div>
            </div>
            
        </div>
        <div class="section_données" id="scroll_accueil">
            <h2>Liste des pays</h2>
            <div class="filtres_section">
                <img class="icone" src="https://img.icons8.com/?size=100&id=3720&format=png&color=ffffff" alt="icone_filtre">
                <p>Filtrer par continents : </p>
                <div class="bouton_menu_filtres"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg></div>
                    <div class="filtres_continent">
                        <input type="checkbox" name="europe" id="europe" checked>
                        <label for="europe">Europe</label>
                        <input type="checkbox" name="asie" id="asie" checked>
                        <label for="asie">Asie</label>
                        <input type="checkbox" name="amerique_du_nord" id="amerique_du_nord" checked>
                        <label for="amerique_du_nord">Amérique du Nord</label>
                        <input type="checkbox" name="amerique_du_sud" id="amerique_du_sud" checked>
                        <label for="amerique_du_sud">Amérique du Sud</label>
                        <input type="checkbox" name="afrique" id="afrique" checked>
                        <label for="afrique">Afrique</label>
                        <input type="checkbox" name="oceanie" id="oceanie" checked>
                        <label for="oceanie">Océanie</label>
                    </div>
            </div>
            <div class="presentation_pays">
                <?= $liste_pays ?>
            </div>
    <div class="affichage_sombre"></div>
    <div class="croix_menu">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
    </div>
            <a href="#scroll_accueil" class="boutton_retour">Retour au début</a>
        </div>
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