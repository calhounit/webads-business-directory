<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.iadsnetwork.com
 * @since             1.0.0
 * @package           Webads_Business_Directory
 *
 * @wordpress-plugin
 * Plugin Name:       WebAds Business Directory
 * Plugin URI:        http://www.iadsnetwork.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.2.0
 * Author:            John Calhoun
 * Author URI:        http://www.iadsnetwork.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       webads-business-directory
 * Domain Path:       /languages
 *
 * RELEASE NOTES
 * 1.0.0 - initial release
 * 1.0.1 - bug fix to trim spaces from business city
 * 1.0.2 - bug fix
 * 1.0.3 - permission change for business sponsor menu items
 * 1.0.4 - bug fix
 * 1.0.5 - added service times field
 * 1.0.6 - added required fields to update form
 * 1.0.7 - bug fix
 * 1.0.8 - added required fields in admin edit/add business
 * 1.0.9 - added caching support for sponsors (may still need to clear cache after CRUD operation, not sure)
 * 1.1.0 - js changes to support js merge when caching
 * 1.1.1 - bug fix for borlabs
 * 1.2.0 - refactored twitter to x
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('WEBADS_BUSINESS_DIRECTORY_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-webads-business-directory-activator.php
 */
function activate_webads_business_directory()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-webads-business-directory-activator.php';
    Webads_Business_Directory_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-webads-business-directory-deactivator.php
 */
function deactivate_webads_business_directory()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-webads-business-directory-deactivator.php';
    Webads_Business_Directory_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_webads_business_directory');
register_deactivation_hook(__FILE__, 'deactivate_webads_business_directory');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-webads-business-directory.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_webads_business_directory()
{
    $plugin = new Webads_Business_Directory();
    $plugin->run();
}

run_webads_business_directory();


// Register Custom Post Type
function business_post_types()
{

    // business post type
    $labels = array(
        'name' => _x('Businesses', 'Post Type General Name', 'text_domain'),
        'singular_name' => _x('Business', 'Post Type Singular Name', 'text_domain'),
        'menu_name' => __('Business Directory', 'text_domain'),
        'name_admin_bar' => __('Business', 'text_domain'),
        'archives' => __('Item Archives', 'text_domain'),
        'attributes' => __('Item Attributes', 'text_domain'),
        'parent_item_colon' => __('Parent Item:', 'text_domain'),
        'all_items' => __('All Businesses', 'text_domain'),
        'add_new_item' => __('Add New Business', 'text_domain'),
        'add_new' => __('Add Business', 'text_domain'),
        'new_item' => __('New Business', 'text_domain'),
        'edit_item' => __('Edit Business', 'text_domain'),
        'update_item' => __('Update Business', 'text_domain'),
        'view_item' => __('View Business', 'text_domain'),
        'view_items' => __('View Businesses', 'text_domain'),
        'search_items' => __('Search Business', 'text_domain'),
        'not_found' => __('Not found', 'text_domain'),
        'not_found_in_trash' => __('Not found in Trash', 'text_domain'),
        'featured_image' => __('Featured Image', 'text_domain'),
        'set_featured_image' => __('Set featured image', 'text_domain'),
        'remove_featured_image' => __('Remove featured image', 'text_domain'),
        'use_featured_image' => __('Use as featured image', 'text_domain'),
        'insert_into_item' => __('Insert into business', 'text_domain'),
        'uploaded_to_this_item' => __('Uploaded to this business', 'text_domain'),
        'items_list' => __('Businesses list', 'text_domain'),
        'items_list_navigation' => __('Businesses list navigation', 'text_domain'),
        'filter_items_list' => __('Filter businesses list', 'text_domain'),
    );
    $args = array(
        'label' => __('Business', 'text_domain'),
        'description' => __('Business Directory', 'text_domain'),
        'labels' => $labels,
        'supports' => array('title'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 25,
        'menu_icon' => 'dashicons-admin-multisite',
        'show_in_admin_bar' => false,
        'show_in_nav_menus' => false,
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );
    register_post_type('business', $args);

    // business sponsor post type
    $labels = array(
        'name' => _x('Business Sponsors', 'Post Type General Name', 'text_domain'),
        'singular_name' => _x('Business Sponsor', 'Post Type Singular Name', 'text_domain'),
        'menu_name' => __('Post Types', 'text_domain'),
        'name_admin_bar' => __('Business Sponsor', 'text_domain'),
        'archives' => __('Item Archives', 'text_domain'),
        'attributes' => __('Item Attributes', 'text_domain'),
        'parent_item_colon' => __('Parent Item:', 'text_domain'),
        'all_items' => __('All Sponsors', 'text_domain'),
        'add_new_item' => __('Add New Sponsor', 'text_domain'),
        'add_new' => __('Add Sponsor', 'text_domain'),
        'new_item' => __('New Sponsor', 'text_domain'),
        'edit_item' => __('Edit Sponsor', 'text_domain'),
        'update_item' => __('Update Sponsor', 'text_domain'),
        'view_item' => __('View Sponsor', 'text_domain'),
        'view_items' => __('View Sponsors', 'text_domain'),
        'search_items' => __('Search Sponsor', 'text_domain'),
        'not_found' => __('Not found', 'text_domain'),
        'not_found_in_trash' => __('Not found in Trash', 'text_domain'),
        'featured_image' => __('Featured Image', 'text_domain'),
        'set_featured_image' => __('Set featured image', 'text_domain'),
        'remove_featured_image' => __('Remove featured image', 'text_domain'),
        'use_featured_image' => __('Use as featured image', 'text_domain'),
        'insert_into_item' => __('Insert into item', 'text_domain'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'text_domain'),
        'items_list' => __('Items list', 'text_domain'),
        'items_list_navigation' => __('Items list navigation', 'text_domain'),
        'filter_items_list' => __('Filter items list', 'text_domain'),
    );
    $args = array(
        'label' => __('Business Sponsor', 'text_domain'),
        'description' => __('Post Type Description', 'text_domain'),
        'labels' => $labels,
        'supports' => array('title'),
        'hierarchical' => false,
        'public' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'show_in_menu' => false,
        'menu_position' => 5,
        'show_in_admin_bar' => false,
        'show_in_nav_menus' => false,
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );
    register_post_type('business_sponsor', $args);


}

add_action('init', 'business_post_types', 0);


add_filter('the_posts', 'generate_business_page', -10);
/**
 * Create a fake page called "fake"
 *
 * $fake_slug can be modified to match whatever string is required
 *
 *
 * @param   object $posts Original posts object
 * @global  object $wp The main WordPress object
 * @global  object $wp The main WordPress query object
 * @return  object  $posts  Modified posts object
 */
function generate_business_page($posts)
{
    global $wp, $wp_query;

    $url_slug = 'business-directory'; // URL slug of the fake page

    if (!defined('BUSINESS_PAGE') && (strtolower($wp->request) == $url_slug)) {

        // stop interferring with other $posts arrays on this page (only works if the sidebar is rendered *after* the main page)
        define('BUSINESS_PAGE', true);

        // create a fake virtual page
        $post = new stdClass;
        $post->post_author = 1;
        $post->post_name = $url_slug;
        $post->guid = home_url() . '/' . $url_slug;
        $post->post_title = 'Business Directory';
        $post->post_content = 'Stick some arbitrary text content in here';
        $post->ID = -998;
        $post->post_type = 'page';
        $post->post_status = 'static';
        $post->comment_status = 'closed';
        $post->ping_status = 'open';
        $post->comment_count = 0;
        $post->post_date = current_time('mysql');
        $post->post_date_gmt = current_time('mysql', 1);
        $posts = NULL;
        $posts[] = $post;

        // make wpQuery believe this is a real page too
        $wp_query->is_page = true;
        $wp_query->is_singular = true;
        $wp_query->is_home = false;
        $wp_query->is_archive = false;
        $wp_query->is_category = false;
        unset($wp_query->query['error']);
        $wp_query->query_vars['error'] = '';
        $wp_query->is_404 = false;
    }

    $url_slug = 'business-directory-update'; // URL slug of the fake page

    if (!defined('BUSINESS_UPDATE_PAGE') && (strtolower($wp->request) == $url_slug)) {

        // stop interferring with other $posts arrays on this page (only works if the sidebar is rendered *after* the main page)
        define('BUSINESS_UPDATE_PAGE', true);

        // create a fake virtual page
        $post = new stdClass;
        $post->post_author = 1;
        $post->post_name = $url_slug;
        $post->guid = home_url() . '/' . $url_slug;
        $post->post_title = 'Business Directory Update';
        $post->post_content = 'Stick some arbitrary text content in here';
        $post->ID = -999;
        $post->post_type = 'page';
        $post->post_status = 'static';
        $post->comment_status = 'closed';
        $post->ping_status = 'open';
        $post->comment_count = 0;
        $post->post_date = current_time('mysql');
        $post->post_date_gmt = current_time('mysql', 1);
        $posts = NULL;
        $posts[] = $post;

        // make wpQuery believe this is a real page too
        $wp_query->is_page = true;
        $wp_query->is_singular = true;
        $wp_query->is_home = false;
        $wp_query->is_archive = false;
        $wp_query->is_category = false;
        unset($wp_query->query['error']);
        $wp_query->query_vars['error'] = '';
        $wp_query->is_404 = false;
    }

    return $posts;
}

add_filter('template_include', 'business_page_template', 99);

function business_page_template($template)
{

    if (is_page('business-directory')) {
        $plugindir = dirname(__FILE__);
        //$new_template = locate_template( array( 'webads-business-template.php' ) );
        $new_template = $plugindir . '/webads-business-template.php';
        if (!empty($new_template)) {
            return $new_template;
        }
    } elseif (is_page('business-directory-update')) {
        $plugindir = dirname(__FILE__);
        //$new_template = locate_template( array( 'webads-business-template.php' ) );
        $new_template = $plugindir . '/webads-business-update-template.php';
        if (!empty($new_template)) {
            return $new_template;
        }
    }

    return $template;
}


add_action('rest_api_init', function () {
    register_rest_route('wp/v2', 'business_sponsors_featured', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'business_sponsors_featured'
    ));
});

function business_sponsors_featured()
{
    //query featured sponsors
    $args = array(
        'post_type' => array('business_sponsor'),
        'post_status' => array('publish'),
        'posts_per_page' => 2,
        'nopaging' => false,
        'order' => 'ASC',
        'orderby' => 'meta_value_num',
        'meta_key' => 'sponsor_sort',
        'fields' => 'title'
    );

    // The Query
    $sponsors = new WP_Query($args);
    $items = array();

    if ($sponsors->have_posts()) {
        while ($sponsors->have_posts()) {
            $sponsors->the_post();
            $itemid = get_the_id();

            $items[] = array(
                'id' => $itemid,
                'title' => get_the_title(),
                'image' => get_post_meta($itemid, 'sponsor_image', true),
                'url' => get_post_meta($itemid, 'sponsor_url', true),
                'newwindow' => get_post_meta($itemid, 'sponsor_newwindow', true),
                'sort' => get_post_meta($itemid, 'sponsor_sort', true)
            );


        }
    }

    return $items;
}

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', 'business_sponsors_nonfeatured', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'business_sponsors_nonfeatured'
    ));
});

