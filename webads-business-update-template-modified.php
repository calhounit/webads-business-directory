<?php

/*
Template Name: Sidebar
*/

get_header();

?>

    <div class="container">
        <div class="row">

            <?php FLTheme::sidebar('left'); ?>


            <div class="fl-content <?php FLTheme::content_class(); ?>">
                <article class="fl-post post--999 page type-page status-static hentry" id="fl-post--999"
                         itemscope="itemscope" itemtype="http://schema.org/CreativeWork">

                    <header class="fl-post-header">
                        <h1 class="fl-post-title" itemprop="headline">
                            <?php
                            if ($_GET['cid'] == 'add') {
                                echo 'Submit A New Business';
                            } else {
                                echo 'Submit Business Update';
                            }

                            ?>
                        </h1>
                    </header><!-- .fl-post-header -->

                    <div class="fl-post-content clearfix" itemprop="text">


                        <?php

                        if (isset($_POST['business_nonce_field'])) {
                            //process form post
                        if (!isset($_POST['business_nonce_field']) || !wp_verify_nonce($_POST['business_nonce_field'], 'update_business')) {

                            print 'Sorry, your nonce did not verify.';
                            exit;

                        } else {
                            //verify recaptcha with google
                            $ch = curl_init();

                            curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                                'secret' => '6LdAtHYUAAAAAO6VsdJM4xDbdAdxx56J5bLfYcq6',
                                'response' => $_POST['g-recaptcha-response'],
                            ]));

                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                            $data = curl_exec($ch);

                            curl_close($ch);

                            $response = @json_decode($data);

                        if ($response && $response->success) {
                            // validation succeeded, user input is correct
                            // process form data
                            $parentid = $_POST['field_parentid'];
                            $submitname = $_POST['field_submitname'];
                            $submitemail = $_POST['field_submitemail'];
                            $title = $_POST['field_title'];
                            $category = isset($_POST['field_category']) ? $_POST['field_category'] : '';
                            $address = $_POST['field_address'];
                            $city = $_POST['field_city'];
                            $state = $_POST['field_state'];
                            $zip = $_POST['field_zip'];
                            $phone = $_POST['field_phone'];
                            $email = $_POST['field_email'];
                            $website = $_POST['field_website'];
                            $facebook = $_POST['field_facebook'];
                            $x = $_POST['field_x'];
                            $instagram = $_POST['field_instagram'];
                            $youtube = $_POST['field_youtube'];
                            $vimeo = $_POST['field_vimeo'];
                            $details = $_POST['field_details'];

                            $author = get_user_by('login', 'superadmin');

                            $args = array(
                                'post_author' => $author->ID,
                                'post_status' => 'pending',
                                'post_title' => $title,
                                'post_type' => 'business'
                            );

                            /*
                             * insert the post by wp_insert_post() function
                             */
                            $post_id = wp_insert_post($args);

                            // custom fields
                            add_post_meta($post_id, 'business_parentid', $parentid);
                            add_post_meta($post_id, 'business_submitname', $submitname);
                            add_post_meta($post_id, 'business_submitemail', $submitemail);
                            add_post_meta($post_id, 'business_address', $address);
                            add_post_meta($post_id, 'business_city', $city);
                            add_post_meta($post_id, 'business_state', $state);
                            add_post_meta($post_id, 'business_zip', $zip);
                            add_post_meta($post_id, 'business_phone', $phone);
                            add_post_meta($post_id, 'business_email', $email);
                            add_post_meta($post_id, 'business_website', $website);
                            add_post_meta($post_id, 'business_facebook', $facebook);
                            add_post_meta($post_id, 'business_x', $x);
                            add_post_meta($post_id, 'business_instagram', $instagram);
                            add_post_meta($post_id, 'business_youtube', $youtube);
                            add_post_meta($post_id, 'business_vimeo', $vimeo);
                            add_post_meta($post_id, 'business_details', $details);
                            
                            // Set the business category
                            if (!empty($category)) {
                                wp_set_object_terms($post_id, intval($category), 'business_category');
                            } else {
                                // Default to "Uncategorized" if no category is selected
                                $uncategorized = get_term_by('slug', 'uncategorized', 'business_category');
                                if ($uncategorized) {
                                    wp_set_object_terms($post_id, $uncategorized->term_id, 'business_category');
                                }
                            }

                            $options = get_option('webads_business');
                            $submission_email = $options['submission_email'];
                            $headers = array('From: Business Directory <wordpress@iadsnetwork.com>', 'Content-Type: text/html; charset=UTF-8');
                            $message = '<p>You have received a submission to the business directory for ' . get_bloginfo('name') . '. You may login and review the submission at the following url.</p><p>' . get_admin_url() . '</p>';

                            wp_mail($submission_email, 'New Submission', $message, $headers);

                            ?>
                            <div class="frm_forms with_frm_style frm_style_formidable-style" id="frm_form_9_container">
                                <div class="frm_message"><p>Your responses were successfully submitted. Thank you!&nbsp;&nbsp;&nbsp;<a
                                                href="<?php echo get_site_url(); ?>/business-directory">Return to business directory</a></p>
                                </div>
                            </div>
                        <?php
                        }
                        else {
                            // response is invalid for some reason
                            // you can find more in $data->{"error-codes"}
                            $redirect_to = $_POST['redirect_to'];
                            wp_redirect($redirect_to);
                        }

                        }
                        ?>

                        <?php
                        } else {
                        //show form
                        if (isset($_GET['cid'])) {
                            //load stuff
                            $postid = $_GET['cid'];
                            if ($postid != 'add' && is_numeric($postid)) {
                                $post = get_post($postid);
                                $title = $post->post_title;
                                $address = get_post_meta($postid, 'business_address', true);
                                $city = get_post_meta($postid, 'business_city', true);
                                $state = get_post_meta($postid, 'business_state', true);
                                $zip = get_post_meta($postid, 'business_zip', true);
                                $phone = get_post_meta($postid, 'business_phone', true);
                                $email = get_post_meta($postid, 'business_email', true);
                                $website = get_post_meta($postid, 'business_website', true);
                                $facebook = get_post_meta($postid, 'business_facebook', true);
                                $x = get_post_meta($postid, 'business_x', true);
                                $instagram = get_post_meta($postid, 'business_instagram', true);
                                $youtube = get_post_meta($postid, 'business_youtube', true);
                                $vimeo = get_post_meta($postid, 'business_vimeo', true);
                                $details = get_post_meta($postid, 'business_details', true);
                                
                                // Get the current category
                                $current_terms = wp_get_object_terms($postid, 'business_category', array('fields' => 'ids'));
                                $current_category = !empty($current_terms) ? $current_terms[0] : '';
                            } else {
                                // Default values for new business
                                $title = '';
                                $address = '';
                                $city = '';
                                $state = 'ZZ';
                                $zip = '';
                                $phone = '';
                                $email = '';
                                $website = '';
                                $facebook = '';
                                $x = '';
                                $instagram = '';
                                $youtube = '';
                                $vimeo = '';
                                $details = '';
                                
                                // Default to "Uncategorized" for new businesses
                                $uncategorized = get_term_by('slug', 'uncategorized', 'business_category');
                                $current_category = $uncategorized ? $uncategorized->term_id : '';
                            }
                        }
                        ?>


                            <script>
                                function submitLoginForm() {
                                    //console.log('test');
                                    var form = document.getElementById("form_business_update");
                                    if (validate_form(form)) {
                                        //alert('yes');
                                        form.submit();
                                    } else {
                                        //console.log('nope');
                                        //alert('Please complete the required fields');
                                        grecaptcha.reset();
                                    }
                                }

                                // Form validation code will come here.
                                function validate_form(form) {
                                    var result = true;

                                    if( form.field_submitname.value == "" ) {
                                        $("#frm_submitname_container").addClass("frm_blank_field");
                                        result = false;
                                    } else {
                                        $("#frm_submitname_container").removeClass("frm_blank_field");
                                    }

                                    if( form.field_submitemail.value.indexOf("@") === -1 || form.field_submitemail.value.indexOf(".") === -1 ) {
                                        //alert(form.field_submitemail.value.indexOf("@") );
                                        $("#frm_submitemail_container").addClass("frm_blank_field");
                                        result = false;
                                    } else {
                                        $("#frm_submitemail_container").removeClass("frm_blank_field");
                                    }

                                    if( form.field_title.value == "" ) {
                                        $("#frm_title_container").addClass("frm_blank_field");
                                        result = false;
                                    } else {
                                        $("#frm_title_container").removeClass("frm_blank_field");
                                    }

                                    if( form.field_city.value == "" ) {
                                        $("#frm_city_container").addClass("frm_blank_field");
                                        result = false;
                                    } else {
                                        $("#frm_city_container").removeClass("frm_blank_field");
                                    }

                                    if( form.field_state.value == "ZZ" ) {
                                        $("#frm_state_container").addClass("frm_blank_field");
                                        result = false;
                                    } else {
                                        $("#frm_state_container").removeClass("frm_blank_field");
                                    }

                                    if (result) {
                                        $(".frm_error_style").hide();
                                    } else {
                                        $(".frm_error_style").show();
                                        $('html, body').animate({
                                            scrollTop: $("#form_business_update").offset().top -50
                                        }, 1000);
                                    }

                                    return( result );
                                }
                            </script>
                            <p>
                                If you would like to submit a new business or update an existing one, please fill out the
                                form below and be sure to include your name and email in the first two fields. We will
                                review your request in a timely manner and thank you for helping us make the business
                                directory the best it can be.
                            </p>
                            <div class="frm_forms  with_frm_style frm_style_formidable-style" id="frm_form_9_container">
                                <form enctype="multipart/form-data" method="post"
                                      class="frm-show-form  frm_pro_form  frm-admin-viewing " id="form_business_update">
                                    <div class="frm_form_fields ">
                                        <fieldset>

                                            <div class="frm_fields_container">
                                                <input type="hidden" name="field_parentid"
                                                       value="<?php echo $postid ?>">
                                                <?php wp_nonce_field('update_business', 'business_nonce_field'); ?>
                                                <div class="frm_error_style" style="display: none;">
                                                    There was a problem with your submission. Errors are marked below.</div>
                                                <h4 class="fl-widget-title" style="margin-bottom: 20px;">Your
                                                    Information</h4>
                                                <div id="frm_submitname_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_submitname" id="field_submitname_label"
                                                           class="frm_primary_label">Your Name
                                                        <span class="frm_required">*</span>
                                                    </label>
                                                    <input type="text" id="field_submitname" name="field_submitname"
                                                           value="" data-reqmsg="This field cannot be blank."
                                                           aria-required="true"
                                                           data-invmsg="This field cannot be blank">
                                                </div>
                                                <div id="frm_submitemail_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_submitemail" id="field_submitemail_label"
                                                           class="frm_primary_label">Your Email
                                                        <span class="frm_required">*</span>
                                                    </label>
                                                    <input type="text" id="field_submitemail" name="field_submitemail"
                                                           value="" data-reqmsg="This field cannot be blank."
                                                           aria-required="true"
                                                           data-invmsg="This field cannot be blank">
                                                </div>
                                                <h4 class="fl-widget-title" style="margin-bottom: 20px;">Business
                                                    Information</h4>
                                                <div id="frm_title_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_title" id="field_title_label"
                                                           class="frm_primary_label">Business Name
                                                        <span class="frm_required">*</span>
                                                    </label>
                                                    <input type="text" id="field_title" name="field_title"
                                                           value="<?php echo $title ?>"
                                                           data-reqmsg="This field cannot be blank."
                                                           aria-required="true"
                                                           data-invmsg="This field cannot be blank">
                                                </div>
                                                
                                                <!-- Business Category Field -->
                                                <div id="frm_category_container"
                                                     class="frm_form_field form-field frm_required_field frm_top_container frm_full">
                                                    <label for="field_category" id="field_category_label"
                                                           class="frm_primary_label">Business Category
                                                        <span class="frm_required">*</span>
                                                    </label>
                                                    <select id="field_category" name="field_category" aria-required="true">
                                                        <?php
                                                        // Get all business categories
                                                        $categories = get_terms(array(
                                                            'taxonomy' => 'business_category',
                                                            'hide_empty' => false,
                                                        ));
                                                        
                                                        if (!empty($categories) && !is_wp_error($categories)) {
                                                            foreach ($categories as $category) {
                                                                $selected = ($current_category == $category->term_id) ? ' selected="selected"' : '';
                                                                echo '<option value="' . $category->term_id . '"' . $selected . '>' . $category->name . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                
                                                <div id="frm_denomination_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_address" id="field_address_label"
                                                           class="frm_primary_label">Address</label>
                                                    <input type="text" id="field_address" name="field_address"
                                                           value="<?php echo $address ?>">
                                                </div>
                                                <div id="frm_city_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_city" id="field_city_label"
                                                           class="frm_primary_label">City
                                                    <span class="frm_required">*</span>
                                                    </label>
                                                    <input type="text" id="field_city" name="field_city"
                                                           value="<?php echo $city ?>"
                                                           data-reqmsg="This field cannot be blank."
                                                           aria-required="true"
                                                           data-invmsg="This field cannot be blank">
                                                </div>
