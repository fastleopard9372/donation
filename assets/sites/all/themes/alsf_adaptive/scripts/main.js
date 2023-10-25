(function($) {

  Drupal.behaviors.ALSFAdaptiveTheme = {
    attach: function (context, settings) {

			// Any scripts that should run on every page load should go here.
			// They will also run on any DOM elements that are added
			// or altered via AJAX requests.

/*
			// once the SIDR hamburger element has loaded, move it into the header
			if($('#sidr-wrapper-0').length > 0 && !$('#sidr-wrapper-0').hasClass('sidr-move-processed')) {
				var button = $('#sidr-wrapper-0').detach();
				$('#leaderboard-wrapper .region-leaderboard .region-inner').append(button);
				button.addClass('sidr-move-processed');
			}
*/

			// Scrolling effects
			$(window).scroll(function() {
				var scroll_h = $(this).scrollTop();
				// header shrinkage
				if (scroll_h > 70){
					// don't run this code every single time
					if(!$('#header').hasClass('sticky')) {
						$('#header').addClass("sticky");
						$('#nav-wrapper').addClass("sticky");
						$('#tophat-wrapper').addClass("sticky");
/*
						// trigger the meanmenu if it's not already showing up because of the screen width
						currentWidth = document.documentElement.clientWidth || document.body.clientWidth;
						console.log(currentWidth);
						// retrieve the meanmenu settings
			      settings.responsive_menus = settings.responsive_menus || {};
						console.log(settings.responsive_menus);
			      $.each(settings.responsive_menus, function(ind, iteration) {
    	        if (iteration.responsive_menus_style == 'mean_menu' && iteration.selectors == '#block-superfish-1' && iteration.media_size < currentWidth) {
				        // Set 1/0 to true/false respectively.
				        $.each(iteration, function(key, value) {
				          if (value == 0) {
				            iteration[key] = false;
				          }
				          if (value == 1) {
				            iteration[key] = true;
				          }
				        });
				        console.log(iteration);
				        console.log('before');
			          $('#block-superfish-1').meanmenu({
			            meanMenuContainer: iteration.container || "body",
			            meanMenuClose: iteration.close_txt || "X",
			            meanMenuCloseSize: iteration.close_size || "18px",
			            meanMenuOpen: iteration.trigger_txt || "<span /><span /><span />",
			            meanRevealPosition: iteration.position || "right",
			            meanScreenWidth: iteration.media_size || "6000",
			            meanExpand: iteration.expand_txt || "+",
			            meanContract: iteration.contract_txt || "-",
			            meanShowChildren: iteration.show_children,
			            meanExpandableChildren: iteration.expand_children,
			            meanRemoveAttrs: iteration.remove_attrs
			          });
				        console.log('after');
			        }
			      });
*/
					}
				}
				else{
					if($('#header').hasClass('sticky')) {
						$('#header').removeClass("sticky");
						$('#nav-wrapper').removeClass("sticky");
						$('#tophat-wrapper').removeClass("sticky");
					}
				}
				// get involved flyout
				if($('#get-involved-flyout').length > 0) {
					var flyout = $('#get-involved-flyout');
					if(scroll_h > 140) {
						flyout.addClass("closed");
					} else {
						flyout.removeClass("closed");
					}
					// don't let it scroll past the top of the footer
					var visible_h = $(window).height();
					var doc_h = $(document).height();
					var footer_h = $('#footer-wrapper').height();
					// if we've scrolled to a point where the footer is visible
					if(scroll_h + visible_h > doc_h - footer_h) {
						var footer_visible = (footer_h + scroll_h + visible_h) - doc_h;
						var flyout_h = flyout.height();
						var flyout_top = flyout.position().top;
						var flyout_bottom = visible_h - (flyout_h + flyout_top);
						// if the visible portion of the footer is greater than the bottom position of the flyout element
						if(footer_visible >= flyout_bottom) {
							var flyout_top = visible_h - footer_visible - flyout_h;
							flyout.css('top', flyout_top+'px');
							if(!flyout.hasClass('bottom')) {
								flyout.addClass('bottom');
							}
						} else if(flyout.hasClass('bottom')) {
							flyout.removeClass('bottom');
							flyout.css('top', visible_h - flyout_h);
						}
					} else if(flyout.hasClass('bottom')) {
						flyout.removeClass('bottom');
						flyout.css('top', visible_h - flyout_h);
					}
				}
			});

			// tophat search form behavior
			$('#tophat-wrapper').once('add-search-toggle', function() {
				if($('#tophat-wrapper .block-search').length > 0) {
					// hide the search form itself
					$('#tophat-wrapper .block-search').after('<a id="tophat-search-icon" href="#">Search</div>');
					$('#tophat-wrapper .block-search').hide();
					// when the icon is clicked, show the form and hide the icon
					$('#tophat-search-icon').click(function(e) {
						e.preventDefault();
						$('#tophat-wrapper .block-search').animate({width: ['show', 'linear']}, 400);
						$('#tophat-search-icon').hide();
						$('#tophat-wrapper .block-search input[name="search_block_form"]').focus();
					});
					// when the search button is clicked, add class to the form that focus trigger doesn't fire
					$('#tophat-wrapper .block-search input[type="submit"]').addClass('submitted');
					// when the search field loses focus, hide the form and show the icon again
					$('#tophat-wrapper .block-search').focusout(function() {
						// build in a delay so that if the submit button was clicked, it has a chance to submit
						setTimeout(function() {
							if(!$('#tophat-wrapper .block-search').hasClass('submitted')) {
								$('#tophat-wrapper .block-search').animate({width: ['hide', 'linear']}, 400);
								$('#tophat-search-icon').show();
							}
						}, 10);
					});

				}
			});

			// initialize traditional tabs
			$('.tabset').tabs({ show: { effect: "fade", duration: 100 } });

			// initialize responsive tabs
			$('.tabset-responsive').once('alsf-responsive-tabs', function() {
				if($(this).hasClass('start-collapsed')) {
					var hash = window.location.hash;
					if(hash) {
						$(this).responsiveTabs({
							startCollapsed: false
						});
					} else {
						$(this).responsiveTabs({
							collapsible: true,
							startCollapsed: true
						});
					}
				} else {
					$(this).responsiveTabs({
						startCollapsed: 'accordion'
					});
				}
			});

			// initialize show/hide regions
			$('h3.showhide-trigger').once('alsf-showhide', function() {
				// see if the next sibling of this element is a div.showhide-target
				if(!$(this).hasClass('showhide-open')) {
					$(this).next('div.showhide-target').hide();
				}
				$(this).click(function(e) {
					if($(this).hasClass('showhide-open')) {
						$(this).next('div.showhide-target').slideUp(400, function() {
							// wait until the animation is complete to change the borders
							$(this).prev('h3.showhide-trigger').removeClass('showhide-open');
						});
					} else {
						$(this).addClass('showhide-open').next('div.showhide-target').slideDown();
					}
				});
			});

			// handling for text fields using labels as default text
			$('input.label-as-bg').each(function() {
				if($(this).val() != '') {
					$(this).addClass('label-as-bg-focus');
				}
				$(this).focus(function() {
					$(this).addClass('label-as-bg-focus');
				});
				$(this).blur(function() {
					if($(this).val() == '') {
						$(this).removeClass('label-as-bg-focus');
					}
				});
			});

			// open all external links in a new window
	    $('a[href^="http://"]').filter(function() {
	        return this.hostname && this.hostname !== location.hostname;
	    }).attr('target', '_blank');

	    // set up content that gets displayed in popups
	    $('.popup-wrapper').each(function() {
	    	var trigger = $(this).find('.popup-trigger').first();
	    	var content = $(this).find('.popup-content').first();
	    	content.dialog({ autoOpen: false, width: 430, resizable: false });
	    	trigger.click(function(e) {
	    		content.dialog('open');
	    		e.preventDefault();
	    	});
	    });

	    // handle links that need to be opened in popup windows
	    $('a.popup-link').once('popup-link', function() {
	    	$(this).click(function(e) {
	        var target = $(this).attr('href');
	        var winWidth = 520;
	        var winHeight = 380;
	        var winTop = (screen.height / 2) - (winWidth / 2);
	        var winLeft = (screen.width / 2) - (winHeight / 2);
	        window.open(target, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
	        e.preventDefault();
	    	});
	    });

	    // show/hide regions - the link for triggering the event is the "opener"
	    // and the link to be shown is the subsequent "opener-target"
	    $('.opener').each(function() {
	    	$(this).wrap('<a href="#"></a>');
	    	$(this).parent().next('.opener-target').hide();
	    	$(this).parent().click(function(e) {
	    		$(this).next('.opener-target').slideToggle();
	    		$(this).toggleClass('opener-open');
	    		e.preventDefault();
	    	});
	    });
	    if($('.opener').length > 0) {
		    var firstOpener = $('.opener').first();
				firstOpener.parent().next('.opener-target').slideToggle();
	    	firstOpener.parent().toggleClass('opener-open');
	    }

	    // accordion regions - this is used on the user profile page
    	if($('.accordion').length) {
    		// if there's only one item in the set AND it's the account settings, keep that one closed by default
    		var is_active = 0;
    		if($('.accordion').children('h3').length == 1 && $('.accordion h3').first().text() == 'Your Account') {
    			is_active = false;
    		}
				$('.accordion').accordion({
      		collapsible: true,
      		heightStyle: "content",
      		active: is_active
    		});
			}

			// "Read More" buttons for narrow screens
			if(window.matchMedia("(max-width: 400px)").matches) {
				$('.read-more-on-mobile').once('alsf-read-more-on-mobile', function() {
					// wrap this item in a div
					$(this).wrap('<div class="read-more-on-mobile-wrapper read-more-hidden"></div>');
					// add a button at the bottom of that div
          var $button = $('<div class="read-more-button-wrapper"><input class="read-more-button" type="button" value="Expand" /></div>');
          $button.click(function(e) {
            e.preventDefault();
            $button.parent().removeClass('read-more-hidden');
            $button.hide();
          });
          $(this).parent().append($button);
				});
			}

			// "Read More" buttons that show up on any screen size
			$('.read-more-everywhere').once('alsf-read-more-everywhere', function() {
				// wrap this item in a div
				$(this).wrap('<div class="read-more-everywhere-wrapper read-more-hidden"></div>');
				// add a button at the bottom of that div
        var $button = $('<div class="read-more-button-wrapper"><input class="read-more-button" type="button" value="Expand" /></div>');
        $button.click(function(e) {
          e.preventDefault();
          $button.parent().removeClass('read-more-hidden');
          $button.hide();
        });
        $(this).parent().append($button);
			});

			//
			// BEGIN FORM STYLING CODE
			//

			// Define my own jQuery scroll function
			jQuery.fn.scrollTo = function(data) {
				$('html, body').animate({
					scrollTop: $(this).offset().top
				}, data);
			};

			// on forms where specified, confirm before leavning the page
			if($('.confirm-unless-clicked').length != 0) {
				$('.confirm-unless-clicked').once('ALSFConfirmBeforeLeaving').click(function(e) {
					window.main_button_clicked = true;
				});
				window.onbeforeunload = function() {
					if(!window.main_button_clicked){
						return 'You haven’t completed registration yet, click ‘Next’ to continue.';
					}
				};
			}

			// add styling classes to the radio elements
			$("input.form-radio:checked", context).once('ALSFForms').addClass('js-radio-on');
			$("input.form-radio", context).once('ALSFForms').addClass('js-radio').change(function() {
				if($(this).attr('checked')) {
					$(this).addClass('js-radio-on');
				} else {
					$(this).removeClass('js-radio-on');
				}
			});

			// add styling classes to the checkbox elements
			$("input.form-checkbox:checked", context).once('ALSFForms').addClass('js-checkbox-on');
			$("input.form-checkbox").addClass('js-checkbox').change(function() {
				if($(this).attr('checked')) {
					$(this).addClass('js-checkbox-on');
				} else {
					$(this).removeClass('js-checkbox-on');
				}
			});

			// add styling classes and elements to select elements
			$("select.form-select", context).once('ALSFForms').wrap('<span class="js-select" />');
			$("select.form-select:disabled", context).parent().addClass('js-select-disabled');

			// add styling classes and elements to text input elements
			$("input.form-text", context).once('ALSFForms').wrap('<span class="js-textfield" />');
			$("input.form-text:disabled", context).parent().addClass('js-textfield-disabled');

			// add styling classes and elements to buttons
			$("input.form-submit", context).not(".styled-button").once('ALSFForms').wrap('<span class="js-button" />');

			// Lani's addition for styling the team option radios
			// With gratitude to: http://so.devilmaycode.it/is-there-an-easy-way-to-replace-radio-button-with-images-and-a-colored-border-fo/#
			$('input:radio').each(function() {
				if (this.id == 'edit-team-option-newteam' || this.id == 'edit-team-option-oldteam' || this.id == 'edit-team-option-individual') {
					$(this).hide()
					var label = $("label[for=" + '"' + this.id + '"' + "]").text();
					$('<a ' + (label != '' ? 'title=" ' + label + ' "' : '' ) + ' class="radio-fx ' + this.name + '" ' + ' id="' + this.id + '" href="#"><span class="radio' + (this.checked ? ' radio-checked' : '') + '"></span></a>').insertAfter(this);
				}
			});

			//
			// END FORM STYLING CODE
			//

		}
	}

})(jQuery);
