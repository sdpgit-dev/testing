/*!
 * Script for adding functionality to the Edit Page screen.
 *
 * @since 1.0.0
 */
/* global jQuery, ttfobspgbEditPageData */
(function($) {
	'use strict';

	var ttfobspgbEditPage = {
		cache: {
			$document: $(document)
		},

		init: function() {
			this.cacheElements();
			this.bindEvents();
		},

		cacheElements: function() {
			this.cache.$builderToggle = $('#use-builder');
			this.cache.$mainEditor = $('#postdivrich');
			this.cache.$builder = $('#ttfobspgb-builder');
			this.cache.$duplicator = $('.ttfobspgb-duplicator');
			this.cache.$builderHide = $('#ttfobspgb-builder-hide');
			this.cache.$featuredImage = $('#postimagediv');
			this.cache.$helpnotice = $('#ttfobspgb-notice-obspgb-page-builder-welcome');
			this.cache.$body = $('body');
		},

		bindEvents: function() {
			var self = this;

			// Setup the event for toggling the Page Builder when the page template input changes
			self.cache.$builderToggle.on('click', self.templateToggle);

			// Change default settings for new pages
			if ( typeof ttfobspgbEditPageData !== 'undefined' ) {
				if ( 'post.php' === ttfobspgbEditPageData.pageNow && ttfobspgbEditPageData.useBuilder ) {
					self.cache.$builderToggle.prop( 'checked', true );
				}
			}

			// Obspgb sure screen is correctly toggled on load
			self.cache.$document.on('ready', function() {
				self.cache.$builderToggle.triggerHandler('click');
			});
		},

		templateToggle: function(e) {
			var self = ttfobspgbEditPage,
				$target = $(e.target),
				val = $target.val();

			if ( self.cache.$builderToggle.is(':checked') ) {
				self.cache.$mainEditor.hide();
				self.cache.$builder.show();
				self.cache.$duplicator.show();
				self.cache.$builderHide.prop('checked', true).parent().show();
				self.featuredImageToggle('message');
				self.cache.$helpnotice.show();
				self.cache.$body.addClass('ttfobspgb-builder-active').removeClass('ttfobspgb-default-active');
			} else {
				self.cache.$mainEditor.show();
				self.cache.$builder.hide();
				self.cache.$duplicator.hide();
				self.cache.$builderHide.prop('checked', false).parent().hide();
				self.featuredImageToggle('show');
				self.cache.$helpnotice.hide();
				self.cache.$body.removeClass('ttfobspgb-builder-active').addClass('ttfobspgb-default-active');
				setTimeout( function() {
					$( window ).trigger( 'resize' );
				}, 300 );
			}
		},

		featuredImageToggle: function(state) {
			var self = ttfobspgbEditPage,
				container, message;

			if ('undefined' !== typeof ttfobspgbEditPageData) {
				message = ttfobspgbEditPageData.featuredImage;
			} else {
				message = 'Note: the Builder Template does not display a featured image.';
			}
			container = $('<div class="ttfobspgb-metabox-message"></div>').css('padding', '0 12px 12px').html(message).wrapInner('<p class="hide-if-no-js">');

			self.cache.$featuredImage.find('.ttfobspgb-metabox-message').remove();

			if ('message' === state) {
				self.cache.$featuredImage.find('.inside').after(container);
			}
		}
	};

	ttfobspgbEditPage.init();
})(jQuery);