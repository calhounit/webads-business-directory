<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.iadsnetwork.com
 * @since      1.0.0
 *
 * @package    Webads_Business_Directory
 * @subpackage Webads_Business_Directory/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Webads_Business_Directory
 * @subpackage Webads_Business_Directory/admin
 * @author     John Calhoun <john@iadsnetwork.com>
 */
class Webads_Business_Directory_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Webads_Business_Directory_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Webads_Business_Directory_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/webads-business-directory-admin.css', array(), '1.0.2', 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Webads_Business_Directory_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Webads_Business_Directory_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/webads-business-directory-admin.js', array('jquery'), $this->version, false);

    }

}


add_action('add_meta_boxes', 'business_meta_boxes');
function business_meta_boxes()
{
    //$options = get_option('webads_admin');
    //$isenablepwp = $options['isenablepwp'];

    //if ($isenablepwp == '1') {
    $args = array();

    add_meta_box(
        'business_metabox_id',
        'Additional Information',                   // Title
        'business_meta_callback_function',               // Callback function that renders the content of the meta box
        'business',                               // Admin page (or post type) to show the meta box on
        'normal',                               // Context where the box is shown on the page
        'high',                                 // Priority within that context
        $args                                   // Arguments to pass the callback function, if any
    );

    $args = array();

    add_meta_box(
        'business_sponsor_metabox_id',
        'Ad Setup',                   // Title
        'business_sponsor_meta_callback_function',               // Callback function that renders the content of the meta box
        'business_sponsor',                               // Admin page (or post type) to show the meta box on
        'normal',                               // Context where the box is shown on the page
        'high',                                 // Priority within that context
        $args                                   // Arguments to pass the callback function, if any
    );
    //}
}

