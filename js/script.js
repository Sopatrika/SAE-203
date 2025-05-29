window.addEventListener("load", () => {
  window.scrollTo(0,0);
}) //Lorsque la page se recharge, le scroll revient au tout début de la page

// Fonction opacité header et déplacement du titre en fonction du scroll
const header = document.querySelector('header') //variable header
const titre_position = document.querySelector('.titre_page') //variable titre
const delay_scroll = 100;
window.addEventListener('scroll', () => { //déclenche une fonction lorsqu'on scroll
    if(scrollY > delay_scroll) { //Si le scroll en Y est supérieur à 150px
        header.classList.add('header-transparent') //Ajoute une classe pour rendre opaque le header
        titre_position.classList.add('titre_moved') //Ajoute une classe pour déplacer le titre
    }
    else {
        header.classList.remove('header-transparent') //Enleve la classe
        titre_position.classList.remove('titre_moved') //Enleve la classe
    }
})

//Menu déroulant pour ouvrir le filtrage
const menu_filtres = document.querySelector(".bouton_menu_filtres");
menu_filtres.addEventListener("click", function() {
  document.querySelector(".filtres_continent").classList.toggle("filtres_continent_open");
  document.querySelector(".bouton_menu_filtres").classList.toggle("bouton_menu_filtres_open");
})

//filtrage par continent
document.querySelectorAll(".filtres_continent > input").forEach(input => {
  input.addEventListener("change", function() { //Se déclenche lorsqu'il y'a une changement
    document.querySelector(".presentation_pays").classList.toggle(this.name); //identifie les blocs pays par le name
  });
});


//Permet d'ajuster les dimensions des drapeaux présent dans les bloc pays
document.querySelectorAll('.drapeau_pays').forEach(img => {
    // Fonction de traitement du drapeau
    function traiterDrapeau() {
        const ratio = img.naturalWidth / img.naturalHeight; //largeur du drapeau divisé par la hauteur
        if (ratio < 1.1) { //Si le ratio du drapeau est inférieur à 1.1 comme celui du Népal
            img.style.objectFit = 'contain'; //Remplit sans etre déformé
            img.style.backgroundColor = '#ececec'; //Ajoute un fond blanc
        } else {
            img.style.objectFit = 'fill'; //Remplit en étant déformé
        }
    }
    // Si l'image est déjà chargée (en cas du rechargement)
    if (img.complete) {
        traiterDrapeau();
    }
    // Dans tous les cas, on garde le onload pour les nouveaux chargements
    img.onload = traiterDrapeau;
});

const affichage_gray = document.querySelector('.affichage_sombre'); //div sombre qui recouvre tout l'écran
const croix = document.querySelector('.croix_menu'); //croix pour fermer un menu
// Fonction menu affichage des données
document.querySelectorAll('.bloc_pays').forEach(bloc => {
  bloc.addEventListener('click', function() {
      // Trouve le menu_pays correspondant dans le même affichage_pays
      const affichage_donnees = this.closest('.affichage_pays').querySelector('.menu_pays'); //sélectionne le menu qui a été cliqué
      affichage_donnees.classList.add('menu_pays_open');
      affichage_donnees.appendChild(croix); // Positionne la croix dans le menu actif
      affichage_gray.classList.add('affichage_sombre_open');
      croix.classList.add('croix_menu_open');
      document.body.style.overflow = 'hidden'; //désactive le défilement
  });
});
  //Fonction qui ferme le menu déroulant
  affichage_gray.addEventListener('click', fermerMenu);
  croix.addEventListener('click', fermerMenu);
  function fermerMenu() {
    document.querySelectorAll('.menu_pays').forEach(fermer => {
      fermer.classList.remove('menu_pays_open');
      croix.classList.remove('croix_menu_open');
      document.body.appendChild(croix); //Enlève la croix du menu
    });
    affichage_gray.classList.remove('affichage_sombre_open');
    document.body.style.overflow = ''; //réactive le défilement
};


