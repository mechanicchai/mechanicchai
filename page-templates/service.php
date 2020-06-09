<?php
/**
 * Template Name: Service
 * 
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="service">
        <div class="container">

            <form id="regForm" action="/action_page.php">
                <div class="step-group" style="text-align:center;">
                    <span class="step"><span class="count">1st</span><span class="name">Category & Specification</span></span>
                    <span class="step"><span class="count">2nd</span><span class="name">Service</span></span>
                    <span class="step"><span class="count">3rd</span><span class="name">Address and Appointment Time/Date</span></span>
                    <span class="step"><span class="count">4th</span><span class="name">Review & Book</span></span>
                </div>
                <h1>Answer a few simple questions to get a Service.</h1>
                <hr>
                <!-- One "tab" for each step in the form: -->
                <div class="tab">
                    <div class="row">
                        <div class="col-md-8 select-service">
                            <h3>Select Service</h3>
                            <?php $categories = mc_get_all_parent_categories( 'service_category' ); ?>
                            <div class="row se-services">
                                <?php
                                    foreach( $categories as $category ) {
                                        $cat_id = $category->term_id;
                                        $cat_name = $category->name;     
                                    ?>
                                    <div class="col-4 mt-2">
                                        <a class="mc-main-services btn <?php echo ($cat_name == 'Car') ? 'btn-primary' : 'btn-secondary'; ?>" data-cat_id="<?php echo !empty($cat_id) ? $cat_id : ''; ?>" 
                                        data-category="<?php echo strtolower($category->name); ?>"><i class="fas fa-car"></i><br><?php echo !empty($cat_name) ? $cat_name : ''; ?></a>
                                    </div>
                                    <?php
                                    }
                                ?>
                            </div>

                        </div>
                        <div class="col-md-4 specify-service">
                            <h3>Specify Your Car</h3>
                            <form>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Brand</label>
                                    
                                        <?php
                                            foreach( $categories as $category ) {
                                                $cat_id = $category->term_id; 
                                                $brands_as_child_categories = get_categories( array( 
                                                    'parent' => $cat_id,
                                                    'taxonomy' => 'service_category'
                                                ) );
                                                
                                                if( $brands_as_child_categories ) {
                                                ?>
                                                
                                                <select name="" id="" class="form-control mc-service-brand <?php echo ($category->slug === 'car') ? 'mc-active' : ''; ?>" data-brand-category="<?php echo strtolower($category->name); ?>">
                                                    <?php
                                                        //default active brand id for getting model lists
                                                        $default_active_brand_id = ($category->slug === 'car') ? $brands_as_child_categories[0]->term_id : '';

                                                        if( $brands_as_child_categories ) {
                                                            foreach( $brands_as_child_categories as $brand ) { 
                                                        ?>
                                                        <option data-brand="<?php echo !empty($brand) ? $brand->slug : ''; ?>" data-id="<?php echo !empty($brand) ? $brand->term_id : ''; ?>"><?php echo !empty($brand) ? $brand->name : ''; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                                <?php
                                                }
                                            }
                                        ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Model</label>
                                    <?php
                                        foreach( $categories as $category ) {
                                            $cat_id = $category->term_id; 
                                            $brands_as_child_categories = get_categories( array( 
                                                'parent' => $cat_id,
                                                'taxonomy' => 'service_category'
                                            ) );
                                            
                                            if( $brands_as_child_categories ) {
                                                $counter = 0;
                                                foreach( $brands_as_child_categories as $brand ) {
                                                    $models_as_child_categories = get_categories( array( 
                                                        'parent' => $brand->term_id,
                                                        'taxonomy' => 'service_category'
                                                    ) );

                                                    if( $models_as_child_categories ) {
                                                ?>
                                                <select class="form-control mc-service-model <?php echo ($counter === 0 && $category->slug === 'car') ? 'mc-active' : ''; ?>" 
                                                data-model-category="<?php echo strtolower($category->name); ?>"
                                                data-brand="<?php echo !empty($brand) ? $brand->slug : ''; ?>">
                                                    <?php
                                                        foreach( $models_as_child_categories as $model ) {
                                                            ?>
                                                            <option data-id="<?php echo !empty($model) ? $model->term_id : ''; ?>"><?php echo !empty($model) ? $model->name : ''; ?></option>
                                                            <?php
                                                        }   
                                                    ?>
                                                </select>
                                                <?php
                                                    }

                                                    $counter++;
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Year</label>
                                    <input type="text" placeholder="2010">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab">
                    <div class="tabs">
                        <div class="tab-button-outer">
                            <ul id="tab-button">
                                <li><a href="#tab01">REPAIR & MAINTENANCE SERVICES</a></li>
                                <li><a href="#tab02">DIAGNOSTICS & INSPECTIONS</a></li>
                            </ul>
                        </div>
                        <div class="tab-select-outer">
                            <select id="tab-select" class="form-control">
                                <option value="#tab01">REPAIR & MAINTENANCE SERVICES</option>
                                <option value="#tab02">DIAGNOSTICS & INSPECTIONS</option>
                            </select>
                        </div>

                        <div id="tab01" class="tab-contents">
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control">
                                        <option>Brake</option>
                                        <option>Engine</option>
                                        <option>Body/Chasis</option>
                                        <option>Fuel/Gas</option>
                                        <option>Tire/Rim</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                                        <div class="input-group-append">
                                            <span class="input-group-text lighten-3" id="basic-text1"><i class="fas fa-search text-grey" aria-hidden="true"></i></span>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-12">
                                    <table class="table table-hover mt-4">
                                        <tbody>
                                            <tr>
                                                <td>ABS Speed Sensor Replacement</td>
                                                <td>780Tk</td>
                                                <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                            </tr>
                                            <tr>
                                                <td>Wheel Speed Sensor Replacement</td>
                                                <td>1200Tk</td>
                                                <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                            </tr>
                                            <tr>
                                                <td>Brake Drum Replacement</td>
                                                <td>540Tk</td>
                                                <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                            </tr>
                                            <tr>
                                                <td>Brake Caliper Replacement</td>
                                                <td>340Tk</td>
                                                <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                            </tr>
                                            <tr>
                                                <td>Brake Hose Replacement</td>
                                                <td>540Tk</td>
                                                <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                            </tr>
                                            <tr>
                                                <td>Brake Master Cylinder Replacement</td>
                                                <td>840Tk</td>
                                                <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                            </tr>
                                            <tr>
                                                <td>Brake Drum Replacement</td>
                                                <td>540Tk</td>
                                                <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                            </tr>
                                            <tr>
                                                <td>Brake Drum Replacement</td>
                                                <td>540Tk</td>
                                                <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                            </tr>
                                            <tr>
                                                <td>Brake Drum Replacement</td>
                                                <td>540Tk</td>
                                                <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                            </tr>
                                            <tr>
                                                <td>Brake Drum Replacement</td>
                                                <td>540Tk</td>
                                                <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div id="tab02" class="tab-contents">
                            <table class="table table-hover mt-4">
                                <tbody>
                                    <tr>
                                        <td>Car is not starting</td>
                                        <td>780Tk</td>
                                        <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                    </tr>
                                    <tr>
                                        <td>Check engine light is on</td>
                                        <td>1200Tk</td>
                                        <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                    </tr>
                                    <tr>
                                        <td>Warning light is on</td>
                                        <td>540Tk</td>
                                        <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                    </tr>
                                    <tr>
                                        <td>Fluids are leaking</td>
                                        <td>340Tk</td>
                                        <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                    </tr>
                                    <tr>
                                        <td>Car is shaking (vibrating)</td>
                                        <td>540Tk</td>
                                        <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                    </tr>
                                    <tr>
                                        <td>Brakes are squeaking</td>
                                        <td>840Tk</td>
                                        <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                    </tr>
                                    <tr>
                                        <td>Smoke or steam is coming out of the car</td>
                                        <td>540Tk</td>
                                        <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                    </tr>
                                    <tr>
                                        <td>Car is overheating Heating and A/C</td>
                                        <td>540Tk</td>
                                        <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                    </tr>
                                    <tr>
                                        <td>Windows are not going up or down</td>
                                        <td>540Tk</td>
                                        <td class="text-right"><a class="btn btn-primary btn-sm">Add</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Name</label>
                                    <input type="text" class="form-control" placeholder="your name here">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Number</label>
                                    <input type="text" class="form-control" placeholder="your number here">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Location</label>
                                    <select class="form-control" id="exampleFormControlSelect1">
                                        <option>Badda</option>
                                        <option>Rampura</option>
                                        <option>Gulshan</option>
                                        <option>Banani</option>
                                        <option>Mohakhali</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Address</label>
                                    <textarea class="form-control">

                </textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Date</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Time</label>
                                    <input type="time" class="form-control">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab">
                    <div class="card">
                        <div class="card-body">

                            <div class="card-title text-center">Order Overview</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Corolla G</h3>
                                    <h5>Toyota - 2016</h5>
                                </div>
                                <div class="col-md-6 text-right">
                                    <h3>Appointment Date/Time</h3>
                                    <h5>1st April 2020</h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <h3>Services</h3>
                                    <table class="table table-hover mt-4">
                                        <tbody>
                                            <tr>
                                                <td>ABS Speed Sensor Replacement</td>
                                                <td>780Tk</td>
                                                <td class="text-right"><a class="btn btn-primary btn-sm">Cancel</a></td>
                                            </tr>
                                            <tr>
                                                <td>Wheel Speed Sensor Replacement</td>
                                                <td>1200Tk</td>
                                                <td class="text-right"><a class="btn btn-primary btn-sm">Cancel</a></td>
                                            </tr>
                                            <tr>
                                                <td>Brake Drum Replacement</td>
                                                <td>540Tk</td>
                                                <td class="text-right"><a class="btn btn-primary btn-sm">Cancel</a></td>
                                            </tr>
                                            <tr>
                                                <td>Brake Caliper Replacement</td>
                                                <td>340Tk</td>
                                                <td class="text-right"><a class="btn btn-primary btn-sm">Cancel</a></td>
                                            </tr>
                                            <tr>
                                                <td>Brake Hose Replacement</td>
                                                <td>540Tk</td>
                                                <td class="text-right"><a class="btn btn-primary btn-sm">Cancel</a></td>
                                            </tr>
                                            <tr style="font-weight: bolder">
                                                <td class="text-right">Total Payable =</td>
                                                <td>3160Tk</td>
                                                <td class="text-right"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Address</h3>
                                    <p>Location : Rampura</p>
                                    <p>Address : House : 29, Road : 11, DIT Road, Rampura</p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <h3>Contact Info</h3>
                                    <p>Name : Rafel Chy</p>
                                    <p>Number : 01992969618</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Payment Method</h3>
                                    <p>Cash on Delivery</p>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="overflow:auto;">
                    <div style="float:right;">
                        <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                        <button type="button" id="nextBtn" onclick="nextPrev(1)">Order</button>
                    </div>
                </div>
                <!-- Circles which indicates the steps of the form: -->

            </form>
        </div>
    </div>

<?php get_footer(); ?>