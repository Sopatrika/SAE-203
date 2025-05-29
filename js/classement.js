
  function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
    //Recherche dans l'URL
  }

  document.addEventListener('DOMContentLoaded', function() { //Lorsque la page se charge
    const choix = getQueryParam('choix'); //Appele la fonction pour rechercher choix dans l'URL
    if (choix) {
      document.querySelectorAll(".table-label").forEach(el => {
        el.classList.remove('bouton_active'); //Retire la classe à tous les boutons si un bouton avait été cliqué auparavant.
      });
      const boutonId = 'btn-' + choix; //Donne à l'ID btn- + choix dans l'URL
      const boutonActif = document.getElementById(boutonId); //Identifie depuis l'ID le bouton
      if (boutonActif) {
        boutonActif.classList.add('bouton_active'); //Donne la classe au bouton cliqué
      }
    }
  });