function business_meta_callback_function($args)
{
    global $post;
    //$custom = get_post_custom($post->ID);
    //$enable_post_pwp = $custom["enable_post_pwp"][0];

    $websitelink = '&nbsp;&nbsp;&nbsp;<a id="business_website_link" href="' . esc_attr(get_post_meta(get_the_ID(), 'business_website', true)) . '" target="_blank">visit</a>';
    $facebooklink = '&nbsp;&nbsp;&nbsp;<a id="business_facebook_link" href="' . esc_attr(get_post_meta(get_the_ID(), 'business_facebook', true)) . '" target="_blank">visit</a>';
    $xlink = '&nbsp;&nbsp;&nbsp;<a id="business_x_link" href="' . esc_attr(get_post_meta(get_the_ID(), 'business_x', true)) . '" target="_blank">visit</a>';
    $instagramlink = '&nbsp;&nbsp;&nbsp;<a id="business_instagram_link" href="' . esc_attr(get_post_meta(get_the_ID(), 'business_instagram', true)) . '" target="_blank">visit</a>';
    $youtubelink = '&nbsp;&nbsp;&nbsp;<a id="business_youtube_link" href="' . esc_attr(get_post_meta(get_the_ID(), 'business_youtube', true)) . '" target="_blank">visit</a>';
    $vimeolink = '&nbsp;&nbsp;&nbsp;<a id="business_vimeo_link" href="' . esc_attr(get_post_meta(get_the_ID(), 'business_vimeo', true)) . '" target="_blank">visit</a>';
    $state = get_post_meta(get_the_ID(), 'business_state', true);
    $parentid = get_post_meta(get_the_ID(), 'business_parentid', true);
    $denomination = esc_attr(get_post_meta(get_the_ID(), 'business_denomination', true));
    $address = esc_attr(get_post_meta(get_the_ID(), 'business_address', true));
    $city = esc_attr(get_post_meta(get_the_ID(), 'business_city', true));
    $zip = esc_attr(get_post_meta(get_the_ID(), 'business_zip', true));
    $phone = esc_attr(get_post_meta(get_the_ID(), 'business_phone', true));
    $email = esc_attr(get_post_meta(get_the_ID(), 'business_email', true));
    $website = esc_attr(get_post_meta(get_the_ID(), 'business_website', true));
    $facebook = esc_attr(get_post_meta(get_the_ID(), 'business_facebook', true));
    $x = esc_attr(get_post_meta(get_the_ID(), 'business_x', true));
    $instagram = esc_attr(get_post_meta(get_the_ID(), 'business_instagram', true));
    $youtube = esc_attr(get_post_meta(get_the_ID(), 'business_youtube', true));
    $vimeo = esc_attr(get_post_meta(get_the_ID(), 'business_vimeo', true));
    $services = esc_attr(get_post_meta(get_the_ID(), 'business_services', true));


    //The markup for your meta box goes here

    //check pending
    if ($post->post_status == 'pending') {
        ?>
        <div id="messages" class="notice notice-error">
            <?php if ($parentid == 'add') {
                echo '<p>This is a submission of a new business. The submitter\'s name and email is also listed.</p>';
            } else {
                echo '<p>This is a pending update. The original information is
                shown below the updated information for each field. The submitter\'s name and email is also listed.</p>';
            }
            ?>


            <p>To approve the submission, click the "Publish" button on the right. If you do not approve,
                click the "Move to Trash" link on the right.</p></div>
        <div class="business-meta-div">

            <label for="business_submitname" class="business-meta-label">Submitter Name</label>
            <input id="business_submitname" type="text" class="widefat" name="business_denomination"
                   value="<?php echo esc_attr(get_post_meta(get_the_ID(), 'business_submitname', true)); ?>">
        </div>
        <div class="business-meta-div">
            <label for="business_submitemail" class="business-meta-label">Submitter Email</label>
            <input id="business_submitemail" type="text" class="widefat" name="business_denomination"
                   value="<?php echo esc_attr(get_post_meta(get_the_ID(), 'business_submitemail', true)); ?>">
        </div>
        <?php
    }
    ?>

    <script>
        document.getElementById("publish").onclick = function() {
            var form = document.getElementById("post");
            if (validate_form(form)) {
                form.submit();
            } else {
                return false;
            }
        }


        // Form validation code will come here.
        function validate_form(form) {
            var result = true;

            if( form.business_city.value == "" ) {
                //$("#frm_city_container").addClass("frm_blank_field");
                result = false;
            } else {
                //$("#frm_city_container").removeClass("frm_blank_field");
            }

            if( form.business_state.value == "ZZ" ) {
                //$("#frm_state_container").addClass("frm_blank_field");
                result = false;
            } else {
                //$("#frm_state_container").removeClass("frm_blank_field");
            }

            if (result) {
                //alert('yes');
                //$(".frm_error_style").hide();
            } else {
                //alert('no');
                jQuery(".frm_error_style").show();
                //$('html, body').animate({
                   // scrollTop: $("#form_business_update").offset().top -50
                //}, 1000);
            }

            return( result );
        }

    </script>

    <div id="messages" class="notice notice-error frm_error_style"  style="display: none;">
        <p>There was a problem with your submission. City and State fields are required.</p>
    </div>

    <div class="business-meta-div">
        <label for="business_denomination" class="business-meta-label">Denomination</label>
        <input id="business_denomination" type="text" class="widefat" name="business_denomination"
               value="<?php echo $denomination ?>">
        <?php if ($parentid !== '' && $parentid !== 'add') {
            $odenomination = get_post_meta($parentid, 'business_denomination', true);
            if ($odenomination !== $denomination) {
                if ($odenomination == '') {
                    $odenomination = 'blank';
                }
                echo '<span class="business-o-value">' . $odenomination . '</span>';
            }
        }
        ?>
    </div>
    <div class="business-meta-div">
        <label for="business_address" class="business-meta-label">Address</label>
        <input id="business_address" type="text" class="widefat" name="business_address"
               value="<?php echo $address; ?>">
        <?php if ($parentid !== '' && $parentid !== 'add') {
            $oaddress = get_post_meta($parentid, 'business_address', true);
            if ($oaddress !== $address) {
                if ($oaddress == '') {
                    $oaddress = 'blank';
                }
                echo '<span class="business-o-value">' . $oaddress . '</span>';
            }
        }
        ?>
    </div>
    <div class="business-meta-div">
        <label for="business_city" class="business-meta-label">City <span class="frm_required">*</span></label>
        <input id="business_city" type="text" class="widefat" name="business_city"
               value="<?php echo $city; ?>">
        <?php if ($parentid !== '' && $parentid !== 'add') {
            $ocity = get_post_meta($parentid, 'business_city', true);
            if ($ocity !== $city) {
                if ($ocity == '') {
                    $ocity = $parentid;
                }
                echo '<span class="business-o-value">' . $ocity . '</span>';
            }
        }
        ?>
    </div>
    <div class="business-meta-div">
        <label for="business_state" class="business-meta-label">State <span class="frm_required">*</span></label>
        <select id="business_state" name="business_state" class="widefat">
            <option value="ZZ"<?= $state == 'ZZ' ? ' selected="selected"' : ''; ?>>--SELECT--</option>
            <option value="AL"<?= $state == 'AL' ? ' selected="selected"' : ''; ?>>Alabama</option>
            <option value="AK"<?= $state == 'AK' ? ' selected="selected"' : ''; ?>>Alaska</option>
            <option value="AZ"<?= $state == 'AZ' ? ' selected="selected"' : ''; ?>>Arizona</option>
            <option value="AR"<?= $state == 'AR' ? ' selected="selected"' : ''; ?>>Arkansas</option>
            <option value="CA"<?= $state == 'CA' ? ' selected="selected"' : ''; ?>>California</option>
            <option value="CO"<?= $state == 'CO' ? ' selected="selected"' : ''; ?>>Colorado</option>
            <option value="CT"<?= $state == 'CT' ? ' selected="selected"' : ''; ?>>Connecticut</option>
            <option value="DE"<?= $state == 'DE' ? ' selected="selected"' : ''; ?>>Delaware</option>
            <option value="DC"<?= $state == 'DC' ? ' selected="selected"' : ''; ?>>District Of Columbia</option>
            <option value="FL"<?= $state == 'FL' ? ' selected="selected"' : ''; ?>>Florida</option>
            <option value="GA"<?= $state == 'GA' ? ' selected="selected"' : ''; ?>>Georgia</option>
            <option value="HI"<?= $state == 'HI' ? ' selected="selected"' : ''; ?>>Hawaii</option>
            <option value="ID"<?= $state == 'ID' ? ' selected="selected"' : ''; ?>>Idaho</option>
            <option value="IL"<?= $state == 'IL' ? ' selected="selected"' : ''; ?>>Illinois</option>
            <option value="IN"<?= $state == 'IN' ? ' selected="selected"' : ''; ?>>Indiana</option>
            <option value="IA"<?= $state == 'IA' ? ' selected="selected"' : ''; ?>>Iowa</option>
            <option value="KS"<?= $state == 'KS' ? ' selected="selected"' : ''; ?>>Kansas</option>
            <option value="KY"<?= $state == 'KY' ? ' selected="selected"' : ''; ?>>Kentucky</option>
            <option value="LA"<?= $state == 'LA' ? ' selected="selected"' : ''; ?>>Louisiana</option>
            <option value="ME"<?= $state == 'ME' ? ' selected="selected"' : ''; ?>>Maine</option>
            <option value="MD"<?= $state == 'MD' ? ' selected="selected"' : ''; ?>>Maryland</option>
            <option value="MA"<?= $state == 'MA' ? ' selected="selected"' : ''; ?>>Massachusetts</option>
            <option value="MI"<?= $state == 'MI' ? ' selected="selected"' : ''; ?>>Michigan</option>
            <option value="MN"<?= $state == 'MN' ? ' selected="selected"' : ''; ?>>Minnesota</option>
            <option value="MS"<?= $state == 'MS' ? ' selected="selected"' : ''; ?>>Mississippi</option>
            <option value="MO"<?= $state == 'MO' ? ' selected="selected"' : ''; ?>>Missouri</option>
            <option value="MT"<?= $state == 'MT' ? ' selected="selected"' : ''; ?>>Montana</option>
            <option value="NE"<?= $state == 'NE' ? ' selected="selected"' : ''; ?>>Nebraska</option>
            <option value="NV"<?= $state == 'NV' ? ' selected="selected"' : ''; ?>>Nevada</option>
            <option value="NH"<?= $state == 'NH' ? ' selected="selected"' : ''; ?>>New Hampshire</option>
            <option value="NJ"<?= $state == 'NJ' ? ' selected="selected"' : ''; ?>>New Jersey</option>
            <option value="NM"<?= $state == 'NM' ? ' selected="selected"' : ''; ?>>New Mexico</option>
            <option value="NY"<?= $state == 'NY' ? ' selected="selected"' : ''; ?>>New York</option>
            <option value="NC"<?= $state == 'NC' ? ' selected="selected"' : ''; ?>>North Carolina</option>
            <option value="ND"<?= $state == 'ND' ? ' selected="selected"' : ''; ?>>North Dakota</option>
            <option value="OH"<?= $state == 'OH' ? ' selected="selected"' : ''; ?>>Ohio</option>
            <option value="OK"<?= $state == 'OK' ? ' selected="selected"' : ''; ?>>Oklahoma</option>
            <option value="OR"<?= $state == 'OR' ? ' selected="selected"' : ''; ?>>Oregon</option>
            <option value="PA"<?= $state == 'PA' ? ' selected="selected"' : ''; ?>>Pennsylvania</option>
            <option value="RI"<?= $state == 'RI' ? ' selected="selected"' : ''; ?>>Rhode Island</option>
            <option value="SC"<?= $state == 'SC' ? ' selected="selected"' : ''; ?>>South Carolina</option>
            <option value="SD"<?= $state == 'SD' ? ' selected="selected"' : ''; ?>>South Dakota</option>
            <option value="TN"<?= $state == 'TN' ? ' selected="selected"' : ''; ?>>Tennessee</option>
            <option value="TX"<?= $state == 'TX' ? ' selected="selected"' : ''; ?>>Texas</option>
            <option value="UT"<?= $state == 'UT' ? ' selected="selected"' : ''; ?>>Utah</option>
            <option value="VT"<?= $state == 'VT' ? ' selected="selected"' : ''; ?>>Vermont</option>
            <option value="VA"<?= $state == 'VA' ? ' selected="selected"' : ''; ?>>Virginia</option>
            <option value="WA"<?= $state == 'WA' ? ' selected="selected"' : ''; ?>>Washington</option>
            <option value="WV"<?= $state == 'WV' ? ' selected="selected"' : ''; ?>>West Virginia</option>
            <option value="WI"<?= $state == 'WI' ? ' selected="selected"' : ''; ?>>Wisconsin</option>
            <option value="WY"<?= $state == 'WY' ? ' selected="selected"' : ''; ?>>Wyoming</option>
        </select>
        <?php if ($parentid !== '' && $parentid !== 'add') {
            $ostate = get_post_meta($parentid, 'business_state', true);
            if ($ostate !== $state) {
                if ($ostate == '') {
                    $ostate = 'blank';
                }
                echo '<span class="business-o-value">' . $ostate . '</span>';
            }
        }
        ?>
    </div>
    <div class="business-meta-div">
        <label for="business_zip" class="business-meta-label">Zip</label>
        <input id="business_zip" type="text" class="widefat" name="business_zip"
               value="<?php echo $zip; ?>">
        <?php if ($parentid !== '' && $parentid !== 'add') {
            $ozip = get_post_meta($parentid, 'business_zip', true);
            if ($ozip !== $zip) {
                if ($ozip == '') {
                    $ozip = 'blank';
                }
                echo '<span class="business-o-value">' . $ozip . '</span>';
            }
        }
        ?>
    </div>
    <div class="business-meta-div">
        <label for="business_phone" class="business-meta-label">Phone</label>
        <input id="business_phone" type="text" class="widefat" name="business_phone"
               value="<?php echo $phone; ?>">
        <?php if ($parentid !== '' && $parentid !== 'add') {
            $ophone = get_post_meta($parentid, 'business_phone', true);
            if ($ophone !== $phone) {
                if ($ophone == '') {
                    $ophone = 'blank';
                }
                echo '<span class="business-o-value">' . $ophone . '</span>';
            }
        }
        ?>
    </div>
    <div class="business-meta-div">
        <label for="business_email" class="business-meta-label">Email</label>
        <input id="business_email" type="text" class="widefat" name="business_email"
               value="<?php echo $email ?>">
        <?php if ($parentid !== '' && $parentid !== 'add') {
            $oemail = get_post_meta($parentid, 'business_email', true);
            if ($oemail !== $email) {
                if ($oemail == '') {
                    $oemail = 'blank';
                }
                echo '<span class="business-o-value">' . $oemail . '</span>';
            }
        }
        ?>
    </div>
    <div class="business-meta-div">
        <label for="business_services" class="business-meta-label">Service Times (one service per line)</label>
        <textarea id="business_services" class="widefat" name="business_services" rows="6"><?php echo $services; ?></textarea>
        <?php if ($parentid !== '' && $parentid !== 'add') {
            $oservices = get_post_meta($parentid, 'business_services', true);
            if ($oservices !== $services) {
                if ($oservices == '') {
                    $oservices = 'blank';
                }
                echo '<span class="business-o-value">' . wpautop($oservices) . '</span>';
            }
        }
        ?>
    </div>
    <div id="messages" class="business-notice business-notice-error">
        <p>Please include http:// or https:// for all URLs</p>
    </div>
    <div class="business-meta-div">
        <label for="business_website" class="business-meta-label">Website URL</label><?php echo $websitelink ?>
        <input id="business_website" type="text" class="widefat" name="business_website"
               value="<?php echo $website ?>">
        <?php if ($parentid !== '' && $parentid !== 'add') {
            $owebsite = get_post_meta($parentid, 'business_website', true);
            if ($owebsite !== $website) {
                if ($owebsite == '') {
                    $owebsite = 'blank';
                }
                echo '<span class="business-o-value">' . $owebsite . '</span>';
            }
        }
        ?>
    </div>
    <div class="business-meta-div">
        <label for="business_facebook" class="business-meta-label">Facebook Page URL</label><?php echo $facebooklink ?>
        <input id="business_facebook" type="text" class="widefat" name="business_facebook"
               value="<?php echo $facebook; ?>">
        <?php if ($parentid !== '' && $parentid !== 'add') {
            $ofacebook = get_post_meta($parentid, 'business_facebook', true);
            if ($ofacebook !== $facebook) {
                if ($ofacebook == '') {
                    $ofacebook = 'blank';
                }
                echo '<span class="business-o-value">' . $ofacebook . '</span>';
            }
        }
        ?>
    </div>
    <div class="business-meta-div">
        <label for="business_x" class="business-meta-label">X URL</label><?php echo $xlink ?>
        <input id="business_x" type="text" class="widefat" name="business_x"
               value="<?php echo $x; ?>">
        <?php if ($parentid !== '' && $parentid !== 'add') {
            $ox = get_post_meta($parentid, 'business_x', true);
            if ($ox !== $x) {
                if ($ox == '') {
                    $ox = 'blank';
                }
                echo '<span class="business-o-value">' . $ox . '</span>';
            }
        }
        ?>
    </div>
    <div class="business-meta-div">
        <label for="business_instagram" class="business-meta-label">Instagram URL</label><?php echo $instagramlink ?>
        <input id="business_instagram" type="text" class="widefat" name="business_instagram"
               value="<?php echo $instagram; ?>">
        <?php if ($parentid !== '' && $parentid !== 'add') {
            $oinstagram = get_post_meta($parentid, 'business_instagram', true);
            if ($oinstagram !== $instagram) {
                if ($oinstagram == '') {
                    $oinstagram = 'blank';
                }
                echo '<span class="business-o-value">' . $oinstagram . '</span>';
            }
        }
        ?>
    </div>
    <div class="business-meta-div">
        <label for="business_youtube" class="business-meta-label">YouTube URL</label><?php echo $youtubelink ?>
        <input id="business_youtube" type="text" class="widefat" name="business_youtube"
               value="<?php echo $youtube; ?>">
        <?php if ($parentid !== '' && $parentid !== 'add') {
            $oyoutube = get_post_meta($parentid, 'business_youtube', true);
            if ($oyoutube !== $youtube) {
                if ($oyoutube == '') {
                    $oyoutube = 'blank';
                }
                echo '<span class="business-o-value">' . $oyoutube . '</span>';
            }
        }
        ?>
    </div>
    <div class="business-meta-div">
        <label for="business_vimeo" class="business-meta-label">Vimeo URL</label><?php echo $vimeolink ?>
        <input id="business_vimeo" type="text" class="widefat" name="business_vimeo"
               value="<?php echo $vimeo; ?>">
        <?php if ($parentid !== '' && $parentid !== 'add') {
            $ovimeo = get_post_meta($parentid, 'business_vimeo', true);
            if ($ovimeo !== $vimeo) {
                if ($ovimeo == '') {
                    $ovimeo = 'blank';
                }
                echo '<span class="business-o-value">' . $ovimeo . '</span>';
            }
        }
        ?>
    </div>


    <?php
}

