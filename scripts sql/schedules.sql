-- Création d'une nouvelle table pour stocker les horaires d'ouverture et de fermeture nommée "schedules" 
CREATE TABLE schedules (
  -- Un identifiant unique pour chaque créneau horaire, qui s'incrémente automatiquement.
  -- Ce champ est essentiel pour assurer l'unicité de chaque enregistrement.
  id INT(11) NOT NULL AUTO_INCREMENT,
  
  -- Une chaîne de caractères pour stocker le jour concerné par l'horaire.
  -- Ce champ est obligatoire et doit être renseigné lors de la création d'un enregistrement.
  `day` varchar(50) COLLATE latin1_swedish_ci NOT NULL,

  -- Heure d'ouverture du matin, stockée sous forme d'heure.
  -- Ce champ est optionnel et peut ne pas être renseigné si l'horaire du matin n'est pas défini.
  `morning_opening_hour` time DEFAULT NULL,

  -- Heure de fermeture du matin, stockée sous forme d'heure.
  -- Ce champ est optionnel et peut ne pas être renseigné si l'horaire du matin n'est pas défini.
  `morning_closing_hour` time DEFAULT NULL,

  -- Heure d'ouverture de l'après-midi, stockée sous forme d'heure.
  -- Ce champ est optionnel et peut ne pas être renseigné si l'horaire de l'après-midi n'est pas défini.
  `afternoon_opening_hour` time DEFAULT NULL,

  -- Heure de fermeture de l'après-midi, stockée sous forme d'heure.
  -- Ce champ est optionnel et peut ne pas être renseigné si l'horaire de l'après-midi n'est pas défini.
  `afternoon_closing_hour` time DEFAULT NULL,

  -- Un horodatage pour enregistrer la date et l'heure de création de l'enregistrement.
  -- Il est automatiquement réglé sur le timestamp actuel lors de l'insertion.
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),

  -- Déclaration de la colonne 'id' comme clé primaire de la table pour garantir l'unicité et l'intégrité des données.
  PRIMARY KEY (`id`)
) 
-- Spécification du moteur de stockage InnoDB pour la table.
-- InnoDB est recommandé pour son support des transactions, sa fiabilité et son support des clés étrangères.
ENGINE=InnoDB 

-- Définition du jeu de caractères par défaut pour la table en latin1 avec l'interclassement latin1_swedish_ci.
-- Cela définit la façon dont les données textuelles sont stockées et comparées dans la base de données.
DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
