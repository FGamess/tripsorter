<?php

use Util\BoardingCardList as SUT;
use Api\Model\BoardingCard;
use Api\Model\BoardingCardInterface;

/**
 * Description of BoardingCardListTest
 *
 * @author Franck GAMESS <franck.gamess@gmail.com>
 */
class BoardingCardListTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     * @var BoardingCardList
     */
    public $boardingCardList;
    
    public function setUp()
    {
        
    }
    
    /**
     * @test
     * @group unit_utils
     */
    public function addMethodShouldAddCardInArray()
    {
        $this->boardingCardList = new SUT();
        
        $this->boardingCardList->add(new BoardingCard());
        
        $this->assertEquals(1, count($this->boardingCardList->getBoardingCards()));
    }
    
    /**
     * @test
     * @group unit_utils
     */
    public function countReturnCardsArrayLength()
    {
        $count = 0;
        $this->boardingCardList = new SUT();
        
        $this->assertEquals($count, $this->boardingCardList->count());
        
        $this->boardingCardList->add(new BoardingCard());
        
        $this->assertEquals(++$count, $this->boardingCardList->count());
    }
    
    /**
     * @test
     * @group unit_utils
     */
    public function getBoardingCardsReturnsCardsArray()
    {
        $this->boardingCardList = new SUT();
        
        $this->assertInternalType('array', $this->boardingCardList->getBoardingCards());
        
        $this->boardingCardList->add(new BoardingCard());
        
        $this->assertInstanceOf(BoardingCardInterface::class, $this->boardingCardList->getBoardingCards()[0]);
    }
}
