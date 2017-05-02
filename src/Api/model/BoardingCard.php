<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Api\Model;

//include('BoardingCardInterface.php');

/**
 * Description of BoardCard
 *
 * @author Franck GAMESS <franck.gamess@gmail.com>
 */
class BoardingCard implements BoardingCardInterface
{
    const TRAIN = 0;
    const PLANE = 1;
    const BUS = 2;
    
    /**
     * Should be an UUID
     * @var string 
     */
    protected $id;
    
    /**
     *
     * @var string
     */
    protected $directives;
    
    /**
     * Should be an integer to ease the use of the persistence layer.
     * @var integer The type of the transportation
     */
    protected $transportationType;
    
    /**
     *
     * @var string 
     */
    protected $transportationNumber;
    
    /**
     *
     * @var string The location of the departure
     */
    protected $departureLocation;

    /**
     *
     * @var string The location of the arrival
     */
    protected $arrivalLocation;
    
    public function __construct(string $id = null)
    {
        $this->id = $id;
    }


    /**
     * @return string Description
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * 
     * @return integer
     */
    public function getTransportationType()
    {
        return $this->transportationType;
    }
    
    /**
     * 
     * @param int $transportationType
     * @return $this
     */
    public function setTransportationType(int $transportationType)
    {
        $this->transportationType = $transportationType;
        
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getTransportationNumber()
    {
        return $this->transportationNumber;
    }
    
    /**
     * 
     * @param string $transportationNumber
     * @return $this
     */
    public function setTransportationNumber(string $transportationNumber = '')
    {
        $this->transportationNumber = $transportationNumber;
        
        return $this;
    }
    
    /**
     * @return string $arrivalLocation 
     */
    public function getArrivalLocation()
    {
        return $this->arrivalLocation;
    }
    
    /**
     * @param string $arrivalLocation set the location of the arrival
     * @return $this
     */
    public function setArrivalLocation(string $arrivalLocation)
    {
        $this->arrivalLocation = $arrivalLocation;
        
        return $this;
    }
    
    /**
     * @return string $departureLocation 
     */
    public function getDepartureLocation()
    {
        return $this->departureLocation;
    }
    
    /**
     * @param string $departureLocation set the location of the departure
     * @return $this
     */
    public function setDepartureLocation(string $departureLocation)
    {
        $this->departureLocation = $departureLocation;
        
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getDirectives() : string
    {
        return $this->directives;
    }
    
    /**
     * 
     * @param string $directives
     * @return $this
     */
    public function setDirectives(string $directives)
    {
        $this->directives = $directives;
        
        return $this;
    }

}
