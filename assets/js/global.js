;
(function( $ ) {

	/*
	let responsiveSliderSettings = {
		rows: 0,
		slidesToShow: 2,
		dots: true,
	};
	let $responsiveSlider = $('.selector');
	 */

	// Scripts which runs after DOM load
	var scrollOut;
	$( document ).ready( function() {
		// Header slider
		$('.header-slider').slick({
			draggable: false,
		});

		$('.post-category').text(function(i, text) {
			if (window.innerWidth < 330) {
				if (text.length >= 20) {
					text = text.substring(0, 20);
					var lastIndex = text.lastIndexOf('');
					text = text.substring(0, lastIndex) + '...';
				}
				$(this).text(text);
			} else {
				if (text.length >= 28) {
					text = text.substring(0, 28);
					var lastIndex = text.lastIndexOf('');
					text = text.substring(0, lastIndex) + '...';
				}
				$(this).text(text);
			}
		});
		$(document).ready(function () {
			function initSliderWhenReady() {
				if ($('.most-popular-slider').children().length > 0) {
					$('.post-category').text(function(i, text) {
						if (window.innerWidth < 350) {
							if (text.length >= 20) {
								text = text.substring(0, 20);
								var lastIndex = text.lastIndexOf('');
								text = text.substring(0, lastIndex) + '...';
							}
							$(this).text(text);
						} else {
							if (text.length >= 28) {
								text = text.substring(0, 28);
								var lastIndex = text.lastIndexOf('');
								text = text.substring(0, lastIndex) + '...';
							}
							$(this).text(text);
						}
					});

					$('.most-popular-slider').slick({
						dots: true,
						arrows: true,
						infinite: false,
						speed: 300,
						slidesToShow: 4,
						slidesToScroll: 4,
						variableWidth: false,
						responsive: [
							{
								breakpoint: 1200,
								settings: {
									slidesToShow: 3,
									slidesToScroll: 3,
									variableWidth: false,
								}
							},
							{
								breakpoint: 1024,
								settings: {
									slidesToShow: 2,
									slidesToScroll: 2,
								}
							},
							{
								breakpoint: 640,
								settings: {
									slidesToShow: 1,
									slidesToScroll: 1,
									variableWidth: true,
								}
							},
						]
					});

					var $getItemBlock = $('.get_item');
					if ($getItemBlock.length) {
						var getItemAttribute = $getItemBlock.attr('audience-attr').trim();
						function removeSlidesWithoutCategoryIcon() {
							let isRemoved = false;
							$getItemBlock.find('.slick-slide').each(function() {
								if ($(this).find('.category-icon').length === 0) {
									$(this).remove();
									isRemoved = true;
								}
							});
							if (isRemoved) {
								$('.get_item .slick-dots').remove();
								$('.get_item .slick-arrow').remove();
								$('.most-popular-slider').slick('reinit');
							}
							if ($getItemBlock.find('.slick-slide').length === 0) {
								$getItemBlock.remove();
							}
						}

						function removeSlidesWithCategoryIcon() {
							let isRemoved = false;
							$getItemBlock.find('.slick-slide').each(function() {
								if ($(this).find('.category-icon').length > 0) {
									$(this).remove();
									isRemoved = true;
								}
							});
							if (isRemoved) {
								$('.get_item .slick-dots').remove();
								$('.get_item .slick-arrow').remove();
								$('.most-popular-slider').slick('reinit');
							}
							if ($getItemBlock.find('.slick-slide').length === 0) {
								$getItemBlock.remove();
							}
						}

						if (getItemAttribute === 'hcp') {
							removeSlidesWithoutCategoryIcon();
						} else if (getItemAttribute === 'ne') {
							removeSlidesWithCategoryIcon();
						}
					}
				} else {
					setTimeout(initSliderWhenReady, 100);
				}
			}
			initSliderWhenReady();
		});



		// setTimeout( function () {
		// 	$('.post-category').text(function(i, text) {
		//
		//
		// 		if (window.innerWidth < 350) {
		// 			if (text.length >= 20) {
		// 				text = text.substring(0, 20);
		// 				var lastIndex = text.lastIndexOf('');
		// 				text = text.substring(0, lastIndex) + '...';
		// 			}
		// 			$(this).text(text);
		// 		} else {
		// 			if (text.length >= 28) {
		// 				text = text.substring(0, 28);
		// 				var lastIndex = text.lastIndexOf('');
		// 				text = text.substring(0, lastIndex) + '...';
		// 			}
		// 			$(this).text(text);
		// 		}
		// 	});
		//
		// 	$('.most-popular-slider').slick({
		// 		dots: true,
		// 		arrows: true,
		// 		infinite: false,
		// 		speed: 300,
		// 		slidesToShow: 4,
		// 		slidesToScroll: 4,
		// 		variableWidth: false,
		// 		responsive: [
		// 			{
		// 				breakpoint: 1200,
		// 				settings: {
		// 					slidesToShow: 3,
		// 					slidesToScroll: 3,
		// 					variableWidth: false,
		// 				}
		// 			},
		// 			{
		// 				breakpoint: 1024,
		// 				settings: {
		// 					slidesToShow: 2,
		// 					slidesToScroll: 2,
		// 				}
		// 			},
		// 			{
		// 				breakpoint: 640,
		// 				settings: {
		// 					slidesToShow: 1,
		// 					slidesToScroll: 1,
		// 					variableWidth: true,
		// 				}
		// 			},
		// 		]
		// 	});
		// }, 1500);


		$('.most-recent-slider').slick({
			dots: true,
			arrows: true,
			infinite: false,
			speed: 300,
			slidesToShow: 4,
			slidesToScroll: 4,
			adaptiveHeight: true,
			variableWidth: false,
			responsive: [
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 3,
						variableWidth: false,
					}
				},
				{
					breakpoint: 1024,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 2,
					}
				},
				{
					breakpoint: 640,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
						variableWidth: true,
					}
				},
			]
		});

		$('.acf-custom-courses-slider').slick({
			dots: false,
			infinite: true,
			arrows: false,
			slidesToShow: 4,
			centerMode: false,
			slidesToScroll: 1,
			variableWidth: false,
			responsive: [
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 3,
					}
				},
				{
					breakpoint: 836,
					settings: {
						slidesToShow: 2,
					}
				},
				{
					breakpoint: 440,
					settings: {
						slidesToShow: 1,
					}
				},
			]
		});
		$('.acf-custom-pod-slider').slick({
			dots: false,
			infinite: true,
			arrows: false,
			slidesToShow: 3,
			centerMode: false,
			slidesToScroll: 1,
			variableWidth: false,
			responsive: [
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 3,
					}
				},
				{
					breakpoint: 836,
					settings: {
						slidesToShow: 2,
					}
				},
				{
					breakpoint: 640,
					settings: {
						slidesToShow: 1,
					}
				},
			]
		});


		// Header search

		$('#search-option-title').on('click', function (event) {
			$('.search-options-list').toggleClass('toggle');
			$('.arrow-down-icon').toggleClass('rotate-180');
		});

		$('#header-search-icon-mobile').on('click', function (e) {
			e.stopPropagation();
			$('.search-modal').toggleClass('toggle-modal');
			$('.cross-icon').toggleClass('toggle-modal');
			$('.search-icon').toggleClass('toggle');
			$('#main-menu').attr('style', 'display: none');
			$('.menu-icon').removeClass('is-active');
			if($('.header').hasClass('fixed-header-menu')) {
				$('.header').removeClass('fixed-header-menu')
			}
			$('.header').toggleClass('fixed-header-search')
			$('.search-modal').toggleClass('overflow-hidden');
		});


		let searchValue = ''
		// Redirect to search page
		$('#header-search').on('click', function (e) {
			e.stopPropagation();
			$('.search-modal').addClass('toggle-modal');
		});
		$('.header-content').on('click', function (event) {
			if ($('.search-modal').hasClass('toggle-modal')) {
				$('.search-modal').removeClass('toggle-modal');
				$('.cross-icon').removeClass('toggle-modal');
				$('.search-icon').removeClass('toggle');
			}
		});

		$('#header-search-icon').on('click', function (e) {
			$(this).attr('href', window.location.origin + '?s=' + searchValue);
		});

		//---------------------- Mobile search ----------------------

		let category_arr = [];
		let audience_arr = [];
		$('.search-modal-arrow').on('click', function (event) {
			let taxonomy_category = '&'+$('.search-option').attr('data-taxonomy')+'[]=';
			let taxonomy_audience = '&'+$('.search-option').attr('data-audience-tax')+'[]=';
			if (category_arr.length > 0 || audience_arr.length > 0) {
				console.log('trigger click')
				$(this).attr('href', '/?s='+$('#search-modal-input').val()+taxonomy_category+category_arr.join('&'+$('.search-option').attr('data-taxonomy')+'[]=')+taxonomy_audience+audience_arr.join('&'+$('.search-option').attr('data-audience-tax')+'[]='));
			}  else {
				$(this).attr('href', '/?s=');
			}
		})
		$('#search-modal-input, .search-option, #header-search').on('keyup', function (e) {
			searchValue = $('#header-search').val();
			console.log('test')
			if(e.which == 13) {
				console.log('test2')
				let taxonomy_category = '&'+$('.search-option').attr('data-taxonomy')+'[]=';
				let taxonomy_audience = '&'+$('.search-option').attr('data-audience-tax')+'[]=';

				if (category_arr.length > 0 || audience_arr.length > 0) {
					console.log('test3')
					$(this).attr('href', );
					window.location.replace( '/?s='+(searchValue ? searchValue : $('#search-modal-input').val())+taxonomy_category+category_arr.join('&'+$('.search-option').attr('data-taxonomy')+'[]=')+taxonomy_audience+audience_arr.join('&'+$('.search-option').attr('data-audience-tax')+'[]='));
				}  else {
					console.log('test4')
					window.location.replace( '/?s='+(searchValue ? searchValue : $('#search-modal-input').val()));
				}
			}
		});

		$('.search-option input').on('click', function () {
			category_arr.push($(this).val())
			if (!audience_arr.includes($(this).parents().attr('data-audience-term'))) {
				audience_arr.push($(this).parents().attr('data-audience-term'))
			}
		})
		//-------------------------------------------------

		// Init LazyLoad
		var lazyLoadInstance = { update: function() {}, loadAll: function() {} };

		// Add tracking on adding any new nodes to body to update lazyload for the new images (AJAX for example)
		window.addEventListener( 'LazyLoad::Initialized', function( e ) {
			// Get the instance and puts it in the lazyLoadInstance variable
			if ( window.MutationObserver ) {
				var observer = new MutationObserver( function( mutations ) {
					mutations.forEach( function( mutation ) {
						mutation.addedNodes.forEach( function( node ) {
							if ( typeof node.getElementsByTagName !== 'function' ) {
								return;
							}
							imgs = node.getElementsByTagName( 'img' );
							if ( 0 === imgs.length ) {
								return;
							}
							lazyLoadInstance.update();
						} );
					} );
				} );
				var b = document.getElementsByTagName( "body" )[0];
				var config = { childList: true, subtree: true };
				observer.observe( b, config );
			}
		}, false );

		// Load all images in slider after init
		$( document ).on( "init", ".slick-slider", function( e, slick ) {
			lazyLoadInstance.loadAll( slick.$slider[0].getElementsByTagName( 'img' ) );
		} );

		/*
		// responsiveSliderSettings - Settings for slider on responsive. Create this variable in the top of this file before $(document).ready()
		reinitSlickOnResize($responsiveSlider, responsiveSliderSettings, 641)
		 */

		// Detect element appearance in viewport
		scrollOut = ScrollOut( {
			offset: function( el ) {
				let bodyRect = document.body.getBoundingClientRect();
				let rect = el.getBoundingClientRect();
				let offset = rect.top - bodyRect.top - window.innerHeight;
				return offset + 50;
			},
			targets: '.acf-map,[data-scroll]',
			once: true,
			onShown: function( element ) {
				if ( $( element ).is( '.ease-order' ) ) {
					$( element ).find( '.ease-order__item' ).each( function( i ) {
						var $this = $( this );
						$( this ).attr( 'data-scroll', '' );
						window.setTimeout( function() {
							$this.attr( 'data-scroll', 'in' );
						}, 300 * i );
					} );
				}
				if ( $( element ).is( '.acf-map' ) ) {
					render_map( $( element ) );
				}
			}
		} );


		// Init parallax
		if ( typeof $.fn.jarallax !== 'undefined' ) {
			$( '.jarallax' ).jarallax( {
				speed: 0.5,
			} );

			$( '.jarallax-inline' ).jarallax( {
				speed: 0.5,
				keepImg: true,
				onInit: function() {
					lazyLoadInstance.update();
				}
			} );
		}

		//Remove placeholder on click
		$( 'input, textarea' ).each( function() {
			removeInputPlaceholderOnFocus( this );
		} );

		//Make elements equal height
		if ( typeof $.fn.matchHeight !== 'undefined' ) {
			$( '.matchHeight' ).matchHeight();
		}

		// Add fancybox to images
		$( '.gallery-item' ).find( 'a[href$="jpg"], a[href$="png"], a[href$="gif"]' ).attr( 'rel', 'gallery' ).attr( 'data-fancybox', 'gallery' );
		$( 'a[rel*="album"], .fancybox, a[href$="jpg"], a[href$="png"], a[href$="gif"]' ).fancybox( {} );

		/**
		 * Scroll to Gravity Form confirmation message after form submit
		 */
		$( document ).on( 'gform_confirmation_loaded', function( event, formId ) {
			var $target = $( '#gform_confirmation_wrapper_' + formId );
			if (formId === 5) {
				$('#contact-us-form').show();
			} else if (formId === 4 || formId === 1) {
				$('#newsletter-form').show();
			}
			smoothScrollTo( $target );
		} );

		// Init Jquery UI select
		$( "select" ).not( "#billing_state, #shipping_state, #billing_country, #shipping_country, [class*='woocommerce'], #product_cat, #rating" ).each( function() {
			initSelect2( this );
		} );

		$( document ).on( 'gform_post_render', function( event, form_id, current_page ) {
			const $form = $( "#gform_" + form_id )
			$form.find( "select" ).each( function() {
				initSelect2( this );
			} );

			$form.find( "input, textarea" ).each( function() {
				removeInputPlaceholderOnFocus( this );
			} );
			if($("#validation_message_" + form_id+ "_5").length && $("#input_" + form_id+ "_5").val().length) {
				$('#gform_submit_button_' + form_id).attr('src','/wp-content/themes/wholisticmatters/assets/images/cross.svg');
				$('#gform_' + form_id+ ' .gform_footer.top_label').append('<div class="cross-error ' +form_id + '"></div>');
				$('.cross-error').css('display', 'block');
			}
		} );
		$(document).on('click', '.cross-error', function () {
			let formId = $(this)[0].classList[1];
			$("#input_"+ formId + "_5").val('');
			$('#gform_submit_button_' + formId).attr('src','/wp-content/themes/wholisticmatters/assets/images/arrow-button.svg');
			$(this).css('display', 'none');
		});
		$( document ).on( 'click', '.s-qty-dec,.s-qty-inc', function() {
			var $numberInput = $( this ).closest( '.quantity' ).find( 'input' ),
				action = $( this ).is( '.s-qty-inc' ) ? 'stepUp' : 'stepDown';
			$numberInput[0][action]();
			$numberInput.trigger( 'change' );
		} );

		/**
		 * Update lazyload images and reinit select on cart/checkout update
		 */
		$( document ).on( 'updated_wc_div', function() {
			lazyLoadInstance.loadAll();
			$( 'body' ).find( 'div.woocommerce' ).find( 'select' ).each( function() {
				initSelect2( this );
			} );
		} );

		/**
		 * Hide gravity forms required field message on data input
		 */
		$( 'body' ).on( 'change keyup', '.gfield input, .gfield textarea, .gfield select', function() {
			var $field = $( this ).closest( '.gfield' );
			if ( $field.hasClass( 'gfield_error' ) && $( this ).val().length ) {
				$field.find( '.validation_message' ).hide();
			} else if ( $field.hasClass( 'gfield_error' ) && !$( this ).val().length ) {
				$field.find( '.validation_message' ).show();
			}
		} );

		/**
		 * Add `is-active` class to menu-icon button on Responsive menu toggle
		 * And remove it on breakpoint change
		 */
		$( window ).on( 'toggled.zf.responsiveToggle', function() {
			$( '.menu-icon' ).toggleClass( 'is-active' );
		} ).on( 'changed.zf.mediaquery', function( e, value ) {
			$( '.menu-icon' ).removeClass( 'is-active' );
		} );

		/**
		 * Close responsive menu on orientation change
		 */
		$( window ).on( 'orientationchange', function() {
			setTimeout( function() {
				if ( $( '.menu-icon' ).hasClass( 'is-active' ) && window.innerWidth < 641 ) {
					$( '[data-responsive-toggle="main-menu"]' ).foundation( 'toggleMenu' )
				}
			}, 200 );
		} );

		resizeVideo();

		// Share post popup
		$( '.js-share-link' ).click( function( e ) {
			e.preventDefault();
			var wpWidth = $( window ).width(), wpHeight = $( window ).height();
			window.open( $( this ).attr( 'href' ), 'Share', "top=" + (wpHeight - 400) / 2 + ",left=" + (wpWidth - 600) / 2 + ",width=600,height=400" );
		} );
	} );


	// Scripts which runs after all elements load

	$( window ).on( 'load', function() {

		if ( typeof scrollOut !== "undefined" ) {
			scrollOut.update();
		}

		//jQuery code goes here
		if ( $( '.preloader' ).length ) {
			$( '.preloader' ).addClass( 'preloader--hidden' );
		}

	} );

	// Scripts which runs at window resize

	let resizeVideoCallback = debounce( resizeVideo, 200 );
	// let resizeSliderCallback = debounce( reinitSlickOnResize, 200 );
	$( window ).on( 'resize', function() {

		//jQuery code goes here
		resizeVideoCallback();

		/*
		resizeSliderCallback( $responsiveSlider, responsiveSliderSettings, 641 );
		*/


	} );

	// Scripts which runs on scrolling

	$( window ).on( 'scroll', function() {

		//jQuery code goes here

	} );

	/*
	 *  This function will render a Google Map onto the selected jQuery element
	 */

	function render_map( $el ) {
		// var
		var $markers = $el.find( '.marker' );
		// var styles = Here should be styles for Google Maps from https://snazzymaps.com/explore ; // Uncomment for map styling

		// vars
		var args = {
			zoom: 16,
			center: new google.maps.LatLng( 0, 0 ),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false,
			// styles : styles // Uncomment for map styling
		};

		// create map
		var map = new google.maps.Map( $el[0], args );

		// add a markers reference
		map.markers = [];

		// add markers
		$markers.each( function() {
			add_marker( $( this ), map );
		} );

		// center map
		center_map( map );
	}

	/*
	 *  This function will add a marker to the selected Google Map
	 */

	var infowindow;

	function add_marker( $marker, map ) {
		// var
		var latlng = new google.maps.LatLng( $marker.attr( 'data-lat' ), $marker.attr( 'data-lng' ) );

		// create marker
		var marker = new google.maps.Marker( {
			position: latlng,
			map: map,
			//icon: $marker.data('marker-icon') //uncomment if you use custom marker
		} );

		// add to array
		map.markers.push( marker );

		// if marker contains HTML, add it to an infoWindow
		if ( $.trim( $marker.html() ) ) {
			// create info window
			infowindow = new google.maps.InfoWindow();

			// show info window when marker is clicked
			google.maps.event.addListener( marker, 'click', function() {
				// Close previously opened infowindow, fill with new content and open it
				infowindow.close();
				infowindow.setContent( $marker.html() );
				infowindow.open( map, marker );
			} );
		}
	}

	/*
	*  This function will center the map, showing all markers attached to this map
	*/

	function center_map( map ) {
		// vars
		var bounds = new google.maps.LatLngBounds();

		// loop through all markers and create bounds
		$.each( map.markers, function( i, marker ) {
			var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
			bounds.extend( latlng );
		} );

		// only 1 marker?
		if ( map.markers.length == 1 ) {
			// set center of map
			map.setCenter( bounds.getCenter() );
		} else {
			// fit to bounds
			map.fitBounds( bounds );
		}
	}

	/**
	 * Helper functions
	 */

	function debounce( callback, time ) {
		var timeout;

		return function() {
			var context = this;
			var args = arguments;
			if ( timeout ) {
				clearTimeout( timeout );
			}
			timeout = setTimeout( function() {
				timeout = null;
				callback.apply( context, args );
			}, time );
		}
	}

	function handleFirstTab( e ) {
		var key = e.key || e.keyCode;
		if ( key === 'Tab' || key === '9' ) {
			$( 'body' ).removeClass( 'no-outline' );

			window.removeEventListener( 'keydown', handleFirstTab );
			window.addEventListener( 'mousedown', handleMouseDownOnce );
		}
	}

	function handleMouseDownOnce() {
		$( 'body' ).addClass( 'no-outline' );

		window.removeEventListener( 'mousedown', handleMouseDownOnce );
		window.addEventListener( 'keydown', handleFirstTab );
	}

	window.addEventListener( 'keydown', handleFirstTab );

	// Fit slide video background to video holder
	function resizeVideo() {
		var $holder = $( ".video-holder" );
		$holder.each( function() {
			var $that = $( this );
			var ratio = $that.data( "ratio" ) ? $that.data( "ratio" ) : "16:9",
				width = parseFloat( ratio.split( ":" )[0] ),
				height = parseFloat( ratio.split( ":" )[1] );
			$that.find( ".video-holder__media" ).each( function() {
				if ( $that.width() / width > $that.height() / height ) {
					$( this ).css( { "width": "100%", "height": "auto" } );
				} else {
					$( this ).css( { "width": $that.height() * width / height, "height": "100%" } );
				}
			} );
		} );
	}

	// Init Select2 plugin
	function initSelect2( elem ) {
		var $field = $( elem );
		var $gfield = $field.closest( ".gfield" );
		var $countryBox = $field.closest( '.ginput_address_country,.gfield_time_ampm' );
		var args = {}
		if ( $countryBox.length ) {
			args.dropdownParent = $countryBox;
		} else if ( $gfield.length ) {
			args.dropdownParent = $gfield;
		}

		$field.select2( args );
	}

	function removeInputPlaceholderOnFocus( el ) {
		$( el ).data( "holder", $( el ).attr( "placeholder" ) );

		$( el ).on( "focusin", function() {
			$( el ).attr( "placeholder", "" );
		} );

		$( el ).on( "focusout", function() {
			$( el ).attr( "placeholder", $( el ).data( "holder" ) );
		} );
	}

	/**
	 * Init slick slider on smaller screens, And destroy it on desktop
	 */
	function reinitSlickOnResize( $slider, settings, breakpoint ) {
		if ( window.innerWidth >= breakpoint ) {
			if ( $slider.hasClass( "slick-initialized" ) ) {
				$slider.slick( "unslick" );
			}
		} else {
			if ( !$slider.hasClass( "slick-initialized" ) ) {
				$slider.slick( settings );
			}
		}
	}

	/**
	 * Smooth scroll to target
	 */
	function smoothScrollTo( $target, offset ) {
		offset = typeof offset == "undefined" ? 0 : offset;
		$( "html, body" ).animate( {
			scrollTop: $target.offset().top - 50 - offset,
		}, 500 );
		$target.focus();
		if ( $target.is( ":focus" ) ) { // Checking if the target was focused
			return false;
		} else {
			$target.attr( 'tabindex', '-1' ); // Adding tabindex for elements not focusable
			$target.focus(); // Set focus again
		}
	}

	//------------------------- Load more ----------------------------//

	let currentPage = 1;
	$('#load-more').on('click', function (event) {
		event.preventDefault();
		let type = $(this).attr('data-post-type')
		currentPage++;
		$.ajax({
			type: 'POST',
			url: ajax.url,
			dataType: 'json',
			data: {
				action: 'load_more_callback',
				type
			},
			success: function (res) {
				if(currentPage >= res.max) {
					$('#load-more').hide();
				}
				$('.grid-item-wrap').html(res.html);
			}

		});
	})

	//-------------- Load More for Media -----------------------

	$('#load-more-media').on('click', function (event) {
		event.preventDefault();
		let type = $(this).attr('data-post-type');
		let per = $(this).attr('data-posts_per_page');
		let tax = $(this).attr('data-tax');
		currentPage++;
		$.ajax({
			type: 'POST',
			url: ajax.url,
			dataType: 'json',
			data: {
				action: 'load_more_media_callback',
				paged: currentPage,
				type,
				tax,
				per
			},
			success: function (res) {
				if(currentPage >= res.max) {
					$('#load-more-media').attr('style', 'display: none !important');
				}
				$('.media-list-articles').append(res.html);
			}

		});
	})
	$('#load-more-media-mob').on('click', function (event) {
		event.preventDefault();
		let type = $(this).attr('data-post-type');
		let per = $(this).attr('data-posts_per_page');
		let tax = $(this).attr('data-tax');
		currentPage++;
		$.ajax({
			type: 'POST',
			url: ajax.url,
			dataType: 'json',
			data: {
				action: 'load_more_media_callback',
				paged: currentPage,
				type,
				tax,
				per
			},
			success: function (res) {
				if(currentPage >= res.max) {
					$('#load-more-media').attr('style', 'display: none !important');
				}
				$('.media-list-articles').append(res.html);
			}

		});
	})
	//-------------------------------------------------------

	$('#filter-media-button, #filter-media-button-mob').on('click', function (event) {
    	$(this).attr('aria-expanded', (i, v) => v === 'true' ? 'false' : 'true');
    	$('.sub-media-list').toggleClass('toggle');
	});
	$('#navigation-title').on('click', function (event) {
		$('.navigation-list').toggleClass('toggle');
		$('.arrow-top-icon').toggleClass('rotate-180');
	});

	$('.menu-icon').on('click', function (event) {
		if($('.search-icon').hasClass('toggle')) {
			$('.search-modal').toggleClass('toggle-modal');
			$('.cross-icon').toggleClass('toggle-modal');
			$('.search-icon').toggleClass('toggle');
		}
		if (($('.top-bar')).css('display') === 'block') {
			if($('.header').hasClass('fixed-header-search')) {
				$('.header').removeClass('fixed-header-search')
			}
			$('.header').toggleClass('fixed-header-menu');
			$('.top-bar').toggleClass('overflow-hidden');
		}

	});


	let postsPerPage = 10;
	let postsPerPageMob = 6;
	let term = ['article', 'podcast', 'video', 'pdf'];
	let urlAudience = ''
	let urlAudienceMob = ''
	let termTax = ''
	let termId = ''
	$('.sub-media-item.chose-item').on('click', function (event) {
		term = $(this).attr('data-term');
		$('#filter-media-button span').text($(this).text());
		$('.sub-media-item.chose-item').css('display', 'block');
		$('.sub-media-list').toggleClass('toggle');
		$(this).css('display', 'none');
		urlAudience = $(this).attr('data-url_term_audience');
		termTax = $(this).attr('data-term-tax');
		termId= $(this).attr('data-term-id');

		$.ajax({
			type: 'POST',
			url: ajax.url,
			dataType: 'json',
			data: {
				action: 'filter_media_callback',
				paged: postsPerPage,
				term,
				termTax,
				termId,
				urlAudience,
			},
			success: function (res) {

				if(postsPerPage < res.max) {
					$('#load-more-media-all').show();
				} else  {
					$('#load-more-media-all').attr('style', 'display: none !important');
				}
				if (!res.html) {
					$('#load-more-media-all').attr('style', 'display: none !important');
				}
				$('#filter-media-list-articles').html(res.html);

			}

		});
	})
	$('.sub-media-item.chose-item-mob').on('click', function (event) {
		term = $(this).attr('data-term');
		$('#filter-media-button-mob span').text($(this).text());
		$('.sub-media-list').toggleClass('toggle');
		$('.sub-media-item.chose-item-mob').css('display', 'block');
		$(this).css('display', 'none');
		urlAudience = $(this).attr('data-url_term_audience');
		termTax = $(this).attr('data-term-tax');
		termId= $(this).attr('data-term-id');
		$.ajax({
			type: 'POST',
			url: ajax.url,
			dataType: 'json',
			data: {
				action: 'filter_media_callback',
				paged: postsPerPageMob,
				term,
				termTax,
				termId,
				urlAudience: urlAudienceMob,
			},
			success: function (res) {
				if(postsPerPage < res.max) {
					$('#load-more-media-all-mob').show();
				} else  {
					$('#load-more-media-all-mob').attr('style', 'display: none !important');
				}
				if (!res.html) {
					$('#load-more-media-all-mob').attr('style', 'display: none !important');
				}
				$('#filter-media-list-articles-mob').html(res.html);

			}

		});
	})


	$('#load-more-media-all').on('click', function (event) {
		event.preventDefault();
		postsPerPage = postsPerPage+10;
		urlAudienceMob = $(this).attr('data-url_term_audience');
		termTax = $(this).attr('data-term-tax');
		termId= $(this).attr('data-term-id');
		$.ajax({
			type: 'POST',
			url: ajax.url,
			dataType: 'json',
			data: {
				action: 'filter_media_callback',
				paged: postsPerPage,
				term,
				termTax,
				termId,
				urlAudience: urlAudienceMob,
			},
			success: function (res) {
				if(postsPerPage >= res.max) {
					$('#load-more-media-all').attr('style', 'display: none !important');
				}
				$('#filter-media-list-articles').html(res.html);
			}

		});
	})
	$('#load-more-media-all-mob').on('click', function (event) {
		event.preventDefault();
		postsPerPageMob = postsPerPageMob+10;
		urlAudience = $(this).attr('data-url_term_audience');
		termTax = $(this).attr('data-term-tax');
		termId= $(this).attr('data-term-id');
		$.ajax({
			type: 'POST',
			url: ajax.url,
			dataType: 'json',
			data: {
				action: 'filter_media_callback',
				paged: postsPerPageMob,
				term,
				termId,
				termTax,
				urlAudience,
			},
			success: function (res) {
				if(postsPerPageMob >= res.max) {
					$('#load-more-media-all-mob').attr('style', 'display: none !important');
				}
				$('#filter-media-list-articles-mob').html(res.html);
			}

		});
	})

	$('#load-more-grid').on('click', function (event) {
		event.preventDefault();
		$('.acf-grid-categories-block').attr('style', 'display: flex!important');
		$('.acf-grid-categories-block.mobile-block').attr('style', 'display: none!important');
	});


	//-------------- Load more with search -------------------- //

	$('#load-more-search').on('click', function (event) {
		event.preventDefault();
		currentPage++;
		$.ajax({
			type: 'POST',
			url: ajax.url,
			dataType: 'json',
			data: {
				action: 'load_more_herbal_callback',
				paged: currentPage,
				searchValue: ''
			},
			success: function (res) {
				if(currentPage >= res.max) {
					$('#load-more-search').attr('style', 'display: none !important');
				}
				$('.herbal-list').append(res.html);
			}

		});
	})

	$('#herbal-search').on('keyup', function (event) {
		event.preventDefault();
		var searchValue = $(this).val();
		$.ajax({
			type: 'POST',
			url: ajax.url,
			dataType: 'json',
			data: {
				action: 'load_more_herbal_callback',
				paged: 1,
				searchValue,
			},
			success: function (res) {
				if(res.html === null) {
					$('#load-more-search').attr('style', 'display: none !important');
					$('#not-found').show();
				} else {
					if(currentPage >= res.max) {
						$('#load-more-search').attr('style', 'display: none !important');
						$('#not-found').hide();
					} else {
						$('#load-more-search').show();

					}
				}
				$('.herbal-list').html(res.html);
			}

		});
	})
	$('.navigation-list > li > a').on('click', function (event) {
		$('.navigation-list > li > a').removeClass('focus');
		$(this).addClass('focus');
	})
	if (window.innerWidth < 1025) {
		$('.acf-cards-block').slick({
			speed: 300,
			dots: true,
			slidesToShow: 2,
			slidesToScroll: 1,
			infinite: false,
			responsive: [
				{
					breakpoint: 640,
					settings: {
						arrows: false,
						slidesToShow: 1,
					}
				},
			]
		})
	}

	let sliderInitialized = false;
	let resizeTimer;

	function applyBackgroundImages() {
		$('.list-two-articles-item').each(function() {
			const $this = $(this);
			const bgImage = $this.data('bg');
			if (bgImage) {
				$this.css('background-image', `url(${bgImage})`);
			}
		});
	}

	function initializeSlider() {
		if (!sliderInitialized) {
			$('.list-two-articles').slick({
				speed: 300,
				dots: true,
				arrows: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: false,
				variableWidth: true,
				adaptiveHeight: true,
			});
			sliderInitialized = true;
			applyBackgroundImages(); // Apply backgrounds after initialization
		}
	}

	function destroySlider() {
		if (sliderInitialized) {
			$('.list-two-articles').slick('unslick');
			sliderInitialized = false;
			applyBackgroundImages(); // Reapply backgrounds after destroying
		}
	}

	function handleResize() {
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(function() {
			if (window.innerWidth <= 647) {
				initializeSlider();
			} else {
				destroySlider();
			}
		}, 250);
	}
	function truncateTitle(selector) {
		const elements = $(selector);

		elements.each(function() {
			const element = $(this);
			const originalText = element.text();
			const words = originalText.split(' ');
			let truncatedText = '';

			$.each(words, function(index, word) {
				element.text(truncatedText + word + ' ');
				if (element[0].scrollHeight > element[0].clientHeight + 1) {
					element.text(truncatedText.trim() + '...');
					return false;
				}
				truncatedText += word + ' ';
			});
		});
	}

	window.addEventListener('load', () => {
		setTimeout(function () {
			truncateTitle('.article-title');
		}, 1000);
	});
