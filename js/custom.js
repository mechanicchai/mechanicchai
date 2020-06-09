(function ($) {
    'use strict';
    var app = {
        init: function () {
            $('.mc-main-services').on('click', app.selectServices);
            $(document).on('change', '.mc-service-brand.mc-active' , app.changeModelByBrand);
        },
        selectServices: function(e) {
            e.preventDefault();

            $('.mc-main-services').each(function(e) {
                if( $(this).is('.btn-primary') ) {
                    $(this).removeClass('btn-primary').addClass('btn-secondary');
                }
            });

            $(this).removeClass('btn-secondary').addClass('btn-primary');

            // change brand
            var current_category = $(this).data('category');

            $('.mc-service-brand').each(function(e) {
                var brand_category = $(this).data('brand-category');
                
                if( brand_category === current_category ) {
                    $(this).addClass('mc-active');
                }else {
                    if( brand_category !== '' ) {
                        $(this).removeClass('mc-active');
                    }
                }
            });


            var brand_selected_value = $('.mc-service-brand.mc-active').find('option:selected').data('brand');
            $('.mc-service-model').each(function(e) {
                var model_selected_value = $(this).data('brand');

                if( brand_selected_value !== '' && brand_selected_value === model_selected_value ) {
                    $(this).addClass('mc-active');
                }else {
                    if( $(this).is('.mc-active') ) {
                        $(this).removeClass('mc-active');
                    }   
                }
            });
            
        },
        changeModelByBrand: function(e) {
            console.log('changed');
            var brand_value = $(this).find('option:selected').data('brand');

            console.log("brand_value " + brand_value);
            $('.mc-service-model').each(function(e) {
                var model_selected_value = $(this).data('brand');

                if( brand_value !== '' && brand_value === model_selected_value ) {
                    $(this).addClass('mc-active');
                }else {
                    if( $(this).is('.mc-active') ) {
                        $(this).removeClass('mc-active');
                    }   
                }
            });
            
        }
        
    };

    $(document).ready(app.init);

    return app;
})(jQuery);


