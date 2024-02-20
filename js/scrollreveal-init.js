// Initialisation de ScrollReveal avec des options spécifiques pour différents types d'éléments 


// Révélation des éléments avec la classe 'scroll-top' en provenance du haut
ScrollReveal().reveal('.scroll-top', {
    delay: 100,
    duration: 600,
    easing: 'ease-in-out',
    origin: 'top',
    distance: '20px',
    interval: 100
});


// Révélation des éléments avec classe 'scroll-bottom' en provenance du bas
ScrollReveal().reveal('.scroll-bottom', {
    delay: 100,
    duration: 600,
    easing: 'ease-in-out',
    origin: 'bottom',
    distance: '20px',
    interval: 100
});

// Révélation des éléments avec classe 'scroll-left' en provenance de la gauche
ScrollReveal().reveal('.scroll-left', {
    delay: 100,
    duration: 600,
    easing: 'ease-in-out',
    origin: 'left',
    distance: '20px',
    interval: 100
});

// Révélation des éléments avec classe 'scroll-right' en provenance de la droite
ScrollReveal().reveal('.scroll-right', {
    delay: 100,
    duration: 600,
    easing: 'ease-in-out',
    origin: 'right',
    distance: '20px',
    interval: 100
});
