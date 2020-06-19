"use strict";

  /* ------------------------------------------- */
  /* - INIT */
  /* ------------------------------------------- */
  var swipers   = [],
      liquiData = ( typeof liquid_data == 'object' ) ? liquid_data : {};

  var xlBPoint = 1400,
    //   lgBPoint = 1200,
    //   mdBPoint = 992,
    smBPoint = 768;
  //   xsBPoint = 480,
  var isMobile = navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i),
      isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

  if (typeof pageCalculations !== 'function') {
    var winW,
      winH,
      winS,
      pageCalculations,
      onEvent = window.addEventListener;

    pageCalculations = function (func) {
      winW = window.innerWidth;
      winH = window.innerHeight;
      winS = $(window).scrollTop();

      if (!func) return;
      onEvent('load', func, true); // window onload
      onEvent('resize', func, true); // window resize
      onEvent('orientationchange', func, false); // window orientationchange
    };

    pageCalculations(function () {
      pageCalculations();
    });
  }

  //Check Mobile Devices
  var checkMobile = function(){
    var isTouch = ('ontouchstart' in document.documentElement);

    //Check Device // All Touch Devices
    if ( isTouch ) {
      // alert('touch');
      $('html').addClass('touch');
    } else {
      // alert('no touch');
      $('html').addClass('no-touch');
    };
  };

  // Execute Check
  checkMobile();

  /* ------------------------------------------- */
  /* If page load in iframe */
  /* ------------------------------------------- */
  if ( window.frameElement ) {
    $('body').addClass('load-in-frame');
  } else {
    $('body').addClass('loaded-page');
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
  $(document).on( eventHamburger, function () {
    $('.js-dropdown-btn').removeClass('is-active');
   // $('.lk-header__nav').removeClass('lk-header__nav--active');
   // $('.js-nav-menu-btn').removeClass('lk-nav-menu-btn--active');
    $('.js-dropdown-btn').find('i').removeClass('fa-close');
    $('.js-dropdown').removeClass('is-active');
  });

  $('.js-dropdown-btn').on( eventHamburger, function (e) {
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

  $('.js-dropdown, .js-nav-menu-btn, .js-header-nav').on( eventHamburger, function (e) {
    e.stopPropagation();
  });

  /* ------------------------------------------- */
  /* POPUP */
  /* ------------------------------------------- */
  function calculatePopupHeight() {
    if ($('.js-header').length) {
      var headerHeight = $('#wpadminbar').innerHeight() + $('.js-header').innerHeight();
      var headerHeightString = 'calc(100% - ' + headerHeight + 'px)';
      var headerHeightViewString = 'calc(100vh - ' + headerHeight + 'px)';
      $('.mfp-bg').css({top: headerHeight, height: headerHeightString});
      $('.mfp-wrap').css({top: headerHeight, height: headerHeightString});
      $('.lk-content-wrapp--full').css({height: headerHeightViewString});
    }
  }

  $('.js-popup').magnificPopup({
    type: 'inline',
    preloader: false,
    closeBtnInside: true,
    closeOnBgClick: false,
    callbacks: {
      open: function() {

        var magnificPopup   = $.magnificPopup.instance,
            $current        = magnificPopup.st.el,
            classes         = $current.attr('class');

        window.scrollTop = window.scrollY;
        $('body, html').addClass('no-scroll');
        $('.lk-content-wrapp--full-height').closest('body').addClass('lk-full-height-popup');
        calculatePopupHeight();
        window.addEventListener('resize', calculatePopupHeight);

        if ( classes.indexOf('js-lazy-load-iframe') != -1 ) {
          console.log( $.magnificPopup.instance );
          lazyLoadIframe( $( $current.attr('href') ).find('.js-lazy-loader-iframe') );
        }

        if ( classes.indexOf('js-lazy-load-asset-pdf') != -1 ) {
          lazyLoadIframe( $( $current.attr('href') ).find('.wonderplugin-pdf-iframe[data-src]') );
          $( $current.attr('href') ).find('.wonderplugin-pdf-iframe[data-src]').addClass('wonderplugin-pdf-iframe');
        }

      },
      beforeClose: function() {
        var $video = $('.mfp-ready').find('.video-js');
        if ( $video.length ) {
          videojs( $video.attr('id') ).pause();
        }
      },
      close: function() {
        $('body, html').removeClass('no-scroll').removeClass('lk-full-height-popup');
        window.removeEventListener('resize', calculatePopupHeight);
        $(window).scrollTop( window.scrollTop );
        $('.js-popup').removeClass('active');
      }
    }
  });

  /* ------------------------------------------- */
  /* FIXED SIDEBAR */
  /* ------------------------------------------- */
  var sidebar = {
    selector: '.js-sidebar-wrapp',
    initialized: false,
    covers: [],
    start: 0,
    stop: 0,
    initialize: function () {
      var that = this;

      // if this is a touch device initialize simple image
      if (winW < smBPoint) {
        if (that.covers) {
          $('.js-sidebar').removeAttr('style');
          that.covers = [];
        }

        return;
      }
      that.covers = [];

      $(that.selector).each(function (index, element) {
        var group = new Object;

        group.side = $(element).find($('.js-sidebar'));
        group.start = $(element).offset().top;
        group.stop = $(element).offset().top + $(element).innerHeight();

        that.covers.push(group);
      });

      this.initialized = true;
      // update progress on the timelines to match current scroll position
      that.update();
    },
    update: function () {

      // if this is a touch device initialize simple image
      if (winW < smBPoint) {
        return;
      }

      $(this.covers).each(function (index, element) {
        // var elStart = element.start;
        // var elStop = element.stop;
        //4676
        //5420

        var columnWrap = document.querySelector('.lk-asset-library__col--left');
        var columnWrapTop = columnWrap.getBoundingClientRect().top;
        var sidebarWrap = document.querySelector('.js-sidebar');

        if (columnWrapTop > 50) {
          columnWrap.classList.remove('sidebar-fixed-top');
          columnWrap.classList.remove('sidebar-fixed-bottom');
        } else if (columnWrapTop < 50) {
          columnWrap.classList.add('sidebar-fixed-top');
          columnWrap.classList.remove('sidebar-fixed-bottom');
        }
        if (columnWrap.getBoundingClientRect().bottom < (sidebarWrap.getBoundingClientRect().height + 50) && columnWrap.classList.contains('sidebar-fixed-top')) {
          columnWrap.classList.remove('sidebar-fixed-top');
          columnWrap.classList.add('sidebar-fixed-bottom');
        }
        // if ($(window).scrollTop() < elStart) {

        //   $('.js-sidebar').css('margin-top', 0);

        // } else if ($(window).scrollTop() > elStart && $(window).scrollTop() < (elStop - $(element.side[0]).innerHeight() - $('.js-sticky-header').innerHeight())) {

        //   $('.js-sidebar').css('margin-top', $(window).scrollTop() - elStart + $('.js-sticky-header').innerHeight());
        // } else if ($(window).scrollTop() > (elStop - $(element.side[0]).innerHeight() - $('.js-sticky-header').innerHeight())) {
        // }
      });
    },
  };

  /* ------------------------------------------- */
  /* - HEADER */
  /* ------------------------------------------- */
  function openMenu() {
    $('.js-nav-menu-btn').toggleClass('lk-nav-menu-btn--active');
    $('.js-header-nav').toggleClass('lk-header__nav--active');
    if($('.z-overlay').is(':visible')) {
      $('.z-overlay').hide();
    } else {
      $('.z-overlay').show();
    }
  }

  $('.z-overlay').on('click', function() {
    $('.js-nav-menu-btn').removeClass('lk-nav-menu-btn--active');
    $('.js-header-nav').removeClass('lk-header__nav--active');
    $(this).hide();
  });

  /* Menu Btn */
  $('.js-nav-menu-btn').on('click', function (e) {
    e.preventDefault();
    openMenu();
  });

  var $firstChildLink = $('.lk-header .main-menu > .menu-item-has-children > a').append('<span class="fa fa-angle-right"></span>');

  $('.lk-header .main-menu > .menu-item-has-children').each(function () {
    var $this = $(this),
      $sub_menu = $this.find('> .sub-menu');
    if (!$sub_menu.find('.clone-menu-item').length) {
      $sub_menu.prepend('<li class="clone-menu-item"><span class="fa fa-angle-left"></span></li>');
      var $clone_item = $sub_menu.find('> .clone-menu-item');
      $clone_item.append($this.find('> a').clone());
      $this.find('> a').on('click', function () {
        return false;
      });
      // $clone_item.find('span')[0].addEventListener('click', goBack(), false);
      $clone_item.find('span')[0].addEventListener('click', function () {
		// if ( $(this).hasClass('clone-menu-item') ) return true;
		
		if($(window).width() > 767) {
			var height_prev = $('.js-header .main-menu').height();
    		$('.js-header .lk-header__inner').css('height', height_prev);
		}
        moveMenu('toRight');
        $('.sub-menu').removeClass('active');
        // $(this).closest('.sub-menu').addClass('active');
        // $(this).next('ul').addClass('active');
        // swipe menu
      }, false);
    }
  });

  $('.main-menu a').each(function (index, el) {
    // $(el)[0].addEventListener('click', goNext(), false);
    $(el)[0].addEventListener('click', function () {
	if($(window).width() > 767) {
		var sub_height_temp = document.querySelector('.lk-header__inner').scrollHeight;
		$('.js-header .lk-header__inner').css('height', sub_height_temp);
	}
      // if(move) {
      $('.sub-menu').removeClass('active');
      $(this).closest('.sub-menu').addClass('active');
      $(this).next('ul').addClass('active');
      // swipe menu
      moveMenu();
      // }
    }, false);
  });

  function goBack() {
    // if ( $(this).hasClass('clone-menu-item') ) return true;
    moveMenu('toRight');
    $('.sub-menu').removeClass('active');
    // $(this).closest('.sub-menu').addClass('active');
    // $(this).next('ul').addClass('active');
    // swipe menu
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

    $('.lk-header .main-menu').css('transform', 'translateX(-' + (show_level * 100) + '%)');

  }

  function menuFixedHeight() {
    if ($('.js-sticky-header').length) {
      var fixedMenuHeight = $('.js-sticky-header').innerHeight();
      $('.js-sticky-container').css('height', fixedMenuHeight);
    }
  }

  /* ------------------------------------------- */
  /* - ASSET DRAWER */
  /* ------------------------------------------- */
  $('.js-asset-drawer-btn').on('click', function (e) {
    var $footer = $('.js-footer'),
      stylesheet = '',
      $copyright = $('.js-copyright'),
      heightCopyright = $copyright.outerHeight();

    e.preventDefault();

    // Transform styles
    if (heightCopyright) {
      stylesheet = 'transform: translateY( -' + heightCopyright + 'px);';
      stylesheet += '-ms-transform: translateY( -' + heightCopyright + 'px);';
      stylesheet += '-webkit-transform: translateY( -' + heightCopyright + 'px);';
    }

    $footer.toggleClass('lk-footer--active');
    

    if (($(document).innerHeight() - $(window).innerHeight()) <= window.pageYOffset && $footer.hasClass('lk-footer--active')) {
      $footer.attr('style', stylesheet);
    } else {
      $footer.removeAttr('style');
    }
  });

  /* ------------------------------------------- */
  /* SWIPER */
  /* ------------------------------------------- */
  function swiperInit() {

		$('.swiper-container:not(".initialized")').each(function (index) {
			var $that = $(this),
				$parents	= $that.parents('.wpb_wrapper'),
				$btnPrev 	= $parents.find('.swiper-button-prev'),
				$btnNext 	= $parents.find('.swiper-button-next'),
				$pagination = $parents.find('.swiper-pagination');

			if ($that.find('.swiper-slide').length > 1) {
				var sliderIndex = 'swiper-unique-id-' + index;
				$that.addClass(sliderIndex + ' initialized').attr('id', sliderIndex);
				$pagination.addClass('swiper-pagination-' + sliderIndex);

				swipers[sliderIndex] = new Swiper('.' + sliderIndex, {
					initialSlide: 0,
					// General
					speed: 1000,
					// Slides grid
					slidesPerView: 1,
					// Grab cursor
					grabCursor: true,
					// Touches
					simulateTouch: true,
					navigation: {
						nextEl: $btnNext,
						prevEl: $btnPrev,
					},
					// Pagination
					pagination: {
						el: $pagination,
						type: 'fraction',
						renderFraction: function (currentClass, totalClass) {
							return '<span class="' + currentClass + '"></span>' +
								' of ' +
								'<span class="' + totalClass + '"></span>';
						}
					},
					// Autoplay
					autoplay: {
						enabled: false,
						delay: 6000,
						disableOnInteraction: false,
					},
					// Keyboard Control
					keyboard: {
						enabled: true,
						onlyInViewport: false,
					},
				});
				swipers[sliderIndex].update();
			}
			else {
				$btnPrev.addClass('hidden');
        $btnNext.addClass('hidden');
			}
		});
	}

  /* ------------------------------------------- */
  /* ACCORDION */
  /* ------------------------------------------- */
  var accordion = document.getElementsByClassName('js-accordion-title');
  for (var i = 0; i < accordion.length; i++) {
    accordion[i].addEventListener('click', function () {
      this.classList.toggle('ac-accordion-item__title--active');
      this.getElementsByTagName('span')[0].classList.toggle('fa-minus');
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    });
  }

  /* ------------------------------------------- */
  /* PARALLAX & FULL BLEED */
  /* ------------------------------------------- */
  function fullbleedImg() {
    if ($('.js-fullbleed').length) {
      if (winW <= xlBPoint) {
        $('.js-fullbleed').removeAttr('style');
        var minHeigth = $('.js-fullbleed').innerHeight();
        setTimeout(function () {
          $('.js-fullbleed-img')[0].style.minHeight = minHeigth + 'px';
        }, 100);
      } else {
        $('.js-fullbleed-img').removeAttr('style');
        var minHeight = $('.js-fullbleed-img').innerHeight();
        $('.js-fullbleed')[0].style.minHeight = minHeight + 'px';
      }
    }
  }

  /* ------------------------------------------- */
  /* SCROLL ANCHOR */
  /* ------------------------------------------- */
  // $('.js-scroll-anchor').on('click', function (e) {
  //   e.preventDefault();
  //   if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
  //     var target = $(this.hash);
  //     target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
  //     if (target.length) {
  //       var targetOffset = target.offset().top;
  //       $('html, body').animate({
  //         scrollTop: targetOffset - $('#wpadminbar').innerHeight() - $('.js-sticky-header').innerHeight(),
  //       }, 600);
  //       return false;
  //     }
  //   }
  // });

  /* ------------------------------------------- */
  /* FLIP BUTTON */
  /* ------------------------------------------- */
  $('.js-flip-btn').on('click', function (e) {
    e.preventDefault();
    $(this).closest('.js-flip').toggleClass('active');
  });

  // TO DO DELETE
  /* ------------------------------------------- */
  /* SEARCH */
  /* ------------------------------------------- */
  // $('#search_form').submit(function (e) {
  //   e.preventDefault();

  //   var params = $(this).serialize();

  //   $.ajax({
  //     url: ajax_data.ajaxurl,
  //     type: 'POST',
  //     data: {
  //       action: 'liquid_knowledge_search',
  //       params: params
  //     },
  //     success: function (res) {}
  //   });
  // });

  /* ------------------------------------------- */
  /* TABS */
  /* ------------------------------------------- */
  var tablinks = document.getElementsByClassName('js-tablinks');
  for (var i = 0; i < tablinks.length; i++) {
    tablinks[i].addEventListener('click', openPanel);
  }

  function openPanel() {
    for (var i = 0; i < tablinks.length; i++) {
      tablinks[i].parentElement.classList.remove('active');
    }

    var tabpanel = document.getElementsByClassName('js-tabpanel');
    for (i = 0; i < tabpanel.length; i++) {
      tabpanel[i].classList.remove('active');
    }

    this.parentElement.classList.add('active');
    var currentId = this.getAttribute('href');
    document.getElementById(currentId).classList.add('active');

    if (document.getElementById(currentId).querySelector('.swiper-container') !== null) {
      var swiperId = document.getElementById(currentId).querySelector('.swiper-container').getAttribute('id');
      swipers[swiperId].update();
    }
  }


  /* ------------------------------------------- */
  /* FULLHEIGHT BLOCK */
  /* ------------------------------------------- */
  function blockOnlyFullHeight(wrapper) {
    var $wrapper = $(wrapper);
    var maxWHeight = winH - $('.js-header').innerHeight() - $('#wpadminbar').innerHeight();
    $wrapper.outerHeight(maxWHeight);
  }

  /* ------------------------------------------- */
  /* WINDOW LOAD */
  /* ------------------------------------------- */
  $(window).on('load', function () {
    var adminBarH = ( $('#wpadminbar').length ) ? $('#wpadminbar').outerHeight() : 0,
        headerH   = ( $('.lk-header').length ) ? $('.lk-header').outerHeight() : 0;
    
    $('.js-asset-drawer-btn').trigger('click');
    // Calculate height iframe
    $('.lk-popup-wrap .wonderplugin-pdf-iframe').css( 'height', 'calc( 100vh - ' + ( adminBarH + headerH ) + 'px )' );
  });

  /* ------------------------------------------- */
  /* WINDOW SCROLL */
  /* ------------------------------------------- */
  $(window).on('scroll', function () {
    sidebar.update();

    if (($(document).innerHeight() - $(window).innerHeight()) <= window.pageYOffset) {
      $('.js-footer:not(.lk-footer--active) .js-asset-drawer-btn').trigger('click');
    } else {
      $('.js-footer.lk-footer--active .js-asset-drawer-btn').trigger('click');
    }
  });


  /* ------------------------------------------- */
  /* LOAD ASSETS IFRAME ON CLICK */
  /* ------------------------------------------- */

  $('.js-item-html').on('click', function() {

    var $this       = $(this),
        id          = $this.attr('href'),
        $iframeData = $( id ).find('.js-iframe-html');

    lazyLoadIframe( $iframeData );
    
  });

  /* ------------------------------------------- */
  /* LAZY LOAD IFRAME */
  /* ------------------------------------------- */
  function lazyLoadIframe( $asset ) {

    if ( ! $asset.hasClass('html-init') ) {
      var $iframe = $('<iframe/>', {
        src : $asset.attr('data-src'),
      });
      $asset.addClass( 'html-init' );
    }
    
    if ( typeof $iframe !== typeof undefined ) {
      $iframe.addClass( $asset.attr('data-class') );

      if ( $asset.hasClass( 'wonderplugin-pdf-iframe' ) ) {
        $iframe.addClass( 'wonderplugin-pdf-iframe' );
      }

      $asset.before( $iframe ).hide();
    }
  }

  /* ------------------------------------------- */
  /* Load mp3 */
  /* ------------------------------------------- */

  function loadMP3( src ) {
    var sound      = document.createElement('audio');
    sound.id       = 'audio-player';
    sound.controls = 'controls';
    sound.src      = src;
    sound.type     = 'audio/mpeg';
    sound.classList.add('hidden');
    return sound;
  }


  function controlMP3( $player, audio ) {
    
    $(audio).on('play', function() {
      $player.addClass('player-init');
    });

    $(audio).on('ended', function() {
      $player.removeClass('player-init').removeClass('active');
    });

  }


  /* ------------------------------------------- */
  /* LOAD BRIGTCOVE PLAYER DUNAMICALLY */
  /* ------------------------------------------- */

  var playerData        = ( typeof liquiData.brigtcovePlayerData == 'object' ) ? liquiData.brigtcovePlayerData : {},
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
  
  /* ------------------------------------------- */
  /* PAGE CALCULATION */
  /* ------------------------------------------- */
  pageCalculations(function () {
    menuFixedHeight();
    fullbleedImg();
    swiperInit();
    blockOnlyFullHeight('.js-only-fullheight');
    sidebar.initialize();
  });

  /* ------------------------------------------- */
	/* SCROLL ANCHOR */
	/* ------------------------------------------- */
	$(document).ready(function () {
		$(document).on("scroll", onScroll);
	
		//smoothscroll
		$('a[href^="#"]').on('click', function (e) {
			e.preventDefault();
			$(document).off("scroll");
	
			$('a').each(function () {
				$(this).removeClass('active');
			})
			$(this).addClass('active');
	
			var target = this.hash,
				menu = target,
			$target = $(target);
			$('html, body').stop().animate({
				'scrollTop': $target.offset().top+2
			}, 500, 'swing', function () {
				window.location.hash = target;
				$(document).on("scroll", onScroll);
			});
		});
	});
	
	// Use Your Class or ID For Selection 
	
	function onScroll(event){
		var scrollPos = $(document).scrollTop();
		$('.lk-asset-library__nav-item a').each(function () {
			var currLink = $(this);
			var refElement = $(currLink.attr("href"));
			if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
				$('.lk-asset-library__nav-item a').removeClass("active");
				currLink.addClass("active");
			}
			else{
				currLink.removeClass("active");
			}
		});
	}