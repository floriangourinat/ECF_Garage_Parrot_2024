// Fonction pour réinitialiser tous les filtres de recherche à leurs valeurs par défaut 
function resetFilters() {
    // Réinitialise les éléments select à la valeur par défaut
    document.getElementById('filterMake').value = '';
    document.getElementById('filterModel').value = '';
    
    // Réinitialise les éléments noUiSlider aux valeurs par défaut
    var priceSlider = document.getElementById('price-slider');
    var mileageSlider = document.getElementById('mileage-slider');
    var yearSlider = document.getElementById('year-slider');
    
    if (priceSlider && priceSlider.noUiSlider) {
        priceSlider.noUiSlider.set([priceSlider.getAttribute('data-min'), priceSlider.getAttribute('data-max')]);
    }
    if (mileageSlider && mileageSlider.noUiSlider) {
        mileageSlider.noUiSlider.set([mileageSlider.getAttribute('data-min'), mileageSlider.getAttribute('data-max')]);
    }
    if (yearSlider && yearSlider.noUiSlider) {
        yearSlider.noUiSlider.set([yearSlider.getAttribute('data-min'), yearSlider.getAttribute('data-max')]);
    }
    
    // Réapplique les filtres après la réinitialisation pour mettre à jour l'affichage
    applyFilters();
}

// Attache la fonction resetFilters au bouton de réinitialisation lors du chargement du document
document.addEventListener('DOMContentLoaded', function() {
    var resetButton = document.getElementById('resetFilters');
    if (resetButton) {
        resetButton.addEventListener('click', resetFilters);
    }
});
