TripSorter
===============

Resources
---------

  * [Report issues] (franck.gamess@gmail.com)

Architecture
------------

    * Api :
        - BoardingCardSorter.php
    * Model :
        - BoardingCardInterface.php
        - BoardingCard.php
        - BoardingCardManager.php
        - NumberedSeat.php
        - FlightBoardingCard.php
    * Util :
        - BoardingCardListInterface.php
        - BoardingCardList.php
    * tests :
        * Unit :
            * Api :
                - BoardingCardSorter.php
            * Utils :

How to use
----------

Ensure you have a running Apache Server with php 7 installed.

Open the app.php file which is at the root folder in browser.

In the app.php you can set 'Madrid' or 'Barcelona'  as actual arrival location 
suposing you have just connected to add your unordered boarding cards set.

example : $orderedSet = new BoardingCardList($cardSorter->sortBoardingCardSet("Barcelona"));


Tests
-----

In a terminal window just execute this command at the root foolder of the app : vendor/bin/phpunit tests