function business_sponsor_meta_callback_function($args)
{
    global $post;

    $newwindow = esc_attr(get_post_meta(get_the_ID(), 'sponsor_newwindow', true));
    if ($newwindow == '') {
        $newwindow = 'on';
    }
    $url = esc_attr(get_post_meta(get_the_ID(), 'sponsor_url', true));
    $image = esc_attr(get_post_meta(get_the_ID(), 'sponsor_image', true));
    $sort = esc_attr(get_post_meta(get_the_ID(), 'sponsor_sort', true));

    wp_enqueue_media();

    //The markup for your meta box goes here


    ?>
    <table class="widefat" style="margin-top: .5em">
        <tbody>
<!--        <tr>-->
<!--            <th width="15%">Sort</th>-->
<!--            <td colspan="2">-->
<!--                <input tabindex="4" id="sponsor_sort" name="sponsor_sort" type="text" size="50"-->
<!--                       class="search-input" value="--><?php //echo stripslashes($sort); ?><!--"-->
<!--                       autocomplete="off"/>-->
<!---->
<!--            </td>-->
<!--        </tr>-->
        <tr class="upload_toggle">
            <th width="15%">Image</th>
            <td colspan="2">
                <input tabindex="3" id="sponsor_image" type="text" size="50" name="sponsor_image"
                       value="<?php echo $image; ?>"/> <input tabindex="4" id="sponsor_image_button"
                                                                        class="button" type="button"
                                                                        value="Select Image"/>
            </td>
        </tr>
        <tr>
            <th width="15%">Link URL</th>
            <td colspan="2">
                <input tabindex="4" id="sponsor_url" name="sponsor_url" type="text" size="50"
                       class="search-input" value="<?php echo stripslashes($url); ?>"
                       autocomplete="off"/>
                <span id="messages" class="business-notice business-notice-error" style="padding: 5px;">
                    Please include http:// or https://
                </span>
            </td>
        </tr>
        <tr>
            <th width="15%">Link Target</th>
            <td colspan="2">
                <label><input tabindex="6" type="checkbox" name="sponsor_newwindow"
                              <?php if ($newwindow == 'on') { ?>checked="checked" <?php } ?> /> Open
                    link in new window
                </label>
            </td>
        </tr>
        <?php if ($image !== ''): ?>
            <tr>
                <th width="15%">Preview</th>
                <td colspan="2">
                    <img src="<?php echo $image; ?>">
                </td>
            </tr>
        <?php endif ?>
        </tbody>
    </table>

    <script>

        jQuery(document).ready(function () {


            jQuery('#sponsor_image_button').click(function (e) {
                e.preventDefault();
                var image = wp.media({
                    title: 'Insert Media',
                    button: {
                        text: "Select File"     // For production, this needs i18n.
                    },
                    // mutiple: true if you want to upload multiple files at once
                    multiple: false
                }).open()
                    .on('select', function (e) {
                        // This will return the selected image from the Media Uploader, the result is an object
                        var uploaded_image = image.state().get('selection').first();
                        // We convert uploaded_image to a JSON object to make accessing it easier
                        // Output to the console uploaded_image
                        console.log(uploaded_image);
                        var image_url = uploaded_image.toJSON().url;
                        // Let's assign the url value to the input field
                        jQuery('#sponsor_image').val(image_url);
                    });
            });


        });


    </script>


    <?php
}

