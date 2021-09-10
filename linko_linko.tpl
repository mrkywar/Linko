{OVERALL_GAME_HEADER}


<div id="gamepanel">
    <div class="container">
        <div id="carddeck" >
            <div class="whiteblock">
                DRAW
                <div id="aviableDraw">
                </div>
                <div class="clear"></div>
            </div>
            <div class="whiteblock">
                DECK
                <div id="deck">
                </div>
                <div class="clear"></div>
            </div>
            <div class="whiteblock">
                DISCARD
                <div id="discard">
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
            <div  class="playertable whiteblock playertable">
                 <div class="playertablename" style="color:#\${player_color}">
                    \${player_name}
                 </div>
                 <div class="playertablecard" id="playertable_\${player_id}">
                </div>
            </div>
            `;

    var jstpl_myhand = `
            <div id="myhand_wrap" class="whiteblock">
                <h3>{MY_HAND}</h3>
                <div id="myhand">
                </div>
            </div>
    `;
    
    
    var jstpl_card = `
        <div class="cardontable card_\${card_type}" data-id="\${card_id}">
        </div>
    `;
    
    var jstpl_deck = `
        <div class="cardontable card_0">
            <div class="deck-status">\${deck}</div>
        </div>
    `;
    
    var jstpl_discard = `
        <div class="cardontable discard card_\${last}">
            <div class="deck-status">\${discard}</div>
        </div>
    `;
    

    //var jstpl_card = '<div class="ntx-card collection-${number}" id="collection-${player}-${number}" style="background-position:-${x}% -${y}%;z-index:${z}"></div>';
</script>  

{OVERALL_GAME_FOOTER}
