<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Util;

use Api\Model\BoardingCardInterface;
use Api\Model\BoardingCardManager;
use Api\Model\BoardingCard;
use Util\BoardingCardList;
use Util\BoardingCardListInterface;

/**
 * Description of BoardingCardSorter
 *
 * @author Franck GAMESS <franck.gamess@gmail.com>
 */
class BoardingCardSorter
{
    /**
     *
     * @var BoardingCardListInterface
     */
    private $boardingCards;
    
    /**
     *
     * @var BoardingCardManager 
     */
    protected $boardingCardManager;
    
    /**
     *
     * @var array 
     */
    private $boardingCardSet = [];
    
    /**
     *
     * @var string
     */
    private $checkpoint;
    
    /**
     * 
     * @param BoardingCardManager $boardingCardManager
     */
    public function __construct(BoardingCardManager $boardingCardManager)
    {
        $this->boardingCards = new BoardingCardList();
        $this->boardingCardManager = $boardingCardManager;
    }
    
    /**
     * @return array Returns an ordered Boarding card array
     */
    public function sortBoardingCardSet(array $unorderedBoardingCardSet)
    {
        $this->buildBoardingCardList($unorderedBoardingCardSet);
        $departurePoint = $this->getDeparturePoint();
        $this->boardingCardSet[] = $departurePoint;
        
        $nextDeparturePoint = $departurePoint->getArrivalLocation();
        $this->fillBoardingCardSet($nextDeparturePoint);
        
        return $this->boardingCardSet;
    }
    
    public function buildBoardingCardList(array $uuidsList)
    {
        foreach ($uuidsList as $uuid) {
            $boardingCard = $this->boardingCardManager->getBoardingCardByUuid($uuid);
            if ($boardingCard instanceof BoardingCard) {
                $this->boardingCards->add($boardingCard);
            }
        }
    }
    
    private function fillBoardingCardSet(string &$nextDeparturePoint)
    {
        $boardingCards = $this->boardingCards->getBoardingCards();
        foreach ($boardingCards as $key => $boardingCard) {
            if (!(stripos($nextDeparturePoint, $boardingCard->getDepartureLocation()) === false)) {
                $this->boardingCardSet[] = $boardingCard;
                $nextDeparturePoint = $boardingCard->getArrivalLocation();
            }
            
        }
        $this->boardingCardSet[] = $this->boardingCardManager->getBoardingCardByDeparture($nextDeparturePoint);
    }
    
    /**
     * 
     * @return boolean | BoardingCardInterface
     */
    private function getDeparturePoint()
    {
        $departureCard = null;
        foreach ($this->boardingCards->getBoardingCards() as $departureCard) {
            if ($this->noArrivalMatchingDeparture($departureCard))
            {
                break;
            }
        }
        
        return $departureCard;
    }
    
    private function noArrivalMatchingDeparture(BoardingCardInterface $boardingCard)
    {
        for ($i = 0; $i < $this->boardingCards->count(); $i++) {
            if ($this->boardingCards->getBoardingCards()[$i]->getId() === $boardingCard->getId())
            {
                continue;
            }
            
            if ($boardingCard->getDepartureLocation() === $this->boardingCards->getBoardingCards()[$i]->getArrivalLocation())
            {
                return false;
            }
        }
        
        return true;
    }
}
