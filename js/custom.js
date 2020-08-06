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
            $(document).on('submit', '.mc-wc-register-form', app.saveRegisterAccountDatas);
            $(document).on('submit', '.mc-register-otp-form', app.otpRegisterWooAccount);
            $(document).on('change', '.mc-service-brand.mc-active' , app.changeModelByBrand);
            $(document).on('change', '.mc-service-types', app.changeServicesByType);
            $(document).on('click', '#nextBtn', app.getServiceDatas);
            $(document).on('click', '#prevBtn', app.showNextBtn);
            $('.mc-add-service-cart-btn').on('click', app.servicesAddToCart);
            $(document).on('click', '#mc_service_submit', app.serviceSubmit);
            
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
            var current_category_text = $(this).text();
            $('.mc-title-category').text( current_category_text );
            

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
                var data_cat = $(this).data('category');
                var service_data = app.getLocalStorage();

                if( data_cat == '' ) {
                    $(this).hide();
                }else {
                    if( service_option_value == id ) {
                        $(this).show();
                    }else {
                        $(this).hide();
                    }

                    var data_cat_arr = data_cat.split(',');
                    var service_data_cat = service_data.categories.category;

                    //when selected option 'All' show all options matched service category 
                    if( id == '0' ) {
                        $(this).show();

                        if( !data_cat_arr.includes(service_data_cat) ) {
                            $(this).hide();
                        }
                    }
                }
                

                
            });
            
        },
        serviceSubmit: function(e) {
            e.preventDefault();

            var localStorate = app.getLocalStorage();
            console.log( localStorate );

            var services = localStorate.services;

            //set datas
            var info = localStorate.info;
            var categories = {
                'category': localStorate.categories.category,
                'brand': localStorate.categories.brand,
                'model': localStorate.categories.model,
            };

            // make total ammount of services
            var total = services.reduce(
                (accumulator, currentValue) => accumulator + parseInt( currentValue.price )
                , 0
            )

            //services
            var services_list = "total: " + total + ", ";
            
            //make services list to string
            services.forEach( function( service ) {
                var services_item = JSON.stringify( service );
                    services_item = services_item.replace("{", "");
                    services_item = services_item.replace('"', "'");
                    services_item = services_item.replace("}", "");
                    services_list += "#" + services_item; 
            });

            console.log( services_list );
            

            

            //service info
            var service_info = "name: "+ info.name +", phone: "+ info.number +", location: "+ info.address + ' ' + info.location +", date: "+ info.date +", time: "+ info.time;

            //service categories
            var service_categories = "service_category: X, brand: Y, model: Z";
            service_categories = service_categories.replace( 'X', categories.category );
            service_categories = service_categories.replace( 'Y', categories.brand );
            service_categories = service_categories.replace( 'Z', categories.model );

            var mc_service_nonce = $('#mc_send_services').val();
            var ajax_data = {
                action: 'mc_submit_services_value',
                mc_service_nonce: mc_service_nonce,
                data: {
                    'services': services_list,
                    'categories': service_categories,
                    'info': service_info
                }
            };
            
            //post otp code
            $.post( my_ajax_object.ajax_url, ajax_data, function( msg ) {
                
                console.log( msg.result );
                console.log( msg.url );
                console.log( msg.headers );

            }, 'json').done(function(msg) {
                
                Swal.fire({
                    title: "Congratulations!",
                    text: "Your order has beed taken!",
                    icon: "success",
                    confirmButtonText: "Cool!"
                }).then(function () {
                    //alert( 'redirect call hoise' );
                }, function (dismiss) {
                      return false;
                });
                
            });

            
        },
        servicesAddToCart: function(e) {
            e.preventDefault();
            
            if( $(this).is('.mc-cart-active') ) {
                return;
            }

            var service_title = $(this).parents('tr').find('.mc-service-title').text();
            var id = $(this).parents('tr').find('.mc-service-title').data('id');
            var cost = $(this).parents('tr').find('.mc-service-cost').data('cost');
            var service_cart = {
                name: service_title,
                id: id,
                price: cost,
            }
            app.cart_array.push(service_cart);

            $(this).addClass('mc-cart-active');

            //update local storage
            app.updateLocalStorage();
        },
        getServiceDatas: function(e) {
            e.preventDefault();
            var service_data = app.getLocalStorage();

            //service categories datas
            var category = $('.service-cat-active').data('category');
            var brand = $('.mc-service-brand.mc-active').find('option:selected').data('brand');
            var model = $('.mc-service-model.mc-active').find('option:selected').data('model');
            var year = $('.mc-service-year').val();

            // repair services matches category and show
            $('.mc-repair-services tr').each(function(e) {
                var data_cat = $(this).data('category');

                if( data_cat !== '' ) {
                    var data_cat_arr = data_cat.split(',');
                    var service_data_cat = service_data.categories.category;

                    if( !data_cat_arr.includes(service_data_cat) ) {
                        $(this).hide();
                    }
                }else {
                    $(this).hide();
                }
            });
            

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

            if( $('.service-review').is('.active') ) {
                $('#nextBtn').hide();
                $('.mc-submit-form-wrapper .gravity-form').show();
            }

            //update local storate
            app.updateLocalStorage();

            //update service checkout dom
            app.updateServiceDom();
        },
        updateServiceDom: function() {
            var service_data = app.getLocalStorage();
            
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
            $('.mc-checkout-brand').text( app.capitalize(brand) );
            $('.mc-checkout-model').text( app.capitalize(model) );
            if( year ) {
                $('.mc-checkout-year').text( " - " + year );
            }else {
                $('.mc-checkout-year').text( "" );
            }
            $('.mc-checkout-appoint-date').text( app.formateDate(date) );
            $('.service-checkout-location').text( location );
            $('.service-checkout-address').text( address );
            $('.service-checkout-name').text( name );
            $('.service-checkout-number').text( number );

            if( service_data.services ) {
                var services = service_data.services;
                // services.each(function() {
    
                // });
            }

            $('.mc-checkout-services-list tr').each(function() {

            });

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
        showNextBtn: function() {
            $('#nextBtn').show();
            $('.mc-submit-form-wrapper .gravity-form').hide();
        },
        formateDate: function(date) {
            var d = new Date(date);

            if( d !== 'Invalid Date' ) {
                var year = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d);
                var month = new Intl.DateTimeFormat('en', { month: 'short' }).format(d);
                var day = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d);

                var full_date = day + '-' + month + '-' + year;
                return full_date;
            }
            
        },
        capitalize: function(word) {
            var caps = word.charAt(0).toUpperCase() + word.slice(1);
            return caps;
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
                'services': app.cart_array
            };
            localStorage.setItem("service_data", JSON.stringify(service_data));
        },
        saveRegisterAccountDatas: function(e) {
            e.preventDefault();
            var data = {};
            data.name = $(this).find('input[name="mc_reg_full_name"]').val();
            data.location = $(this).find('select[name="mc_reg_location"]').val();
            data.mobile_first = $(this).find('select[name="mc_reg_mobile_first"]').val();
            data.mobile_last = $(this).find('input[name="mc_reg_mobile_last"]').val();
            data.mobile = data.mobile_first + '' + data.mobile_last; 
            data.password = $(this).find('input[name="mc_reg_password"]').val();
            data.re_password = $(this).find('input[name="mc_reg_re_password"]').val();

            //when no field is empty
            if( data.name !== '' || data.location !== '0' || data.password !== '' || data.mobile !== '' ) {
                $('.mc-input-error').removeClass('mc-input-error');
                $('.mc-form-error-msg').remove();
            }

            //when name is empty
            if( data.name == null || data.name == '' ) {
                var name_msg_div = $(this).find('input[name="mc_reg_full_name"]').parent();
                $(this).find('input[name="mc_reg_full_name"]').addClass('mc-input-error');
                if( $('.mc-form-name-field').length == '0' ) {
                    $('<div></div>', {
                        'class': 'mc-form-error-msg mc-form-name-field',
                        text: "Name field should not be empty."
    
                    }).appendTo( name_msg_div );
                }
            }

            //when location is empty
            if( data.location == null || data.location == '0'  ) {
                var location_msg_div = $(this).find('select[name="mc_reg_location"]').parent();
                $(this).find('select[name="mc_reg_location"]').addClass('mc-input-error');
                if( $('.mc-form-location-field').length == 0 ) {
                    $('<div></div>', {
                        'class': 'mc-form-error-msg mc-form-location-field',
                        text: "Location field should not be empty."
    
                    }).appendTo( location_msg_div );
                }
                
            }

            if( data.mobile_last == null || data.name == '' ) {
                var mobile_msg_div = $(this).find('input[name="mc_reg_mobile_last"]').parent();
                $(this).find('input[name="mc_reg_mobile_last"]').addClass('mc-input-error');
                if( $('.mc-form-mobile-field').length == 0 ) {
                    $('<div></div>', {
                        'class': 'mc-form-error-msg mc-form-mobile-field',
                        text: "Mobile field should not be empty."
    
                    }).appendTo( mobile_msg_div );
                }
                
            }

            if( data.password == null || data.name == '' ) {
                var password_msg_div = $(this).find('input[name="mc_reg_password"]').parent();
                $(this).find('input[name="mc_reg_password"]').addClass('mc-input-error');
                if( $('.mc-form-password-field').length == 0 ) {
                    $('<div></div>', {
                        'class': 'mc-form-error-msg mc-form-password-field',
                        text: "Password field should not be empty."
    
                    }).appendTo( password_msg_div );
                }
                
            }

            //when confirm password does not matched
            if( data.password !== data.re_password ) {
                var re_password_msg_div = $(this).find('input[name="mc_reg_re_password"]').parent();
                $(this).find('input[name="mc_reg_re_password"]').addClass('mc-input-error');
                if( $('.mc-form-repassword-field').length == 0 ) {
                    $('<div></div>', {
                        'class': 'mc-form-error-msg mc-form-repassword-field',
                        text: "Confirm password does not matched."
    
                    }).appendTo( re_password_msg_div );
                }
                
            }

            //set localstorage data
            localStorage.setItem("register_form_data", JSON.stringify(data));

            var reg_nonce = $('#_wpnonce').val();
            var ajax_data = {
                action: 'mc_send_otp_for_register_form',
                reg_nonce: reg_nonce,
                mobile: data.mobile
            };
            
            //post otp code
            $.post( my_ajax_object.ajax_url, ajax_data, function( msg ) {

                // set otp to localstorage
                if( msg.otp_code ) {
                    localStorage.setItem("register_otp", msg.otp_code);
                }

            }, 'json').done(function(msg) {
                
                //when user is exists by this phone number
                if( msg.user_exists ) {
                    alert('This phone number already have an account.');
                    
                    setTimeout(() => {
                        window.location.replace('/registration');
                        localStorage.removeItem("register_otp");
                        localStorage.removeItem("register_form_data");
                    }, 1000);
                }else{
                    if( msg.otp_code ) {
                        //add query param to current url
                        const urlParams = new URLSearchParams(window.location.search);
                        urlParams.set('otp', 'yes');
                        window.location.search = urlParams;
                    }
                }
            });
        },
        otpRegisterWooAccount: function(e) {
            e.preventDefault();

            var input_otp = $('input[name="mc_reg_otp_code"]').val();
            var stored_otp = localStorage.getItem("register_otp");

            // when otp matched
            if( input_otp == stored_otp ) {
                var data = localStorage.getItem("register_form_data");
                data = JSON.parse(data);

                var otp_reg_nonce = $('#woocommerce-otp-nonce').val();
                var ajax_data = {
                    action: 'mc_send_otp_send_register_data',
                    otp_reg_nonce: otp_reg_nonce,
                    data: {
                        name: data.name,
                        location: data.location,
                        phone: data.mobile,
                        password: data.password
                    }
                };

                //post otp code
                $.post( my_ajax_object.ajax_url, ajax_data, function( msg ) {
                    console.log(msg);
                }, 'json').done(function(msg) {
                    window.location.replace('/');
                    localStorage.removeItem("register_otp");
                    localStorage.removeItem("register_form_data");
                });
            }else{
                alert('OTP does not matched...');
            }
        }

    };

    $(document).ready(app.init);

    return app;
})(jQuery);


