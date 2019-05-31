LES ÉTAPES DU PROJET "VoitureRA":

1-  Pour télecharger les dépendences (vendor) executer la commande :
    $ sudo apt install docker
    $ sudo apt install docker-compose
    $ composer install

2-  dans le dossier de VoitureRA executer les commandes suivante dans le terminal:

    $ docker-compose up -d 
    $ docker-compose exec php-fpm bash
        # bin/console cache:clear
        # bin/console doctrine:database:create 
        # bin/console doctrine:migrations:diff
        # bin/console doctrine:migrations:migrate
        # bin/console doctrine:fixtures:load
        

3- page de login taper localhost:81/login
    username = admin
    password = admin

4- page principale de projet localhost:81/

