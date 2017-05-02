<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Api\Model;

/**
 * Description of TrainBoardingCard
 *
 * @author hamzaAlMartiniki
 */
class TrainBoardingCard extends NumberedSeat
{
    /**
     * Could be a string. eg : 43bis
     * @var string
     */
    private $platformNumber;
    
    /**
     * 
     * @return string
     */
    public function getPlatformNumber()
    {
        return $this->platformNumber;
    }
    
    /**
     * 
     * @param string $platformNumber
     * @return $this
     */
    public function setPlatformNumber(string $platformNumber = null)
    {
        $this->platformNumber = $platformNumber;
        
        return $this;
    }
}
