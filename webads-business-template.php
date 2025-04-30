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

                loadFeatured();
                loadNonFeatured();
            });

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


                            echo wpautop($general_info);
                            ?>

                            <div id="featuredWrapper">
                            </div>


                        </div>


                        <div id="business-sponsor-info">
                            <?php echo wpautop($sponsor_info); ?>
                        </div>
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
                        <div>

                            <?php

                            $c_city = '';

                            // WP_Query arguments
                            $args = array(
                                'post_type' => array('business'),
                                'post_status' => array('publish'),
                                'nopaging' => true,
                                'order' => 'ASC',
                                'orderby' => 'meta_value title',
                                'meta_key' => 'business_city',
                            );

                            // The Query
                            $businesses = new WP_Query($args);

                            // The Loop
                            if ($businesses->have_posts()) {
                                while ($businesses->have_posts()) {
                                    $businesses->the_post();
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
                                    $details = get_post_meta(get_the_id(), 'business_details', true);

                                    if ($city !== $c_city) {
                                        echo '</div><h2>' . $city . '</h2><div class="business-accordion">';
                                    }
                                    $c_city = $city;
                                    ?>

                                    <h4><?php the_title(); ?><i class="fa fa-angle-down"></i>
                                    </h4>

                                    <div>
                                        <div class="row">
                                            <div class="col-sm-6 business-col1">
                                                <?php
                                                if (!empty($address)) {
                                                    echo $address . "</br>" . $city . ", " . $state . " " . $zip;
                                                }
                                                if (!empty($phone)) {
                                                    echo '</br><a href="tel:' . $phone . '">' . $phone . '</a>';
                                                }
                                                if (!empty($email)) {
                                                    echo '<div><a href="mailto:' . $email . '">' . $email . '</a></div>';
                                                }


                                                ?>
                                            </div>
                                            <div class="col-sm-6 business-col2">

                                                <div class="fl-icon-group fl-icon-group-center">

                                                    <?php
                                                    if (!empty($facebook)) { ?>
                                                        <span class="fl-icon">
                                                        <a href="<?php echo $facebook ?>" target="_blank">
                                                                <img src="<?php echo plugin_dir_url(__FILE__) . 'images/icon-facebook.png' ?>"
                                                                     alt="Facebook">
                                                        </a>
                                                    </span>
                                                    <?php } ?>
                                                    <?php
                                                    if (!empty($x)) { ?>
                                                        <span class="fl-icon">
                                                        <a href="<?php echo $x ?>" target="_blank">
                                                                <img src="<?php echo plugin_dir_url(__FILE__) . 'images/icon-x.png' ?>"
                                                                     alt="X">
                                                        </a>
                                                    </span>
                                                    <?php } ?>
                                                    <?php
                                                    if (!empty($instagram)) { ?>
                                                        <span class="fl-icon">
                                                        <a href="<?php echo $instagram ?>" target="_blank">
                                                                <img src="<?php echo plugin_dir_url(__FILE__) . 'images/icon-instagram.png' ?>"
                                                                     alt="Instagram">
                                                        </a>
                                                    </span>
                                                    <?php } ?>
                                                    <?php
                                                    if (!empty($youtube)) { ?>
                                                        <span class="fl-icon">
                                                        <a href="<?php echo $youtube ?>" target="_blank">
                                                                <img src="<?php echo plugin_dir_url(__FILE__) . 'images/icon-youtube.png' ?>"
                                                                     alt="YouTube">
                                                        </a>
                                                    </span>
                                                    <?php } ?>
                                                    <?php
                                                    if (!empty($vimeo)) { ?>
                                                        <span class="fl-icon">
                                                        <a href="<?php echo $vimeo ?>" target="_blank">
                                                                <img src="<?php echo plugin_dir_url(__FILE__) . 'images/icon-vimeo.png' ?>"
                                                                     alt="Vimeo">
                                                        </a>
                                                    </span>
                                                    <?php } ?>
                                                    <?php
                                                    if (!empty($address)) { ?>
                                                        <span class="fl-icon">
                                                        <a href="https://www.google.com/maps/place/<?php echo urlencode($address . ' ' . $city . ' ' . $state . ' ' . $zip) ?>"
                                                           target="_blank">
                                                                <img src="<?php echo plugin_dir_url(__FILE__) . 'images/icon-map.png' ?>"
                                                                     alt="Map">
                                                        </a>
                                                    </span>
                                                    <?php } ?>

                                                </div>
                                                <?php

                                                if (!empty($website)) {
                                                    echo '<div><a href="' . $website . '" target="_blank" class="business-website">view our website</a></div>';
                                                }
                                                ?>
                                            </div>
                                            <?php
                                            if (!empty($details)) {
                                                echo '<div class="col-sm-12" style="text-align: center;"><h4 style="text-decoration: underline;" align="center">Details</h4>' . wpautop($details) . '</div>';
                                            }
                                            ?>
                                        </div>
                                        <div class="business-edit"><a
                                                    href="<?php echo site_url(); ?>/business-directory-update?cid=<?php echo get_the_id() ?>">update
                                                this information</a></div>
                                    </div>


                                    <?php
                                    //echo 'yes';
                                    // do something
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