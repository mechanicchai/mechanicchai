/**
 * Admin JS
 */
(function ($) {
    'use strict';
    var app = {
        init: function () {
            app.onLoadServicesType();
            $('.mc_service_type').on('change', app.changeServicestype);
        },

        onLoadServicesType: function() {
            var mc_service_type_val = $('.mc_service_type:checked').val();
            console.log(mc_service_type_val);
            
            if( mc_service_type_val == 1 ) {
                $('.service-type-child').show();
            }else {
                $('.service-type-child').hide();
            }
        },
        changeServicestype: function() {
            var mc_service_type_val = $(this).val();
            if( mc_service_type_val == 1 ) {
                $('.service-type-child').show();
            }else {
                $('.service-type-child').hide();
            }
        }
    };

    $(document).ready(app.init);

    return app;
})(jQuery);


