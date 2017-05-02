<?php



use PHPUnit\Framework\TestCase;
use Api\Model\DataSource;
use Util\BoardingCardSorter;
use Api\Model\BoardingCardManager;


/**
 * Description of BoardingCardSorterTest
 *
 * @author Franck GAMESS <franck.gamess@gmail.com>
 */
class BoardingCardSorterTest extends TestCase
{
    public $boardingCardSorter;
    
    private $boardingCardManager;
    
    private $cards;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->boardingCardManager = $this->prophesize(BoardingCardManager::class);
        
        $datasource = DataSource::getInstance();
        $this->cards = $datasource->getUnorderedBoardingCardsSet();
        
        $this->boardingCardSorter = new BoardingCardSorter($this->boardingCardManager->reveal());
    }
    
    /**
     * @test
     */
    public function sortBoardingCardSetReturnsCorrectSet()
    {
        $cardList = $this->boardingCardSorter->buildBoardingCardList(DataSource::ID_MAP);
//        $this->assertEquals($cardsOrdered, $this->boardingCardSorter->sortBoardingCardSet(DataSource::ID_MAP));
    }
    
}
