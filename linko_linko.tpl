{OVERALL_GAME_HEADER}

<div id="gamepanel">
    <div class="container">
        <div id="carddeck" >
            <div class="">
                <div id="aviableDraw">
                </div>
                <div class="clear"></div>
            </div>
            <div class="">
                <div id="deck">
                </div>
                <div class="clear"></div>
            </div>

        </div>
        <div id="board">

        </div>
    </div>
    <div class="clear"></div>

</div>




<script type="text/javascript">
    var jstpl_player_board = `
            <div  class="playertable whiteblock playertable" id="player_board_\${player_id}" >
                <div class="playertablename" style="color:#\${player_color}">
                    \${player_name}
                </div>
                <div class="playertablecard" id="playertable_\${player_id}">
                </div>
                <div class="clear"></div>
            </div>
            `;
    
    var jstpl_myhand = `
            <div id="myhand_wrap" class="whiteblock">
                <h3>{MY_HAND}</h3>
                <div id="myhand">
                </div>
                <div class="clear"></div>
            </div>
    `;
    
    var jstpl_card = `
        <div class="cardontable card_\${card_type}" id="\${card_location}_card_\${card_id}" data-id="\${card_id}">
        </div>
    `;
    
    var jstpl_deck = `
        <div class="cardontable card_0">
            <div class="count-status">\${deck}</div>
        </div>
    `;
    
    var jstpl_discard = `
        <div class="cardontable discard card_\${last}" id="discard">
            <div class="count-status">\${discard}</div>
        </div>
    `;
    
    var jstpl_collection = `
        <div class="collection collection_\${collection_index}" id="collection_\${player_id}_\${collection_index}" style="z-index:\${collection_index}0">
        </div>
    `;
</script>  

{OVERALL_GAME_FOOTER}
