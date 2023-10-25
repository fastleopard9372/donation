(function ($) {
  $.fn.ALSFTriggerAdWordsConversions = function (data) {
    if (typeof gtag === "function") {
      for (var i = 0; i < data.length; i++) {
        var conversion = {
          send_to: data[i].conversion_id + "/" + data[i].conversion_label,
        };
        if (data[i].value != "undefined") {
          conversion.value = data[i].value;
          conversion.currency = "USD";
        }
        var result = gtag("event", "conversion", conversion);
      }
    }
  };
  $.fn.ALSFTriggerFacebookConversions = function (data) {
    if (typeof fbq === "function") {
      for (var i = 0; i < data.length; i++) {
        var fb_event = data[i];
        fbq("track", fb_event.event, fb_event.params);
      }
    }
  };
  $.fn.ALSFTriggerGAConversions = function (data) {
    for (var i = 0; i < data.length; i++) {
      var ga_event = data[i];
      dataLayer.push({
        event: "AnalyticsEvent",
        category: ga_event.category,
        action: ga_event.action,
        label: ga_event.label,
        value: ga_event.value,
      });
    }
  };
  if (typeof Drupal.ajax != "undefined") {
    Drupal.ajax.prototype.ALSFAJAXResponse = function () {
      var ajax = this;
      if (ajax.ajaxing) {
        return false;
      }
      try {
        $.ajax(ajax.options);
      } catch (err) {
        alert(
          "An error occurred while attempting to process " + ajax.options.url
        );
        return false;
      }
      return false;
    };
  }
  function detectIE() {
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    if (msie > 0) {
      return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
    }
    var trident = ua.indexOf("Trident/");
    if (trident > 0) {
      var rv = ua.indexOf("rv:");
      return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
    }
    var edge = ua.indexOf("Edge/");
    if (edge > 0) {
      return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
    }
    return false;
  }
  Drupal.behaviors.ALSFCore = {
    attach: function (context, settings) {
      var doUserCallback = true;
      if (typeof Accept == "object") {
        var IE = detectIE();
        if (IE && IE <= 11) {
          doUserCallback = false;
        }
      }
      if (
        doUserCallback &&
        typeof $("body").once === "function" &&
        typeof Drupal.ajax != "undefined"
      ) {
        $("body").once("alsf-ajax-content", function () {
          var path = window.location.pathname;
          var alsf_usercontent_ajax_settings = {
            url: "/ajax/user-content",
            event: "onload",
            progress: { type: "throbber" },
            submit: {
              p: unescape(encodeURIComponent(path)),
              ajax_page_state: Drupal.settings.ajaxPageState,
            },
          };
          Drupal.ajax["alsf_usercontent_ajax_action"] = new Drupal.ajax(
            null,
            $(document.body),
            alsf_usercontent_ajax_settings
          );
          //  Drupal.ajax["alsf_usercontent_ajax_action"].ALSFAJAXResponse();
        });
      }
      if (typeof $(".messages").once === "function") {
        $(".messages").once("alsf-messages", function () {
          var allKrumoContent = "";
          $(".messages.status li.message-item")
            .has(".krumo-root")
            .each(function (i) {
              allKrumoContent += $(this).html();
              $(this).remove();
            });
          $(".messages.status")
            .has(".krumo-root")
            .each(function (i) {
              allKrumoContent += $(this).html();
              $(this).remove();
            });
          if (allKrumoContent != "") {
            $("body").prepend(
              '<div id="debug-messages">' + allKrumoContent + "</div>"
            );
          }
          $(".messages").append(
            $("<a>", {
              text: "Close",
              class: "close-link",
              href: "#",
              click: function (e) {
                $(this).parent(".messages").slideUp();
                e.preventDefault();
              },
            })
          );
        });
      }
      $("#messages-help-wrapper").slideDown();
      if (
        typeof Drupal.settings.ALSFCoreEvents != "undefined" &&
        typeof ga != "undefined"
      ) {
        $.each(Drupal.settings.ALSFCoreEvents, function (delta, ga_event) {
          var result = null;
          if (typeof ga_event.value != "undefined") {
            result = ga(
              "send",
              "event",
              ga_event.category,
              ga_event.action,
              ga_event.label,
              Math.round(ga_event.value)
            );
          } else {
            result = ga(
              "send",
              "event",
              ga_event.category,
              ga_event.action,
              ga_event.label
            );
          }
        });
        delete Drupal.settings.ALSFCoreEvents;
      }
      if (typeof Drupal.settings.dragndropUpload != "undefined") {
        $("form").once("alsf-dragndrop-behaviors", function () {
          $.each(Drupal.settings.dragndropUpload, function (id, settings) {
            var parentForms = $(id).parents("form");
            $(id).bind(
              "dnd:addFiles:before",
              function (response, status, sentFiles) {
                parentForms.find("input[type='submit']").hide();
                $(id).parents("form").find("input[type='submit']").hide();
              }
            );
            $(id).bind(
              "dnd:send:complete",
              function (response, status, sentFiles) {
                parentForms.find("input[type='submit']").show();
                $(id).parents("form").find("input[type='submit']").show();
              }
            );
          });
        });
      }
    },
  };
})(jQuery);
