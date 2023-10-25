(function($){Drupal.behaviors.superfish={attach:function(context,settings){$.each(settings.superfish||{},function(index,options){$('#superfish-'+options.id,context).once('superfish',function(){var list=$(this);if(options.plugins||false){if(options.plugins.supersubs||false){list.supersubs(options.plugins.supersubs);}}
list.superfish(options.sf);if(options.plugins||false){if(options.plugins.touchscreen||false){list.sftouchscreen(options.plugins.touchscreen);}
if(options.plugins.smallscreen||false){list.sfsmallscreen(options.plugins.smallscreen);}
if(options.plugins.automaticwidth||false){list.sfautomaticwidth();}
if(options.plugins.supposition||false){list.supposition();}
if(options.plugins.bgiframe||false){list.find('ul').bgIframe({opacity:false});}}});});}};})(jQuery);