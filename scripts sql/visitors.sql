-- Création ou mise à jour de la table pour stocker les informations sur les visiteurs du garage nommée "visitors" 
CREATE TABLE visitors (
  -- Un identifiant unique pour chaque visiteur, qui s'incrémente automatiquement.
  -- Ce champ est essentiel pour assurer l'unicité de chaque enregistrement de visiteur.
  id INT(11) NOT NULL AUTO_INCREMENT,

  -- Le prénom du visiteur.
  -- Ce champ est optionnel et peut être laissé vide si aucun prénom n'est fourni.
  firstname VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,

  -- Le nom de famille du visiteur.
  -- Ce champ est optionnel et peut être laissé vide si aucun nom de famille n'est fourni.
  lastname VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,

  -- L'adresse email du visiteur.
  -- Ce champ est optionnel et peut être laissé vide si aucune adresse email n'est fournie.
  email VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,

  -- Déclaration de la colonne 'id' comme clé primaire de la table pour garantir l'unicité et l'intégrité des données.
  PRIMARY KEY (id)
) 
-- Le moteur de stockage pour la table est InnoDB, qui supporte les transactions et les clés étrangères.
ENGINE=InnoDB 

-- Le jeu de caractères par défaut pour la table est latin1, avec l'interclassement latin1_swedish_ci.
-- Cela détermine comment les données textuelles sont stockées et comparées dans la base de données.
DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
