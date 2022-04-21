+function ($) { "use strict";
    $(document).render(function() {
        if ($.FroalaEditor) {
            $.FroalaEditor.DEFAULTS = $.extend($.FroalaEditor.DEFAULTS, {
                toolbarButtons: ['inlineClass','inlineStyles'],
                inlineClasses: {
                  'accent': 'accent',
                },
                inlineStyles: {
                    'Big Red': 'font-size: 20px; color: red;',
                    'Small Blue': 'font-size: 14px; color: blue;'
                }
            });
        }
    })
}(window.jQuery);