<?php

namespace Util;

/**
 * Description of DirectivesFormatter
 *
 * @author Franck GAMESS <franck.gamess@gmail.com>
 */
class DirectivesFormatter
{
    /**
     * 
     * @param \Util\BoardingCardList $cardList
     * @return array
     */
    public function getDirectives(BoardingCardList $cardList)
    {
        $boardingCards = $cardList->getBoardingCards();
        
        $directives = [];
        foreach ($boardingCards as $key => $boardingCard) {
            $directives[] = ++$key.". ".$boardingCard->getDirectives();
        }

        $count = $cardList->count();

        $directives[] = ++$count.". You have arrived at your final destination.";
        
        return $directives;
    }
}
