<?php

namespace Linko\States\StateAdapters;

use Linko;
use Linko\CardsCollection\Collection;
use Linko\Managers\Deck\Deck;
use Linko\Managers\Logger;
use Linko\Managers\StateManager;
use Linko\Models\Factories\StateFactory;
use Linko\Models\Player;
use Linko\Models\State;
use Linko\Repository\StateRepository;

/**
 * Description of CollectionTakeableStateFactory
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
class CardsTakeableStateAdapter {

    /**
     * 
     * @var StateManager
     */
    private $stateManager;

    /**
     * 
     * @var StateRepository
     */
    private $stateRepository;

    public function __construct() {
        $this->stateManager = Linko::getInstance()->getStateManager();
        $this->stateRepository = $this->stateManager->getRepository();
    }

    /**
     * 
     * @return State
     */
    private function getLastOrder() {
        $endOfTurn = $this->stateRepository
                ->setDoUnserialization(true)
                ->getLastState();
        return $endOfTurn;
    }

    public function adapt(Player $activePlayer, Collection $targetedCollection) {
        $activePlayerId = $activePlayer->getId();
        $targetPlayerId = $targetedCollection->getPlayer()->getId();

        $states = [];
        $lastState = $this->getLastOrder();
        $stateOrder = $lastState->getOrder();

        //---- STATE STEAL CARD
        $states[] = StateFactory::create(
                        ST_PLAYER_STEAL_CARDS,
                        $stateOrder,
                        $activePlayerId,
                        [
                            "targetCollection" => Deck::COLLECTION_NAME . "_" . $targetPlayerId . "_" . $targetedCollection->getCollectionIndex(),
                            "location" => $targetedCollection->getCardAt()->getLocation(),
                            "locationArg" => $targetedCollection->getCardAt()->getLocationArg(),
                            "targetPlayer" => $targetedCollection->getPlayer()->getName()
                        ]
        );

        //---- STATE END STEAL
        $states[] = StateFactory::create(
                        ST_END_OF_STEAL,
                        $stateOrder,
                        $activePlayerId
        );

        //---- STATE DRAW PLAYER
        $states[] = StateFactory::create(
                        ST_PLAYER_DRAW,
                        $stateOrder,
                        null,
                        [
                            "numberOfCards" => $targetedCollection->getCountCards()
                        ]
        );

        //-- Insert new states
        $this->stateRepository->create($states);
        $log = $activePlayer->getName()." attack "
                .$targetedCollection->getPlayer()->getName()." and steal "
                .$targetedCollection->getCountCards()." cards ";
        Logger::log("Add ".count($states)." states ");
        
//        var_dump($states);

        //---- LAST STATE UPD
        $lastState->setOrder($stateOrder);
        $this->stateRepository->update($lastState);
    }

}
