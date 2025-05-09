<?php

/*
Template Name: Sidebar
*/

wp_enqueue_script('jquery-ui-accordion');

get_header();

?>

    <script type="text/javascript">
        (function( $ ) {

            $(document).ready(function () {
                $(".business-accordion").accordion({
                    collapsible: true, active: false, heightStyle: "content"
                });

                // First rotate the sponsors, then load them
                rotateThenLoadSponsors();
            });
            
            function rotateThenLoadSponsors() {
                // Call the rotation endpoint first
                jQuery.ajax({
                    url: "<?php echo get_site_url(); ?>/wp-json/wp/v2/business_sponsors_rotate",
                    dataType: "json",
                    type: "GET",
                    contentType: "application/json; charset=utf-8",
                    complete: function() {
                        // After rotation is complete (whether successful or not), load the sponsors
                        loadFeatured();
                        loadNonFeatured();
                    }
                });
            }

            function loadFeatured() {
                jQuery.ajax({
                    url: "<?php echo get_site_url(); ?>/wp-json/wp/v2/business_sponsors_featured",
                    dataType: "json",
                    type: "GET",
                    contentType: "application/json; charset=utf-8",
                    success: function (data) {
                        if (data != null) {
                            jQuery("#featuredWrapper").empty();
                            $code = '<h4>Featured Sponsors</h4><div id="business-sponsors" class="row">';
                            var dt = data;
                            if (dt.length == 1) {
                                $cssClass = 'col-sm-12';
                            } else {
                                $cssClass = 'col-sm-6';
                            }
                            for (i = 0; i < dt.length; i++) {
                                $code = $code + '<div class="' + $cssClass + '">';
                                if (dt[i].url !== '') {
                                    if (dt[i].newwindow == 'on') {
                                        $target = ' target="_blank"';
                                    } else {
                                        $target = '';
                                    }
                                    $code = $code + '<a href="' + dt[i].url + '"' + $target + '>';
                                }
                                $code = $code + '<img src="' + dt[i].image + '" style="max-width: 100%; height: auto;">';
                                if (dt[i].url !== '') {
                                    $code = $code + '</a>';
                                }
                                $code = $code + '</div>';
                            }
                            $code = $code + '</div>';
                            jQuery("#featuredWrapper").append($code);
                        }
                    },
                    error: function (d) {
                        //alert("Error");
                    }
                });
            }

            function loadNonFeatured() {
                jQuery.ajax({
                    url: "<?php echo get_site_url(); ?>/wp-json/wp/v2/business_sponsors_nonfeatured",
                    dataType: "json",
                    type: "GET",
                    contentType: "application/json; charset=utf-8",
                    success: function (data) {
                        if (data != null) {
                            jQuery("#nonFeaturedWrapper").empty();
                            $code = '<h4 class="fl-widget-title">Our Business Directory Sponsors</h4><div>';
                            $code = $code + '<ul>';

                            var dt = data;

                            for (i = 0; i < dt.length; i++) {
                                $code = $code + '<li style="padding-bottom: 20px; position: relative; float: left; list-style: none; display: block; margin: 0px; width: 300px;">';
                                if (dt[i].url !== '') {
                                    if (dt[i].newwindow == 'on') {
                                        $target = ' target="_blank"';
                                    } else {
                                        $target = '';
                                    }
                                    $code = $code + '<a href="' + dt[i].url + '"' + $target + '>';
                                }
                                $code = $code + '<img src="' + dt[i].image + '" style="max-width: 100%; height: auto;">';
                                if (dt[i].url !== '') {
                                    $code = $code + '</a>';
                                }
                                $code = $code + '</li>';
                            }
                            $code = $code + '</ul>';
                            $code = $code + '</div>';
                            jQuery("#nonFeaturedWrapper").append($code);
                        }
                    },
                    error: function (d) {
                        //alert("Error");
                    }
                });
            }

        })( jQuery );
    </script>

    <div class="container">
        <div class="row">

            <?php FLTheme::sidebar('left'); ?>


            <div class="fl-content <?php FLTheme::content_class(); ?>">
                <article class="fl-post post--999 page type-page status-static hentry" id="fl-post--999"
                         itemscope="itemscope" itemtype="http://schema.org/CreativeWork">

                    <header class="fl-post-header">
                        <h1 class="fl-post-title" itemprop="headline"><?php echo $location; ?>Business Directory</h1>
                    </header><!-- .fl-post-header -->

                    <div class="fl-post-content clearfix" itemprop="text">

                        <div id="business-general-info">

                            <?php

                            if ( is_page_template( 'webads-business-template' ) ) {
                                echo 'yep';
                            }

                            global $template;
                            global $post;
                            echo get_post_meta( $post->ID, '_wp_page_template', true );

                            //load options
                            $options = get_option('webads_business');

                            //information
                            $general_info = $options['general_info'];
                            $sponsor_info = $options['sponsor_info'];
                            $allow_public_submissions = isset($options['allow_public_submissions']) ? $options['allow_public_submissions'] : 0;


                            echo wpautop($general_info);
                            ?>

                            <div id="featuredWrapper">
                            </div>


                        </div>


                        <div id="business-sponsor-info">
                            <?php echo wpautop($sponsor_info); ?>
                        </div>
                        <?php if ($allow_public_submissions) { ?>
                        <p>
                        <div class="business-edit">

                            
                            <div>
                                <a href="<?php echo site_url(); ?>/business-directory-update?cid=add" target="_self"
                                   class="fl-button" role="button" style="padding: 15px; font-size: 14px;">
                                    add my business
                                </a>
                            </div>
                          

                        </div>
                        </p>
                        <?php } ?>
                        <div>

                            <?php

                            $c_city = '';

                            // WP_Query arguments
                            $args = array(
                                'post_type' => array('business'),
                                'post_status' => array('publish'),
                                'posts_per_page' => -1,
                                'orderby' => 'title',
                                'order' => 'ASC',
                            );

                            // The Query
                            $businesses = new WP_Query($args);

                            // The Loop
                            if ($businesses->have_posts()) {
                                // Initialize an array to store businesses by category
                                $businesses_by_category = array();
                                
                                // Group businesses by category
                                while ($businesses->have_posts()) {
                                    $businesses->the_post();
                                    
                                    // Get business details
                                    $details = get_post_meta(get_the_id(), 'business_details', true);
                                    $address = get_post_meta(get_the_id(), 'business_address', true);
                                    $city = get_post_meta(get_the_id(), 'business_city', true);
                                    $state = get_post_meta(get_the_id(), 'business_state', true);
                                    $zip = get_post_meta(get_the_id(), 'business_zip', true);
                                    $phone = get_post_meta(get_the_id(), 'business_phone', true);
                                    $email = get_post_meta(get_the_id(), 'business_email', true);
                                    $website = get_post_meta(get_the_id(), 'business_website', true);
                                    $facebook = get_post_meta(get_the_id(), 'business_facebook', true);
                                    $x = get_post_meta(get_the_id(), 'business_x', true);
                                    $instagram = get_post_meta(get_the_id(), 'business_instagram', true);
                                    $youtube = get_post_meta(get_the_id(), 'business_youtube', true);
                                    $vimeo = get_post_meta(get_the_id(), 'business_vimeo', true);
                                    
                                    // Get business category
                                    $category_name = 'Uncategorized';
                                    $category_id = 0;
                                    $terms = get_the_terms(get_the_id(), 'business_category');
                                    if ($terms && !is_wp_error($terms)) {
                                        $category_name = $terms[0]->name;
                                        $category_id = $terms[0]->term_id;
                                    }
                                    
                                    // Store business data in the array
                                    if (!isset($businesses_by_category[$category_id])) {
                                        $businesses_by_category[$category_id] = array(
                                            'name' => $category_name,
                                            'businesses' => array()
                                        );
                                    }
                                    
                                    $businesses_by_category[$category_id]['businesses'][] = array(
                                        'id' => get_the_id(),
                                        'title' => get_the_title(),
                                        'details' => $details,
                                        'address' => $address,
                                        'city' => $city,
                                        'state' => $state,
                                        'zip' => $zip,
                                        'phone' => $phone,
                                        'email' => $email,
                                        'website' => $website,
                                        'facebook' => $facebook,
                                        'x' => $x,
                                        'instagram' => $instagram,
                                        'youtube' => $youtube,
                                        'vimeo' => $vimeo
                                    );
                                }
                                
                                // Sort categories alphabetically by name
                                $category_names = array();
                                foreach ($businesses_by_category as $category_id => $category_data) {
                                    $category_names[$category_id] = $category_data['name'];
                                }
                                asort($category_names); // Sort alphabetically, case-insensitive
                                
                                // Display businesses grouped by category in alphabetical order
                                foreach ($category_names as $category_id => $name) {
                                    echo '<h2>' . esc_html($name) . '</h2>';
                                    echo '<div class="business-accordion">';
                                    
                                    foreach ($businesses_by_category[$category_id]['businesses'] as $business) {
                                        ?>
                                        <h4><?php echo esc_html($business['title']); ?><i class="fa fa-angle-down"></i></h4>

                                        <div>
                                            <div class="row">
                                                <div class="col-sm-6 business-col1">
                                                    <?php
                                                    if (!empty($business['address'])) {
                                                        echo esc_html($business['address']) . "</br>" . esc_html($business['city']) . ", " . esc_html($business['state']) . " " . esc_html($business['zip']);
                                                    }
                                                    if (!empty($business['phone'])) {
                                                        echo '</br><a href="tel:' . esc_attr($business['phone']) . '">' . esc_html($business['phone']) . '</a>';
                                                    }
                                                    if (!empty($business['email'])) {
                                                        echo '<div><a href="mailto:' . esc_attr($business['email']) . '">' . esc_html($business['email']) . '</a></div>';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-sm-6 business-col2">

                                                    <div class="fl-icon-group fl-icon-group-center">

                                                        <?php
                                                        if (!empty($business['facebook'])) { ?>
                                                            <span class="fl-icon">
                                                            <a href="<?php echo esc_url($business['facebook']); ?>" target="_blank">
                                                                    <img src="<?php echo plugin_dir_url(__FILE__) . 'images/icon-facebook.png' ?>"
                                                                         alt="Facebook">
                                                            </a>
                                                        </span>
                                                        <?php } ?>
                                                        <?php
                                                        if (!empty($business['x'])) { ?>
                                                            <span class="fl-icon">
                                                            <a href="<?php echo esc_url($business['x']); ?>" target="_blank">
                                                                    <img src="<?php echo plugin_dir_url(__FILE__) . 'images/icon-x.png' ?>"
                                                                         alt="X">
                                                            </a>
                                                        </span>
                                                        <?php } ?>
                                                        <?php
                                                        if (!empty($business['instagram'])) { ?>
                                                            <span class="fl-icon">
                                                            <a href="<?php echo esc_url($business['instagram']); ?>" target="_blank">
                                                                    <img src="<?php echo plugin_dir_url(__FILE__) . 'images/icon-instagram.png' ?>"
                                                                         alt="Instagram">
                                                            </a>
                                                        </span>
                                                        <?php } ?>
                                                        <?php
                                                        if (!empty($business['youtube'])) { ?>
                                                            <span class="fl-icon">
                                                            <a href="<?php echo esc_url($business['youtube']); ?>" target="_blank">
                                                                    <img src="<?php echo plugin_dir_url(__FILE__) . 'images/icon-youtube.png' ?>"
                                                                         alt="YouTube">
                                                            </a>
                                                        </span>
                                                        <?php } ?>
                                                        <?php
                                                        if (!empty($business['vimeo'])) { ?>
                                                            <span class="fl-icon">
                                                            <a href="<?php echo esc_url($business['vimeo']); ?>" target="_blank">
                                                                    <img src="<?php echo plugin_dir_url(__FILE__) . 'images/icon-vimeo.png' ?>"
                                                                         alt="Vimeo">
                                                            </a>
                                                        </span>
                                                        <?php } ?>
                                                        <?php
                                                        if (!empty($business['address'])) { ?>
                                                            <span class="fl-icon">
                                                            <a href="https://www.google.com/maps/place/<?php echo urlencode($business['address'] . ' ' . $business['city'] . ' ' . $business['state'] . ' ' . $business['zip']) ?>"
                                                               target="_blank">
                                                                    <img src="<?php echo plugin_dir_url(__FILE__) . 'images/icon-map.png' ?>"
                                                                         alt="Map">
                                                            </a>
                                                        </span>
                                                        <?php } ?>

                                                    </div>
                                                    <?php
                                                    if (!empty($business['website'])) {
                                                        echo '<div><a href="' . esc_url($business['website']) . '" target="_blank" class="business-website">view our website</a></div>';
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                                if (!empty($business['details'])) {
                                                    echo '<div class="col-sm-12" style="text-align: center;"><h4 style="text-decoration: underline;" align="center">Business Information</h4>' . wpautop($business['details']) . '</div>';
                                                }
                                                ?>
                                            </div>
                                            <?php if ($allow_public_submissions) { ?>
                                            <div class="business-edit"><a
                                                        href="<?php echo site_url(); ?>/business-directory-update?cid=<?php echo $business['id']; ?>">update
                                                    this information</a></div>
                                            <?php } ?>
                                        </div>
                                        <?php
                                    }
                                    
                                    echo '</div>';
                                }
                            } else {
                                // no posts found
                                //echo 'no';
                            }

                            // Restore original Post Data
                            wp_reset_postdata();
                            ?>

                        </div>

                    </div>


                </article>


            </div>


            <div class="fl-sidebar fl-sidebar-right fl-sidebar-display-always col-md-3" itemscope="itemscope"
                 itemtype="http://schema.org/WPSideBar">
                <aside id="webads_displayads_widget-2" class="fl-widget widget_webads_displayads_widget">

                    <div id="nonFeaturedWrapper">
                    </div>





                </aside>
            </div>
            <?php //FLTheme::sidebar('right'); ?>

        </div>
    </div>

<?php get_footer(); ?>