// Save Meta Details
add_action('save_post', 'save_business');

function save_business()
{
    global $post;


    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post->ID;
    }

    if ($post->post_type === 'business'){
        update_post_meta($post->ID, "business_denomination", $_POST["business_denomination"]);
        update_post_meta($post->ID, "business_address", $_POST["business_address"]);
        update_post_meta($post->ID, "business_city", trim($_POST["business_city"]));
        update_post_meta($post->ID, "business_state", $_POST["business_state"]);
        update_post_meta($post->ID, "business_zip", $_POST["business_zip"]);
        update_post_meta($post->ID, "business_phone", $_POST["business_phone"]);
        update_post_meta($post->ID, "business_email", $_POST["business_email"]);
        update_post_meta($post->ID, "business_website", $_POST["business_website"]);
        update_post_meta($post->ID, "business_facebook", $_POST["business_facebook"]);
        update_post_meta($post->ID, "business_x", $_POST["business_x"]);
        update_post_meta($post->ID, "business_instagram", $_POST["business_instagram"]);
        update_post_meta($post->ID, "business_youtube", $_POST["business_youtube"]);
        update_post_meta($post->ID, "business_vimeo", $_POST["business_vimeo"]);
        update_post_meta($post->ID, "business_services", $_POST["business_services"]);

        // Clear cache for business directory page
        global $wpdb;

        $statement = '
        UPDATE
            `' . $wpdb->prefix . 'borlabs_cache_pages`
        SET
            `last_updated`=\'0000-00-00 00:00:00\',
            `next_update`=\'0000-00-00 00:00:00\',
            `runtime_with_cache`=0
        WHERE
            `is_404`=0 AND `url`=\'/business-directory/\'
        ';

        $wpdb->query($statement);

    } elseif ($post->post_type === 'business_sponsor'){

        $thispost = $post;

        // check sort exists
        $sort = get_post_meta($post->ID, 'sponsor_sort', true);
        if ($sort == '') {
            $sort = 0;
            // query highest sortid
            $args = array(
                'post_type' => array('business_sponsor'),
                'post_status' => array('publish'),
                'posts_per_page' => 1,
                'nopaging' => false,
                'order' => 'DESC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'sponsor_sort',
            );

            // The Query
            $sponsors = new WP_Query($args);


            // The Loop
            if ($sponsors->have_posts()) {
                while ($sponsors->have_posts()) {
                    $sponsors->the_post();
                    $sort = get_post_meta(get_the_id(), 'sponsor_sort', true);
                }
            } else {
                //wp_mail('john@calhoun.it', 'no results', 'no results');
            }
            $sort++;
            update_post_meta($thispost->ID, "sponsor_sort", intval($sort));
            //wp_mail('john@calhoun.it', $thispost->ID . ' - ' . $post->ID . ' - ' . $sort, $thispost->ID . ' - ' . $post->ID . ' - ' . $sort);
        }

        $newwindow = $_POST["sponsor_newwindow"];
        if ($newwindow == '') {
            $newwindow = 'off';
        }
        update_post_meta($thispost->ID, "sponsor_newwindow", $newwindow);
        update_post_meta($thispost->ID, "sponsor_image", $_POST["sponsor_image"]);
        update_post_meta($thispost->ID, "sponsor_url", $_POST["sponsor_url"]);

    }




    //}
}

