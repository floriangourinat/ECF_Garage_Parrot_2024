-- Création de la base de données avec le nom spécifique 'garage_vincent_parrot', pour bien identifier la base de données du garage 
CREATE DATABASE `garage_vincent_parrot`
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

-- Sélection de la base de données créée pour l'utiliser pour les opérations futures
USE `garage_vincent_parrot`;

-- Une fois ma base de données sélectionné, je peux directement ajouter mes tables dans la requête SQL

-- Pour créer la table 'vehicles', iL faut utiliser la commande CREATE TABLE avec les champs appropriés.
-- CREATE TABLE `vehicles` (...);

-- Pour créer la table 'services', iL faut utiliser la commande CREATE TABLE avec les champs appropriés.
-- CREATE TABLE `services` (...);

-- Pour créer la table 'users', iL faut utiliser la commande CREATE TABLE avec les champs appropriés.
-- CREATE TABLE `users` (...);

-- Pour créer la table 'visitors', iL faut utiliser la commande CREATE TABLE avec les champs appropriés.
-- CREATE TABLE `visitors` (...);

-- Pour créer la table 'comments', iL faut utiliser la commande CREATE TABLE avec les champs appropriés et il faut s'asssurer d'inclure une clé étrangère qui référence 'visitors'.
-- CREATE TABLE `comments` (...);

-- Pour créer la table 'contacts', il faut s'asssurer d'inclure une clé étrangère qui référence 'visitors'.
-- CREATE TABLE `contacts` (...);

-- Pour créer la table 'schedules', iL faut utiliser la commande CREATE TABLE avec les champs appropriés.
-- CREATE TABLE `schedules` (...);

-- Ne pas oublier d'ajouter des contraintes de clé étrangère là où c'est nécessaire pour maintenir l'intégrité référentielle.
-- ALTER TABLE `...` ADD CONSTRAINT `...` FOREIGN KEY (`...`) REFERENCES `...` (`...`);

-- Après avoir créé les tables, nous pouvons commencer à insérer des données dans chaque table.
-- INSERT INTO `vehicles` (...) VALUES (...);
-- Répéter pour les autres tables...

-- Nous pouvons effectuer des tests pour nous assurer que toutes les tables ont été créées correctement et que les relations sont correctement établies.
-- SELECT * FROM `vehicles`;
-- Répéter pour les autres tables...
