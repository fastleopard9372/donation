(function($,undefined){if($.ui&&$.ui.dialog&&$.ui.dialog.overlay){$.ui.dialog.overlay.events=$.map('focus,keydown,keypress'.split(','),function(event){return event+'.dialog-overlay';}).join(' ');}}(jQuery));