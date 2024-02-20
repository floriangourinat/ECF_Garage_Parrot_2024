-- Création d'une nouvelle table pour stocker les informations de contact nommée "contacts" 
CREATE TABLE contacts (
  -- Un identifiant unique pour chaque contact, qui s'incrémente automatiquement
  id INT(11) NOT NULL AUTO_INCREMENT,
  
  -- L'identifiant du visiteur qui a rempli le formulaire de contact
  -- Cette valeur référence la clé primaire dans la table 'visitors'
  -- Elle peut être NULL si le commentaire n'est pas associé à un visiteur
  visitor_id INT(11) DEFAULT NULL,
  
  -- Le prénom de la personne à contacter
  -- Ce champ peut être laissé vide
  firstname VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- Le nom de famille de la personne à contacter
  -- Ce champ peut être laissé vide
  lastname VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- L'adresse email de la personne à contacter
  -- Ce champ peut être laissé vide
  email VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- Le numéro de téléphone de la personne à contacter
  -- Ce champ peut être laissé vide
  phone VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- Le message textuel laissé par la personne à contacter
  -- Ce champ peut être laissé vide
  message VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- La date et l'heure de création de l'enregistrement de contact
  -- Par défaut, cette valeur est réglée sur le timestamp au moment de l'insertion
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  -- La colonne 'id' est désignée comme la clé primaire de la table
  PRIMARY KEY (id)

  -- Définition d'une clé étrangère pour le champ 'visitor_id'
  -- Cette clé étrangère fait référence à la colonne 'id' de la table 'visitors'
  CONSTRAINT `fk_comments_visitor_id` FOREIGN KEY (`visitor_id`) 
  REFERENCES `visitors` (`id`) 
)
-- Le moteur de stockage pour la table est InnoDB, qui supporte les transactions et les clés étrangères
ENGINE=InnoDB 

-- Le jeu de caractères par défaut pour la table est latin1, avec l'interclassement latin1_swedish_ci
-- Cela détermine comment les données textuelles sont stockées et comparées
DEFAULT CHARSET=latin1;