// define the get_sample_permalink_html callback
function filter_get_sample_permalink_html($return, $post_id, $new_title, $new_slug, $post)
{
    // make filter magic happen here...
    if ($post->post_type == 'business' or $post->post_type == 'business_sponsor') {
        return '';
    } else {
        return $return;
    }
}

;

// add the filter
add_filter('get_sample_permalink_html', 'filter_get_sample_permalink_html', 10, 5);


// attempt to manipulate dom of core events admin screens
function webads_business_current_screen()
{
    $currentScreenID = get_current_screen()->id;
    //echo $currentScreen->id;
    if ($currentScreenID === "edit-business" or $currentScreenID === "edit-business_sponsor") {
        //echo $currentScreen->id;
        function webads_business_custom_js()
        {
            echo '<script type="text/javascript" src="' . plugin_dir_url(__FILE__) . 'js/' . get_current_screen()->id . '-hack.js"></script>';
        }

        // Add hook for admin <head></head>
        add_action('admin_head', 'webads_business_custom_js');
    }
}

add_action('current_screen', 'webads_business_current_screen');

add_action('admin_menu', 'webads_business_admin_menu');
function webads_business_admin_menu()
{
    add_submenu_page('edit.php?post_type=business', 'All Sponsors', 'All Sponsors', 'publish_posts', 'edit.php?post_type=business_sponsor');
    add_submenu_page('edit.php?post_type=business', 'Add Sponsor', 'Add Sponsor', 'publish_posts', 'post-new.php?post_type=business_sponsor');
    add_submenu_page('edit.php?post_type=business', 'Settings', 'Settings', 'publish_posts', 'webads-business-settings', 'webads_business_settings');
    //remove_submenu_page( 'edit.php?post_type=business', 'post-new.php?post_type=business' );
}



