## bugs.elenox.net

Ce projet destiné a [Elenox](https://elenox.net), a pour but de permettre a des non développeur la création de Ticket ainsi que la possibilité de les suivres.

### Prérequis

- PHP >= 7.2.5
- GitLab Token
- Un serveur MySQL
- Composer

### Mise en place

- Cloner le projet
- Installer les dépendances NodeJS : `npm i`
- Installer les dépendances Composer : `composer install`
- Configurer le `.env` avec les informations BDD, et gitlab
- Générer la key: `php artisan key:generate`
- Effectuer la migration des données: `php artisan migrate:install`
