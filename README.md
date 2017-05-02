TripSorter
===============

Resources
---------

  * [Report issues] (franck.gamess@gmail.com)

Architecture
------------

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
    * tests :
        * Unit :
            * Api :
                - BoardingCardSorter.php
            * Utils :

How to use
----------

Ensure you have the following prerequisites :
    - running Apache Server or Nginx with php 7 installed.
    - curl installed on the host machine

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

In a terminal window just execute this command at the root foolder of the app : vendor/bin/phpunit tests
