<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Util;

use Api\Model\BoardingCardInterface;
include('BoardingCardListInterface.php');

/**
 * Description of BoardingCardList
 *
 * @author Franck GAMESS <franck.gamess@gmail.com>
 */
class BoardingCardList implements BoardingCardListInterface
{
    
     /**
     * @var BoardingCardInterface[]
     */
    private $boardingCards = array();

    /**
     * Creates a new boarding card list.
     *
     * @param BoardingCardInterface[] $boardingCards The boarding cards to add to the list
     */
    public function __construct(array $boardingCards = array())
    {
        foreach ($boardingCards as $boardingCard) {
            $this->add($boardingCard);
        }
    }
    
    public function add(BoardingCardInterface $boardingCard)
    {
        $this->boardingCards[] = $boardingCard;
    }

    /**
     * 
     * @return int
     */
    public function count(): int
    {
        return count($this->boardingCards);
    }

    /**
     * 
     * @param int $offset
     * @return BoardingCardInterface
     * @throws \OutOfBoundsException
     */
    public function get(int $offset): BoardingCardInterface
    {
        if (!isset($this->boardingCards[$offset])) {
            throw new \OutOfBoundsException(sprintf('The offset "%s" does not exist.', $offset));
        }

        return $this->boardingCards[$offset];
    }
    
    /**
     * 
     * @return array
     */
    public function getBoardingCards() : array
    {
        return $this->boardingCards;
    }

    /**
     * 
     * @param int $offset
     * @return bool
     */
    public function has(int $offset): bool
    {
        return isset($this->boardingCards[$offset]);
    }
    
    /**
     * 
     * @param int $offset
     * @return bool
     */
    public function offsetExists(int $offset): bool
    {
        return $this->has($offset);
    }
    
    /**
     * 
     * @param int $offset
     */
    public function remove(int $offset)
    {
        unset($this->boardingCards[$offset]);
    }
    
    /**
     * 
     * @param int $offset
     * @param BoardingCardInterface $boardingCard
     */
    public function set(int $offset, BoardingCardInterface $boardingCard)
    {
        $this->boardingCards[$offset] = $boardingCard;
    }
    
    /**
     * 
     * @param \Closure $p
     * @return boolean | BoardingCardInterface
     */
    public function returnCardIfExists(\Closure $p, $removeOffset = false)
    {
        foreach ($this->boardingCards as $key => $element) {
            if ($p($key, $element)) {
                if ($removeOffset)
                {
                    unset($this->boardingCards[$key]);
                }
                return $element;
            }
        }

        return false;
    }
}