function webads_business_settings()
{
    if (isset($_POST['general_info'])) {
        //load options
        $options = get_option('webads_business');
        $options['submission_email'] = $_POST['submission_email'];
        $options['general_info'] = $_POST['general_info'];
        $options['sponsor_info'] = $_POST['sponsor_info'];
        update_option('webads_business', $options);
    }


    $options = get_option('webads_business');
    $submission_email = $options['submission_email'];
    $general_info = $options['general_info'];
    $sponsor_info = $options['sponsor_info'];
    $settings = array('media_buttons' => false, 'textarea_rows' => 10);


    ?>
    <div>
        <h1>Business Directory Settings</h1>
        <hr/>

        <form method="POST">


            <table class="widefat" style="margin-top: .5em">
                <tbody>
                <tr>

                    <td>
                        <h3>Email Address For Submissions</h3>
                        <label for="submission_email"><input tabindex="1" id="submission_email" name="submission_email"
                                                             type="text" size="50" class="search-input"
                                                             value="<?php echo $submission_email; ?>"
                                                             autocomplete="off"/></label>
                    </td>
                </tr>
                <tr>

                    <td>
                        <h3>General Information</h3>
                        <?php wp_editor($general_info, 'general_info', $settings); ?>
                    </td>
                </tr>
                <tr>

                    <td>
                        <h3>Sponsor Information</h3>
                        <?php wp_editor($sponsor_info, 'sponsor_info', $settings); ?>
                    </td>
                </tr>

                </tbody>
            </table>


            <p class="submit">
                <input type="submit" value="Save Changes" class="button button-primary button-large">
            </p>


        </form>

    </div>

    <?php
}

