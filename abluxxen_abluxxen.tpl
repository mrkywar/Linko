{OVERALL_GAME_HEADER}

<!-- 
--------
-- BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
-- abluxxen implementation : © <Your name here> <Your email address here>
-- 
-- This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
-- See http://en.boardgamearena.com/#!doc/Studio for more information.
-------

    abluxxen_abluxxen.tpl
    
    This is the HTML template of your game.
    
    Everything you are writing in this file will be displayed in the HTML page of your game user interface,
    in the "main game zone" of the screen.
    
    You can use in this template:
    _ variables, with the format {MY_VARIABLE_ELEMENT}.
    _ HTML block, with the BEGIN/END format
    
    See your "view" PHP file to check how to set variables and control blocks
    
    Please REMOVE this comment before publishing your game on BGA
-->

<div id="gamepanel">
    <div class="container">
        <div id="carddeck" >
            <div class="whiteblock">
                DECK
                <div id="aviableDraw">
                </div>
            </div>
        </div>
        <div id="playertables">
            <!-- BEGIN player -->
            <div class="playertable whiteblock playertable">
                <div class="playertablename" style="color:#{PLAYER_COLOR}">
                    {PLAYER_NAME}
                </div>
                <div class="playertablecard" id="playertable_{PLAYER_ID}">
                </div>
            </div>
            <!-- END player -->
            <div id="myhand_wrap" class="whiteblock">
                <h3>{MY_HAND}</h3>
                <div id="myhand">
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>

</div>




<script type="text/javascript">
    //var jstpl_card = '<div class="ntx-card collection-${number}" id="collection-${player}-${number}" style="background-position:-${x}% -${y}%;z-index:${z}"></div>';
</script>  

{OVERALL_GAME_FOOTER}
