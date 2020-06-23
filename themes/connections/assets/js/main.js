;(function ($, window, document, undefined) {
	'use strict';

	/* ------------------------------------------- */
	/* - INIT */
	/* ------------------------------------------- */
	var swipers = [],
		creonData = ( typeof creon_data == 'object' ) ? creon_data : {};

	var xlBPoint = 1400,
		smBPoint = 768;
	var isMobile = navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i),
		isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

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