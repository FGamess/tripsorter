<?php

namespace Api\V1;

use Util\BoardingCardSorter;
use Api\Model\BoardingCardManager;
use Api\Model\DataSource;
use Util\BoardingCardList;
use Util\DirectivesFormatter;

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
    
    /**
     *
     * @var DirectivesFormatter
     */
    private $directivesFormatter;
    
    public function __construct($request, $origin, $query = [], $postValues = []) 
    {
        $datasource = DataSource::getInstance();

        $manager = new BoardingCardManager($datasource);

        $this->cardSorter = new BoardingCardSorter($manager);
        $this->directivesFormatter = new DirectivesFormatter();
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
            
            return $this->directivesFormatter->getDirectives($orderedSet);
        } elseif ($this->method == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $orderedSet = new BoardingCardList($this->cardSorter->sortBoardingCardSet($data));
            
            return $this->directivesFormatter->getDirectives($orderedSet);
        }
        else {
            return "Only accepts GET or POST requests";
        }
    }
}
