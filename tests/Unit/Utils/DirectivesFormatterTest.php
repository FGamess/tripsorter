<?php

use Util\DirectivesFormatter as SUT;
use Util\BoardingCardList;
use Api\Model\DataSource;

/**
 * Description of DirectivesFormatterTest
 *
 * author Franck GAMESS <franck.gamess@gmail.com>
 */
class DirectivesFormatterTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     * @var DirectivesFormatter
     */
    public $directivesFormatter;
    
    public function setUp()
    {
        $this->directivesFormatter = new SUT();
    }
    
    /**
     * @test
     * @group unit_utils
     * @dataProvider cardListProvider
     */
    public function getDirectivesReturnsFormattedDirectives($count, $cardList, $expected)
    {
        $this->assertEquals($expected, $this->directivesFormatter->getDirectives($cardList)[$count]);
    }
    
    public function cardListProvider()
    {
        $datasource = DataSource::getInstance();
        $boardingCards = $datasource->getUnorderedBoardingCardsSet();
        
        $cardList =  new BoardingCardList($boardingCards);
        $count = $cardList->count();
        return [
            [$count, $cardList, ++$count.". You have arrived at your final destination."]
        ];
    }
}
