# Amidanse (Documentation d'installation)

## Installation du projet en mode développement :

Positionner-vous dans le dossier ou vous souhaitez importer le projet

    > git clone https://github.com/FrancoisDoussin/Amidanse.git
    > cd Amidanse
    > composer install
    
Saisir les informations requises concernant votre base de données et votre serveur mail

Pour utiliser Gmail : 

    mailer_user : votre adresse gmail
    mailer_password : votre mot de passe gmail

Ensuite

    > php bin/console doctrine:database:create
    > php bin/console doctrine:schema:update --force
    > php bin/console doctrine:fixtures:load

### Lancer le projet

    > php bin/console server:run
    
### Differents login/password d'utilisateurs :

#### Responsable:
    email: responsable@gmail.com
    password: responsable

#### Professeur:
    email: professeur@gmail.com
    password: professeur

#### Danseur:
    email: danseur@gmail.com
    password: dansedanse
    
## Installation du projet en mode production :

### Si elle existe, importer votre base de données

Positionner-vous dans le dossier ou vous souhaitez importer le projet

    > git clone https://github.com/FrancoisDoussin/Amidanse.git
    > cd Amidanse
    > SYMFONY_ENV=prod composer install --no-dev --optimize-autoloader
    
Saisir les informations requises concernant votre base de données et votre serveur mail

Pour utiliser Gmail : 

    mailer_user : votre adresse gmail
    mailer_password : votre mot de passe gmail

Ensuite

    > php bin/console cache:clear --env=prod --no-debug
    
Si vous n'avez pas importer votre base de données, 
pour créer un nouvel utilisateur responsable :

    > php bin/console app:createresponsable
    
Puis remplir les informations demandées