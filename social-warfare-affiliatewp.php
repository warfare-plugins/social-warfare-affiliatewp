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
 * Define plugin constants for use throughout the plugin (Version and Directories)
 *
 */
define( 'SWAWP_VERSION', '1.0.0' );
define( 'SWAWP_PLUGIN_FILE', __FILE__ );
define( 'SWAWP_PLUGIN_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'SWAWP_PLUGIN_DIR', dirname( __FILE__ ) );

/**
 * Add a registration key for the registration functions
 *
 * @param Array An array of registrations for each paid addon
 * @return Array An array modified to add this new registration key
 */
add_filter('swp_registrations' , 'social_warfare_affiliatewp_registration_key');
function social_warfare_affiliatewp_registration_key($array) {
    $array['affiliatewp'] = array(
        'plugin_name' => 'Social Warfare - AffiliateWP',
        'key' => 'affiliatewp',
        'product_id' => 999999
    );

    return $array;
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

    // Check if the AffiliateWP plugin is installed
    if ( function_exists('affwp_is_affiliate') ) {

        // Check if the current user is logged in and is an affiliate
        if ( ! ( is_user_logged_in() && affwp_is_affiliate() ) ) {
            return $buttons;
        }

        // Append referral parameter and affiliate ID to sharing links in Social Warfare
        $buttons['url'] = add_query_arg( affiliate_wp()->tracking->get_referral_var(), affwp_get_affiliate_id(), $buttons['url'] );
    }

    // Return the modified array
    return $buttons;
}
add_filter( 'swp_network_buttons' , 'append_affiliate_id_to_social_warfare_sharing_links' , 1 , 1 );