/**
 * Add menu meta box
 *
 * @param object $object The meta box object
 * @link https://developer.wordpress.org/reference/functions/add_meta_box/
 */
function business_add_menu_meta_box($object)
{
    add_meta_box('custom-menu-metabox', __('Business Directory'), 'business_menu_metabox', 'nav-menus', 'side', 'default');
    return $object;
}

add_filter('nav_menu_meta_box_object', 'business_add_menu_meta_box', 10, 1);


/**
 * Displays a menu metabox
 *
 * @param string $object Not used.
 * @param array $args Parameters and arguments. If you passed custom params to add_meta_box(),
 * they will be in $args['args']
 */
function business_menu_metabox($object, $args)
{
    global $nav_menu_selected_id;
    // Create an array of objects that imitate Post objects
    $my_items = array(
        (object)array(
            'ID' => 1,
            'db_id' => 0,
            'menu_item_parent' => 0,
            'object_id' => 1,
            'post_parent' => 0,
            'type' => 'custom',
            'object' => 'my-object-slug',
            'type_label' => 'My Cool Plugin',
            'title' => 'Business Directory',
            'url' => home_url('/business-directory/'),
            'target' => '',
            'attr_title' => '',
            'description' => '',
            'classes' => array(),
            'xfn' => '',
        ),
    );
    $db_fields = false;
    // If your links will be hieararchical, adjust the $db_fields array bellow
    if (false) {
        $db_fields = array('parent' => 'parent', 'id' => 'post_parent');
    }
    $walker = new Walker_Nav_Menu_Checklist($db_fields);
    $removed_args = array(
        'action',
        'customlink-tab',
        'edit-menu-item',
        'menu-item',
        'page-tab',
        '_wpnonce',
    ); ?>
    <div id="my-plugin-div">
    <div id="tabs-panel-my-plugin-all" class="tabs-panel tabs-panel-active">
        <ul id="my-plugin-checklist-pop" class="categorychecklist form-no-clear">
            <?php echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $my_items), 0, (object)array('walker' => $walker)); ?>
        </ul>

        <p class="button-controls">
			<span class="list-controls">
				<a href="<?php
                echo esc_url(add_query_arg(
                    array(
                        'my-plugin-all' => 'all',
                        'selectall' => 1,
                    ),
                    remove_query_arg($removed_args)
                ));
                ?>#my-menu-test-metabox" class="select-all"><?php _e('Select All'); ?></a>
			</span>

            <span class="add-to-menu">
				<input type="submit"<?php wp_nav_menu_disabled_check($nav_menu_selected_id); ?>
                       class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Menu'); ?>"
                       name="add-my-plugin-menu-item" id="submit-my-plugin-div"/>
				<span class="spinner"></span>
			</span>
        </p>
    </div>
    <?php
}


