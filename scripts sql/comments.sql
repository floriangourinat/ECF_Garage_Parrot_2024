-- Création d'une nouvelle table pour les avis clients nommée "comments"
CREATE TABLE comments (
  -- Un identifiant unique pour chaque commentaire, qui s'incrémente automatiquement
  id INT(11) NOT NULL AUTO_INCREMENT,

  -- L'identifiant du visiteur qui a laissé le commentaire
  -- Cette valeur référence la clé primaire dans la table 'visitors'
  -- Elle peut être NULL si le commentaire n'est pas associé à un visiteur
  visitor_id INT(11) DEFAULT NULL,

  -- Le prénom de la personne laissant un commentaire
  -- Ce champ ne peut pas être NULL et accepte jusqu'à 255 caractères
  firstname VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,

  -- Le nom de famille de la personne laissant un commentaire
  -- Ce champ ne peut pas être NULL et accepte jusqu'à 255 caractères
  lastname VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,

  -- Le contenu textuel du commentaire
  -- Ce champ peut être vide si aucun contenu n'est soumis avec le commentaire
  content TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,

  -- Un indicateur pour savoir si le commentaire a été approuvé
  -- 0 signifie non approuvé, et 1 signifie approuvé. La valeur par défaut est 0 (non approuvé)
  is_approved TINYINT(1) DEFAULT 0,

  -- Une note ou évaluation qui peut être donnée avec le commentaire
  -- Ce champ est optionnel et peut rester NULL si aucune note n'est donnée
  rating INT(11) DEFAULT NULL,

  -- La date et l'heure auxquelles le commentaire a été soumis
  -- Ce champ peut rester NULL si la date de soumission n'est pas définie
  submitted_at DATETIME DEFAULT NULL,

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
