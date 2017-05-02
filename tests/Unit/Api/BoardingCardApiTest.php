<?php

use Api\V1\BoardingCardApi as SUT;

/**
 * Description of BoardingCardApiTest
 *
 * @author Franck GAMESS <franck.gamess@gmail.com>
 */
class BoardingCardApiTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     * @var BoardingCardApi
     */
    public $boardingCardApi;
    
    /**
     * @test
     * @group unit_api
     * @runInSeparateProcess
     */
    public function processApiReturnsJson()
    {
        $this->boardingCardApi = new SUT('boarding_cards', 'localhost');
        
        $actual = $this->boardingCardApi->processAPI();
                
        $this->assertJson($actual);
        
        $this->assertEquals('"Only accepts GET or POST requests"', $actual);
    }
}