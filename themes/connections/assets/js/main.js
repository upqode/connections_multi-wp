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

    var
        // playerData        = ( typeof liquiData.brigtcovePlayerData == 'object' ) ? liquiData.brigtcovePlayerData : {},
        currentPlayerID   = '',
        autoplay          = false,
        iconClass         = '',
        animateClass      = 'fa fa-spinner fa-spin fa-3x fa-fw',
        $itemsBC          = $('.js-item-BC'),
        errorMessage      = 'Can\'t reproduce. Please verify the entered data for this player.',
        $itemBC           = $(''),
        $icon             = $('');

    var  isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

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


    /* ------------------------------------------- */
    /* Magnific Popup */
    /* ------------------------------------------- */

    $('.js-popup').magnificPopup({
        type: 'inline',
        preloader: false,
        closeBtnInside: true,
        // closeOnBgClick: false,
        callbacks: {
        open: function() {

            var magnificPopup   = $.magnificPopup.instance,
                $current        = magnificPopup.st.el,
                classes         = $current.attr('class');

            // window.scrollTop = window.scrollY;
            $('body, html').addClass('no-scroll');
            // $('.lk-content-wrapp--full-height').closest('body').addClass('lk-full-height-popup');
            // calculatePopupHeight();
            // window.addEventListener('resize', calculatePopupHeight );

            // if ( classes.indexOf('js-lazy-load-iframe') != -1 ) {
            //   console.log( $.magnificPopup.instance );
            //   lazyLoadIframe( $( $current.attr('href') ).find('.js-lazy-loader-iframe') );
            // }

            // if ( classes.indexOf('js-lazy-load-asset-pdf') != -1 ) {
            //   lazyLoadIframe( $( $current.attr('href') ).find('.wonderplugin-pdf-iframe[data-src]') );
            //   $( $current.attr('href') ).find('.wonderplugin-pdf-iframe[data-src]').addClass('wonderplugin-pdf-iframe');
            // }

        },
        beforeClose: function() {
            var $video = $('.mfp-ready').find('.video-js');
            if ( $video.length ) {
            videojs( $video.attr('id') ).pause();
            }
        },
        close: function() {
            $('body, html').removeClass('no-scroll').removeClass('lk-full-height-popup');
            // window.removeEventListener('resize', calculatePopupHeight);
            // $(window).scrollTop( window.scrollTop );
            $('.js-popup').removeClass('active');
        }
        }
    });

    /* ------------------------------------------- */
    /* LAZY LOAD IFRAME */
    /* ------------------------------------------- */
    function lazyLoadIframe( $iframeLoader ) {

        if ( ! $iframeLoader.hasClass('html-init') ) {
            var $iframe = $('<iframe/>', {
                src : $iframeLoader.attr('data-src'),
            });
            $iframeLoader.addClass( 'html-init' );
        }

        if ( typeof $iframe !== typeof undefined ) {

            $iframe.addClass( $iframeLoader.attr('data-class') );

            if ( $iframeLoader.hasClass( 'wonderplugin-pdf-iframe' ) ) {
                $iframe.addClass( 'wonderplugin-pdf-iframe' );
            }

            $iframeLoader.before( $iframe ).hide();

        }

    }


    /* ------------------------------------------- */
    /* LOAD ASSETS IFRAME ON CLICK */
    /* ------------------------------------------- */

    $('.js-item-html').on('click', function() {

        var $this       = $(this),
            id          = $this.attr('href'),
            $iframeData = $( id ).find('.js-iframe-html');

        lazyLoadIframe( $iframeData );

    });

    // Load asset with page
    if ( $('.js-video-BC').length ) {
        BCenqueueScript();
    }

    /* ------------------------------------------- */
    /* - HEADER */

    /* ------------------------------------------- */
    function openMenu() {
        $('.js-nav-menu-btn').toggleClass('cn-menu-btn--active');
        $('.js-header-nav').toggleClass('cn-header__nav--active');
        if ($('.z-overlay').is(':visible')) {
            $('.z-overlay').hide();
        } else {
            $('.z-overlay').show();
        }
    }

    $('.z-overlay').on('click', function () {
        $('.js-nav-menu-btn').removeClass('cn-menu-btn--active');
        $('.js-header-nav').removeClass('cn-header__nav--active');
        $(this).hide();
    });

    /* Menu Btn */
    $('.js-nav-menu-btn').on('click', function (e) {
        e.preventDefault();
        openMenu();
    });

    var $firstChildLink = $('.cn-header .menu > .menu-item-has-children > a').append('<span class="fa fa-angle-left"></span>');

    $('.cn-header .menu > .menu-item-has-children').each(function () {
        var $this = $(this),
            $sub_menu = $this.find('> .sub-menu');
        $(this).find('> a').on('click', function(e){
            e.preventDefault();
        })
        if (!$sub_menu.find('.clone-menu-item').length) {
            $sub_menu.prepend('<li class="clone-menu-item"><span class="fa fa-angle-right"></span><span class="back-title js-back-text"></span></li>');
            var $clone_item = $sub_menu.find('> .clone-menu-item');
            $clone_item.find('span')[1].addEventListener('click', function (e) {
                if($(window).width() > 767) {
                    var height_prev = $('.js-header .menu').height();
                    $('.js-header .cn-header__inner').css('height', height_prev);
                }
                moveMenu('toRight');
                $('.sub-menu').removeClass('active');
            }, false);
        }
    });

    $('.menu >.menu-item-has-children a').each(function (index, el) {
        $(el)[0].addEventListener('click', function (e) {
            if($(window).width() > 767) {
                var sub_menus = document.querySelectorAll('.cn-header__inner .sub-menu');
                var h_counter = 0;
                for( var i = 0; i < sub_menus.length; i++ ) {
                    if(sub_menus[i].scrollHeight > h_counter) {
                        h_counter = sub_menus[i].scrollHeight;
                    }
                }
                $('.js-header .cn-header__inner').css('height', h_counter);
            }
            var temp_name = $(this).html().split('<span')[0];
            $('.sub-menu').removeClass('active');
            $(this).closest('.sub-menu').addClass('active');
            $(this).next('ul').addClass('active').find('.js-back-text').html(temp_name);
            moveMenu();
        }, false);
    });

    function goBack() {
        moveMenu('toRight');
        $('.sub-menu').removeClass('active');

    }

    function goNext(e) {
        e.preventDefault();
        // if(move) {
        $('.sub-menu').removeClass('active');
        $(this).closest('.sub-menu').addClass('active');
        $(this).next('ul').addClass('active');
        // swipe menu

        moveMenu();
        // }
    }

    var show_level = 0;

    function moveMenu(direction) {
        var submenu_count = $('.sub-menu.active').length;

        if (direction == 'toRight') {
            show_level--;
        } else {
            show_level++;
        }

        if (show_level < 0) show_level = 0;
        if (show_level >= submenu_count) show_level = submenu_count;

        $('.cn-header .menu').css('transform', 'translateX(-' + (show_level * 100) + '%)');

    }

    function menuFixedHeight() {
        if ($('.js-sticky-header').length) {
            var fixedMenuHeight = $('.js-sticky-header').innerHeight();
            $('.js-sticky-container').css('height', fixedMenuHeight);
        }
    }

    /* ------------------------------------------- */
    /* SEARCH */
    /* ------------------------------------------- */
    $('.js-form-toggle-wrapp .search-submit').prop('disabled', true);

    $(document).on('click touchstart', function () {
        $('.js-form-toggle-wrapp').removeClass('is-active');
        $('.js-form-toggle-wrapp .search-form input').blur();
        $('.js-form-toggle-wrapp .search-submit').prop('disabled', true);
    });

    $('.js-form-toggle-wrapp').on('click touchstart', '.search-form input, .js-form-toggle-btn', function (e) {
        e.stopPropagation();
        $('.js-form-toggle-wrapp').addClass('is-active');
        setTimeout(function () {
            $('.js-form-toggle-wrapp .search-submit').prop('disabled', false);
        }, 1000);
    });

    /* ------------------------------------------- */
    /* DROPDOWN */
    /* ------------------------------------------- */
    var eventHamburger = isIOS ? 'touchstart' : 'click';
    $(document).on(eventHamburger, function () {
        $('.js-dropdown-btn').removeClass('is-active');
        $('.js-dropdown-btn').find('i').removeClass('fa-close');
        $('.js-dropdown').removeClass('is-active');
    });

    $('.js-dropdown-btn').on(eventHamburger, function (e) {
        e.stopPropagation();
        if ($(this).hasClass('is-active')) {
            $(this).removeClass('is-active');
            $(this).find('i').removeClass('fa-close');
            var dropmenu = '#' + $(this).attr('data-dropdown');
            $(dropmenu).removeClass('is-active');
        } else {
            $('.js-dropdown-btn').removeClass('is-active');
            $('.js-dropdown-btn').find('i').removeClass('fa-close');
            $('.js-dropdown').removeClass('is-active');
            $(this).addClass('is-active');
            $(this).find('i').addClass('fa-close');
            var dropmenu = '#' + $(this).attr('data-dropdown');
            $(dropmenu).addClass('is-active');
        }
        e.preventDefault();
    })

    $('.js-dropdown, .js-nav-menu-btn, .js-header-nav').on(eventHamburger, function (e) {
        e.stopPropagation();
    });
})(jQuery, window, document);