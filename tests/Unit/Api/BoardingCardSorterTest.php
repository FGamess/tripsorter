<?php

require_once __DIR__.'/../../../src/Api/BoardingCardSorter.php';
require_once __DIR__.'/../../../src/Util/QrCodeHandler.php';
require_once __DIR__.'/../../../src/Util/BoardingCardList.php';
require_once __DIR__.'/../../../src/Util/BoardingCardListInterface.php';
require_once __DIR__.'/../../../src/Model/BoardingCardManager.php';
require_once __DIR__.'/../../../src/Model/DataSource.php';

use PHPUnit\Framework\TestCase;


/**
 * Description of BoardingCardSorterTest
 *
 * @author Franck GAMESS <franck.gamess@gmail.com>
 */
class BoardingCardSorterTest extends TestCase
{
    public $boardingCardSorter;
    
    /**
     *
     * @var QrCodeHandler
     */
    private $qrCodeHandler;
    
    private $boardingCardManager;
    
    private $cards;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->qrCodeHandler = $this->prophesize(Util\QrCodeHandler::class);
        
        $this->boardingCardManager = $this->prophesize(Model\BoardingCardManager::class);
        
        $datasource = \Model\DataSource::getInstance();
        $this->cards = $datasource->getUnorderedBoardingCardsSet();
        
        $this->qrCodeHandler->decodeQrCode(\Prophecy\Argument::exact(1))->willReturn('DGNQEK918KQP9IPZ5');
        $this->qrCodeHandler->decodeQrCode(\Prophecy\Argument::exact(2))->willReturn('DGNQES0QGG4YKHHQ9');
        $this->qrCodeHandler->decodeQrCode(\Prophecy\Argument::exact(3))->willReturn('DGNQF2A6PNCQ5FWU9');
        $this->qrCodeHandler->decodeQrCode(\Prophecy\Argument::exact(4))->willReturn('DGNQF9S2MJJFRU6TS');
        
        $this->boardingCardManager->getBoardingCardByDeparture(\Prophecy\Argument::exact('Stockholm'))->willReturn($this->cards[0]);
        $this->boardingCardManager->getBoardingCardByDeparture(\Prophecy\Argument::exact('Barcelona'))->willReturn($this->cards[1]);
        $this->boardingCardManager->getBoardingCardByDeparture(\Prophecy\Argument::exact('Madrid'))->willReturn($this->cards[2]);
        $this->boardingCardManager->getBoardingCardByDeparture(\Prophecy\Argument::exact('Gerona'))->willReturn($this->cards[3]);
        
        $this->boardingCardManager->getBoardingCardByUuid(\Prophecy\Argument::exact('DGNQEK918KQP9IPZ5'))->willReturn($this->cards[0]);
        $this->boardingCardManager->getBoardingCardByUuid(\Prophecy\Argument::exact('DGNQES0QGG4YKHHQ9'))->willReturn($this->cards[1]);
        $this->boardingCardManager->getBoardingCardByUuid(\Prophecy\Argument::exact('DGNQF2A6PNCQ5FWU9'))->willReturn($this->cards[2]);
        $this->boardingCardManager->getBoardingCardByUuid(\Prophecy\Argument::exact('DGNQF9S2MJJFRU6TS'))->willReturn($this->cards[3]);
        
        
        $this->boardingCardSorter = new \Api\BoardingCardSorter($this->qrCodeHandler->reveal(), $this->boardingCardManager->reveal());
    }
    
    /**
     * @test
     */
    public function sortBoardingCardSetReturnsCorrectSet()
    {
        $cardsOrdered = [];
        $cardsOrdered[] = $this->cards[2];
        $cardsOrdered[] = $this->cards[1];
        $cardsOrdered[] = $this->cards[3];
        $cardsOrdered[] = $this->cards[0];
        $this->boardingCardSorter->addBoardingCard(1);
        $this->boardingCardSorter->addBoardingCard(2);
        $this->boardingCardSorter->addBoardingCard(3);
        $this->boardingCardSorter->addBoardingCard(4);
        $this->assertEquals($cardsOrdered, $this->boardingCardSorter->sortBoardingCardSet('Madrid'));
    }
    
}
