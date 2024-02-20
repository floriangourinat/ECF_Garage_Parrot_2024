// Initialisation de l'animation des chiffres sur la page d'accueil pour afficher de manière dynamique les statistiques telles que le pourcentage de clients satisfaits, le nombre de véhicules vendus et le nombre de services fournis

// Définition des valeurs initiales des statistiques 
const satisfiedCustomers = 95; // % de clients satisfaits
const vehiclesSold = 567; // Nombre de véhicules vendus
const servicesProvided = 10456; // Nombre de services offerts

// Animation des chiffres
const updateNumber = (elementId, endNumber, suffix = '') => {
    let startNumber = 0;
    const duration = 5000; // Durée de l'animation en millisecondes
    const interval = 50; // Intervalle de mise à jour du nombre en millisecondes
    const increment = Math.ceil((endNumber - startNumber) / (duration / interval));

    const timer = setInterval(() => {
        startNumber += increment;
        if (startNumber >= endNumber) {
            startNumber = endNumber;
            clearInterval(timer);
        }
        document.getElementById(elementId).textContent = startNumber + suffix;
    }, interval);
};

// Lance l'animation pour chaque statistique
updateNumber('satisfied-customers', satisfiedCustomers, '%');
updateNumber('vehicles-sold', vehiclesSold);
updateNumber('services-provided', servicesProvided);
