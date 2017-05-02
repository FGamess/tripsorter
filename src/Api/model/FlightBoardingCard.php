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
class FlightBoardingCard extends NumberedSeat
{
    /**
     *
     * @var string
     */
    private $gate;
    
    /**
     *
     * @var string Short description concerning the bagages tracking
     */
    private $bagageTracking;
    
    /**
     * 
     * @return string
     */
    public function getGate()
    {
        return $this->gate;
    }
    
    /**
     * 
     * @param string $gate
     * @return $this
     */
    public function setGate(string $gate = '')
    {
        $this->gate = $gate;
        
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getBagageTracking()
    {
        return $this->bagageTracking;
    }
    
    /**
     * 
     * @param string $bagageTracking
     * @return $this;
     */
    public function setBagageTracking(string $bagageTracking = '')
    {
        $this->bagageTracking = $bagageTracking;
        
        return $this;
    }
}
