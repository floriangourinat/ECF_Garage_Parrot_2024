//Initialisation du script js pour faire fonctionner le carousel d'avis clients sur la page d'accueil 

// Attend que le contenu du DOM soit entièrement chargé avant d'exécuter le script
document.addEventListener('DOMContentLoaded', function () {
    var carouselItems = Array.from(document.querySelectorAll('.carousel-item'));
    var prevButton = document.querySelector('.carousel-control-prev');
    var nextButton = document.querySelector('.carousel-control-next');
    var indicators = document.querySelectorAll('.carousel-indicators li');

    var activeIndex = 0;
    var autoScrollInterval = 5000;

    // Fonction pour mettre à jour l'état actif des éléments du carousel et des indicateurs
    function updateCarousel() {
        carouselItems.forEach(function (item, index) {
            item.classList.remove('active');
            if (index === activeIndex) {
                item.classList.add('active');
            }
        });
        updateIndicators();
    }

    // Fonction pour mettre à jour les indicateurs de pagination
    function updateIndicators() {
        indicators.forEach(function(indicator, index) {
            indicator.classList.remove('active');
            if (index === activeIndex) {
                indicator.classList.add('active');
            }
        });
    }

    // Fonction pour avancer au slide suivant
    function moveToNextSlide() {
        activeIndex = (activeIndex + 1) % carouselItems.length;
        updateCarousel();
    }

    // Ajoute un écouteur d'événements sur le bouton précédent
    prevButton.addEventListener('click', function () {
        activeIndex = (activeIndex - 1 + carouselItems.length) % carouselItems.length;
        updateCarousel();
        resetAutoScroll();
    });

    // Ajoute un écouteur d'événements sur le bouton suivant
    nextButton.addEventListener('click', function () {
        moveToNextSlide();
        resetAutoScroll();
    });

    // Ajoute des écouteurs d'événements sur chaque indicateur pour une navigation directe
    indicators.forEach(function(indicator, index) {
        indicator.addEventListener('click', function() {
            activeIndex = index;
            updateCarousel();
            resetAutoScroll();
        });
    });

    // Initialise le défilement automatique
    var autoScroll = setInterval(moveToNextSlide, autoScrollInterval);

    // Fonction pour réinitialiser le défilement automatique
    function resetAutoScroll() {
        clearInterval(autoScroll);
        autoScroll = setInterval(moveToNextSlide, autoScrollInterval);
    }

    // Met à jour le carousel une première fois au chargement de la page
    updateCarousel();
});
