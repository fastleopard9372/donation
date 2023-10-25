(function($){Drupal.behaviors.initColorbox={attach:function(context,settings){if(!$.isFunction($('a, area, input',context).colorbox)||typeof settings.colorbox==='undefined'){return;}
if(settings.colorbox.mobiledetect&&window.matchMedia){var mq=window.matchMedia("(max-device-width: "+settings.colorbox.mobiledevicewidth+")");if(mq.matches){return;}}
settings.colorbox.rel=function(){if($(this).data('colorbox-gallery')){return $(this).data('colorbox-gallery');}
else{return $(this).attr('rel');}};$('.colorbox',context).once('init-colorbox').each(function(){var extendParams={photo:true};var title=$(this).attr('title');if(title){extendParams.title=Drupal.colorbox.sanitizeMarkup(title);}
$(this).colorbox($.extend({},settings.colorbox,extendParams));});$(context).bind('cbox_complete',function(){Drupal.attachBehaviors('#cboxLoadedContent');});}};if(!Drupal.hasOwnProperty('colorbox')){Drupal.colorbox={};}
Drupal.colorbox.sanitizeMarkup=function(markup){if(typeof DOMPurify!=='undefined'){var purifyConfig={ALLOWED_TAGS:['a','b','strong','i','em','u','cite','code','br'],ALLOWED_ATTR:['href','hreflang','title','target']}
if(Drupal.settings.hasOwnProperty('dompurify_custom_config')){purifyConfig=Drupal.settings.dompurify_custom_config;}
return DOMPurify.sanitize(markup,purifyConfig);}
else{return Drupal.checkPlain(markup);}}})(jQuery);