
# ECF du Garage Vincent Parot - Fichiers importants et installation en local

## Liens importants du projet

- Site en ligne : "https://garagevparrot31.fr

- Trello : "https://trello.com/b/8QGl5yJ8/ecf

- Charte graphique et maquettes : "https://drive.google.com/file/d/1f0kKS21hvA_luZdAzwD9yshm72foZ3aE/view"

- Documentation technique du projet : "https://drive.google.com/file/d/1AlJHagOUol7i5R33wkIFoL_xFqYrWoJW/view"

- Scripts SQL : "https://drive.google.com/file/d/1Mz6LxqrxqiowkjsfDUCn3hCOF0oKy5OD/view"

- Manuel d'utilisation : "https://drive.google.com/file/d/14Q8kqwO-tzM7qyx7XY1Ox-g8GCocdFyd/view"

## Installation en local

### Prérequis :

- WampServer (ou tout autre environnement de développement PHP et MySQL)
- PHPMyAdmin (inclus dans WampServer)

### Instructions d'installation :

1. Installer WampServer :

- Téléchargez le dernier package d'installation de WampServer depuis le site officiel.
- Exécutez le programme d'installation téléchargé et suivez les instructions à l'écran pour installer WampServer sur votre système.
- Pendant l'installation, vous pouvez choisir le répertoire d'installation de WampServer, mais le chemin par défaut est généralement C:\wamp64\ sous Windows.

2. Configurer PHPMyAdmin :

- Une fois l'installation de WampServer terminée, lancez le logiciel en cliquant sur son icône sur le bureau ou en le recherchant dans le menu Démarrer.
- Assurez-vous que les services Apache et MySQL sont démarrés. - Vous pouvez vérifier cela en regardant les icônes de WampServer dans la barre des tâches. Elles doivent être vertes.
- Ouvrez PHPMyAdmin en cliquant sur l'icône de WampServer dans la barre des tâches, puis en sélectionnant "phpMyAdmin".
- Connectez-vous à PHPMyAdmin en utilisant les identifiants suivants :
   - Nom d'utilisateur : root
   - Mot de passe : (laissez le champ du mot de passe vide ou utilisez "admin")

3. Importer la base de données :

- Dans PHPMyAdmin, créez une nouvelle base de données en cliquant sur l'onglet "Bases de données" dans la barre de navigation et en entrant un nom pour votre base de données (par exemple, "garage_vincent_parrot").
- Sélectionnez la nouvelle base de données dans le volet de gauche.
- Cliquez sur l'onglet "Importer" dans la barre de navigation supérieure.
- Sélectionnez le fichier SQL complet fourni avec le projet en cliquant sur le bouton "Choisir un fichier".
- Cliquez sur le bouton "Exécuter" pour importer le fichier SQL dans votre base de données.

4. Modifier les informations de connexion à la base de données :

- Dans le répertoire du projet, recherchez le fichier includes/db.php et ouvrez-le avec un éditeur de texte.
- Modifiez les valeurs des variables $username et $password pour correspondre à votre nom d'utilisateur et mot de passe MySQL, respectivement. Par défaut, ils sont configurés pour "root" et "admin", mais vous pouvez les modifier selon vos paramètres.

5. Lancer le serveur local :

- Assurez-vous que WampServer est en cours d'exécution et que les services Apache et MySQL sont démarrés.
- Placez les fichiers du projet dans le répertoire www de votre installation WampServer. Par défaut, ce répertoire se trouve dans le dossier d'installation de WampServer (généralement C:\wamp64\www sous Windows).
- Dans votre navigateur web, accédez à l'URL http://localhost/votre_dossier_de_projet pour charger votre projet, avec le nom de votre dossier dans l'URL.

6. Tester le projet :

- Vous devriez maintenant pouvoir accéder au projet localement à l'adresse http://localhost/votre_dossier_de_projet
- Dès à présent, vous pouvez utiliser le manuel d'utilisation inclus dans les liens pour tester le site et ses fonctionnalités.
