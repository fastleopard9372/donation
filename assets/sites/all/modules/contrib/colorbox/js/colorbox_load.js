(function($){Drupal.behaviors.initColorboxLoad={attach:function(context,settings){if(!$.isFunction($.colorbox)||typeof settings.colorbox==='undefined'){return;}
if(settings.colorbox.mobiledetect&&window.matchMedia){var mq=window.matchMedia("(max-device-width: "+settings.colorbox.mobiledevicewidth+")");if(mq.matches){return;}}
$.urlParams=function(url){var p={},e,a=/\+/g,r=/([^&=]+)=?([^&]*)/g,d=function(s){return decodeURIComponent(s.replace(a,' '));},q=url.split('?');while(e=r.exec(q[1])){e[1]=d(e[1]);e[2]=d(e[2]);switch(e[2].toLowerCase()){case 'true':case 'yes':e[2]=true;break;case 'false':case 'no':e[2]=false;break;}
if(e[1]=='width'){e[1]='innerWidth';}
if(e[1]=='height'){e[1]='innerHeight';}
if(e[2]){e[2]=Drupal.checkPlain(e[2]);}
p[e[1]]=e[2];}
return p;};$('.colorbox-load',context).once('init-colorbox-load',function(){var href=$(this).attr('href');var params=$.urlParams(href);params.iframe=true;if(!params.hasOwnProperty('innerWidth')){params.innerWidth=$(window).width()*.8;}
if(!params.hasOwnProperty('innerHeight')){params.innerHeight=$(window).height()*.8;}
if(!params.hasOwnProperty('title')){var title=$(this).attr('title');if(title){params.title=Drupal.colorbox.sanitizeMarkup(title);}}
$(this).colorbox($.extend({},settings.colorbox,params));});}};})(jQuery);