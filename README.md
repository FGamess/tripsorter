TripSorter
===============

Resources
---------

  * [Report issues] (franck.gamess@gmail.com)

Architecture
------------

    --src
        --Api
            --Model :
                - BoardingCardInterface.php
                - BoardingCard.php
                - BoardingCardManager.php
                - NumberedSeat.php
                - FlightBoardingCard.php
            --Util :
                - BoardingCardListInterface.php
                - BoardingCardList.php
                - BoardingCardSorter.php
                - DirectivesFormatter.php
            --v1 :
                - ApiBehavior.php
                - BoardingCardApi.php
                - api.php
    --tests
        --Unit
            --Api :
            --Utils :
                - BoardingCardListTest.php
                - BoardingCardSorterTest.php
                - DirectivesFormatterTest.php

How to use
----------

Ensure you have the following prerequisites :

    - running Apache Server or Nginx with php 7 installed.

    - curl installed on the host machine

Server configuration :

    - Apache, using .htaccess file :

        <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule api/v1/(.*)$ api/v1/api.php?request=$1 [QSA,NC,L]
        </IfModule>

    - Nginx, add server block config :
        
        server {
            listen 80;
            listen [::]:80;

            root /var/www/src;
            index app.php;

            server_name localhost;

            # location / {
            #         try_files $uri $uri/ =404;
            # }

            location / {
                fastcgi_pass php-upstream;
                 fastcgi_split_path_info ^(.+\.php)(/.*)$;
                 include fastcgi_params;
                 fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                 fastcgi_param HTTPS off;
                if (!-e $request_filename){
                    rewrite Api/v1/(.*)$ /Api/v1/api.php?request=$1 break;
                }
            }

            location ~ ^/Api/v1/(api)\.php(/|$) {
                fastcgi_pass php-upstream;
                fastcgi_split_path_info ^(.+\.php)(/.*)$;
                include fastcgi_params;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                fastcgi_param HTTPS off;
            }
        }

You can use Docker with this project. If you use DockerCE for Mac, please 
considere using docker-sync to speed up the synchronization fo the files (see docker-compose-mac.yml and docker-sync.yml file).

Or you can use the docker-compose.yml file directly if you are under windows or Linux.

 * Using curl send post data with the input file src/boardingCardSet.json at the root of the project on the host machine:

        curl -XPOST 
        -H 'Content-Type:application/json' 
        -H 'Accept: application/json' 
        --data-binary @src/boardingCardSet.json http://<your_server>/Api/v1/boarding_cards -v -s

        boarding_cards is the route expose in the api

* In the browser (eg : Chrome) fill the address bar with :


        http://<your_server>/Api/v1/boarding_cards?cards[]=DGNQEK918KQP9IPZ5&cards[]=DGNQES0QGG4YKHHQ9&cards[]=DGNQF2A6PNCQ5FWU9&cards[]=DGNQF9S2MJJFRU6TS




Tests
-----

In a terminal window just execute this command at the root foolder of the app : 

        vendor/bin/phpunit tests
