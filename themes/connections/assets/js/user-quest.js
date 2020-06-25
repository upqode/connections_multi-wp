/* SCRIPT.JS */
/* ------------------------------------------------------------------------------------------------------- */
/* This is main JS file that contains custom rules used in this template */
/* ------------------------------------------------------------------------------------------------------- */
/* Template Name: liquid-knowledge */
/* Version: 1.1.0 Initial Release */
/* Build Date: */
/* Author:  */
/* Website: */
/* Copyright: (C) */
/* ------------------------------------------------------------------------------------------------------ */

/* -------------------------------------------------------- */
/* TABLE OF CONTENTS: */
/* -------------------------------------------------------- */
/*
  1. INIT
*/
/* -------------------------------------------------------- */
;
(function ($, window, document, underfined) {
	"use strict";
	$(document).ready(function() {

		/* ------------------------------------------- */
		/* POPUP */
		/* ------------------------------------------- */
		$('.js-user-guest-popup').magnificPopup({
			type: 'inline',
			preloader: false,
			closeBtnInside: true,
			closeMarkup: '<button title="%title%" type="button" class="mfp-close mfp-close--black">&#215;</button>',
			tClose: 'Close (Esc)',
			callbacks: {
				open: function() {
					$('body, html').addClass('no-scroll page-user-guest-popup-active');
					if ($('.js-header').length) {
						var headerHeight = $('#wpadminbar').length ? $('#wpadminbar').innerHeight() : 0;
						var headerHeightString = 'calc(100% - ' + headerHeight + 'px)';
						var headerHeightViewString = 'calc(100vh - ' + headerHeight + 'px)';
						$('.mfp-bg').css({height: headerHeightString});
						$('.mfp-wrap').css({height: headerHeightString});
						$('.cn-content-wrapp--full').css({height: headerHeightViewString});
					}
				},
				close: function() {
					$('body, html').removeClass('no-scroll page-user-guest-popup-active');
				}
			}
		});

		function guestsPopup() {
			var $popupSrc = $('.js-user-guest-popup-src'),
				$iframe = $('<iframe/>', {
					src : $popupSrc.attr('data-src'),
				});

			$popupSrc.before( $iframe );

			setTimeout(function(){
				$('.js-user-guest-popup').trigger('click');
			}, 300);
		}

		// Only user guests
		if ( ! localStorage.getItem('userGuest') ) {

			var $popupSrc = $('.js-user-guest-popup-src'),
				$iframe = $('<iframe/>', {
					src : $popupSrc.attr('data-src'),
				});

			$popupSrc.before( $iframe );

			setTimeout(function(){
				$('.js-user-guest-popup').trigger('click');
			}, 300);
		}

		$('.js-user-guest-popup').on('click', function() {
			localStorage.setItem('userGuest', true);
		});
	})
})(jQuery, window, document);