<?php
namespace Linko\CardsCollection;


/**
 *
 * @author Mr_Kywar mr_kywar@gmail.com
 */
abstract class CardsToCollectionTransformer {

    /**
     * 
     * @param array $cards
     * @return Collection
     */
    public static function adapt(array $cards) {
        $collection = new Collection();
        foreach ($cards as $card) {
            $collection->addCard($card);
//            if (null === $collection->getNumber() || intval($card->getType()) < $collection->getNumber()) {
//                $collection->setNumber(intval($card->getType()));
//            }
        }
        return $collection;
    }

}
