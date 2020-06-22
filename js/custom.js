(function ($) {
    'use strict';
    var app = {
        cart_array: [], // cart array for service,
        cart_categories: {
            'category': '',
            'brand': '',
            'model': '',
            'year': ''
        },
        service_info: {
            'name' : '',
            'number' : '',
            'location' : '',
            'address' : '',
            'date' : '',
            'time' : '',
            'user' : ''
        }, // cart service information
        init: function () {
            
            //initial update local storage if empty
            if( jQuery.isEmptyObject(app.getLocalStorage()) ) {
                app.updateLocalStorage();
            }

            $('.mc-main-services').on('click', app.selectServices);
            $(document).on('change', '.mc-service-brand.mc-active' , app.changeModelByBrand);
            $(document).on('change', '.mc-service-types', app.changeServicesByType);
            $('.mc-add-service-cart-btn').on('click', app.servicesAddToCart);
            $(document).on('click', '#nextBtn', app.getServiceDatas);
            
        },
        selectServices: function(e) {
            e.preventDefault();

            $('.mc-main-services').each(function(e) {
                if( $(this).is('.btn-primary') ) {
                    $(this).removeClass('btn-primary').addClass('btn-secondary');
                }
                if( $(this).is('.service-cat-active') ) {
                    $(this).removeClass('service-cat-active');
                }
            });

            $(this).removeClass('btn-secondary').addClass('btn-primary');
            $(this).addClass('service-cat-active');

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
            var brand_value = $(this).find('option:selected').data('brand');
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
            
        },
        changeServicesByType: function(e) {
            var id = $(this).find('option:selected').attr('value');
            $('.mc-repair-services tr').each(function() {
                var service_option_value = $(this).data('service-option');
                if( service_option_value == id ) {
                    $(this).show();
                }else {
                    $(this).hide();
                }

                //when selected option 'All' show all options 
                if( id == '0' ) {
                    $(this).show();
                }
            });
            
        },
        servicesAddToCart: function(e) {
            e.preventDefault();
            
            if( $(this).is('.mc-cart-active') ) {
                return;
            }

            var service_title = $(this).parents('tr').find('.mc-service-title').text();
            app.cart_array.push(service_title);
            console.log(app.cart_array);

            $(this).addClass('mc-cart-active');
        },
        getServiceDatas: function(e) {
            e.preventDefault();
            var service_data = app.getLocalStorage();

            //service categories datas
            var category = $('.service-cat-active').data('category');
            var brand = $('.mc-service-brand.mc-active').find('option:selected').data('brand');
            var model = $('.mc-service-model.mc-active').find('option:selected').data('model');
            var year = $('.mc-service-year').val();
            

            app.cart_categories.category = category ? category : service_data.categories.category;
            app.cart_categories.brand = brand ? brand : service_data.categories.brand;
            app.cart_categories.model = model ? model : service_data.categories.model;
            app.cart_categories.year = year ? year : service_data.categories.year;

            //service info datas
            var name = $('.service-info-name').val();
            var number = $('.service-info-number').val();
            var location = $('.service-info-location').val();
            var address = $('.service-info-address').val();
            var date = $('.service-info-date').val();
            var time = $('.service-info-time').val();
            var user = $('.service-info-user').val();

            app.service_info.name = name ? name : service_data.info.name;
            app.service_info.number = number ? number : service_data.info.number;
            app.service_info.location = location ? location : service_data.info.location;
            app.service_info.address = address ? address : service_data.info.address;
            app.service_info.date = date ? date : service_data.info.date;
            app.service_info.time = time ? time : service_data.info.time;
            app.service_info.user = user ? user : service_data.info.user;

            //update local storate
            app.updateLocalStorage();

            //update service checkout dom
            app.updateServiceDom();
        },
        updateServiceDom: function() {
            var service_data = app.getLocalStorage();
            console.log(service_data);

            var location = service_data.info.location ? service_data.info.location : '';
            var address = service_data.info.address ? service_data.info.address : '';
            var name = service_data.info.name ? service_data.info.name : '';
            var number = service_data.info.number ? service_data.info.number : '';
            var date = service_data.info.date ? service_data.info.date : '';
            var time = service_data.info.time ? service_data.info.time : '';
            var user = service_data.info.user ? service_data.info.user : '';
            
            //service categories
            var category = service_data.categories.category ? service_data.categories.category : '';
            var brand = service_data.categories.brand ? service_data.categories.brand : '';
            var model = service_data.categories.model ? service_data.categories.model : '';
            var year = service_data.categories.year ? service_data.categories.year : '';

            //update categories dom
            $('.mc-main-services').each(function() {
                if( category ) {
                    if( $(this).data('category') == category ) {
                        $(this).removeClass('btn-secondary').addClass('btn-primary service-cat-active');
                    }else {
                        $(this).removeClass('btn-primary service-cat-active').addClass('btn-secondary');
                    }
                }else {
                    if( $(this).data('category') == 'car' ) {
                        $(this).removeClass('btn-secondary').addClass('btn-primary service-cat-active');
                    }
                }
                
            });

            $('.mc-service-brand').each(function() {
                if( category ) {
                    if( $(this).data('brand-category') == category ) {
                        $(this).addClass('mc-active');
                        $(this).find('option[data-brand='+ brand +']').attr('selected','selected');
                    }else {
                        $(this).removeClass('mc-active');
                    }
                }else {
                    if( $(this).data('brand-category') == 'car' ) {
                        $(this).addClass('mc-active');
                    }
                }
                
            });
            
            $('.mc-service-model').each(function() {
                if( category ) {
                    if( $(this).data('model-category') == category && $(this).data('brand') == brand ) {
                        $(this).addClass('mc-active');
                        $(this).find('option[data-model='+ model +']').attr('selected','selected');
                    }else {
                        $(this).removeClass('mc-active');
                    }
                }else {
                    if( $(this).data('model-category') == 'car' && $(this).data('brand') == 'bmw' ) {
                        $(this).addClass('mc-active');
                    }
                }
                
            });

            $('.mc-service-year').val(year);            

            //update checkout dom
            $('.service-checkout-location').text( location );
            $('.service-checkout-address').text( address );
            $('.service-checkout-name').text( name );
            $('.service-checkout-number').text( number );

            //update form dom
            $('.service-info-name').val(name);
            $('.service-info-number').val(number);
            if( location ) {
                $('.service-info-location').val(location);
            }else {
                $('.service-info-location:first-child').attr('selected', 'selected');
            }
            $('.service-info-address').val(address);
            $('.service-info-date').val(date);
            $('.service-info-time').val(time);

        },
        getLocalStorage: function() {
            // Get the existing data
            var existing = localStorage.getItem('service_data');

            // If no existing data, create an array
            // Otherwise, convert the localStorage string to an array
            existing = existing ? JSON.parse(existing) : {};

            return existing;
        },
        updateLocalStorage: function() {
            var service_data = {
                'categories': app.cart_categories,
                'info': app.service_info,
                'services': ''
            };
            localStorage.setItem("service_data", JSON.stringify(service_data));
        }
    };

    $(document).ready(app.init);

    return app;
})(jQuery);


