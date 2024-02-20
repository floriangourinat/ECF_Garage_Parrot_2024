-- Création d'une nouvelle table pour stocker les informations sur les véhicules d'occasions du garage nommée "vehicles"
CREATE TABLE vehicles (
  -- Un identifiant unique pour chaque véhicule, qui s'incrémente automatiquement.
  -- Ce champ est essentiel pour assurer l'unicité de chaque enregistrement de véhicule.
  id INT(11) NOT NULL AUTO_INCREMENT,
  
  -- La marque du véhicule.
  -- Ce champ est optionnel et peut être laissé vide.
  brand VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- Le modèle du véhicule.
  -- Ce champ est optionnel et peut être laissé vide.
  model VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- L'année de fabrication du véhicule.
  -- Ce champ est optionnel et peut être laissé vide.
  year INT(11) DEFAULT NULL,
  
  -- Le kilométrage du véhicule.
  -- Ce champ est optionnel et peut être laissé vide.
  mileage INT(11) DEFAULT NULL,
  
  -- Le prix du véhicule.
  -- Ce champ est optionnel et peut être laissé vide.
  price DECIMAL(10,2) DEFAULT NULL,
  
  -- L'état du véhicule (neuf, occasion, etc.).
  -- Ce champ est optionnel et peut être laissé vide.
  condition VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- La puissance du moteur du véhicule.
  -- Ce champ est optionnel et peut être laissé vide.
  power INT(11) DEFAULT NULL,
  
  -- Le type de transmission du véhicule (automatique, manuelle).
  -- Ce champ est optionnel et peut être laissé vide.
  transmission VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- Le type de carburant utilisé par le véhicule.
  -- Ce champ est optionnel et peut être laissé vide.
  fuel VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- La consommation de carburant du véhicule.
  -- Ce champ est optionnel et peut être laissé vide.
  consumption VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- Indique si le véhicule est équipé d'un système de navigation.
  -- 0 pour non et 1 pour oui. Ce champ est optionnel.
  navigation TINYINT(1) DEFAULT NULL,
  
  -- Indique si le véhicule est équipé de sièges chauffants.
  -- 0 pour non et 1 pour oui. Ce champ est optionnel.
  heated_seats TINYINT(1) DEFAULT NULL,
  
  -- Le statut du changement d'huile du véhicule.
  -- Ce champ est optionnel et peut être laissé vide.
  oil_change VARCHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- Le statut du contrôle technique du véhicule.
  -- Ce champ est optionnel et peut être laissé vide.
  technical_control VARCHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- Indique si le véhicule est sous garantie.
  -- 0 pour non et 1 pour oui. Ce champ est optionnel.
  warranty TINYINT(1) DEFAULT NULL,
  
  -- Le nombre de portes du véhicule.
  -- Ce champ est optionnel et peut être laissé vide.
  number_doors INT(11) DEFAULT NULL,
  
  -- La couleur du véhicule.
  -- Ce champ est optionnel et peut être laissé vide si l'information n'est pas disponible.
  color VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- L'URL de la photo du véhicule.
  -- Ce champ est optionnel et peut être laissé vide si aucune photo n'est associée au véhicule.
  photo_url VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- La date et l'heure de création de l'enregistrement du véhicule.
  -- Par défaut, cette valeur est réglée sur le timestamp au moment de l'insertion.
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  -- Déclaration de la colonne 'id' comme clé primaire de la table pour garantir l'unicité et l'intégrité des données.
  PRIMARY KEY (id)
) 
-- Le moteur de stockage pour la table est InnoDB, qui supporte les transactions et les clés étrangères.
ENGINE=InnoDB 

-- Le jeu de caractères par défaut pour la table est latin1, avec l'interclassement latin1_swedish_ci.
-- Cela détermine comment les données textuelles sont stockées et comparées dans la base de données.
DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
