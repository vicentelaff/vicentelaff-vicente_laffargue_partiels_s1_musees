# 0. ANALYSE DU PROJET:
 - Créer une application web sur le thème des musées célèbres. Contenu nécessaire:
    1. Page de présentation de quelques musées.
    2. Page de détails d'un musée avec une image et description.
    3. Pages de formulaires CRUD afin de possibiliter l'admin du site de gérer son contenu.

 - Actions particulières demandées:
    1. Fixtures.
    2. Msg flash.
    3. Contraintes de validation pour les formulaires.
    4. Mise en page personnalisée.

__NB__ : Pour lancer l'application, ne pas oublier de faire un `symfony serve` dans le terminal. Elle sera ensuite accessible à l'adresse `localhost:8000` sur le navigateur.

# 1. MODÉLISATION ET CRÉATION DE LA BASE DE DONNÉES:
 * Modélisation avec MySQL Workbench:
    - On a 2 entités (Musee et Ville).
    - Pour Musee => id, nom, photo, adresse, prix (de l'entrée), presentation.
    - Pour Ville => id, adresse.
    - Une ville peut avoir plusieurs musées mais un musée ne peut être qu'à une ville à la fois. Si la ville est détruite, le musée sera
      aussi détruit. Alors on a une relation de ManyToOne entre Musee et Ville et cette relation est "identifying".

    ![DB_Musees](./public/images/db_musees.jpg)

 * Création `db_vicente_laffargue_musees` en PostGreSQL:
    ```bash
    # Dans le fichier `.env`, décommenter la ligne suivante: 
     DATABASE_URL="postgresql://postgres:papito@127.0.0.1:5432/db_vicente_laffargue_musees"
    # Dans le terminal taper la commande suivante pour créer la DB:
     symfony console doctrine:database:create
    ```

# 2. CRÉATION DES ENTITÉS:
 * Avec la commande `symfony console make:entity` on crée les deux entités demandées à l'aide du terminal.

## 2.1 Relations:
 * Avec la commande `symfony console make:entity Musee` on crée la relation entre les deux entités à l'aide du terminal.
 
    __NB__ : Comme la suppression d'une ville implique la suppression de ses musées, l'option "orphan removal" est activée lors de la création de la relation.

 * Ensuite, on fait la migration: `symfony console make:migration` puis `symfony console doctrine:migrations:migrate`

# 3. FIXTURES:
 * Il faut installer le bundle datafixtures avec la commande suivante: `composer require --dev doctrine/doctrine-fixtures-bundle`
    - Ensuite, on tape la commande `symfony console doctrine:fixtures:load` dans le terminal pour que l'on puisse, par la suite, alimenter notre DB pour la première fois.
    - Un nouveau dossier `src/DataFixtures` avec un fichier `AppFixtures.php`.

## 3.1 Alimentation de la DB pour la première fois:
 * Dans le fichier `AppFixtures.php` il nous faut le suivant:
    - Un tableau d'objets contenant les villes des musées célèbres.
    - Un musée (ici le Louvre).
        > La méthode setVille() a besoin d'un objet Ville comme argument, pour le louvre c'est Paris, qui est l'élément d'index 0 dans le tableau $tabObjectsVilles !

 * On refait `symfony console doctrine:fixtures:load` pour mettre la DB à jour.

# 4. MAKE CRUD:
 * On va créer l'interface CRUD, à l'aide de la `commande symfony console make:crud`:
    - L'entité que l'on souhaite pouvoir CRUD est Musee => On a donc MuseeController.
        > Au singulier.

# 5. CUSTOMISATION DE LA VUE:
 * À l'aide de Bootstrap, nous allons par la suite personnalisé la vue (dossier template) de notre application