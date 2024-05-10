/**
 * Variables récupérées / renvoyées
 *
 * nonce : jeton de sécurité
 * ajaxurl : adresse URL de la fonction Ajax dans WP
 *
 * categorie_id : n° de la catégorie demandée ou vide si on ne filtre pas par catégorie
 * format_id : n° du format demandé ou vide si on ne filtre pas par format
 * order : ordre de tri Croissant (ASC) ou Décroissant (DEC)
 * orderby : actuellement on trie par la date mais on pourrait éventuellement avoir un autre critère
 * currentPage : page affichée au moment de l'utilisation du script
 * max_pages : page maximum en fonction des filtres
 * nb_total_posts : nombres de photos à afficher
 *
 */

document.addEventListener("DOMContentLoaded", function () {
  const body = document.querySelector("body");
  const allarrowfilters = document.querySelectorAll(".arrowfilters");
  const allSelect = document.querySelectorAll("select");
  const message = "<p>Désolé. Aucun article ne correspond à cette demande.<p>";

  // Initialisation des variables des filtres au premier affichage du site
  let categorie_id = "";
  if (document.getElementById("categorie_id")) {
    document.getElementById("categorie_id").value = "";
  }
  let format_id = "";
  if (document.getElementById("format_id")) {
    document.getElementById("format_id").value = "";
  }
  let order = "";
  if (document.getElementById("date")) {
    document.getElementById("date").value = "";
  }

  let currentPage = 1;
  let max_pages = 1;
  let selectId = "";

  document.getElementById("currentPage").value = 1;

  (function ($) {
      $(document).ready(function () {
          console.log("script js ready")
        $(".option-filter").change(function (e) {
          // Empêcher l'envoi classique du formulaire
          e.preventDefault();

          let max_pages=0;
          if (document.getElementById("filtered_max_pages") !== null) {
            max_pages = document.getElementById("filtered_max_pages").value;
          }
  

          // Récupération des valeurs sélectionnées
          let targetName = e.target.name;
          let targetValue = e.target.value;
          console.log(targetName);
          console.log(targetValue);

          // Réaffectation de la valeur dans la variable correspondante
          if (targetName === "categorie_id") {
            categorie_id = targetValue;
          }
          if (targetName === "format_id") {
            format_id = targetValue;
          }
          if (targetName === "date") {
            order = targetValue;
          }

          let orderby = "date";
          const ajaxurl = $("#ajaxurl").val();
          // Récupération du jeton de sécurité
          const nonce = $("#nonce").val();

          $.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'html',
            data: {
              action: "mota_load",
              categorie_id: categorie_id,
              nonce: nonce,
              paged: 1,
              format_id: format_id,
              orderby: orderby,
              order: order,
            },
            success: function(res) {
              console.log("ajax request succeed");
              $(".publication-list").empty().append(res);
              
               // Récupération de la valeur du nouveau nombre de pages
              let nb_total_posts = 0;

              // Affiche ou cache le bouton "Charger plus" en fonction du nombre de pages
              console.log("currentPage: "+currentPage+" max_pages: "+max_pages);
              if (currentPage >= max_pages) {
                $("#load-more").addClass("hidden");
              } else {
                $("#load-more").removeClass("hidden");
              }

              // Contrôle s'il y a des photos à afficher
              if (document.getElementById("nb_total_posts") !== null) {
                nb_total_posts = document.getElementById("nb_total_posts").value;
              }

              // Et affiche un message s'il n'y a aucune photo à afficher
              if (nb_total_posts == 0) {
                $(".publication-list").append(message);
              }
            },
            error: function(err) {
              console.error(err);
            }
          })

        });
      });
  })(jQuery);


// Réinitialisation des flèches des select si on click en dehors
body.addEventListener("click", (e) => {
  if (e.target.tagName != "select" && e.target.tagName != "SELECT") {
    initArrow();
  }
});

 // Fonction pour rechercher un mot dans une variable
  // retourne vrai si le mot est trouvé, si non retourne false
  function findWord(word, str) {
    return RegExp("\\b" + word + "\\b").test(str);
  }


 // Réinitialisation de l'affichage des flèches sur les select
 const initArrow = () => {
  console.log("Initialisation des fleches");
  allarrowfilters.forEach((arrowfilter) => {
    arrowfilter.classList.add("select-close");
    arrowfilter.classList.remove("select-open");
  });
};

// Passer de la flèche qui descend à la flèqhe qui monte
// et inversement
// et force la flèche qui descend sur les 2 autres selects
const arrow = (arg) => {
  allarrowfilters.forEach((arrowfilter) => {
    if (findWord(arg, arrowfilter.className)) {
      if (
        findWord("select-close", arrowfilter.className) ||
        findWord("select-open", arrowfilter.className)
      ) {
        // initArrow();
        if (findWord("select-close", arrowfilter.className)) {
          arrowfilter.classList.remove("select-close");
          arrowfilter.classList.add("select-open");
        } else {
          arrowfilter.classList.add("select-close");
          arrowfilter.classList.remove("select-open");
        }
      }
    }
  });
};

  // Détection du click sur un select
  // et modification de la flèche correpondante
  allSelect.forEach((select) => {
    select.addEventListener("click", (e) => {
      e.preventDefault();

      // On contrôle si on a clické dans un autre select
      if (select.id != selectId) {
        initArrow();
      }
      selectId = select.id;
      arrow(selectId);
    });
  });


});