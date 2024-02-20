-- Création d'une nouvelle table pour stocker les informations des utilisateurs admin et employés  
CREATE TABLE users (
  -- Un identifiant unique pour chaque utilisateur, qui s'incrémente automatiquement.
  -- Ce champ est essentiel pour assurer l'unicité de chaque enregistrement d'utilisateur.
  id INT(11) NOT NULL AUTO_INCREMENT,
  
  -- Le prénom de l'utilisateur.
  -- Ce champ est obligatoire et doit être renseigné lors de la création d'un enregistrement d'utilisateur.
  firstname VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  
  -- Le nom de famille de l'utilisateur.
  -- Ce champ est obligatoire et doit être renseigné lors de la création d'un enregistrement d'utilisateur.
  lastname VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  
  -- Le nom d'utilisateur affiché sur le dashboard
  -- Ce champ est obligatoire et doit être unique pour chaque utilisateur.
  username VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL UNIQUE,
  
  -- L'email de l'utilisateur utilisé pour l'authentification et la communication.
  -- Ce champ est obligatoire et doit être unique pour chaque utilisateur.
  email VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL UNIQUE,
  
  -- Le mot de passe utilisé pour l'authentification.
  -- Ce champ est obligatoire et stocké de manière sécurisée, de manière hashé.
  password VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  
  -- La profession ou le poste de l'utilisateur.
  -- Ce champ est optionnel et peut être laissé vide.
  job VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- Le rôle de l'utilisateur dans le système (admin, employé).
  -- Ce champ est obligatoire et est utilisé pour déterminer les permissions de l'utilisateur.
  role VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,

  -- Déclaration de la colonne 'id' comme clé primaire de la table pour garantir l'unicité et l'intégrité des données.
  PRIMARY KEY (id)
) 
-- Le moteur de stockage pour la table est InnoDB, qui supporte les transactions et les clés étrangères.
ENGINE=InnoDB 

-- Le jeu de caractères par défaut pour la table est latin1, avec l'interclassement latin1_swedish_ci.
-- Cela détermine comment les données textuelles sont stockées et comparées dans la base de données.
DEFAULT CHARSET=latin1;
