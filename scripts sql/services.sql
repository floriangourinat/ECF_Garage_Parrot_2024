-- Création d'une nouvelle table pour stocker les informations sur les services du garage nommée "services" 
CREATE TABLE services (
  -- Un identifiant unique pour chaque service, qui s'incrémente automatiquement.
  -- Ce champ est essentiel pour assurer l'unicité de chaque enregistrement de service.
  id INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key, unique identifier for each service',

  -- Une description textuelle du service.
  -- Ce champ est optionnel et peut être laissé vide si aucune description n'est fournie.
  description VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,

  -- Le titre du service.
  -- Ce champ est obligatoire et ne peut pas être laissé vide.
  title VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,

  -- Le chemin vers l'image représentant le service.
  -- Ce champ est optionnel et peut être laissé vide si aucune image n'est associée au service.
  img_service VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,

  -- Déclaration de la colonne 'id' comme clé primaire de la table pour garantir l'unicité et l'intégrité des données.
  PRIMARY KEY (id)
) 
-- Le moteur de stockage pour la table est InnoDB, qui supporte les transactions et les clés étrangères.
ENGINE=InnoDB 

-- Le jeu de caractères par défaut pour la table est latin1, avec l'interclassement latin1_swedish_ci.
-- Cela détermine comment les données textuelles sont stockées et comparées dans la base de données.
DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
