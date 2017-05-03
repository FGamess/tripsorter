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
                - BoardingCardTestApi.php
            --Utils :
                - BoardingCardListTest.php
                - BoardingCardSorterTest.php
                - DirectivesFormatterTest.php

Prerequisites
-------------

### Ensure you have the following prerequisites :

    * running Apache Server or Nginx with php 7 installed.
    * curl installed on the host machine
    * docker and docker-compose if you plan to use the docker-compose files provided in this project (optional)

### Server configuration :

    - Using your own Apache server, using .htaccess file (an example is providen in this project, **.htaccess_example** :

        <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule api/v1/(.*)$ api/v1/api.php?request=$1 [QSA,NC,L]
        </IfModule>

    - Using your own Nginx server, add server block config :
        
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
considere using docker-sync to speed up the synchronization of the files (see **docker-compose-mac.yml** and **docker-sync.yml** file).

Or you can use the **docker-compose.yml** file directly if you are under windows or Linux.

### How to use

 1. Using curl send **POST** data with the input file src/boardingCardSet.json at the root of the project on the host machine:

        curl -XPOST 
        -H 'Content-Type:application/json' 
        -H 'Accept: application/json' 
        --data-binary @src/boardingCardSet.json http://<your_server>/Api/v1/boarding_cards -v -s

boarding_cards is the route exposed in the api

The input json file look like this :

    {
        "1": "DGNQEK918KQP9IPZ5",
        "2": "DGNQES0QGG4YKHHQ9",
        "3": "DGNQF2A6PNCQ5FWU9",
        "4": "DGNQF9S2MJJFRU6TS"
    }


2. In the browser (eg : Chrome), you can send **GET** data. Fill the address bar with :


    `http://<your_server>/Api/v1/boarding_cards?cards[]=DGNQEK918KQP9IPZ5&cards[]=DGNQES0QGG4YKHHQ9&cards[]=DGNQF2A6PNCQ5FWU9&cards[]=DGNQF9S2MJJFRU6TS`
    

Actually the api use a DataSource (see **src/Api/model/DataSource.php**) with 4 BoardingCards entities instanciated. There is no Database but we could use one.

The api take in input 4 UUIDs corresponding to 4 Boarding cards out of order. It finds the boarding cards associated and then sort them.


Unit Tests
----------

In a terminal window just execute this command at the root foolder of the app : 

    `vendor/bin/phpunit tests`
