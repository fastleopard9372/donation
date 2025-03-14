/*!
 * jQuery meanMenu v2.0.8 (Drupal Responsive Menus version)
 * @Copyright (C) 2012-2014 Chris Wharton @ MeanThemes (https://github.com/meanthemes/meanMenu)
 *
 */ (function ($) {
  "use strict";
  $.fn.meanmenu = function (options) {
    var defaults = {
      meanMenuTarget: jQuery(this),
      meanMenuContainer: "body",
      meanMenuClose: "X",
      meanMenuCloseSize: "18px",
      meanMenuOpen: "<span /><span /><span />",
      meanRevealPosition: "right",
      meanRevealPositionDistance: "0",
      meanRevealColour: "",
      meanScreenWidth: "480",
      meanNavPush: "",
      meanShowChildren: true,
      meanExpandableChildren: true,
      meanExpand: "+",
      meanContract: "-",
      meanRemoveAttrs: false,
      onePage: false,
      meanDisplay: "block",
      removeElements: "",
      meanScrollHeight: "70",
    };
    options = $.extend(defaults, options);
    var currentWidth = document.documentElement.clientWidth || document.body.clientWidth;
    console.log("v1");
    return this.each(function () {
      var meanMenu = options.meanMenuTarget;
      var meanMenuClone = options.meanMenuTarget.clone();
      meanMenuClone.find(".contextual-links-wrapper").remove().find("ul.contextual-links").remove();
      var meanContainer = options.meanMenuContainer;
      var meanMenuClose = options.meanMenuClose;
      var meanMenuCloseSize = options.meanMenuCloseSize;
      var meanMenuOpen = options.meanMenuOpen;
      var meanRevealPosition = options.meanRevealPosition;
      var meanRevealPositionDistance = options.meanRevealPositionDistance;
      var meanRevealColour = options.meanRevealColour;
      var meanScreenWidth = options.meanScreenWidth;
      var meanNavPush = options.meanNavPush;
      var meanRevealClass = ".meanmenu-reveal";
      var meanShowChildren = options.meanShowChildren;
      var meanExpandableChildren = options.meanExpandableChildren;
      var meanExpand = options.meanExpand;
      var meanContract = options.meanContract;
      var meanRemoveAttrs = options.meanRemoveAttrs;
      var onePage = options.onePage;
      var meanDisplay = options.meanDisplay;
      var removeElements = options.removeElements;
      var meanScrollHeight = options.meanScrollHeight;
      var isMobile = false;
      if (
        navigator.userAgent.match(/iPhone/i) ||
        navigator.userAgent.match(/iPod/i) ||
        navigator.userAgent.match(/iPad/i) ||
        navigator.userAgent.match(/Android/i) ||
        navigator.userAgent.match(/Blackberry/i) ||
        navigator.userAgent.match(/Windows Phone/i)
      ) {
        isMobile = true;
      }
      if (navigator.userAgent.match(/MSIE 8/i) || navigator.userAgent.match(/MSIE 7/i)) {
        jQuery("html").css("overflow-y", "scroll");
      }
      var meanRevealPos = "";
      var meanCentered = function () {
        if (meanRevealPosition === "center") {
          var newWidth = document.documentElement.clientWidth || document.body.clientWidth;
          var meanCenter = newWidth / 2 - 22 + "px";
          meanRevealPos = "left:" + meanCenter + ";right:auto;";
          if (!isMobile) {
            jQuery(".meanmenu-reveal").css("left", meanCenter);
          } else {
            jQuery(".meanmenu-reveal").animate({ left: meanCenter });
          }
        }
      };
      var menuOn = false;
      var meanMenuExist = false;
      if (meanRevealPosition === "right") {
        meanRevealPos = "right:" + meanRevealPositionDistance + ";left:auto;";
      }
      if (meanRevealPosition === "left") {
        meanRevealPos = "left:" + meanRevealPositionDistance + ";right:auto;";
      }
      meanCentered();
      var $navreveal = "";
      var meanInner = function () {
        if (jQuery($navreveal).is(".meanmenu-reveal.meanclose")) {
          $navreveal.html(meanMenuClose);
        } else {
          $navreveal.html(meanMenuOpen);
        }
      };
      var meanOriginal = function () {
        jQuery(".mean-bar,.mean-push").remove();
        jQuery(meanContainer).removeClass("mean-container");
        jQuery(meanMenu).css("display", meanDisplay);
        menuOn = false;
        meanMenuExist = false;
        jQuery(removeElements).removeClass("mean-remove");
      };
      var showMeanMenu = function () {
        var currentScroll = $(document).scrollTop();
        var meanStyles = "background:" + meanRevealColour + ";color:" + meanRevealColour + ";" + meanRevealPos;
        if (currentWidth <= meanScreenWidth || currentScroll >= meanScrollHeight) {
          jQuery(removeElements).addClass("mean-remove");
          meanMenuExist = true;
          jQuery(meanContainer).addClass("mean-container");
          jQuery(".mean-container").prepend('<div class="mean-bar"><a href="#nav" class="meanmenu-reveal" style="' + meanStyles + '">Show Navigation</a><nav class="mean-nav"></nav></div>');
          var meanMenuContents = jQuery(meanMenuClone).html();
          jQuery(".mean-nav").html(meanMenuContents);
          if (meanRemoveAttrs) {
            jQuery("nav.mean-nav ul, nav.mean-nav ul *").each(function () {
              if (jQuery(this).is(".mean-remove")) {
                jQuery(this).attr("class", "mean-remove");
              } else {
                jQuery(this).removeAttr("class");
              }
              jQuery(this).removeAttr("id");
            });
          }
          jQuery(meanMenu).before('<div class="mean-push" />');
          jQuery(".mean-push").css("margin-top", meanNavPush);
          jQuery(meanMenu).hide();
          jQuery(".meanmenu-reveal").show();
          jQuery(meanRevealClass).html(meanMenuOpen);
          $navreveal = jQuery(meanRevealClass);
          jQuery(".mean-nav ul").hide();
          if (meanShowChildren) {
            if (meanExpandableChildren) {
              jQuery(".mean-nav ul ul").each(function () {
                if (jQuery(this).children().length) {
                  jQuery(this, "li:first")
                    .parent()
                    .append('<a class="mean-expand" href="#" style="font-size: ' + meanMenuCloseSize + '">' + meanExpand + "</a>");
                }
              });
              jQuery(".mean-expand").on("click", function (e) {
                e.preventDefault();
                if (jQuery(this).hasClass("mean-clicked")) {
                  jQuery(this).text(meanExpand);
                  jQuery(this)
                    .prev("ul")
                    .slideUp(300, function () {});
                } else {
                  jQuery(this).text(meanContract);
                  jQuery(this)
                    .prev("ul")
                    .slideDown(300, function () {});
                }
                jQuery(this).toggleClass("mean-clicked");
              });
            } else {
              jQuery(".mean-nav ul ul").show();
            }
          } else {
            jQuery(".mean-nav ul ul").hide();
          }
          jQuery(".mean-nav ul li").last().addClass("mean-last");
          $navreveal.removeClass("meanclose");
          jQuery($navreveal).click(function (e) {
            e.preventDefault();
            if (menuOn === false) {
              $navreveal.css("text-align", "center");
              $navreveal.css("text-indent", "0");
              $navreveal.css("font-size", meanMenuCloseSize);
              jQuery(".mean-nav ul:first").slideDown();
              menuOn = true;
            } else {
              jQuery(".mean-nav ul:first").slideUp();
              menuOn = false;
            }
            $navreveal.toggleClass("meanclose");
            meanInner();
            jQuery(removeElements).addClass("mean-remove");
          });
          if (onePage) {
            jQuery(".mean-nav ul > li > a:first-child").on("click", function () {
              jQuery(".mean-nav ul:first").slideUp();
              menuOn = false;
              jQuery($navreveal).toggleClass("meanclose").html(meanMenuOpen);
            });
          }
        } else {
          console.log("avoided");
          meanOriginal();
        }
      };
      if (!isMobile) {
        jQuery(window).resize(function () {
          currentWidth = document.documentElement.clientWidth || document.body.clientWidth;
          if (currentWidth > meanScreenWidth) {
            meanOriginal();
          } else {
            meanOriginal();
          }
          if (currentWidth <= meanScreenWidth) {
            showMeanMenu();
            meanCentered();
          } else {
            meanOriginal();
          }
        });
      }
      jQuery(window).scroll(function () {
        var currentScroll = $(this).scrollTop();
        var currentWidth = document.documentElement.clientWidth || document.body.clientWidth;
        if (currentWidth > meanScreenWidth) {
          if (!isMobile) {
            meanOriginal();
            if (currentScroll >= meanScrollHeight) {
              showMeanMenu();
              meanCentered();
            }
          } else {
            meanCentered();
            if (currentScroll < meanScrollHeight) {
              if (meanMenuExist === false) {
                showMeanMenu();
              }
            } else {
              meanOriginal();
            }
          }
        }
      });
      jQuery(window).resize(function () {
        currentWidth = document.documentElement.clientWidth || document.body.clientWidth;
        if (!isMobile) {
          meanOriginal();
          if (currentWidth <= meanScreenWidth) {
            showMeanMenu();
            meanCentered();
          }
        } else {
          meanCentered();
          if (currentWidth <= meanScreenWidth) {
            if (meanMenuExist === false) {
              showMeanMenu();
            }
          } else {
            meanOriginal();
          }
        }
      });
      showMeanMenu();
    });
  };
})(jQuery);
