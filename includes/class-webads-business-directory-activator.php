<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.iadsnetwork.com
 * @since      1.0.0
 *
 * @package    Webads_Business_Directory
 * @subpackage Webads_Business_Directory/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Webads_Business_Directory
 * @subpackage Webads_Business_Directory/includes
 * @author     John Calhoun <john@iadsnetwork.com>
 */
class Webads_Business_Directory_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        // Set expiration date defaults
        $defaults = get_option('expirationdateDefaultsBusiness');
        if (!$defaults) $defaults = array();
        update_option('expirationdateDefaultsBusiness', $defaults);
        
        // Set default general info text
        $options = get_option('webads_business', array());
        
        // Only set the default general_info if it doesn't already exist or is empty
        if (!isset($options['general_info']) || (isset($options['general_info']) && trim($options['general_info']) === '')) {
            $options['general_info'] = '<p>Welcome to our Business Directory.</p><p>To have your business added, please call our office.</p>';
            update_option('webads_business', $options);
        }
	}

}
