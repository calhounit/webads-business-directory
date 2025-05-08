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
                                // Default to "Uncategorized" for new businesses
$uncategorized = get_term_by('slug', 'uncategorized', 'business_category');
$current_category = $uncategorized ? $uncategorized->term_id : '';
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
                            $title = $_POST['field_title'];
                            $parentid = $_POST['field_parentid'];
                            $submitname = $_POST['field_submitname'];
                            $submitemail = $_POST['field_submitemail'];
                            $category = $_POST['field_category'];
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
                                                <div id="frm_category_container" class="frm_form_field form-field frm_required_field frm_top_container frm_full">
                                                    <label for="field_category" id="field_category_label" class="frm_primary_label">Business Category
                                                        <span class="frm_required">*</span>
                                                    </label>
                                                    <select id="field_category" name="field_category" aria-required="true">
                                                        <?php
                                                        // Get all business categories
                                                        $categories = get_terms(array(
                                                            'taxonomy' => 'business_category',
                                                            'hide_empty' => false,
                                                        ));
                                                        
                                                        // Make sure we have the uncategorized term ID for new submissions
                                                        if ($_GET['cid'] == 'add' && empty($current_category)) {
                                                            $uncategorized = get_term_by('slug', 'uncategorized', 'business_category');
                                                            $current_category = $uncategorized ? $uncategorized->term_id : '';
                                                        }
                                                        
                                                        if (!empty($categories) && !is_wp_error($categories)) {
                                                            // First, add Uncategorized at the top of the list
                                                            foreach ($categories as $category) {
                                                                if ($category->slug === 'uncategorized') {
                                                                    $selected = ($current_category == $category->term_id) ? ' selected="selected"' : '';
                                                                    echo '<option value="' . $category->term_id . '"' . $selected . '>' . $category->name . '</option>';
                                                                    break;
                                                                }
                                                            }
                                                            
                                                            // Then add all other categories
                                                            foreach ($categories as $category) {
                                                                if ($category->slug !== 'uncategorized') {
                                                                    $selected = ($current_category == $category->term_id) ? ' selected="selected"' : '';
                                                                    echo '<option value="' . $category->term_id . '"' . $selected . '>' . $category->name . '</option>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div id="frm_address_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_address" id="field_address_label"
                                                           class="frm_primary_label">Address
                                                    <span class="frm_required">*</span>
                                                    </label>
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
                                                
                                                <div id="frm_state_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_state" id="field_state_label"
                                                           class="frm_primary_label">State
                                                        <span class="frm_required">*</span></label>
                                                    <select id="field_state" name="field_state">
                                                        <option value="ZZ"<?= $state == 'ZZ' ? ' selected="selected"' : ''; ?>>
                                                            --SELECT--
                                                        </option>
                                                        <option value="AL"<?= $state == 'AL' ? ' selected="selected"' : ''; ?>>
                                                            Alabama
                                                        </option>
                                                        <option value="AK"<?= $state == 'AK' ? ' selected="selected"' : ''; ?>>
                                                            Alaska
                                                        </option>
                                                        <option value="AZ"<?= $state == 'AZ' ? ' selected="selected"' : ''; ?>>
                                                            Arizona
                                                        </option>
                                                        <option value="AR"<?= $state == 'AR' ? ' selected="selected"' : ''; ?>>
                                                            Arkansas
                                                        </option>
                                                        <option value="CA"<?= $state == 'CA' ? ' selected="selected"' : ''; ?>>
                                                            California
                                                        </option>
                                                        <option value="CO"<?= $state == 'CO' ? ' selected="selected"' : ''; ?>>
                                                            Colorado
                                                        </option>
                                                        <option value="CT"<?= $state == 'CT' ? ' selected="selected"' : ''; ?>>
                                                            Connecticut
                                                        </option>
                                                        <option value="DE"<?= $state == 'DE' ? ' selected="selected"' : ''; ?>>
                                                            Delaware
                                                        </option>
                                                        <option value="DC"<?= $state == 'DC' ? ' selected="selected"' : ''; ?>>
                                                            District Of Columbia
                                                        </option>
                                                        <option value="FL"<?= $state == 'FL' ? ' selected="selected"' : ''; ?>>
                                                            Florida
                                                        </option>
                                                        <option value="GA"<?= $state == 'GA' ? ' selected="selected"' : ''; ?>>
                                                            Georgia
                                                        </option>
                                                        <option value="HI"<?= $state == 'HI' ? ' selected="selected"' : ''; ?>>
                                                            Hawaii
                                                        </option>
                                                        <option value="ID"<?= $state == 'ID' ? ' selected="selected"' : ''; ?>>
                                                            Idaho
                                                        </option>
                                                        <option value="IL"<?= $state == 'IL' ? ' selected="selected"' : ''; ?>>
                                                            Illinois
                                                        </option>
                                                        <option value="IN"<?= $state == 'IN' ? ' selected="selected"' : ''; ?>>
                                                            Indiana
                                                        </option>
                                                        <option value="IA"<?= $state == 'IA' ? ' selected="selected"' : ''; ?>>
                                                            Iowa
                                                        </option>
                                                        <option value="KS"<?= $state == 'KS' ? ' selected="selected"' : ''; ?>>
                                                            Kansas
                                                        </option>
                                                        <option value="KY"<?= $state == 'KY' ? ' selected="selected"' : ''; ?>>
                                                            Kentucky
                                                        </option>
                                                        <option value="LA"<?= $state == 'LA' ? ' selected="selected"' : ''; ?>>
                                                            Louisiana
                                                        </option>
                                                        <option value="ME"<?= $state == 'ME' ? ' selected="selected"' : ''; ?>>
                                                            Maine
                                                        </option>
                                                        <option value="MD"<?= $state == 'MD' ? ' selected="selected"' : ''; ?>>
                                                            Maryland
                                                        </option>
                                                        <option value="MA"<?= $state == 'MA' ? ' selected="selected"' : ''; ?>>
                                                            Massachusetts
                                                        </option>
                                                        <option value="MI"<?= $state == 'MI' ? ' selected="selected"' : ''; ?>>
                                                            Michigan
                                                        </option>
                                                        <option value="MN"<?= $state == 'MN' ? ' selected="selected"' : ''; ?>>
                                                            Minnesota
                                                        </option>
                                                        <option value="MS"<?= $state == 'MS' ? ' selected="selected"' : ''; ?>>
                                                            Mississippi
                                                        </option>
                                                        <option value="MO"<?= $state == 'MO' ? ' selected="selected"' : ''; ?>>
                                                            Missouri
                                                        </option>
                                                        <option value="MT"<?= $state == 'MT' ? ' selected="selected"' : ''; ?>>
                                                            Montana
                                                        </option>
                                                        <option value="NE"<?= $state == 'NE' ? ' selected="selected"' : ''; ?>>
                                                            Nebraska
                                                        </option>
                                                        <option value="NV"<?= $state == 'NV' ? ' selected="selected"' : ''; ?>>
                                                            Nevada
                                                        </option>
                                                        <option value="NH"<?= $state == 'NH' ? ' selected="selected"' : ''; ?>>
                                                            New Hampshire
                                                        </option>
                                                        <option value="NJ"<?= $state == 'NJ' ? ' selected="selected"' : ''; ?>>
                                                            New Jersey
                                                        </option>
                                                        <option value="NM"<?= $state == 'NM' ? ' selected="selected"' : ''; ?>>
                                                            New Mexico
                                                        </option>
                                                        <option value="NY"<?= $state == 'NY' ? ' selected="selected"' : ''; ?>>
                                                            New York
                                                        </option>
                                                        <option value="NC"<?= $state == 'NC' ? ' selected="selected"' : ''; ?>>
                                                            North Carolina
                                                        </option>
                                                        <option value="ND"<?= $state == 'ND' ? ' selected="selected"' : ''; ?>>
                                                            North Dakota
                                                        </option>
                                                        <option value="OH"<?= $state == 'OH' ? ' selected="selected"' : ''; ?>>
                                                            Ohio
                                                        </option>
                                                        <option value="OK"<?= $state == 'OK' ? ' selected="selected"' : ''; ?>>
                                                            Oklahoma
                                                        </option>
                                                        <option value="OR"<?= $state == 'OR' ? ' selected="selected"' : ''; ?>>
                                                            Oregon
                                                        </option>
                                                        <option value="PA"<?= $state == 'PA' ? ' selected="selected"' : ''; ?>>
                                                            Pennsylvania
                                                        </option>
                                                        <option value="RI"<?= $state == 'RI' ? ' selected="selected"' : ''; ?>>
                                                            Rhode Island
                                                        </option>
                                                        <option value="SC"<?= $state == 'SC' ? ' selected="selected"' : ''; ?>>
                                                            South Carolina
                                                        </option>
                                                        <option value="SD"<?= $state == 'SD' ? ' selected="selected"' : ''; ?>>
                                                            South Dakota
                                                        </option>
                                                        <option value="TN"<?= $state == 'TN' ? ' selected="selected"' : ''; ?>>
                                                            Tennessee
                                                        </option>
                                                        <option value="TX"<?= $state == 'TX' ? ' selected="selected"' : ''; ?>>
                                                            Texas
                                                        </option>
                                                        <option value="UT"<?= $state == 'UT' ? ' selected="selected"' : ''; ?>>
                                                            Utah
                                                        </option>
                                                        <option value="VT"<?= $state == 'VT' ? ' selected="selected"' : ''; ?>>
                                                            Vermont
                                                        </option>
                                                        <option value="VA"<?= $state == 'VA' ? ' selected="selected"' : ''; ?>>
                                                            Virginia
                                                        </option>
                                                        <option value="WA"<?= $state == 'WA' ? ' selected="selected"' : ''; ?>>
                                                            Washington
                                                        </option>
                                                        <option value="WV"<?= $state == 'WV' ? ' selected="selected"' : ''; ?>>
                                                            West Virginia
                                                        </option>
                                                        <option value="WI"<?= $state == 'WI' ? ' selected="selected"' : ''; ?>>
                                                            Wisconsin
                                                        </option>
                                                        <option value="WY"<?= $state == 'WY' ? ' selected="selected"' : ''; ?>>
                                                            Wyoming
                                                        </option>
                                                    </select>
                                                </div>
                                                <div id="frm_zip_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_zip" id="field_zip_label"
                                                           class="frm_primary_label">Zip</label>
                                                    <input type="text" id="field_zip" name="field_zip"
                                                           value="<?php echo $zip ?>">
                                                </div>
                                                <div id="frm_phone_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_phone" id="field_phone_label"
                                                           class="frm_primary_label">Phone</label>
                                                    <input type="text" id="field_phone" name="field_phone"
                                                           value="<?php echo $phone ?>">
                                                </div>
                                                <div id="frm_email_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_email" id="field_email_label"
                                                           class="frm_primary_label">Email</label>
                                                    <input type="text" id="field_email" name="field_email"
                                                           value="<?php echo $email ?>">
                                                </div>
                                                <div id="frm_details_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_details" id="field_details_label"
                                                           class="frm_primary_label">Details</label>
                                                    <textarea id="field_details" name="field_details" rows="6"><?php echo $details ?></textarea>
                                                </div>
                                                <div id="messages" class="business-notice business-notice-error">
                                                    <p>Please include http:// or https:// for all URLs</p>
                                                </div>
                                                <div id="frm_website_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_website" id="field_website_label"
                                                           class="frm_primary_label">Website URL</label>
                                                    <input type="text" id="field_website" name="field_website"
                                                           value="<?php echo $website ?>">
                                                </div>
                                                <div id="frm_facebook_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_facebook" id="field_facebook_label"
                                                           class="frm_primary_label">Facebook Page URL</label>
                                                    <input type="text" id="field_facebook" name="field_facebook"
                                                           value="<?php echo $facebook ?>">
                                                </div>
                                                <div id="frm_x_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_x" id="field_x_label"
                                                           class="frm_primary_label">X URL</label>
                                                    <input type="text" id="field_x" name="field_x"
                                                           value="<?php echo $x ?>">
                                                </div>
                                                <div id="frm_instagram_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_instagram" id="field_instagram_label"
                                                           class="frm_primary_label">Instagram URL</label>
                                                    <input type="text" id="field_instagram" name="field_instagram"
                                                           value="<?php echo $instagram ?>">
                                                </div>
                                                <div id="frm_youtube_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_youtube" id="field_youtube_label"
                                                           class="frm_primary_label">YouTube URL</label>
                                                    <input type="text" id="field_youtube" name="field_youtube"
                                                           value="<?php echo $youtube ?>">
                                                </div>
                                                <div id="frm_vimeo_container"
                                                     class="frm_form_field form-field  frm_required_field frm_top_container frm_full">
                                                    <label for="field_vimeo" id="field_vimeo_label"
                                                           class="frm_primary_label">Vimeo URL</label>
                                                    <input type="text" id="field_vimeo" name="field_vimeo"
                                                           value="<?php echo $vimeo ?>">
                                                </div>


                                                <input name="redirect_to" value="<?php echo get_permalink() ?>"
                                                       type="hidden">
                                                <div class="frm_submit">
                                                    <button class="g-recaptcha"
                                                            data-sitekey="6LdAtHYUAAAAABwhmmYpXQl8687P3FvLAlSVKLwa"
                                                            data-callback='submitLoginForm' id="webads_login_submit">
                                                        Submit
                                                    </button>

                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </form>
                            </div>


                        <?php } ?>


                    </div>


                </article>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <?php endwhile; endif; ?>

            </div>

            <?php FLTheme::sidebar('right'); ?>

        </div>
    </div>

<?php get_footer(); ?>