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

//* Make sure Core is laoded so we have access to SWP_Addon.
add_action( 'plugins_loaded', function() {

    //* Define our new class here. Immediately instantiate below.
    // class SWP_AffiliateWP extends SWP_Addon {
    //     public function __construct( $name, $key, $product_id, $version, $core ) {
    //         parent::__construct( $name, $key, $product_id, $version, $core );
    //         add_filter( 'swp_network_buttons' , [$this, 'append_affiliate_id_to_links'], 1 , 1 );
    //     }
    //
    //     /**
    //      * Adds affiliate links to the share buttons.
    //      *
    //      * @since  1.0.0
    //      * @access public
    //      * @param  Array $buttons An array of information about the buttons being generated
    //      * @return Array $buttons The modified array of information about the buttons being generated
    //      *
    //      */
    //     public function append_affiliate_id_to_links( $buttons ) {
    //
    //         // Make sure core is on a version that contains our dependancies
    //         if (defined('SWP_VERSION') && version_compare(SWP_VERSION , SWAWP_CORE_VERSION_REQUIRED) >= 0) {
    //
    //             // Check if the AffiliateWP plugin is installed
    //             if ( function_exists('affwp_is_affiliate') ) {
    //
    //                 // Check if the current user is logged in and is an affiliate
    //                 if ( ! ( is_user_logged_in() && affwp_is_affiliate() ) ) {
    //                     return $buttons;
    //                 }
    //
    //                 // Append referral parameter and affiliate ID to sharing links in Social Warfare
    //                 $buttons['url'] = add_query_arg( affiliate_wp()->tracking->get_referral_var(), affwp_get_affiliate_id(), $buttons['url'] );
    //             }
    //         }
    //
    //         // Return the modified array
    //         return $buttons;
    //     }
    // }
    //
    // $AffiliateWP = new SWP_AffiliateWP( 'Social Warfare - AffiliateWP', 'affiliatewp', 114264, '1.0.0', '2.3.2' );
    //

    class Test {
        public function render() {
            die("rendering");
        }
    }

    $test = new Test();

    $test->render();
});
