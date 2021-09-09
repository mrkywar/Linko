{OVERALL_GAME_HEADER}


<div id="gamepanel">
    <div class="container">
        <div id="carddeck" >
            <div class="whiteblock">
                DECK
                <div id="aviableDraw">
                </div>
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

    //var jstpl_card = '<div class="ntx-card collection-${number}" id="collection-${player}-${number}" style="background-position:-${x}% -${y}%;z-index:${z}"></div>';
</script>  

{OVERALL_GAME_FOOTER}
