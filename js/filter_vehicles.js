/*
Ce script JavaScript permets la manipulation des sliders à l'aide de la bibliothèque noUiSlider.
Il permet de créer des sliders interactifs pour filtrer les données affichées sur les véhicules.

Il initialise les sliders, ajoute des étiquettes de valeur correspondantes, applique les filtres en fonction des valeurs des sliders et des sélections de l'utilisateur,
et ajoute des écouteurs d'événements pour détecter les changements dans les filtres et les sliders, et appliquer les filtres en conséquence.
*/

document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des sliders
    var priceSlider = document.getElementById('price-slider');
    var mileageSlider = document.getElementById('mileage-slider');
    var yearSlider = document.getElementById('year-slider');

    // Fonction pour créer un slider
    function createSlider(sliderElement, labelElement) {
        var min = parseFloat(sliderElement.dataset.min);
        var max = parseFloat(sliderElement.dataset.max);

        noUiSlider.create(sliderElement, {
            start: [min, max],
            connect: true,
            range: {
                'min': min,
                'max': max
            },
            // Cette option force les valeurs à être des entiers
            step: 1
        });

        // Ajoute les étiquettes de valeur
        var sliderValues = [
            labelElement.querySelector('.min-value'),
            labelElement.querySelector('.max-value')
        ];

        sliderElement.noUiSlider.on('update', function(values, handle) {
            // Utilisation de Math.round pour arrondir les valeurs et les convertir en chaîne sans décimales
            sliderValues[handle].innerHTML = Math.round(values[handle]);
        });
    }

    // Création des sliders pour prix, kilométrage, et année
    createSlider(priceSlider, document.getElementById('price-label'));
    createSlider(mileageSlider, document.getElementById('mileage-label'));
    createSlider(yearSlider, document.getElementById('year-label'));

    // Fonction pour appliquer les filtres
    function applyFilters() {
        var selectedBrand = document.getElementById('filterMake').value;
        var selectedModel = document.getElementById('filterModel').value;
        var priceValues = priceSlider.noUiSlider.get();
        var mileageValues = mileageSlider.noUiSlider.get();
        var yearValues = yearSlider.noUiSlider.get();

        document.querySelectorAll('.vehicle-card').forEach(function(card) {
            var brand = card.getAttribute('data-make');
            var model = card.getAttribute('data-model');
            var price = parseFloat(card.getAttribute('data-price'));
            var mileage = parseFloat(card.getAttribute('data-mileage'));
            var year = parseInt(card.getAttribute('data-year'));

            var show = (!selectedBrand || brand === selectedBrand) &&
                       (!selectedModel || model === selectedModel) &&
                       price >= parseFloat(priceValues[0]) && price <= parseFloat(priceValues[1]) &&
                       mileage >= parseFloat(mileageValues[0]) && mileage <= parseFloat(mileageValues[1]) &&
                       year >= parseInt(yearValues[0]) && year <= parseInt(yearValues[1]);

            card.style.display = show ? '' : 'none';
        });
    }

    // Écouteurs d'événements pour les changements de filtres
    document.getElementById('filterMake').addEventListener('change', applyFilters);
    document.getElementById('filterModel').addEventListener('change', applyFilters);
    priceSlider.noUiSlider.on('update', applyFilters);
    mileageSlider.noUiSlider.on('update', applyFilters);
    yearSlider.noUiSlider.on('update', applyFilters);

    // Applique les filtres au chargement de la page
    applyFilters();
});
