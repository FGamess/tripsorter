<?php

namespace Api\V1;

use Util\BoardingCardSorter;
use Api\Model\BoardingCardManager;
use Api\Model\DataSource;
use Util\BoardingCardList;

/**
 * Description of BoardingCardApi
 *
 * @author Franck GAMESS <franck.gamess@gmail.com>
 */
class BoardingCardApi extends ApiBehavior
{
    const ROUTES = [
        'boarding_cards' => 'getOrderedCards'
    ];
    
    /**
     * @var BoardingCardSorter
     */
    private $cardSorter;
    
    public function __construct($request, $origin, $query = [], $postValues = []) 
    {
        $datasource = DataSource::getInstance();

        $manager = new BoardingCardManager($datasource);

        $this->cardSorter = new BoardingCardSorter($manager);
        $this->query = $query;
        $this->postValues = $postValues;
        parent::__construct($request);
    }
    
    public function processAPI() {
        if (array_key_exists($this->endpoint, self::ROUTES)) {
            return $this->buildResponse($this->{self::ROUTES[$this->endpoint]}());
        }
        return $this->buildResponse("No Endpoint: $this->endpoint", 404);
    }
    
    protected function getOrderedCards()
    {
        if ($this->method == 'GET') {
            $orderedSet = new BoardingCardList($this->cardSorter->sortBoardingCardSet($this->query['cards']));
            $orderedBoardingCards = $orderedSet->getBoardingCards();
           $directives = [];
           foreach ($orderedBoardingCards as $key => $boardingCard) {
               $directives[] = ++$key.". ".$boardingCard->getDirectives();
           }
           
           $count = $orderedSet->count();
           
           $directives[] = ++$count.". You have arrived at your final destination.";
                
           return $directives;
        } else {
            return "Only accepts GET requests";
        }

    }
}
