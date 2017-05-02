<?php

namespace Api\Model;

/**
 * Description of DataSource
 * 
 * Singleton pattern for this class because it will be implemented only one time.
 * Advice : Singleton pattern is deprecated.
 *
 * Franck GAMESS <franck.gamess@gmail.com>
 */
class DataSource
{
    const ID_MAP = [
        1 => 'DGNQEK918KQP9IPZ5',
        2 => 'DGNQES0QGG4YKHHQ9',
        3 => 'DGNQF2A6PNCQ5FWU9',
        4 => 'DGNQF9S2MJJFRU6TS'
    ];

    public $boardingCards;
    
    protected static $instance;
  
    protected function __construct() { } // private construct
    protected function __clone() { } // clone method private too
  
    public static function getInstance()
    {
        if (!isset(self::$instance))
        {
            self::$instance = new self; 
        }

        return self::$instance;
    }
    
    public function getUnorderedBoardingCardsSet()
    {
        $this->boardingCards[] = $this->createBoardingCard(
            'DGNQEK918KQP9IPZ5',
            BoardingCard::PLANE,
            'Stockholm',
            "New York JFK",
            "From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B. Baggage will we automatically transferred from your last leg.",
            '7B',
            '22',
            '',
            "Baggage will we automatically transferred from your last leg.",
            'SK22'
        );
        $this->boardingCards[] = $this->createBoardingCard(
            'DGNQES0QGG4YKHHQ9',
            BoardingCard::BUS,
            'Barcelona',
            'Gerona',
            "Take the airport bus from Barcelona to Gerona Airport. No seat assignment."
        );
        $this->boardingCards[] = $this->createBoardingCard(
            'DGNQF2A6PNCQ5FWU9',
            BoardingCard::TRAIN,
            'Madrid',
            'Barcelona',
            "Take train 78A from Madrid to Barcelona. Sit in seat 45B.",
            '45B',
            '',
            '',
            '',
            '78A'
        );
        $this->boardingCards[] = $this->createBoardingCard(
            'DGNQF9S2MJJFRU6TS',
            BoardingCard::PLANE,
            'Gerona',
            'Stockholm',
            "From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. Baggage drop at ticket counter 344.",
            '3A',
            '45B',
            '', 
            "Baggage drop at ticket counter 344.",
            'SK455'
        );
        
        return $this->boardingCards;
    }
    
    private function createBoardingCard(
        string $id,
        int $transportationType,
        string $departurePoint,
        string $arrivalPoint,
        string $directives,
        string $seatAssignment = '',
        string $gate = '',
        string $platformNumber = '',
        string $bagageTracking = '',
        string $transportationNumber = ''
    )
    {
        switch ($transportationType) {
            case BoardingCard::PLANE:
                $boardingCard = new FlightBoardingCard($id);
                $boardingCard->setTransportationType($transportationType)
                    ->setDepartureLocation($departurePoint)
                    ->setArrivalLocation($arrivalPoint)
                    ->setDirectives($directives)
                    ->setSeatAssignment($arrivalPoint)
                    ->setGate($gate)
                    ->setBagageTracking($bagageTracking)
                    ->setTransportationNumber($transportationNumber)
                ;
                return $boardingCard;
            case BoardingCard::TRAIN:
                $boardingCard = new TrainBoardingCard($id);
                $boardingCard->setTransportationType($transportationType)
                    ->setDepartureLocation($departurePoint)
                    ->setArrivalLocation($arrivalPoint)
                    ->setDirectives($directives)
                    ->setSeatAssignment($seatAssignment)
                    ->setPlatformNumber($platformNumber)
                    ->setTransportationNumber($transportationNumber)
                ;
                return $boardingCard;;
            case BoardingCard::BUS:
                $boardingCard = new BoardingCard($id);
                $boardingCard->setTransportationType($transportationType)
                    ->setDepartureLocation($departurePoint)
                    ->setArrivalLocation($arrivalPoint)
                    ->setDirectives($directives)
                ;
                return $boardingCard;;

            default:
                break;
        }
    }
}
