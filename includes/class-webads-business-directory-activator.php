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
        $defaults = get_option('expirationdateDefaultsBusiness');
        if (!$defaults) $defaults = array();
        update_option('expirationdateDefaultsBusiness', $defaults);
	}

}