// Add the hook action
add_action('transition_post_status', 'business_transition_post_status', 10, 3);

// Listen for publishing of a new post
function business_transition_post_status($new_status, $old_status, $post)
{
    if ('publish' === $new_status && 'pending' === $old_status && $post->post_type === 'business') {
        // Do something!
        $post_id = $post->ID;
        $parentid = get_post_meta($post_id, 'business_parentid', true);
        update_post_meta($post_id, 'business_parentid', '');
        wp_delete_post($parentid, true);
    }
}


add_action('pre_get_posts', 'business_pre_get_posts');
function business_pre_get_posts($query)
{
    if ('business' == $query->get('post_type') or 'business_sponsor' == $query->get('post_type')) {
        if ($query->get('orderby') == '')
            $query->set('orderby', 'title');

        if ($query->get('order') == '')
            $query->set('order', 'ASC');
    }
}


add_action('edit_form_before_permalink', 'business_edit_form_before_permalink');
function business_edit_form_before_permalink($post)
{
    $parentid = get_post_meta(get_the_ID(), 'business_parentid', true);
    if ($parentid !== '' && $parentid !== 'add') {
        $otitle = get_the_title($parentid);
        if ($otitle == '') {
            $otitle = 'blank';
        }
        if ($otitle !== get_the_title()) {
            echo '<span class="business-o-value">' . $otitle . '</span>';
        }
    }

}


// remove featured image meta box
function business_remove_meta_boxes() {
    remove_meta_box('postimagediv', 'business', 'side');
    remove_meta_box('postimagediv', 'business_sponsor', 'side');
}
add_action('admin_head','business_remove_meta_boxes'); //admin_init & admin_menu don't work for certain meta boxes
