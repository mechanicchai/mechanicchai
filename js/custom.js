(function ($) {
    'use strict';
    var app = {
        service_cart_array: [],
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
            
            //initial update local storage if emptyservicesAddToCart

            if( jQuery.isEmptyObject(app.getLocalStorage()) ) {
                app.updateLocalStorage();
            }

            //init service cart array
            app.service_cart_array = app.cart_array();

            $(document).on('click', '.mc-main-services', app.selectServices);
            $(document).on('submit', '.mc-wc-register-form', app.saveRegisterAccountDatas);
            $(document).on('submit', '.mc-register-otp-form', app.otpRegisterWooAccount);
            $(document).on('change', '.mc-service-brand.mc-active' , app.changeModelByBrand);
            $(document).on('change', '.mc-service-types', app.changeServicesByType);
            $(document).on('click', '#nextBtn', app.getServiceDatas);
            $(document).on('click', '#prevBtn', app.showNextBtn);
            $(document).on('click', '.mc-add-service-cart-btn', app.servicesAddToCart);
            $(document).on('click', '#mc_service_submit', app.serviceSubmit);
            $(document).on('click', '.mc-btn-service-cancel', app.removeServices);
            $(document).on('click', '.cd-cart__actions .cd-cart__delete-item', app.removeServices);
            
        },
        getServicesClan: function() {

            var services_clan = [
                {
                    'name': 'ac',
                    'type_one': 'brand',
                    'type_two': 'ton'
                },
                {
                    'name': 'car',
                    'type_one': 'brand',
                    'type_two': 'model'
                },
                {
                    'name': 'cctv',
                    'type_one': 'brand',
                    'type_two': 'camera-type'
                },
                {
                    'name': 'electricity',
                    'type_one': 'user-type',
                    'type_two': 'setup-type'
                },
                {
                    'name': 'generator',
                    'type_one': 'generator-type',
                    'type_two': 'oil-type'
                },
                {
                    'name': 'motorcycle',
                    'type_one': 'brand',
                    'type_two': 'model'
                },
                {
                    'name': 'refrigerator',
                    'type_one': 'brand',
                    'type_two': 'type'
                },
                {
                    'name': 'plumbing',
                    'type_one': 'user-type',
                    'type_two': 'setup-type'
                },
                {
                    'name': 'computer',
                    'type_one': 'brand',
                    'type_two': 'processor'
                }
            ];

            return services_clan;

        },
        selectServices: function(e) {
            e.preventDefault();

            //current category  
            var current_category = $(this).data('category');

            //get services type clan  
            var clan = app.getServicesClan();

            //get matched clan with selected category
            var matched_clan = clan.filter( function(clan_item) {
                return current_category === clan_item.name; 
            }).shift();

            //update the select labels
            if( matched_clan !== undefined ) {
                var matched_clan_type_one = matched_clan.type_one.split("-");
                    matched_clan_type_one = matched_clan_type_one.join(" ");
                    matched_clan_type_one = `${matched_clan_type_one[0].toUpperCase()}${matched_clan_type_one.slice(1)}`;
                var matched_clan_type_two = matched_clan.type_two.split("-");
                    matched_clan_type_two = matched_clan_type_two.join(" ");
                    matched_clan_type_two = `${matched_clan_type_two[0].toUpperCase()}${matched_clan_type_two.slice(1)}`;
                $('.service_child_one_label').text( matched_clan_type_one );
                $('.service_child_two_label').text( matched_clan_type_two );
            }

            //select each main services
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
            $('.mc-services-list-items tr').each(function() {
                var service_option_value = $(this).data('service-option');
                var data_cat = $(this).data('category');
                var service_data = app.getLocalStorage();

                if( data_cat == '' ) {
                    $(this).hide();
                }else {
                    console.log( 'id is : ' + id);
                    
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

            var services = localStorate.services;

            //set datas
            var info = localStorate.info;
            var categories = {
                'category': localStorate.categories.category,
                'brand': localStorate.categories.brand,
                'model': localStorate.categories.model,
            };

            // make total ammount of services
            var total = app.getTotal();

            //services
            var services_list = "total: " + total + ", ";
            
            //make services list to string
            services.forEach( function( service ) {
                var services_item = JSON.stringify( service );
                    services_item = services_item.replace("{", "");
                    services_item = services_item.replace('"', "");
                    services_item = services_item.replace("}", "");
                    services_list += "#" + services_item; 
            });

            //service info
            var service_info = "name: "+ info.name +", phone: "+ info.number +", location: "+ info.address + ' ' + info.location +", date: "+ info.date +", time: "+ info.time;

            //service categories
            var service_categories = "service_category: X, FBL: Y, FML: Z";
            service_categories = service_categories.replace( 'FBL', categories.category.brand_label );
            service_categories = service_categories.replace( 'FML', categories.category.model_label );
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
        cart_array: function(newItem) {
            //cart array with storage services
            var service_data = app.getLocalStorage();
            var services_datas = service_data.services;
            

            //when new item is not empty and this item is not exist as previous item, just add this item
            if( newItem !== null && newItem !== undefined ) {
                console.log( services_datas.filter(function(e) { return e.id === newItem.id; }).length  )
                if ( ! services_datas.filter(function(e) { return e.id === newItem.id; }).length > 0 ) {
                    services_datas.push( newItem );
                }
            }
            
            return services_datas;
        },
        servicesAddToCart: function(e) {
            e.preventDefault();

            var service_data = app.getLocalStorage();

            var service_title = $(this).parents('tr').find('.mc-service-title').text();
            var id = $(this).data('id');
            var cost = $(this).parents('tr').find('.mc-service-cost').data('cost');
            
            if( $(this).is('.mc-cart-active') ) {
                $(this).removeClass( 'mc-cart-active' );
                $(this).text('Add');
                app.removeServices(id);
            }else {
                $(this).text('Cancel');

                //new item
                var newItem = {
                    name: service_title,
                    id: id,
                    price: cost,
                }
                app.cart_array(newItem);

                //assign cart array
                app.service_cart_array = app.cart_array(newItem);

                //update localstorage
                app.updateLocalStorage();
               
                //add active class
                $(this).addClass('mc-cart-active');


                //get local storage services
                var service_data = app.getLocalStorage();

                // local services
                var services = service_data.services;

                //set to empty before pushing cart services
                $('.cd-cart__body .p-4').html('');

                // make total ammount of services
                var total = app.getTotal();

                //show total in cart
                $('.cd-cart__checkout span').text(total);

                //services loop
                services.forEach(function(item) {
                    var name = item.name;
                    var price = item.price;

                    //make services item html
                    var service_name_anchor = $('<a>').text( name );
                    var service_price = $('<span>', {
                        "class": "cd-cart__price" 
                    }).text( price );
                    var action = $('<a>', {
                        "class": "cd-cart__delete-item",
                        "id": item.id
                    }).text('Cancel');

                    var h3 = $('<h3>', {
                        "class": "truncate",
                    }).append(service_name_anchor);

                    var cart_action = $('<div>', {
                        "class": 'cd-cart__actions'
                    }).append(action);

                    var card_details = $('<div>', {
                        "class": 'cd-cart__details'
                    }).append(h3).append(service_price).append(cart_action);

                    var li = $('<li>').append(card_details);

                    //append cart item
                    $('.cd-cart__body .p-4').append(li);
                });
                
            }
            
        },
        getTotal: function() {

            var service_data = app.getLocalStorage();

            // local services
            var services = service_data.services;
            
            // make total ammount of services
            var total = services.reduce(
                (accumulator, currentValue) => accumulator + parseInt( currentValue.price )
                , 0
            );

            return total;
        },
        removeServices: function(id) {

            var service_data = app.getLocalStorage();
            var services  = service_data.services;
            
            

            //when this is checkout cancel button, get it's service id
            if( $(this).is('.mc-btn-service-cancel') ) {
                id = $(this).parent().data('id');
                $(this).parents('tr').hide();

                $('.mc-services-list-items .mc-add-service-cart-btn[data-id="'+ id +'"]').text('Add').removeClass('mc-cart-active');
            }else if( $(this).is('.cd-cart__delete-item') ) {
                id = $(this).attr('id');
                $(this).parents('li').hide();

                $('.mc-services-list-items .mc-add-service-cart-btn[data-id="'+ id +'"]').text('Add').removeClass('mc-cart-active');
            
            }

            //filter services
            var filtered_services  = services.filter((service) => service.id !== parseInt(id) );
                filtered_services === undefined ? [] : filtered_services;

            //update cart total after filter services
            if( $(this).is('.cd-cart__delete-item') ) {
                // make total ammount of filtered services
                var total = filtered_services.reduce(
                    (accumulator, currentValue) => accumulator + parseInt( currentValue.price )
                    , 0
                );

                //show total in cart
                $('.cd-cart__checkout span').text(total);
            }
            
            var service_data = {
                'categories': app.cart_categories,
                'info': app.service_info,
                'services': filtered_services
            };

            localStorage.setItem("service_data", JSON.stringify(service_data));
        },
        getServiceDatas: function(e) {
            e.preventDefault();
            var service_data = app.getLocalStorage();

            //service categories datas
            var category = $('.service-cat-active').data('category');
            var brand = $('.mc-service-brand.mc-active').find('option:selected').data('brand');
            var model = $('.mc-service-model.mc-active').find('option:selected').data('model');
            var year = $('.mc-service-year').val();

            //brand label
            var brand_label = $('.service_child_one_label').text();
            
            //model label
            var model_label = $('.service_child_two_label').text();
            

            app.cart_categories.category = category ? category : service_data.categories.category;
            app.cart_categories.brand_label =  brand_label ? brand_label : service_data.categories.brand_label;
            app.cart_categories.brand =  brand ? brand : service_data.categories.brand;
            app.cart_categories.model_label = model_label ? model_label : service_data.categories.model_label;
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

            
            //clear all services from checkout
            if( $('.service-review').is('.active') ) {
                $('.mc-checkout-services-list tbody').html('');
            }

            //add all services in checkout
            var all_services = service_data.services;
            all_services.forEach( function( item ) {

                //create checkout service dom
                var first_td = $('<td>', {
                    'data-id': '1'
                }).text( item.name );

                var second_td = $('<td>', {
                    'data-cost': item.price
                }).text( item.price + 'tk' );

                var button = $('<a>', {
                    class: 'btn btn-primary btn-sm mc-btn-service-cancel'
                }).text('Cancel');

                var third_td = $('<td>', {
                    'data-id': item.id,
                    class: 'text-right'
                }).append( button );



                var all_services_tr = $('<tr>').append(first_td).append(second_td).append(third_td);

                if( $('.service-review').is('.active') ) {
                    $('.mc-checkout-services-list tbody').append( all_services_tr );
                }

            });

            if( $('.service-review').is('.active') ) {
                $('#nextBtn').hide();
                $('.mc-submit-form-wrapper .gravity-form').show();
            }

            //update local storate
            app.updateLocalStorage();

            //update service checkout dom
            app.updateServiceDom();


            var service_data = app.getLocalStorage();

            // repair services matches category and show
            $('.mc-services-list-items tr').each(function(e) {
                var data_cat = $(this).data('category');

                if( data_cat !== '' ) {
                    var data_cat_arr = data_cat.split(',');
                    var service_data_cat = service_data.categories.category;

                    if( ! data_cat_arr.includes(service_data_cat) ) {
                        $(this).hide();

                    }else {
                        $(this).show();
                        console.log( 'ase ase ase' );
                    } 

                }else {
                    $(this).hide();
                }
            });


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
            if( $('.service-review').is('.active') ) {
                if( date !== '' ) {
                    $('.mc-checkout-appoint-date').text( app.formateDate(date) );
                }
            }
            $('.service-checkout-location').text( location );
            $('.service-checkout-address').text( address );
            $('.service-checkout-name').text( name );
            $('.service-checkout-number').text( number );

            if( service_data.services ) {
                var services = service_data.services;
                // services.each(function() {
    
                // });
            }

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
                'services': app.service_cart_array
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


