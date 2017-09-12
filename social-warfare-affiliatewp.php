<?php
/**
 * Plugin Name: Social Warfare - AffiliateWP
 * Plugin URI:  http://warfareplugins.com
 * Description: A plugin to that transforms all shared links on the Social Warfare buttons across your site into affiliate links for logged in affiliates.
 * Version:     1.0.0
 * Author:      Warfare Plugins
 * Author URI:  http://warfareplugins.com
 * Text Domain: social-warfare
 */

defined( 'WPINC' ) || die;

/**
 * Define plugin constants for use throughout the plugin (Version, Directories and Updates)
 *
 */
define( 'SWAWP_VERSION', '1.0.0' );
define( 'SWAWP_PLUGIN_FILE', __FILE__ );
define( 'SWAWP_PLUGIN_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'SWAWP_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'SWAWP_STORE_URL', 'https://warfareplugins.com' );
define( 'SWAWP_ITEM_ID', 114264 );
define( 'SWAWP_CORE_VERSION_REQUIRED' , '2.3.2');

/**
 * Add a registration key for the registration functions
 *
 * @param Array An array of registrations for each paid addon
 * @return Array An array modified to add this new registration key
 *
 */
add_filter('swp_registrations' , 'social_warfare_affiliatewp_registration_key' , 10);
function social_warfare_affiliatewp_registration_key($array) {

    // Make sure core is on a version that contains our dependancies
    if (defined('SWP_VERSION') && version_compare(SWP_VERSION , SWAWP_CORE_VERSION_REQUIRED) >= 0){

        // Add this plugin to the registrations array
        $array['affiliatewp'] = array(
            'plugin_name' => 'Social Warfare - AffiliateWP',
            'key' => 'affiliatewp',
            'product_id' => SWAWP_ITEM_ID
        );
    }

    // Return the modified or unmodified array
    return $array;
}

/**
 * A function to check for updates to this addon
 *
 * @since 1.0.0
 * @param none
 * @return none
 *
 */
add_action( 'plugins_loaded' , 'swawp_update_checker' , 20 );
function swawp_update_checker() {

    // Make sure core is on a version that contains our dependancies
    if (defined('SWP_VERSION') && version_compare(SWP_VERSION , SWAWP_CORE_VERSION_REQUIRED) >= 0){

        // Check if the plugin is registered
        if( is_swp_addon_registered( 'affiliatewp' ) ) {

            // retrieve our license key from the DB
            $license_key = swp_get_license_key('affiliatewp');
            $website_url = swp_get_site_url();

            // setup the updater
            $edd_updater = new SW_EDD_SL_Plugin_Updater( SWAWP_STORE_URL , __FILE__ , array(
            	'version'   => SWAWP_VERSION,		// current version number
            	'license'   => $license_key,	// license key
            	'item_id'   => SWAWP_ITEM_ID,	// id of this plugin
            	'author'    => 'Warfare Plugins',	// author of this plugin
            	'url'       => $website_url,
                'beta'      => false // set to true if you wish customers to receive update notifications of beta releases
                )
            );
        }
    }
}


/**
 * A function to add affiliate links to the share buttons
 *
 * @since  1.0.0
 * @access public
 * @param  Array $buttons An array of information about the buttons being generated
 * @return Array $buttons The modified array of information about the buttons being generated
 *
 */
function swawp_append_affiliate_id_to_links( $buttons ) {

    // Make sure core is on a version that contains our dependancies
    if (defined('SWP_VERSION') && version_compare(SWP_VERSION , SWAWP_CORE_VERSION_REQUIRED) >= 0){

        // Check if the AffiliateWP plugin is installed
        if ( function_exists('affwp_is_affiliate') ) {

            // Check if the current user is logged in and is an affiliate
            if ( ! ( is_user_logged_in() && affwp_is_affiliate() ) ) {
                return $buttons;
            }

            // Append referral parameter and affiliate ID to sharing links in Social Warfare
            $buttons['url'] = add_query_arg( affiliate_wp()->tracking->get_referral_var(), affwp_get_affiliate_id(), $buttons['url'] );
        }

    }

    // Return the modified array
    return $buttons;
}
add_filter( 'swp_network_buttons' , 'swawp_append_affiliate_id_to_links' , 1 , 1 );
