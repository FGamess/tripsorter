<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Api\Model;

/**
 * Description of BoardCardInterface
 * 
 * @author Franck GAMESS <franck.gamess@gmail.com>
 */
interface BoardingCardInterface
{
    public function getTransportationType();
    
    public function getDepartureLocation();
    
    public function getArrivalLocation();
    
    public function getDirectives();
}
