<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Api\Model;

/**
 * Description of FlightBoardingCard
 *
 * @author Franck GAMESS <franck.gamess@gmail.com>
 */
abstract class NumberedSeat extends BoardingCard
{
    /**
     *
     * @var string
     */
    protected $seatAssignment;
   
    /**
     *
     * @var boolean
     */
    protected $hasSeatAssignment;
    
    /**
     * @return string Returns the seat assignment
     */
    public function getSeatAssignment()
    {
        return $this->seatAssignment;
    }
    
    /**
     * 
     * @param string $seatAssignment
     * @return $this
     */
    public function setSeatAssignment(string $seatAssignment)
    {
        $this->seatAssignment = $seatAssignment;
        return $this;
    }
    
    /**
     * 
     * @return boolean
     */
    public function hasSeatAssignment()
    {
        return $this->hasSeatAssignment;
    }
    
    /**
     * 
     * @param bool $hasSeatAssignment
     * @return $this
     */
    public function setHasSeatAssignment(bool $hasSeatAssignment)
    {
        $this->hasSeatAssignment = $hasSeatAssignment;
        return $this;
    }
}