// Initial setup
	$(document).ready(function() {
		applyBackgroundImages(); // Apply backgrounds on page load
		handleResize();
	});

// Handle window resize
	$(window).on('resize', handleResize);

// Reinitialize slider when all images are loaded
	$(window).on('load', function() {
		applyBackgroundImages(); // Ensure backgrounds are applied after all images load
		if (window.innerWidth <= 647) {
			destroySlider(); // Ensure it's destroyed first
			initializeSlider(); // Then reinitialize
		}
	});

	// -------------------- Back to all button ------------- //

	$('.submenu-with-content-block').on('mouseenter', function () {
		$('.submenu-with-content-block .lvl-0 > li:first-child').addClass('is-active');
		$('.submenu-with-content-block .lvl-0 > li:first-child > .lvl-1').addClass('js-dropdown-active-active');
	})
	$('.copy-button').on('click', function () {
		var copyText = $(this).attr('data-current-link');
		navigator.clipboard.writeText(copyText);
		alert("Link Copied: " + copyText);
	})

	$('.share-button').on('click', function (event) {
		event.preventDefault();
		event.stopPropagation()
		$('.share-box').toggleClass('toggle');
	})

	let rightDivHeight = $('.acf-custom-featured-block').children(':nth-child(2)').find('.featured-right-block').outerHeight();
	let leftDiv = $('.acf-custom-featured-block').children(':nth-child(2)').find('.featured-left-block');
	leftDiv.css('max-height', rightDivHeight + 'px');
	$(window).resize(function() {
		let rightDivHeight = $('.acf-custom-featured-block').children(':nth-child(2)').find('.featured-right-block').outerHeight();
		leftDiv.css('max-height', rightDivHeight + 'px');
	});

	// -------------------- Audience filter for posts in most popular slider ------------- //
	// $(document).ready(function() {
	// 	setTimeout(function() {
	//
	// 	}, 1500);
	// });
// --------------------------------------------------------------------------------- //
	document.addEventListener("DOMContentLoaded", function () {
		const links = document.querySelectorAll('a[href^="#"]');

		const headerHeight = document.querySelector("header").offsetHeight;

		links.forEach(link => {
			link.addEventListener("click", function (event) {

				const targetId = link.getAttribute("href");
				if (targetId && targetId.startsWith("#")) {
					event.preventDefault();

					const target = document.querySelector(targetId);
					if (target) {

						window.scrollTo({
							top: target.offsetTop - headerHeight,
							behavior: "smooth"
						});
					}
				}
			});
		});
	});

	$('.contact-block-email.show-email').on('click', function (event) {
		event.preventDefault();
		console.log('test')
		$.ajax({
			type: 'POST',
			url: ajax.url,
			dataType: 'html',
			data: {
				action: 'show_footer_email',
			},
			success: function (res) {
				$('.contact-block-email').replaceWith(res);
			},
			error: function (xhr, status, error) {
				console.error("AJAX error:", status, error);
			}
		});
	})
}( jQuery ));