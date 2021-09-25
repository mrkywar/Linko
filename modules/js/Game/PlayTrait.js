

define([
    'dojo',
    'dojo/_base/declare',
    'ebg/core/gamegui',

    g_gamethemeurl + 'modules/js/Core/ToolsTrait.js'
], function (dojo, declare) {
    return declare(
            'linko.PlayTrait',
            [
                common.ToolsTrait
            ],
            {

                constructor: function () {
                    this.debug('linko.playTrait constructor');
                },

                initalizePlayNumber: function () {
                    this.addActionButton('completeSelection_button', _('Play cards'), 'onCompleteSelection', null, false, 'red');
                    this.addActionButton('unselectSelection_button', _('Reset'), 'onSelectionReset', null, false, 'gray');

                    dojo.query("#myhand .cardontable").addClass("selectable");
                    dojo.connect("#myhand .cardontable", 'onHandClick', (evt) => {
                        evt.preventDefault();
                        evt.stopPropagation();
                        this.onClickCard(this);
                    });

                },

                /* -------------------------------------------------------------
                 *                  BEGIN - Btn Actions
                 * ---------------------------------------------------------- */

                onSelectionReset: function () {
                    dojo.query('#myhand .selected').removeClass("selected");
                    this.selectedJokers = [];
                    this.selectedNumber = null;
                },

                onCompleteSelection: function () {
                    var cards = dojo.query('#myhand .selected').map((card) => {
                        return dojo.attr(card, 'data-id');
                    });
                    this.debug('cards : ', cards);
                    this.ajaxcall("/" + this.game_name + "/" + this.game_name + "/playCards.html", {
                        ids: cards.toString(),
                        lock: true
                    }, this, function (result) {
                        this.debug("Play :", result);
                    }, function (is_error) {
                        //--error
                        this.debug("Play fail:", is_error);
                    });

                },

                getCardInHand: function (targetedCard) {
                    var cardId = targetedCard.target.attributes['data-id'].value;
                    return this.handCards[cardId];
                },

                onClickCard(targetedCard) {
                    var card = this.getCardInHand(targetedCard);
                    var cardType = card.card_type;
                    if ("14" === cardType) {
                        var pos = this.selectedJokers.indexOf(card.card_id);
                        if (pos >= 0) {
                            dojo.query('#myhand #linko_card_' + card.card_id).removeClass("selected");
                            this.selectedJokers.splice(pos, 1);
                        } else {
                            dojo.query('#myhand #linko_card_' + card.card_id).addClass("selected");
                            this.selectedJokers.push(card.card_id);
                        }
                    } else if (null === this.selectedNumber) {
                        dojo.query('#myhand .card_' + cardType).addClass("selected");
                        this.selectedNumber = cardType;
                    } else if (this.selectedNumber !== cardType) {
                        dojo.query('#myhand .card_' + this.selectedNumber).removeClass("selected");
                        dojo.query('#myhand .card_' + cardType).addClass("selected");
                        this.selectedNumber = cardType;
                    } else {
                        if (targetedCard.target.attributes['class'].value.indexOf("selected") > 0) {
                            dojo.query('#myhand #linko_card_' + card.card_id).removeClass("selected");
                        } else {
                            dojo.query('#myhand #linko_card_' + card.card_id).addClass("selected");
                        }

                    }

                },

                /* -------------------------------------------------------------
                 *                  BEGIN - Notifications
                 * ---------------------------------------------------------- */
                notifPlayNumber(datas) {
                    this.debug('NPN', datas.args);
                    var collection = {
                        collection_index: datas.args.collectionIndex,
                        add_class: "debug"
                    };

                    var collectionDiv = dojo.place(this.format_block('jstpl_collection', collection), datas.args.destination);

                    for (var cardId in datas.args.cardIds) {
//                        this.debug('NPN-2', cardId);
//                        this.debug('NPN-3',  datas.args.cardIds[cardId]);
//
//                           var divId = "linko_card_"+datas.args.cardIds[cardId];
//                           this.slideToObject( "linko_card_"+datas.args.cardIds[cardId], collectionDiv ).play();

                    }
                }

            });




});

//                        dojo.query('#myhand .selected').map((card) => {
//                            
////                            return dojo.attr(card, 'data-id');
//                        });


//                        this.slideToObject( mobile_obj, target_obj, duration, delay )

//You can use slideToObject to "slide" an element to a target position.
//
//Sliding element on the game area is the recommended and the most used way to animate your game interface. Using slides allow players to figure out what is happening on the game, as if they were playing with the real boardgame.
//
//The parameters are:
//
//mobile_obj: the ID of the object to move. This object must be "relative" or "absolute" positioned.
//target_obj: the ID of the target object. This object must be "relative" or "absolute" positioned. Note that it is not mandatory that mobile_obj and target_obj have the same size. If their size are different, the system slides the center of mobile_obj to the center of target_obj.
//duration: (optional) defines the duration in millisecond of the slide. The default is 500 milliseconds.
//delay: (optional). If you defines a delay, the slide will start only after this delay. This is particularly useful when you want to slide several object from the same position to the same position: you can give a 0ms delay to the first object, a 100ms delay to the second one, a 200ms delay to the third one, ... this way they won't be superposed during the slide.
//BE CAREFUL: The method returns an dojo.fx animation, so you can combine it with other animation if you want to. It means that you have to call the "play()" method, otherwise the animation WON'T START.
//
//Example:
//
//   this.slideToObject( "some_token", "some_place_on_board" ).play();
                      