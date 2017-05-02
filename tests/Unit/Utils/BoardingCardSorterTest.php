<?php



use PHPUnit\Framework\TestCase;
use Api\Model\DataSource;
use Util\BoardingCardSorter as SUT;
use Api\Model\BoardingCardManager;
use Api\Model\BoardingCard;
use Api\Model\BoardingCardInterface;

/**
 * Description of BoardingCardSorterTest
 *
 * @author Franck GAMESS <franck.gamess@gmail.com>
 */
class BoardingCardSorterTest extends TestCase
{
    /**
     *
     * @var BoardingCardSorter
     */
    public $boardingCardSorter;
    
    /**
     *
     * @var BoardingCardManager
     */
    private $boardingCardManager;
    
    /**
     *
     * @var array
     */
    private $cards;
    
    /**
     *
     * @var DataSource
     */
    private $datasource;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->boardingCardManager = $this->prophesize(BoardingCardManager::class);
        
        $this->datasource = DataSource::getInstance();
        $this->cards = $this->datasource->getUnorderedBoardingCardsSet();
        
        $this->boardingCardSorter = new SUT($this->boardingCardManager->reveal());
    }
    
    /**
     * @test
     * @group unit_utils
     * @dataProvider orderedSetProvider
     */
    public function sortBoardingCardSetReturnsCorrectSet($expected)
    {
        $uuidList = DataSource::ID_MAP;
        $unorderedSet = $this->datasource->getUnorderedBoardingCardsSet();
        foreach ($unorderedSet as $boardingCard) {
            $this->boardingCardManager
                ->getBoardingCardByUuid(Prophecy\Argument::exact($boardingCard->getId()))->willReturn($boardingCard);
        }
        $this->boardingCardManager
            ->getBoardingCardByDeparture(Prophecy\Argument::exact("Stockholm"))
            ->willReturn($this->datasource->getUnorderedBoardingCardsSet()[0]);
        $orderedSet = $this->boardingCardSorter->sortBoardingCardSet(DataSource::ID_MAP);
        
        $this->assertEquals($expected, $orderedSet);
    }
    
    /**
     * @test
     * @group unit_utils
     */
    public function buildBoardingCardListPopulatesCardsArray()
    {
        $boardingCard = new BoardingCard();
        $this->boardingCardManager->getBoardingCardByUuid(Prophecy\Argument::type('string'))->willReturn($boardingCard);
        $uuidList = DataSource::ID_MAP;
        $boardingCardList = $this->boardingCardSorter->buildBoardingCardList($uuidList);
        
        foreach ($boardingCardList->getBoardingCards() as $key => $card) {
            $this->assertInstanceOf(BoardingCardInterface::class, $card);
        }
        
        $this->assertEquals(count($uuidList), $boardingCardList->count());
    }
    
    public function orderedSetProvider()
    {
        $datasource = DataSource::getInstance();
        return [
            [
                array(
                    $datasource->getUnorderedBoardingCardsSet()[2],
                    $datasource->getUnorderedBoardingCardsSet()[1],
                    $datasource->getUnorderedBoardingCardsSet()[3],
                    $datasource->getUnorderedBoardingCardsSet()[0],
                )
            ]
        ];
    }
    
}