function business_sponsors_nonfeatured()
{
    //query non featured sponsors
    $args = array(
        'post_type' => array('business_sponsor'),
        'post_status' => array('publish'),
        'offset' => 2,
        'posts_per_page' => 100,
        'nopaging' => false,
        'order' => 'ASC',
        'orderby' => 'meta_value_num',
        'meta_key' => 'sponsor_sort',
        'fields' => 'title'
    );

    // The Query
    $sponsors = new WP_Query($args);
    $items = array();

    if ($sponsors->have_posts()) {
        while ($sponsors->have_posts()) {
            $sponsors->the_post();
            $itemid = get_the_id();

            $items[] = array(
                'id' => $itemid,
                'title' => get_the_title(),
                'image' => get_post_meta($itemid, 'sponsor_image', true),
                'url' => get_post_meta($itemid, 'sponsor_url', true),
                'newwindow' => get_post_meta($itemid, 'sponsor_newwindow', true),
                'sort' => get_post_meta($itemid, 'sponsor_sort', true)
            );


        }
    }

    return $items;
}

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', 'business_sponsors_rotate', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'business_sponsors_rotate'
    ));
});

function business_sponsors_rotate()
{
    // rotate sponsors
    $args = array(
        'post_type' => array('business_sponsor'),
        'post_status' => array('publish'),
        'posts_per_page' => 100,
        'nopaging' => false,
        'order' => 'ASC',
        'orderby' => 'meta_value_num',
        'meta_key' => 'sponsor_sort',
    );

    // The Query
    $sponsors = new WP_Query($args);

    // The Loop
    if ($sponsors->have_posts()) {
        while ($sponsors->have_posts()) {
            $sponsors->the_post();

            $postid = get_the_id();
            $sort = get_post_meta($postid, 'sponsor_sort', true);

            $newsort = $sort + 1;

            //echo $sort . '-'. $newsort . '-' . $postid . '<br>';
            update_post_meta($postid, "sponsor_sort", $newsort);

            //echo get_the_title() . ' - ' . $sort . ' - ' . $newsort . '<br>';
        }
        //echo $postid . ' - ' . get_the_title($postid);
        update_post_meta($postid, "sponsor_sort", 1);
    }


}
