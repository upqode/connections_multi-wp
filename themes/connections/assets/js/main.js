/* SCRIPT.JS */
/* ------------------------------------------------------------------------------------------------------- */
/* This is main JS file that contains custom rules used in this template */
/* ------------------------------------------------------------------------------------------------------- */

/* -------------------------------------------------------- */
/* TABLE OF CONTENTS: */
/* -------------------------------------------------------- */
/*
  
*/
/* -------------------------------------------------------- */
;
(function ($, window, document, underfined) {

    let connectionsData = ( typeof connections_data == 'object' ) ? connections_data : {};

  
    /* ------------------------------------------- */
    /* LOAD BRIGTCOVE PLAYER DUNAMICALLY */
    /* ------------------------------------------- */

    var playerData        = ( typeof connectionsData.brigtcovePlayerData == 'object' ) ? connectionsData.brigtcovePlayerData : {},
        currentPlayerID   = '',
        autoplay          = false,
        iconClass         = '',
        animateClass      = 'fa fa-spinner fa-spin fa-3x fa-fw',
        $itemsBC          = $('.js-item-BC'),
        errorMessage      = 'Can\'t reproduce. Please verify the entered data for this player.',
        $itemBC           = $(''),
        $icon             = $('');


    $('.js-item-BC').on('click', function(e) {

        e.preventDefault();

        var 
            $this           = $(this),
            typeAudio       = $this.attr('data-type-audio'),
            customAudioSrc  = $this.attr('data-custom-audio-src');

        // Custom audio file
        if ( typeAudio == 'custom' && customAudioSrc ) {

        var $audio = $this.find('audio');
        

        if ( ! $audio.length ) {

            var customAudio = loadMP3( customAudioSrc );
            $this.prepend( customAudio );
            customAudio.play();
            $this.addClass('player-init');
            controlMP3( $this, customAudio );

        } else {

            $audio[0].play();

            if ( $this.hasClass('player-init') ) {
            $this.find('audio')[0].pause();
            $this.removeClass('player-init');
            } else {
            $this.addClass('player-init');
            controlMP3( $this, $audio[0] );
            }

            console.log( $this.attr('class') );

        }
        
        return false;
        }


        // Brigtcove
        if ( $this.hasClass('player-init') ) {
            videojs( currentPlayerID ).pause();
            $itemBC.removeClass('player-init');
        } else if ( autoplay ) {
            videojs( currentPlayerID ).play();
            $itemBC.addClass('player-init');
        }


        var 
            id            = ( $this.attr('data-href') ) ? $this.attr('data-href') : $this.attr('href'),
            $player       = $( id ).find('.js-lazy-load-BC'),
            playID        = $player.attr('data-video-id'),
            isLoaded      = $player.find('video-js').length;

        // Check errors
        if ( ! $player.length ) {
            console.warn( 'Player not found' );
            return false;
        }
        if ( $this.hasClass('player-error') ) {
            alert( errorMessage );
            return false;
        }

        // Stop current player
        if ( currentPlayerID && currentPlayerID != 'bc-player-' + playID ) {
            videojs( currentPlayerID ).pause();
            $itemsBC.removeClass('player-init');
        }
            
        currentPlayerID   = 'bc-player-' + playID;
        autoplay          = $player.attr('data-autoplay');
        $itemBC           = $this;
        $icon             = $this.find('.fa');
        iconClass         = $icon.attr('class');

        if ( isLoaded ) {
        
        if ( $itemBC.hasClass('player-init') ) {
            videojs( currentPlayerID ).pause();
            $itemBC.removeClass('player-init');
        } else if ( autoplay ) {
            videojs( currentPlayerID ).play();
            $itemBC.addClass('player-init');
        }
        
        } else {

            $this.addClass('player-start');
            $itemsBC.addClass('player-freezed');

            // Add icon load
            $icon.attr('class', '').addClass( animateClass );

            buildPlayerBC( $player );
        }   

    });

    // Generate source for player
    function BCenqueueScript() {

        var playerSrc = document.createElement("script");
            playerSrc.src =
            "//players.brightcove.net/" +
            playerData.accountId +
            "/" +
            playerData.playerId +
            "_default/index.min.js";

        // Add the script tag to the document
        document.body.appendChild( playerSrc );

        return playerSrc;

    }


    // Build the player and place in HTML DOM
    function buildPlayerBC( $player ) {

        // Dynamically build the player video element
        var 
            playID = $player.attr('data-video-id'),
            playerHTML =
            '<video-js id="bc-player-' + playID +'" data-video-id="' +
            playID +
            '"  data-account="' +
            playerData.accountId +
            '" data-player="' +
            playerData.playerId +
            '" data-embed="default" class="' + $player.attr('data-class') + '" controls></video-js>';

        // Inject the player code into the DOM
        if ( ! $player.text() ) {
            $player.append( playerHTML );
            var player = BCenqueueScript();
            player.onload = initPlayerBC;
        }
        
    }

    // Initialize the player and start the video
    function initPlayerBC() {
        var player = bc( currentPlayerID );

        // Error player
        player.on('error', function() {
            $itemBC.removeClass('player-start').addClass('player-error');
            $icon.removeClass( animateClass ).addClass( iconClass );
            $itemsBC.removeClass('player-freezed');
            alert( errorMessage );
        });

        // Can also use the following to assign a player instance to the variable if you choose not to use IDs for elements directly
        player.on('loadedmetadata', function() {

            // Mute the audio track, if there is one, so video will autoplay on button click
            // player.muted(true);

            if ( autoplay ) {
                player.play();
                $itemBC.removeClass('player-start').addClass('player-init');
            }

            // Add icon load
            $icon.removeClass( animateClass ).addClass( iconClass );
            $itemsBC.removeClass('player-freezed');
        
        });

        videojs( currentPlayerID ).play();

        // Finished track
        player.on('ended', function () {
            $itemBC.removeClass('player-init');
        });

    }

    // Load asset with page
    if ( $('.js-video-BC').length ) {
        BCenqueueScript();
    }

})(jQuery, window, document);