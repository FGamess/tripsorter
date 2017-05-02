<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Util;

use Api\Model\BoardingCardInterface;

/**
 * Description of BoardingCardListInterface
 *
 * @author Franck GAMESS <franck.gamess@gmail.com>
 */
interface BoardingCardListInterface extends \Countable
{
    /**
     * Adds a constraint boarding card to this list.
     *
     * @param BoardingCardInterface $boardingCardInterface The boarding card to add
     */
    public function add(BoardingCardInterface $boardingCardInterface);

    /**
     * Returns the boarding card at a given offset.
     *
     * @param int $offset The offset of the boarding card
     *
     * @return BoardingCardInterface The boarding card
     *
     */
    public function get(int $offset);

    /**
     * Returns whether the given offset exists.
     *
     * @param int $offset The boarding card offset
     *
     * @return bool Whether the offset exists
     */
    public function has(int $offset);

    /**
     * Sets a boarding card at a given offset.
     *
     * @param int                          $offset    The boarding card offset
     * @param BoardingCardInterface $boardingCardInterface The boarding card
     */
    public function set(int $offset, BoardingCardInterface $boardingCardInterface);

    /**
     * Removes a boarding card at a given offset.
     *
     * @param int $offset The offset to remove
     */
    public function remove(int $offset);
    
    /**
     * 
     * @param \Closure $p
     */
    public function returnCardIfExists(\Closure $p);
}
