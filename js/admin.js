/**
 * Admin JS
 */
(function ($) {
    'use strict';
    var app = {
        init: function () {
            app.onLoadServicesType();
            $('.mc_service_type').on('change', app.changeServicestype);
            $(document).on('change', '', app.testDom);
            $('.popular-category input[type="checkbox"]').on('change', app.changeChildCategorySelected);

        },
        testDom: function() {

        },
        changeChildCategorySelected: function() {
            console.log( 'hello Corona' );
            
            if( $(this).attr('checked') ) {
                $(this).parent().siblings().find('input[type="checkbox"]').attr('checked','checked');
            }else {
                console.log('nai');
            }
            
        },

        onLoadServicesType: function() {
            var mc_service_type_val = $('.mc_service_type:checked').val();
            
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


