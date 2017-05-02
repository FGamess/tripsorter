<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Api\Model;

use Util\BoardingCardList;
//use Util\BoardingCardListInterface;

/**
 * @todo Implements this manager to request the persistence layer
 * Description of BoardingCardManager
 *
 * @author Franck GAMESS <franck.gamess@gmail.com>
 */
class BoardingCardManager
{
    /**
     *
     * @var BoardingCardListInterface
     */
    private $boardingCards;
    
    public function __construct(DataSource $dataSource)
    {
        $this->boardingCards = new BoardingCardList($dataSource->getUnorderedBoardingCardsSet());
    }
    
    /**
     * 
     * @return array
     */
    public function getList() : BoardingCardListInterface
    {
        return $this->boardingCards;
    }
    
    /**
     * @todo Implements this method
     * @param string $uuid
     * @return \Model\BoardingCard | boolean
     */
    public function getBoardingCardByUuid(string $uuid)
    {
        $closure = function ($key, BoardingCardInterface $element) use (&$uuid) 
        {
            if (!($element->getId() === $uuid)) {
                return false;
            }
            return true;
        };
        
        return $this->boardingCards->returnCardIfExists($closure);
    }
    
    /**
     * @todo Implements this method
     * @param string $departurePoint
     * @return \Model\BoardingCard | boolean
     */
    public function getBoardingCardByDeparture(string $departurePoint)
    {
        $closure = function ($key, BoardingCardInterface $element) use (&$departurePoint) 
        {
            if (stripos($element->getDepartureLocation(), $departurePoint) === false) {
                return false;
            }
            return true;
        };
        
        return $this->boardingCards->returnCardIfExists($closure);
    }
}
