# Projet WebTech N3 - Laravel

## Initialisation du projet

Pour utiliser le site et créer des données fake pour l'utilisation, il faut passer par plusieurs étapes.

### Étape 1

Installer les dépendances Composer du projet

```shell
php composer install
```

### Étape 2

Installer les dépendances node

```shell
npm i
```

### Étape 3

Générer la base de données et les données de test

```shell
php artisan migrate && php artisan db:seed
```

Une fois toutes ces étapes réalisées, il suffira de lancer deux commandes pour lancer le serveur de dev.

```shell
php artisan serve
```

et

```shell
npm run dev
```

## Connexion à l'interface

Pour se connecter à l'application les identifiants par défaut sont :

ID : test@example.com <br/>
MDP : Test1234

Une fois connecté, le dashboard est affiché et permet d'afficher les tâches sous forme de calendrier.

Les pages disponibles depuis la navigation :

- La page tâche : permettra d'afficher les tâches sous forme de tableau et d'ajouter/modifier/supprimer des tâches.
- La page catégories : permettra d'afficher les catégories sous forme de tableau et d'ajouter/modifier/supprimer des
  catégories.

### Ajouter une tâche

Il suffit de se rendre sur la page [http://localhost:8000/tasks](http://localhost:8000/tasks) et de cliquer sur "Créer
une tâche".

Tous les champs du formulaire sont requis pour enregistrer une nouvelle tâche.

### Ajouter une catégorie

Il suffit de se rendre sur la page [http://localhost:8000/categories](http://localhost:8000/categories) et de cliquer
sur "Créer
une catégorie".

Tous les champs du formulaire sont requis pour enregistrer une nouvelle catégorie.

### Affichage calendrier

Depuis le calendrier, il est possible de consulter les détails d'une tâche en cliquant sur celle-ci.
Pour naviguer dans le calendrier, il suffit de changer le mois et l'année, l'actualisation est automatique.

### Consulter les tâches

Il est possible de consulter les tâches depuis la page [tâche](http://localhost:8000/tasks), mais également depuis la page [catégorie](http://localhost:8000/categories) en cliquant
sur le nom d'une catégorie. La liste qui sera affichée sera la liste des tâches qui sont dans cette catégorie.

### Consulter les catégories

Il suffit de se rendre sur la page de [catégorie](http://localhost:8000/categories).
